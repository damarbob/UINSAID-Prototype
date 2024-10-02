<?php

namespace App\Controllers;

use App\Libraries\DataSyntaxQueryProcessor;
use App\Libraries\Twig;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

use function App\Helpers\format_tanggal;
use function App\Helpers\format_tanggal_suatu_kolom;

class HalamanAdmin extends BaseControllerAdmin
{

    /* Libraries */
    protected $twig; // For twig rendering
    protected $dataSyntaxQueryProcessor;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->twig = new Twig();
        $this->dataSyntaxQueryProcessor = new DataSyntaxQueryProcessor();

        $this->model = $this->halamanModel;
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.halaman');
        $this->data['halaman'] = $this->model->findAll();
        return view('admin_halaman', $this->data);
    }

    /**
     * Get data for DataTables server-side processing
     *
     * @param string|null $status Optional status filter
     * @return $this
     */
    public function getDT($status = null)
    {
        $columns = ['id', 'judul', 'slug', 'id_komponen', 'css', 'js', 'status', 'created_at'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->model->countAll();
        $totalFiltered = $totalData;

        $halaman = $this->model->getDT($limit, $start, $status, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->model->getTotalFilteredRecordsDT($status, $search);
        }

        $data = [];
        if (!empty($halaman)) {
            foreach ($halaman as $row) {

                $nestedData['id'] = $row['id'];
                $nestedData['judul'] = $row['judul'];
                $nestedData['slug'] = $row['slug'];
                $nestedData['id_komponen'] = $row['id_komponen'];
                $nestedData['css'] = $row['css'];
                $nestedData['js'] = $row['js'];
                $nestedData['status'] = $row['status'];
                $nestedData['created_at'] = $row['created_at'];
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $this->response->setJSON($json_data);
    }

    public function tambah()
    {
        /* Kode lama */
        // $this->data['availableComponents'] = $this->komponenModel->findAll();
        // return view('admin_halaman_editor', $this->data);
        /* Akhir dari kode lama */

        $this->data['judul'] = lang('Admin.buatHalaman');

        $judul = lang('Admin.halamanBaru');

        // Buat halaman baru
        $this->model->insert([
            'judul' => $judul,
            'id_komponen' => '[]',
        ]);

        $id = $this->model->getInsertID(); // 
        // dd($id);

        // Lalu masuk ke halaman sunting untuk mengedit
        $data = [
            'slug' => url_title($judul . ' ' . $id, '-', true),
        ];
        $this->model->update($id, $data);

        return redirect()->to('admin/halaman/sunting/' . $id);
    }

    // Edit a specific page
    public function sunting($id)
    {
        $halaman = $this->model->find($id);
        $this->data['judul'] = lang('Admin.suntingHalaman') . " - " . $halaman['judul'];
        $komponenData = json_decode($halaman['id_komponen']);
        $komponen = [];
        if ($komponenData) {
            foreach ($komponenData as $x) {
                $komponen[] = $this->komponenModel->find($x->komponen_id);
            }
        }
        $this->data['halaman'] = $halaman;
        $this->data['komponenData'] = $komponenData;
        $this->data['komponen'] = $komponen;
        $this->data['daftarKomponen'] = $this->komponenModel->orderBy('nama', 'asc')->findAll();

        return view('admin_halaman_editor', $this->data);
    }

    // Save the reordered components
    public function simpan($id = null)
    {
        $modeTambah = ($id == null); // Apakah saat ini mode tambah

        $halamanLama = $this->halamanModel->getByid($id);

        // Check for post request
        $judul = $this->request->getPost('judul');
        $slug = $this->request->getPost('slug');
        $newOrder = $this->request->getPost('id_komponen'); // List ID komponen
        $status = $this->request->getPost('status');
        $cssOld = $this->request->getPost('css_old');
        $jsOld = $this->request->getPost('js_old');

        // Check for file uploads
        $cssFile = $this->request->getFile('css_file');
        $jsFile = $this->request->getFile('js_file');

        /* Files validation */
        $fileRules = []; // Contains file rules

        $cssFileValid = $cssFile && $cssFile->isValid();
        $jsFileValid = $jsFile && $jsFile->isValid();

        if ($cssFileValid || $jsFileValid) {
            if ($cssFileValid) {
                $fileRules = array_merge(
                    $fileRules,
                    [
                        'css_file' => [
                            'label' => 'CSS',
                            'rules' => [
                                'uploaded[css_file]',
                                'ext_in[css_file,css]',
                            ]
                        ]
                    ]
                );
            }
            if ($jsFileValid) {
                $fileRules = array_merge(
                    $fileRules,
                    [
                        'js_file' => [
                            'label' => 'JS',
                            'rules' => [
                                'uploaded[js_file]',
                                'ext_in[js_file,js]',
                            ]
                        ],
                    ]
                );
            }
            if (!$this->validateData([], $fileRules)) {
                return redirect()->back()->withInput();
            }
        }
        /* End of files validation */

        // Redireksi
        $redirectTo = ($modeTambah) ? base_url('/admin/halaman/') : base_url('/admin/halaman/sunting/' . $id);

        /* Input validation */
        $slugRule = 'required'; // Slug input

        // If slug is changed, apply slug rules
        if (!$modeTambah && $halamanLama['slug'] !== $slug) {
            $slugRule = 'required|is_unique[halaman.slug]';
        }

        $rules = [
            'judul' => [
                'label' => lang('Admin.judul'),
                'rules' => 'required',
            ],
            'slug' => [
                'label' => lang('Admin.alamatHalaman'),
                'rules' => $slugRule,
            ],
            'id_komponen' => [
                'label' => lang('Admin.komponen'),
                'rules' => 'required',
            ],
            'status' => [
                'label' => lang('Admin.status'),
                'rules' => 'required|in_list[draf,publikasi]', // TODO: Buat constant untuk 'draf' dan 'publikasi' karena sama semua
            ]
        ];

        // Cek validasi input
        if (!$this->validate($rules)) {

            // dd($halamanLama);
            // dd("Dead by validation");

            return redirect()->back()->withInput();
        }
        /* End of input validation */

        /* Files upload */
        // Initialize file paths
        $cssPath = null;
        $jsPath = null;

        // Handle CSS file upload
        if ($cssFile && $cssFile->isValid()) {
            // If file is valid move and rename
            if (!$cssFile->hasMoved()) {
                $originalName = url_title(pathinfo($cssFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                $randomName = $cssFile->getRandomName(); // Generate a random file name
                $cssFile->move(FCPATH . 'assets/pages/css/', $originalName . '-' . $randomName);
                $cssPath = ('assets/pages/css/' . $originalName . '-' . $randomName);
            }
        } else {
            // Get css from old value
            $cssPath = $cssOld;
        }

        // Handle JS file upload
        if ($jsFile && $jsFile->isValid()) {
            // If file is valid move and rename
            if (!$jsFile->hasMoved()) {
                $originalName = url_title(pathinfo($jsFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                $randomName = $jsFile->getRandomName(); // Generate a random file name
                $jsFile->move(FCPATH . 'assets/pages/js/', $originalName . '-' . $randomName);
                $jsPath = ('assets/pages/js/' . $originalName . '-' . $randomName);
            }
        } else {
            // Get css from old value
            $jsPath = $jsOld;
        }
        /* End of files upload */

        /* CRUD */
        $data = [
            'judul' => $judul,
            'slug' => $slug,
            'id_komponen' => $newOrder,
            'css' => $cssPath,
            'js' => $jsPath,
            'status' => $status,
        ];

        if ($id) {
            $this->model->update($id, $data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        } else {
            $this->model->insert($data);

            // Pesan berhasil dibuat
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        }

        return redirect()->to($redirectTo);
    }
}
