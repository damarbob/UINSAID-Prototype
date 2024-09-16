<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\format_tanggal;

class BeritaDiajukanAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.beritaDiajukan');
        return view('admin_berita_diajukan', $this->data);
    }

    // Fetch data untuk datatable
    public function fetchData($status = null)
    {
        $columns = ['judul', 'kategori', 'tgl_terbit', 'status', 'sumber'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
        $search = $this->request->getPost('search')['value'] ?? null;

        $totalData = $this->beritaDiajukanModel->countAll();
        $totalFiltered = $totalData;

        $berita = $this->beritaDiajukanModel->getBerita($limit, $start, $status, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->beritaDiajukanModel->getTotalRecords($status, $search);
        }

        $data = [];
        if (!empty($berita)) {
            foreach ($berita as $row) {

                $nestedData['id'] = $row->id;
                $nestedData['judul'] = $row->judul;
                $nestedData['penulis'] = $row->penulis_username;
                $nestedData['konten'] = $row->konten;
                $nestedData['kategori'] = $row->kategori;
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

    // Simpan ke rilis media
    public function simpan($id = null)
    {
        // Validasi
        // Jika buat baru, tambahkan kondisi is_unique agar tidak ada judul berita yang sama.
        $rules = ($id == null) ? $this->formRules('required|is_unique[berita.judul]') : $this->formRules('required');

        // Redireksi
        $redirectTo = ($id == null) ? base_url('/admin/berita/') : base_url('/admin/berita/sunting?id=' . $id);

        // Cek validasi
        if (!$this->validate($rules)) {
            if ($id == null) {
                return redirect()->back()->withInput();
            }
            return redirect()->to($redirectTo)->withInput();
        }

        // Cek kategori
        $kategoriNama = $this->request->getVar('kategori');

        if ($kategoriNama == '') {
            $kategoriNama = $this->request->getVar('kategori_lainnya');
        }
        $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        // Cek kategori. Jika baru, simpan kategori baru
        if (!$kategori) {
            $this->kategoriModel->save(['nama' => $kategoriNama]);
            $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        }

        // Simpan rilis media
        if ($id == null) {
            $user = [
                'id_penulis' => auth()->id(),
                'judul' => $this->request->getVar('judul'),
                'slug' => create_slug($this->request->getVar('judul')),
                'konten' => $this->request->getVar('konten'),
                'ringkasan' => $this->request->getVar('ringkasan'),
                'id_kategori' => $kategori['id'],
                'status' => $this->request->getVar('status'),
            ];

            // Jika ID kosong, buat entri baru
            $this->beritaModel->save($user);

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


    public function get()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaDiajukanModel->get())
        ]));
    }

    public function getPublikasi()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaDiajukanModel->getPublikasi())
        ]));
    }

    public function getDraf()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->beritaDiajukanModel->getDraf())
        ]));
    }

    public function publikasiBanyak()
    {
        $selectedData = $this->request->getPost('selectedData');

        $result = true;
        $errors = [];

        foreach ($selectedData as $data) {

            // Ambil beberapa konten berita dari database karena tidak ada dari selected data
            $dataDb = $this->beritaDiajukanModel->getByID($data['id']);
            $konten = $dataDb['konten'];
            $ringkasan = $dataDb['ringkasan'];

            // Prepare the data to be inserted
            $newEntry = [
                'id_penulis' => auth()->id(), // Assuming the current logged-in user's ID
                'judul' => $data['judul'],
                'slug' => create_slug($data['judul']),
                'konten' => $konten,
                'ringkasan' => $ringkasan,
                'id_kategori' => $this->getOrCreateKategori($data['kategori']),
                'status' => $data['status'],
                'tgl_terbit' => $data['tgl_terbit'],
                // Add other fields as needed
            ];

            // Insert the new entry into the database
            if (!$this->beritaModel->insert($newEntry)) {
                $result = false;
                $errors[] =  lang('Admin.gagalMenyimpanEntriDenganJudul', ['judul' => $data['judul']]);
            } else {
                // Jika berhasil, hapus permintaan pengajuan TODO: Tambah error-checking apabila gagal hapus
                $this->beritaDiajukanModel->delete($data['id']);
            }
        }

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDibuat')]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Admin.gagalDibuat'),
                'errors' => $errors,
            ]);
        }
    }

    public function hapusBanyak()
    {
        $selectedData = $this->request->getPost('selectedData');

        // Initialize result flag
        $result = true;

        // Loop through each selected row's data
        foreach ($selectedData as $rowData) {

            // Extract the ID
            $id = $rowData['id'];

            // Delete the record based on the ID
            if (!$this->beritaDiajukanModel->delete($id)) {
                $result = false;
                break;
            }
        }

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
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
        ];

        return $rules;
    }

    protected function getOrCreateKategori($kategoriNama)
    {
        // Check if the category exists
        $kategori = $this->kategoriModel->where('nama', $kategoriNama)->first();

        // If not, create a new category
        if (!$kategori) {
            $this->kategoriModel->save(['nama' => $kategoriNama]);
            $kategori = $this->kategoriModel->where('nama', $kategoriNama)->first();
        }

        // Return the ID of the category
        return $kategori['id'];
    }

    // Terima berita request dari API Endpoint
    public function terimaBeritaBanyak()
    {
        $selectedData = $this->request->getPost('selectedData');

        $result = true;
        $errors = [];

        foreach ($selectedData as $data) {

            // Prepare the data to be inserted
            $newEntry = [
                'id_penulis' => 0, // Assuming the current logged-in user's ID
                'judul' => $data['judul'],
                'slug' => create_slug($data['judul']),
                'konten' => $data['konten'],
                'ringkasan' => $data['ringkasan'],
                'id_kategori' => $this->getOrCreateKategori($data['kategori']),
                'status' => $data['status'],
                'sumber' => $data['sumber'],
                'tgl_terbit' => $data['tgl_terbit'],
                // Add other fields as needed
            ];

            // Insert the new entry into the database
            if (!$this->beritaDiajukanModel->insert($newEntry)) {
                $result = false;
                $errors[] = lang('Admin.gagalMenyimpanEntriDenganJudul', ['judul' => $data['judul']]);
            }
        }

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Permintaan berhasil dikirim!']);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Admin.permintaanGagalDikirim'),
                'errors' => $errors,
            ]);
        }
    }
}
