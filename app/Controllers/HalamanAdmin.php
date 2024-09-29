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
        $this->data['daftarKomponen'] = $this->komponenModel->findAll();

        return view('admin_halaman_editor', $this->data);
    }

    // Save the reordered components
    public function simpan($id = null)
    {
        $modeTambah = ($id == null); // Apakah saat ini mode tambah

        $halamanLama = $this->halamanModel->getByid($id);

        $judul = $this->request->getPost('judul');
        $slug = $this->request->getPost('slug');
        $newOrder = $this->request->getPost('id_komponen'); // List ID komponen
        $status = $this->request->getPost('status');

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
                                // 'mime_in[css_file,text/css]',
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
                                // 'mime_in[js_file,text/javascript]',
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
                $cssPath = base_url('assets/pages/css/' . $originalName . '-' . $randomName);
            }
        } else {
            // Get css from old halaman
            $cssPath = $halamanLama['css'];
        }

        // Handle JS file upload
        if ($jsFile && $jsFile->isValid()) {
            // If file is valid move and rename
            if (!$jsFile->hasMoved()) {
                $originalName = url_title(pathinfo($jsFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                $randomName = $jsFile->getRandomName(); // Generate a random file name
                $jsFile->move(FCPATH . 'assets/pages/js/', $originalName . '-' . $randomName);
                $jsPath = base_url('assets/pages/js/' . $originalName . '-' . $randomName);
            }
        } else {
            // Get css from old halaman
            $jsPath = $halamanLama['js'];
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

    // Rename the function to avoid conflicts
    function formatDateTime($datetime)
    {
        return date('M Y, H:i', strtotime($datetime));
    }

    function replaceMetaSyntax($htmlSource, $metaSource)
    {
        // Decode the meta source JSON into an associative array
        $metaDataArray = json_decode($metaSource, true);

        // Create an associative array for quick lookup by ID
        $metaDataMap = [];
        foreach ($metaDataArray as $metaData) {
            $metaDataMap[$metaData['id']] = $metaData;
        }

        // Function to replace meta syntax with values
        $pattern = '/\/\* meta \{(.*?)\} meta \*\//';
        $replacementCallback = function ($matches) use ($metaDataMap) {
            // Decode the meta data from the match
            $meta = json_decode('{' . $matches[1] . '}', true);

            // Check if the meta ID exists, if not, return an empty string
            if (!isset($metaDataMap[$meta['id']])) {
                return ''; // Set to empty if not found
            }

            $metaData = $metaDataMap[$meta['id']];
            $value = $metaData['value'];
            $output = '';

            // Handle different types
            switch ($meta['tipe']) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                case 'color':
                case 'textarea':
                    $output = htmlspecialchars($value); // Use htmlspecialchars for safety
                    break;

                case 'datetime-local':
                    $output = $this->formatDateTime($value);
                    break;

                case 'radio':
                    // Assuming the value is one of the options' values
                    foreach ($meta['options'] as $option) {
                        if ($option['value'] === $value) {
                            $output = $option['label'];
                            break;
                        }
                    }
                    break;

                case 'checkbox':
                    $output = $value ? $value : ''; // 'on' for checked, empty string for unchecked or not found
                    break;

                case 'file':
                    $output = is_array($value) ? implode(', ', $value) : $value;
                    break;

                case 'select':
                    // Assuming the value is one of the options' values
                    foreach ($meta['options'] as $option) {
                        if ($option['value'] === $value) {
                            $output = $option['label'];
                            break;
                        }
                    }
                    break;

                default:
                    $output = htmlspecialchars($value); // Default case
                    break;
            }

            return $output;
        };

        // Replace the meta syntax in the HTML source
        $result = preg_replace_callback($pattern, $replacementCallback, $htmlSource);

        return $result;
    }

    function replaceAttributes($content, $jsonString)
    {
        // Decode the JSON string into an associative array
        $jsonArray = json_decode($jsonString, true);

        // Regular expression to match the attr placeholder pattern (supports both single and double quotes)
        $pattern = '/\/\*\s*attr\s*\([\'"]([^\'"]+)[\'"]\)\s*attr\s*\*\//';

        // Replace the attr placeholders
        $content = preg_replace_callback($pattern, function ($matches) use ($jsonArray) {
            $key = $matches[1];
            return isset($jsonArray[$key]) ? $jsonArray[$key] : $matches[0];
        }, $content);

        return $content;
    }

    /**
     * Frontend view
     * 
     * @param int Id of the page
     * @return string Halaman page
     */
    public function view($id)
    {
        $halaman = $this->model->find($id);
        $komponenData = json_decode($halaman['id_komponen']);
        $komponen = [];

        if ($komponenData) {
            foreach ($komponenData as $x) {
                $komponen[] = $this->komponenModel->find($x->komponen_id);
            }
        }

        // Set up the Twig environment
        $loader = new ArrayLoader();
        $twig = new Environment($loader);

        $komponenTerformat = []; // Array untuk menyimpan komponen terformat
        foreach ($komponen as $i => $x) {
            // dd($x['konten']);

            $komponenMeta = $this->komponenMetaModel->getById(
                $komponenData[$i]->komponen_instance_id, // Assuming the order of komponenData is the same as komponen[]
                $x['id'],
                $id
            );

            // dd(!$komponenMeta);

            // Replace attr syntax
            $x['konten'] = $this->replaceAttributes($x['konten'], json_encode($komponenData[$i]));

            // dd($x['konten']);

            // Replace meta syntax
            if (!$komponenMeta) {
                $x['konten_terformat'] = $this->twig->renderTemplateString($x['konten'], []);
            } else {
                $x['konten_terformat'] = $this->twig->renderTemplateString(
                    $this->replaceMetaSyntax(
                        $x['konten'],
                        $komponenMeta['meta']
                    ),
                    []
                ); // Format komponen
            }

            // Replace data syntax
            $x['konten_terformat'] = $this->dataSyntaxQueryProcessor->processDataSyntax($x['konten_terformat']);

            // dd($komponenMeta['meta']);
            // dd($x['konten_terformat']);

            // '[{"id":"bold_text","value":"zzsx"},{"id":"italic_text","value":"zzzzzz"},{"id":"underline_text","value":"zzzzzzzzzzzz"},{"id":"strikethrough_text","value":"zzzzzzzzzzzzzzzzz"},{"id":"number","value":"22222"},{"id":"datetime","value":"2024-09-13T10:33"},{"id":"email","value":"simslifepbluns@gmail.com"},{"id":"password","value":"wdqwdqwdqwddqw"},{"id":"color_picker","value":"#000000"},{"id":"range","value":"57"},{"id":"accept_terms","value":"on"},{"id":"gender","value":"female"},{"id":"upload_file","value":["http:\/\/localhost:8000\/assets\/components\/uploads\/1726198454_e301f94e93b09b0533ab.json"]},{"id":"country","value":"us"},{"id":"comments","value":"greargegargerge"},{"id":"favorite_color","value":"green"},{"id":"gender2","value":"female"}]'

            // Store the formatted konten in the Twig loader
            $loader->setTemplate("komponen_$i", $x['konten_terformat']);

            $komponenTerformat[] = $x;
        }

        $this->data['halaman'] = $halaman;
        $this->data['komponen'] = $komponenTerformat;

        // dd($komponenTerformat);

        ///////////////
        helper('format');

        return view('halaman', $this->data);
    }
}
