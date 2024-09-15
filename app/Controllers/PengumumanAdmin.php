<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class PengumumanAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.pengumuman');
        return view('admin_pengumuman', $this->data);
    }

    public function tambah(): string
    {
        $this->data['judul'] = lang('Admin.tambahPengumuman');
        $this->data['mode'] = "tambah";
        return view('admin_pengumuman_editor', $this->data);
    }

    public function sunting(): string
    {
        $id = $this->request->getGet('id');
        $pengumuman = $this->pengumumanModel->getByID($id);
        if (empty($pengumuman)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }
        $this->data['judul'] = lang('Admin.suntingPengumuman');
        $this->data['mode'] = "sunting";
        $this->data['pengumuman'] = $pengumuman; // 
        return view('admin_pengumuman_editor', $this->data);
    }

    public function fetchData($status = null)
    {
        // $columns = [lang('Admin.judul'), lang('Admin.penulis'), lang('Admin.kategori'), lang('Admin.tanggal'), lang('Admin.status')];
        $columns = ['pengumuman', 'waktu_mulai', 'status'];
        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->pengumumanModel->countAll();
        $totalFiltered = $totalData;

        // $pengumuman = format_tanggal($this->pengumumanModel->getPengumuman($limit, $start, $search, $order, $dir));
        $pengumuman = $this->pengumumanModel->getPengumuman($limit, $start, $status, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->pengumumanModel->getTotalRecords($status, $search);
        }

        $data = [];
        if (!empty($pengumuman)) {
            foreach ($pengumuman as $row) {
                $nestedData['id'] = $row->id;
                $nestedData['pengumuman'] = $row->pengumuman;
                $nestedData['waktu'] = $row->waktu_mulai;
                $nestedData['status'] = $row->status;
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

    public function test()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->pengumumanModel->paginate(10))
        ]));
    }


    public function get()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->pengumumanModel->get())
        ]));
    }

    public function getPublikasi()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->pengumumanModel->getPublikasi())
        ]));
    }

    public function getDraf()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->pengumumanModel->getDraf())
        ]));
    }

    // Tambah rilis media. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    public function simpan($id = null)
    {
        // Validasi
        $rules = $this->formRules();

        // Redireksi
        $redirectTo = ($id == null) ? '/admin/pengumuman/' : '/admin/pengumuman/sunting?id=' . $id;

        // Cek validasi
        if (!$this->validate($rules)) {
            if ($id == null) {
                return redirect()->back()->withInput();
            }
            return redirect()->to($redirectTo)->withInput();
        }

        // Cek sumber gambar. Kalau unggah gambar baru, simpan gambar
        // Kalau pilih galeri, ambil ID galeri
        if ($this->request->getVar('image_source') == 'unggah') {
            $galeriModel = $this->galeriModel;
            $imageFile = $this->request->getFile('file_gambar');

            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imageFile->getMimeType(), $validTypes)) {
                    return redirect()->back()->withInput()->with('error', 'Invalid file type. Only JPEG, PNG, and GIF files are allowed.');
                }

                $newName = $imageFile->getRandomName();
                $imageFile->move(FCPATH . 'uploads', $newName);

                $data = [
                    'uri' => base_url('uploads/' . $newName),
                    'judul' => $this->request->getPost('judul'),
                    'alt' => $this->request->getPost('alt'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                ];
                $galeriModel->save($data);
                $galeriId = $galeriModel->getInsertID();
            } else {
                $galeriId = $this->request->getVar('galeri') != '' ? $this->request->getVar('galeri') : null; // Jika gambar tidak valid, ambil galeri (memungkinkan bernilai NULL)
            }
        } else {
            $galeriId = $this->request->getVar('galeri')  != '' ? $this->request->getVar('galeri') : null;
        }

        // Simpan pengumuman
        if ($id == null) {
            // Jika ID kosong, buat entri baru
            $data = [
                'pengumuman' => $this->request->getVar('pengumuman'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'waktu_mulai' => $this->request->getVar('waktu_mulai'),
                'waktu_selesai' => $this->request->getVar('waktu_selesai') != '' ? $this->request->getVar('waktu_selesai') : null,
                'status' => $this->request->getVar('status'),
                'id_galeri' => $galeriId,
            ];

            $this->pengumumanModel->save($data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        } else {
            // Jika id terisi, perbarui yang sudah ada
            $this->pengumumanModel->save([
                'id' => $id,
                'pengumuman' => $this->request->getVar('pengumuman'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'waktu_mulai' => $this->request->getVar('waktu_mulai'),
                'waktu_selesai' => $this->request->getVar('waktu_selesai') != '' ? $this->request->getVar('waktu_selesai') : null,
                'status' => $this->request->getVar('status'),
                'id_galeri' => $galeriId,
            ]);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        }

        return redirect()->to($redirectTo)->withInput();
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->pengumumanModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }

    // Aturan validasi form artikel
    public function formRules()
    {
        $rules = [
            'pengumuman' => [
                'rules' => 'required',
            ],
            'waktu_mulai' => [
                'rules' => 'required',
            ],
            'status' => [
                'rules' => 'required',
            ],
            'file_gambar' => [
                'rules' => 'max_size[file_gambar,4096]|mime_in[file_gambar,image/png,image/jpeg,image/jpg]|is_image[file_gambar]',
            ]
        ];

        return $rules;
    }

    // API Endpoint: unggah gambar ke server (untuk tinyMCE)
    public function unggahGambar()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();

            $file->move(ROOTPATH . 'public/uploads', $newName);

            // Respons yang diharapkan tinyMCE
            $response = [
                'location' => base_url('uploads/' . $newName),
            ];

            return $this->response->setStatusCode(200)->setJSON($response);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'File tidak valid!']);
        }
    }

    // API Endpoint: hapus gambar dari server
    public function hapusGambar()
    {
        $imageUrl = $this->request->getVar('image_url');

        // Extract the filename from the URL
        $filename = pathinfo($imageUrl, PATHINFO_BASENAME);

        // Construct the full server path
        $filePath = ROOTPATH . 'public/uploads/' . $filename;

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            unlink($filePath);

            return $this->response->setStatusCode(200)->setJSON(['message' => 'Gambar terhapus.']);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Gambar tidak ditemukan']);
        }
    }
}
