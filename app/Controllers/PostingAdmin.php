<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\update_many;

class PostingAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.posting');
        $this->data['is_parent_site'] = $this->isParentSite;
        $this->data['is_child_site'] = $this->isChildSite;
        return view('admin_posting', $this->data);
    }

    public function tambah(): string
    {
        $this->data['judul'] = lang('Admin.tambahPosting');
        $this->data['mode'] = "tambah";
        $this->data['kategori'] = $this->kategoriModel->findAll();
        return view('admin_posting_editor', $this->data);
    }

    public function sunting(): string
    {
        $id = $this->request->getGet('id');
        $this->data['judul'] = lang('Admin.suntingPosting');
        $this->data['mode'] = "sunting";
        $this->data['posting'] = $this->postingModel->getById($id); // 
        $this->data['kategori'] = $this->kategoriModel->findAll();
        return view('admin_posting_editor', $this->data);
    }

    // Fetch data untuk datatable
    public function fetchData($status = null)
    {

        $columns = ['judul', 'penulis', 'kategori', 'tanggal_terbit', 'status'];

        // $columns = [lang('Admin.judul'), lang('Admin.penulis'), lang('Admin.kategori'), lang('Admin.tanggal'), lang('Admin.status')];
        // Only if this is child site change the columns with 'pengajuan'
        if ($this->isChildSite) {
            // Child dan super ada kolom pengajuan (di view juga)
            $columns = ['judul', 'penulis', 'kategori', 'pengajuan', 'tanggal_terbit', 'status'];
        }

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $statusX = $this->request->getPost('status');

        $draw = $this->request->getPost('draw');
        $totalData = $this->postingModel->countAll();
        $totalFiltered = $totalData;

        $posting = $this->postingModel->getByFilter('berita', $limit, $start, $statusX, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->postingModel->getTotalRecords('berita', $status, $search);
        }

        $data = [];
        if (!empty($posting)) {
            foreach ($posting as $row) {

                $nestedData['id'] = $row->id;
                $nestedData['judul'] = $row->judul;
                $nestedData['penulis'] = $row->penulis;
                $nestedData['kategori'] = $row->kategori;
                $nestedData['konten'] = $row->konten;
                $nestedData['ringkasan'] = $row->ringkasan;
                $nestedData['pengajuan'] = $row->pengajuan;
                $nestedData['tanggal_terbit'] = $row->tanggal_terbit;
                $nestedData['created_at'] = $row->created_at;
                $nestedData['status'] = $row->status;
                $nestedData['sumber'] = $row->sumber;
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $this->response->setJSON($json_data);
    }

    public function getPublikasi()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->postingModel->getPublikasi('berita'))
        ]));
    }

    public function getDraf()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->postingModel->getDraf('berita'))
        ]));
    }

    /**
     * Simpan posting, baik untuk menambah baru atau memperbarui data yang ada.
     *
     * Jika parameter $id bernilai null, fungsi ini akan menambah posting baru.
     * Jika $id berisi, maka fungsi ini akan memperbarui posting yang ada.
     *
     * Fungsi ini memvalidasi input berdasarkan mode (tambah atau perbarui). Untuk mode tambah,
     * judul harus unik. Kategori akan diperiksa, dan jika tidak ada, akan dibuat baru.
     * Setelah data berhasil disimpan, pengguna akan diarahkan kembali ke halaman yang sesuai.
     *
     * @param int|null $id ID dari posting yang akan diperbarui. Jika null, akan membuat posting baru.
     * @return \CodeIgniter\HTTP\RedirectResponse Mengembalikan respons redireksi ke halaman sebelumnya atau halaman edit.
     */
    public function simpan($id = null)
    {
        $modeTambah = is_null($id);

        // Validasi input: jika buat baru, tambahkan 'is_unique' untuk mencegah judul yang sama.
        $rules = $this->formRules('required' . ($modeTambah ? '|is_unique[posting.judul]' : ''));

        // URL untuk redireksi setelah penyimpanan
        $redirectTo = base_url('/admin/posting/' . ($modeTambah ? '' : 'sunting?id=' . $id));

        // Jika validasi gagal, kembalikan ke halaman sebelumnya (halaman buat posting) dengan input.
        if (!$this->validate($rules)) {
            return $modeTambah ? redirect()->back() : redirect()->to($redirectTo)->withInput();
        }

        // Dapatkan jenis postingan dan kategori dari input
        $jenis = $this->postingJenisModel->getByNama($this->request->getVar('jenis'));
        $kategoriNama = $this->request->getVar('kategori') ?: $this->request->getVar('kategori_lainnya');

        // Periksa kategori, buat baru jika tidak ada
        $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        if (!$kategori) {
            $this->kategoriModel->save(['nama' => $kategoriNama]);
            $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        }

        // Data yang akan disimpan
        $data = [
            'id_penulis' => auth()->id(),
            'id_kategori' => $kategori['id'],
            'id_jenis' => $jenis['id'] ?? null, // Jenis postingan (null jika tidak ada)
            'judul' => $this->request->getVar('judul'),
            'slug' => create_slug($this->request->getVar('judul')),
            'konten' => $this->request->getVar('konten'),
            'ringkasan' => $this->request->getVar('ringkasan'),
            'status' => $this->request->getVar('status'),
            'tanggal_terbit' => $this->request->getVar('tanggal_terbit'),
        ];

        // Jika id ada, tambahkan ke array data untuk pembaruan
        if (!$modeTambah) {
            $data['id'] = $id;
        }

        // Simpan atau perbarui data posting
        $this->postingModel->save($data);

        // Set pesan flash untuk hasil operasi
        session()->setFlashdata('sukses', lang('Admin.' . ($modeTambah ? 'berhasilDibuat' : 'berhasilDiperbarui')));

        return redirect()->to($redirectTo)->withInput();
    }


    // // Tambah rilis media. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    // public function simpan($id = null)
    // {

    //     $isCreateMode = ($id == null);

    //     // Validasi
    //     // Jika buat baru, tambahkan kondisi is_unique agar tidak ada judul posting yang sama.
    //     $rules = ($isCreateMode) ? $this->formRules('required|is_unique[posting.judul]') : $this->formRules('required');

    //     // Redireksi
    //     $redirectTo = ($isCreateMode) ? base_url('/admin/posting/') : base_url('/admin/posting/sunting?id=') . $id;

    //     // Cek validasi
    //     if (!$this->validate($rules)) {
    //         // dd("Dead by input validation");

    //         if ($isCreateMode) {
    //             return redirect()->back()->withInput();
    //         }

    //         return redirect()->to($redirectTo)->withInput();
    //     }

    //     // Get jenis postingan dari request
    //     $jenisNama = $this->request->getVar('jenis');

    //     // 
    //     $jenis = $this->postingJenisModel->getByNama($jenisNama);

    //     // Get kategori from the request
    //     $kategoriNama = $this->request->getVar('kategori') ?: $this->request->getVar('kategori_lainnya');

    //     // Check if the kategori exists
    //     $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);

    //     // If the kategori does not exist, create a new one
    //     if (!$kategori) {
    //         $this->kategoriModel->save(['nama' => $kategoriNama]);
    //         $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
    //     }

    //     // Simpan rilis media
    //     if ($isCreateMode) {
    //         $user = [
    //             'id_penulis' => auth()->id(),
    //             'id_kategori' => $kategori['id'],
    //             'id_jenis' => ($jenis) ? $jenis['id'] : null, // Jenis postingan, jika $jenis tidak null, ambil 'id' nya
    //             'judul' => $this->request->getVar('judul'),
    //             'slug' => create_slug($this->request->getVar('judul')),
    //             'konten' => $this->request->getVar('konten'),
    //             'ringkasan' => $this->request->getVar('ringkasan'),
    //             'status' => $this->request->getVar('status'),
    //             'sumber' => base_url(),
    //             'tanggal_terbit' => $this->request->getVar('tanggal_terbit'),
    //         ];

    //         // Jika ID kosong, buat entri baru
    //         $this->postingModel->save($user);

    //         // dd($user);

    //         // Pesan berhasil diperbarui
    //         session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
    //     } else {
    //         $user = [
    //             'id' => $id,
    //             'id_kategori' => $kategori['id'],
    //             'id_jenis' => $jenis['id'], // Jenis postingan
    //             'judul' => $this->request->getVar('judul'),
    //             'konten' => $this->request->getVar('konten'),
    //             'ringkasan' => $this->request->getVar('ringkasan'),
    //             'status' => $this->request->getVar('status'),
    //             'tanggal_terbit' => $this->request->getVar('tanggal_terbit'),
    //         ];

    //         // Jika id terisi, perbarui yang sudah ada
    //         $this->postingModel->save($user);

    //         // dd($user);

    //         // Pesan berhasil diperbarui
    //         session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
    //     }

    //     return redirect()->to($redirectTo)->withInput();
    // }

    public function ajukanBanyak()
    {
        $selectedData = $this->request->getPost('selectedData');

        // Extract IDs from the selected data
        $ids = array_column($selectedData, 'id');

        // Define the data to update for all selected records
        $updateData = [
            'pengajuan' => 'diajukan',
        ];

        // Call update_many with the array of IDs
        $result = update_many($ids, $this->postingModel, $updateData);

        // If the update was successful, send the data to another route
        if ($result) {
            // Send the data to the 'terima-posting' route
            $response = $this->sendToTerimaBerita($selectedData);

            $statusCode = $response->getStatusCode();
            $responseBody = json_decode((string) $response->getBody(), true);

            switch ($statusCode) {
                case 200:
                    if ($responseBody['status'] === 'success') {
                        return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDiajukan')]);
                    } else {
                        return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.berhasilDiajukanTapiAdaMasalahPenerimaan')]);
                    }

                case 400:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.permintaanTidakValid')]);

                case 401:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.tidakDiizinkanAndaPerluLogin')]);

                case 403:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.aksesDitolakAndaTidakMemilikiIzin')]);

                case 404:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.ruteAtauSumberDayaTidakDitemukan')]);

                case 500:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.kesalahanServerSilakanCobaLagiNanti')]);

                default:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.terjadiKesalahanTidakTerdugaKodeStatus', ['kode' => $statusCode])]);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.gagalDiajukan')]);
        }
    }


    private function sendToTerimaBerita($selectedData)
    {
        $client = \Config\Services::curlrequest();

        $response = $client->post(base_url('api/posting-diajukan/terima-posting'), [
            'form_params' => [
                'selectedData' => $selectedData
            ]
        ]);

        return $response;
    }


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

        $result = update_many($selectedIds, $this->postingModel, $updateData);

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

        $result = delete_many($selectedIds, $this->postingModel);

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
            'tanggal_terbit' => [
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
        $filePath = ROOTPATH . 'public/uploads/' . $filename;

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            unlink($filePath);

            return $this->response->setStatusCode(200)->setJSON(['message' => lang('Admin.gambarTerhapus')]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => lang('Admin.gambarTidakDitemukan')]);
        }
    }
}
