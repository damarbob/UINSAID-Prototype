<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\update_many;

class KategoriAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.kategori');
        $this->data['jenis'] = $this->postingJenisModel->findAll();
        return view('admin_kategori', $this->data);
    }

    // public function tambah(): string
    // {
    //     $this->data['judul'] = lang('Admin.tambahKategori');
    //     $this->data['mode'] = "tambah";
    //     $this->data['postingJenis'] = $this->postingJenisModel->findAll();
    //     return view('admin_kategori_editor', $this->data);
    // }

    // public function sunting(): string
    // {
    //     $id = $this->request->getGet('id');
    //     $this->data['judul'] = lang('Admin.suntingKategori');
    //     $this->data['mode'] = "sunting";
    //     $this->data['kategori'] = $this->kategoriModel->find($id);
    //     $this->data['postingJenis'] = $this->postingJenisModel->findAll();

    //     return view('admin_kategori_editor', $this->data);
    // }

    public function tambah()
    {
        $data = $this->request->getPost();



        // Prepare data for kategori table
        $kategoriData = [];
        if (!empty($data['nama'])) {
            $kategoriData['nama'] = $data['nama'];
            $kategoriData['terkunci'] = isset($data['terkunci']) ? 1 : 0;
            $kategoriData['id_jenis'] = $data['jenis'];
        }

        // Validation
        $validation = Services::validation();
        $validation->setRules(
            [
                'nama' => [
                    'label' => lang('Admin.nama'),
                    'rules' => 'required'
                ],
                'jenis' => [
                    'label' => lang('Admin.jenis'),
                    'rules' => 'required'
                ],
            ]
        );

        // Validate input
        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $validation->getErrors()
            ]);
        }

        $this->kategoriModel->save($kategoriData);

        return $this->response->setJSON([
            'success' => true,
            'message' => lang('Admin.berhasilDibuat')
        ]);
    }

    public function sunting()
    {
        $data = $this->request->getPost();

        // Prepare data for kategori table
        $kategoriData = [];
        $kategoriData['id'] = $data['id'];
        if (!empty($data['nama'])) {
            $kategoriData['nama'] = $data['nama'];
            $kategoriData['terkunci'] = isset($data['terkunci']) ? 1 : 0;;
        }

        // Validation
        $validation = Services::validation();
        $validation->setRules(
            [
                'nama' => [
                    'label' => lang('Admin.nama'),
                    'rules' => 'required'
                ],
            ]
        );

        // Validate input
        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $validation->getErrors()
            ]);
        }

        $this->kategoriModel->save($kategoriData);

        return $this->response->setJSON([
            'success' => true,
            'message' => lang('Admin.berhasilDiperbarui')
        ]);
    }

    // Fetch data untuk datatable
    public function fetchData()
    {
        $columns = ['nama', 'posting_jenis_nama', 'terkunci'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $jenisNama = $this->request->getPost('jenisNama');

        $draw = $this->request->getPost('draw');
        $totalData = $this->kategoriModel->countAllResults();
        $totalFiltered = $totalData;

        $kategori = $this->kategoriModel->getForDatatables(limit: $limit, start: $start, search: $search, order: $order, dir: $dir, jenisNama: $jenisNama);

        if ($search || $jenisNama) {
            $totalFiltered = sizeof($kategori);
        }

        $data = [];
        if (!empty($kategori)) {
            foreach ($kategori as $row) {

                $nestedData['id'] = $row->id;
                $nestedData['nama'] = $row->nama;
                $nestedData['posting_jenis_nama'] = $row->posting_jenis_nama;
                $nestedData['id_posting_jenis'] = $row->id_posting_jenis;
                $nestedData['terkunci'] = $row->terkunci;
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

        $kategori = $id ? $this->kategoriModel->find($id) : null;

        $namaLama = $id ? $kategori['nama'] : null;
        $namaBaru = $this->request->getPost('nama');

        // Validasi input: jika buat baru, tambahkan 'is_unique' untuk mencegah nama yang sama.
        $rules = $this->formRules('required' . ($modeTambah || $namaLama != $namaBaru ? '|is_unique[kategori.nama]' : ''));

        // URL untuk redireksi setelah penyimpanan
        $redirectTo = base_url('/admin/kategori/' . ($modeTambah ? '' : 'sunting?id=' . $id));

        // Jika validasi gagal, kembalikan ke halaman sebelumnya (halaman buat kategori) dengan input.
        if (!$this->validate($rules)) {
            return $modeTambah ? redirect()->back() : redirect()->to($redirectTo)->withInput();
        }

        // Data yang akan disimpan
        $data = [
            'nama' => $this->request->getVar('nama'),
            'id_jenis' => $this->request->getVar('id_jenis'),
            'terkunci' => $this->request->getVar('terkunci'),
        ];

        // Jika id ada, tambahkan ke array data untuk pembaruan
        if (!$modeTambah) {
            $data['id'] = $id;
        }

        // Simpan atau perbarui data kategori
        $this->kategoriModel->save($data);

        // Set pesan flash untuk hasil operasi
        session()->setFlashdata('sukses', lang('Admin.' . ($modeTambah ? 'berhasilDibuat' : 'berhasilDiperbarui')));

        return redirect()->to($redirectTo)->withInput();
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        // Tidak ada kategori terpilih
        if (empty($selectedIds)) {
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }

        // Cek apakah ada kategori yang terkunci
        if (count($selectedIds) == 1) {
            $kategori = $this->kategoriModel->find($selectedIds[0]);
            if ($kategori['terkunci'] == 1) {
                return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagalKarenaTerkunci')]);
            }
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        }

        foreach ($selectedIds as $id) {
            $this->kategoriModel->where(['id' => $id, 'terkunci' => 0])->delete();
        }

        return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
    }


    // Aturan validasi form artikel
    public function formRules($rules_nama)
    {
        $rules = [
            'nama' => [
                'rules' => $rules_nama,
            ],
            'id_jenis' => [
                'rules' => 'required',
            ],
            'terkunci' => [
                'rules' => 'required',
            ],
        ];

        return $rules;
    }

    /**
     * Get kategori by posting jenis
     * 
     * @return JSON kategori Kategori based on posting jenis
     */
    public function getKategoriByJenis()
    {
        $id_jenis = $this->request->getPost('id_jenis');

        // Fetch kategori based on posting_jenis
        $kategori = $this->kategoriModel->where('id_jenis', $id_jenis)->findAll();

        // Return the results as JSON
        return $this->response->setJSON(['kategori' => $kategori]);
    }
}
