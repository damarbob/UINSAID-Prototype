<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class BeritaAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.berita');
        return view('admin_berita', $this->data);
    }

    public function tambah(): string
    {
        $this->data['judul'] = lang('Admin.tambahBerita');
        $this->data['mode'] = "tambah";
        $this->data['kategori'] = $this->kategoriModel->findAll();
        return view('admin_berita_editor', $this->data);
    }

    public function sunting(): string
    {
        $id = $this->request->getGet('id');
        $this->data['judul'] = lang('Admin.suntingBerita');
        $this->data['mode'] = "sunting";
        $this->data['berita'] = $this->beritaModel->getById($id); // 
        $this->data['kategori'] = $this->kategoriModel->findAll();
        return view('admin_berita_editor', $this->data);
    }

    public function fetchData()
    {
        // $columns = [lang('Admin.judul'), lang('Admin.penulis'), lang('Admin.kategori'), lang('Admin.tanggal'), lang('Admin.status')];
        $columns = ['judul', 'penulis', 'kategori', 'created_at', 'status'];
        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->beritaModel->countAll();
        $totalFiltered = $totalData;

        // $berita = format_tanggal($this->beritaModel->getBerita($limit, $start, $search, $order, $dir));
        $berita = $this->beritaModel->getBerita($limit, $start, $search, $order, $dir);

        if ($search) {
            $totalFiltered = $this->beritaModel->getTotalRecords($search);
        }

        $data = [];
        if (!empty($berita)) {
            foreach ($berita as $row) {
                $nestedData['id'] = $row->id;
                $nestedData['judul'] = $row->judul;
                $nestedData['penulis'] = $row->penulis_username;
                $nestedData['kategori'] = $row->kategori;
                // $nestedData['created_at_timestamp'] = $row->created_at_timestamp;
                $nestedData['created_at'] = $row->created_at;
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


    public function get()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaModel->get())
        ]));
    }

    public function getDipublikasikan()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaModel->getDipublikasikan())
        ]));
    }

    public function getDraf()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaModel->getDraf())
        ]));
    }

    // Tambah rilis media. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    public function simpan($id = null)
    {
        // Validasi
        // Jika buat baru, tambahkan kondisi is_unique agar tidak ada judul berita yang sama.
        $rules = ($id == null) ? $this->formRules('required|is_unique[berita.judul]') : $this->formRules('required');

        // Redireksi
        $redirectTo = ($id == null) ? '/admin/berita/' : '/admin/berita/sunting?id=' . $id;

        // Cek validasi
        if (!$this->validate($rules)) {
            return redirect()->to($redirectTo)->withInput();
        }

        // Cek kategori
        $kategoriNama = $this->request->getVar('kategori');
        $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);

        // Simpan kategori baru
        if (!$kategori) {
            $this->kategoriModel->save(['nama' => $kategoriNama]);
            $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        }

        // Simpan rilis media
        if ($id == null) {
            // Jika ID kosong, buat entri baru
            $this->beritaModel->save([
                'id_penulis' => auth()->id(),
                'judul' => $this->request->getVar('judul'),
                'konten' => $this->request->getVar('konten'),
                'ringkasan' => $this->request->getVar('ringkasan'),
                'id_kategori' => $kategori['id'],
                'status' => $this->request->getVar('status'),
            ]);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        } else {

            // Jika id terisi, perbarui yang sudah ada
            $this->beritaModel->save([
                'id' => $id,
                'judul' => $this->request->getVar('judul'),
                'konten' => $this->request->getVar('konten'),
                'ringkasan' => $this->request->getVar('ringkasan'),
                'id_kategori' => $kategori['id'],
                'status' => $this->request->getVar('status'),
            ]);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        }

        return redirect()->to($redirectTo)->withInput();
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->beritaModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.hapusBanyakSukses')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.hapusBanyakGagal')]);
        }
    }

    // Aturan validasi form artikel
    public function formRules($rules_nama)
    {
        $rules = [
            'judul' => [
                'rules' => $rules_nama,
            ],
            'konten' => [
                'rules' => 'required',
            ],
            'status' => [
                'rules' => 'required',
            ],
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
