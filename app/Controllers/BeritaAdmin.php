<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\ConfigException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use DomainException;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\update_many;

class BeritaAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.berita');
        $this->data['is_parent_site'] = $this->isParentSite;
        $this->data['is_child_site'] = $this->isChildSite;
        // dd(env('app.parentSite'));
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

    // Fetch data untuk datatable
    public function fetchData($status = null)
    {
        // $columns = [lang('Admin.judul'), lang('Admin.penulis'), lang('Admin.kategori'), lang('Admin.tanggal'), lang('Admin.status')];
        if ($this->isChildSite) {
            // Child dan super ada kolom pengajuan (di view juga)
            $columns = ['judul', 'penulis', 'kategori', 'pengajuan', 'tgl_terbit', 'status'];
        } else {
            $columns = ['judul', 'penulis', 'kategori', 'tgl_terbit', 'status'];
        }

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->beritaModel->countAll();
        $totalFiltered = $totalData;

        // $berita = format_tanggal($this->beritaModel->getBerita($limit, $start, $search, $order, $dir));
        $berita = $this->beritaModel->getBerita($limit, $start, $status, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->beritaModel->getTotalRecords($status, $search);
        }

        $data = [];
        if (!empty($berita)) {
            foreach ($berita as $row) {

                $nestedData['id'] = $row->id;
                $nestedData['judul'] = $row->judul;
                $nestedData['penulis'] = $row->penulis;
                $nestedData['kategori'] = $row->kategori;
                $nestedData['konten'] = $row->konten;
                $nestedData['ringkasan'] = $row->ringkasan;
                $nestedData['pengajuan'] = $row->pengajuan;
                $nestedData['tgl_terbit'] = $row->tgl_terbit;
                $nestedData['status'] = $row->status;
                $nestedData['sumber'] = $row->sumber;
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
            "data" => format_tanggal($this->beritaModel->paginate(10))
        ]));
    }

    public function get()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaModel->get())
        ]));
    }

    public function getPublikasi()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaModel->getPublikasi())
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

        $judul = $this->request->getVar('judul');
        $modeTambah = ($id == null);

        // Validasi
        // Jika buat baru, tambahkan kondisi is_unique agar tidak ada judul berita yang sama.
        $rules = $this->formRules('required');

        if (!$modeTambah) {
            $berita = $this->beritaModel->getByID($id); // Get postingan

            // Jika berita lama ditemukan dan jika judul berbeda dari sebelumnya, tambah validasi is_unique
            if ($berita && $judul != $berita['judul']) {
                $rules = $this->formRules('required|is_unique[berita.judul]');
            }
        }

        // Redireksi
        $redirectTo = ($modeTambah) ? base_url('/admin/berita/') : base_url('/admin/berita/sunting?id=') . $id;

        // Cek validasi
        if (!$this->validate($rules)) {

            if ($modeTambah) {
                return redirect()->back()->withInput();
            }

            return redirect()->to($redirectTo)->withInput();
        }

        // Get kategori from the request
        $kategoriNama = $this->request->getVar('kategori') ?: $this->request->getVar('kategori_lainnya');

        // Check if the kategori exists
        $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);

        // If the kategori does not exist, create a new one
        if (!$kategori) {
            $this->kategoriModel->save(['nama' => $kategoriNama]);
            $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        }

        // dd($kategori);

        // Simpan rilis media TODO: Buat seperti di PostingAdmin
        if ($modeTambah) {
            $data = [
                'id_penulis' => auth()->id(),
                'judul' => $judul,
                'slug' => create_slug($this->request->getVar('judul')),
                'konten' => $this->request->getVar('konten'),
                'ringkasan' => $this->request->getVar('ringkasan'),
                'id_kategori' => $kategori['id'],
                'status' => $this->request->getVar('status'),
                'sumber' => base_url(),
                'tgl_terbit' => $this->request->getVar('tgl_terbit'),
                'featured_image' => $this->beritaModel->extract_first_image($this->request->getVar('konten'), base_url('assets/img/icon-notext.png'), false),
            ];

            // Jika ID kosong, buat entri baru
            $this->beritaModel->save($data);

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
                'tgl_terbit' => $this->request->getVar('tgl_terbit'),
                'featured_image' => $this->beritaModel->extract_first_image($this->request->getVar('konten'), base_url('assets/img/icon-notext.png'), false),
            ]);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        }

        return redirect()->to($redirectTo)->withInput();
    }

    // API Endpoint
    // public function ajukanBanyak()
    // {
    //     // Check whether parent site has been configured
    //     $parent = env('app.parentSite');

    //     if ($parent == null) {
    //         return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.permintaanGagalDikirim')]);
    //     }

    //     $selectedData = $this->request->getPost('selectedData');

    //     // Extract IDs from the selected data
    //     $ids = array_column($selectedData, 'id');

    //     // Define the data to update for all selected records
    //     $updateData = [
    //         'pengajuan' => 'diajukan',
    //     ];

    //     // Call update_many with the array of IDs
    //     $result = update_many($ids, $this->beritaModel, $updateData);

    //     // If the update was successful, send the data to another route
    //     if ($result) {
    //         // Send the data to the 'terima-berita' route
    //         $response = $this->sendToTerimaBerita($selectedData, $parent);

    //         $statusCode = $response->getStatusCode();
    //         $responseBody = json_decode((string) $response->getBody(), true);

    //         switch ($statusCode) {
    //             case 200:
    //                 if ($responseBody['status'] === 'success') {
    //                     return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDiajukan')]);
    //                 } else {
    //                     return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.berhasilDiajukanTapiAdaMasalahPenerimaan')]);
    //                 }

    //             case 400:
    //                 return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.permintaanTidakValid')]);

    //             case 401:
    //                 return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.tidakDiizinkanAndaPerluLogin')]);

    //             case 403:
    //                 return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.aksesDitolakAndaTidakMemilikiIzin')]);

    //             case 404:
    //                 return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.ruteAtauSumberDayaTidakDitemukan')]);

    //             case 500:
    //                 return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.kesalahanServerSilakanCobaLagiNanti')]);

    //             default:
    //                 return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.terjadiKesalahanTidakTerdugaKodeStatus', ['kode' => $statusCode])]);
    //         }
    //     } else {
    //         return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.gagalDiajukan')]);
    //     }
    // }


    // private function sendToTerimaBerita(array $selectedData, string $parent)
    // {
    //     $client = \Config\Services::curlrequest();

    //     $response = $client->post($parent . 'api/berita-diajukan/terima-berita', [
    //         'form_params' => [
    //             'selectedData' => $selectedData
    //         ]
    //     ]);

    //     return $response;
    // }


    // TODO: USE TRANSLATION
    public function batalAjukanBanyak()
    {
        $selectedData = $this->request->getPost('selectedData');

        // Extract IDs from the selected data
        $selectedIds = array_column($selectedData, 'id');

        // Define the data to update for each record
        $updateData = [
            'pengajuan' => 'tidak diajukan',
        ];

        $result = update_many($selectedIds, $this->beritaModel, $updateData);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDibatalkan')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.gagalDibatalkan')]);
        }
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->beritaModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
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
            'tgl_terbit' => [
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

            $file->move(FCPATH . 'uploads', $newName);

            // Respons yang diharapkan tinyMCE
            $response = [
                'location' => base_url('uploads/' . $newName),
            ];

            return $this->response->setStatusCode(200)->setJSON($response);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => lang('Admin.fileTidakValid')]);
        }
    }

    // API Endpoint: hapus gambar dari server
    public function hapusGambar()
    {
        $imageUrl = $this->request->getVar('image_url');

        // Extract the filename from the URL
        $filename = pathinfo($imageUrl, PATHINFO_BASENAME);

        // Construct the full server path
        $filePath = FCPATH . 'uploads/' . $filename;

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            unlink($filePath);

            return $this->response->setStatusCode(200)->setJSON(['message' => lang('Admin.gambarTerhapus')]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => lang('Admin.gambarTidakDitemukan')]);
        }
    }
}
