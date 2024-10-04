<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class MediaSosialAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.mediaSosial');
        return view('admin_media_sosial', $this->data);
    }

    public function tambah(): string
    {
        $this->data['judul'] = lang('Admin.tambahMediaSosial');
        $this->data['mode'] = "tambah";
        $this->data['urutan'] = $this->mediaSosialModel->getUrutan();

        return view('admin_media_sosial_editor', $this->data);
    }

    public function sunting(): string
    {
        $id = $this->request->getGet('id');

        $item = $this->mediaSosialModel->getByID($id); // 
        if (empty($item)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('');
        }

        $this->data['judul'] = lang('Admin.suntingMediaSosial');

        $this->data['mode'] = "sunting";
        $this->data['item'] = $item;
        $this->data['urutan'] = $this->mediaSosialModel->getUrutan($id);

        return view('admin_media_sosial_editor', $this->data);
    }

    public function getDT()
    {
        $columns = ['urutan', 'nama', 'url', 'ikon', 'created_at'];
        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->mediaSosialModel->countAll();
        $totalFiltered = $totalData;

        $item = $this->mediaSosialModel->getDT($limit, $start, $search, $order, $dir);

        if ($search) {
            $totalFiltered = $this->mediaSosialModel->getDTTotalRecords($search);
        }

        // dd($item);

        $data = [];
        if (!empty($item)) {
            foreach ($item as $row) {
                $nestedData['id'] = $row->id;
                $nestedData['urutan'] = $row->urutan;
                $nestedData['nama'] = $row->nama;
                $nestedData['url'] = $row->url;
                $nestedData['ikon'] = $row->ikon;
                $nestedData['created_at'] = $row->created_at;
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

    // Tambah rilis media. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    public function simpan($id = null)
    {

        // dd("WTH");
        $data = $this->request->getPost();
        // dd($id);

        // Check for file uploads
        $ikonFile = $this->request->getFile('ikon_file');

        /* Files validation */
        $fileRules = []; // Contains file rules

        $ikonFileValid = $ikonFile && $ikonFile->isValid();

        if ($ikonFileValid) {
            if ($ikonFileValid) {
                $fileRules = array_merge(
                    $fileRules,
                    [
                        'ikon_file' => [
                            'label' => lang('Admin.ikon'),
                            'rules' => [
                                'uploaded[ikon_file]',
                                'max_size[ikon_file,4096]|mime_in[file_gambar,image/png,image/jpeg,image/jpg]|is_image[file_gambar]',
                            ]
                        ]
                    ]
                );
            }
            if (!$this->validateData([], $fileRules)) {
                return redirect()->back()->withInput();
            }
        }
        /* End of files validation */

        /* Input validation */
        $rules = [
            'nama' => [
                'label' => lang('Admin.nama'),
                'rules' => 'required',
            ],
            'url' => [
                'label' => lang('Admin.alamatSitus'),
                'rules' => 'required',
            ],
            'urutan' => [
                'label' => lang('Admin.urutan'),
                'rules' => 'required'
            ],
        ];
        // dd($data);

        // Cek validasi input
        if (!$this->validate($rules)) {

            // dd($halamanLama);
            // dd("Dead by validation");

            return redirect()->back()->withInput();
        }
        /* End of input validation */

        /* Files upload */
        // Initialize file paths
        $ikonPath = null;

        // Handle CSS file upload
        if ($ikonFile && $ikonFile->isValid() && !$ikonFile->hasMoved()) {
            $originalName = url_title(pathinfo($ikonFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
            $randomName = $ikonFile->getRandomName(); // Generate a random file name
            $ikonFile->move(FCPATH . 'assets/img/media-sosial/', $originalName . '-' . $randomName);
            $ikonPath = ('assets/img/media-sosial/' . $originalName . '-' . $randomName);
            $data['ikon'] = $ikonPath;
        } else {
            $data['ikon'] = $data['ikon_old'];
        }
        /* End of files upload */

        // dd($data);

        if ($id === null) {

            // Create new component
            $this->mediaSosialModel->save($data);

            // Pesan berhasil dibuat
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));

            return redirect()->to('admin/media-sosial/');
        } else {

            // Update existing component
            $this->mediaSosialModel->update($id, $data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        }

        $this->mediaSosialModel->reorder($data['urutan'], $id);

        return redirect()->to('admin/media-sosial/sunting?id=' . $id);
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->agendaModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }
}
