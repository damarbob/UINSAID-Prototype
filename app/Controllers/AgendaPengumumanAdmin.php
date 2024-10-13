<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\capitalize_first_letter;
use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class AgendaPengumumanAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.agenda');
        $this->data['rute'] = "agenda"; // URL route
        return view('admin_agenda_pengumuman', $this->data);
    }

    public function indexPengumuman(): string
    {
        $this->data['judul'] = lang('Admin.pengumuman');
        $this->data['rute'] = "pengumuman"; // URL route
        return view('admin_agenda_pengumuman', $this->data);
    }

    // BARU
    public function utama($jenis): string
    {
        $this->data['judul'] = capitalize_first_letter($jenis);
        $this->data['rute'] = $jenis; // URL route
        return view('admin_agenda_pengumuman', $this->data);
    }

    // BARU
    public function tambah($jenis): string
    {
        $dataJenis = $this->acaraJenisModel->getByNama($jenis);
        $idJenis = $dataJenis['id'] ?: null;

        $this->data['judul'] = lang('Admin.tambahX', [capitalize_first_letter($jenis)]);
        $this->data['mode'] = "tambah";
        $this->data['rute'] = $jenis; // URL route
        $this->data['idJenis'] = $idJenis;

        return view('admin_agenda_pengumuman_editor', $this->data);
    }

    // BARU
    public function sunting($jenis)
    {
        $dataJenis = $this->acaraJenisModel->getByNama($jenis);
        $idJenis = $dataJenis['id'] ?: null;

        $id = $this->request->getGet('id');
        $acara = $this->agendaPengumumanModel->getByID($id); // 

        if (empty($acara)) {
            throw new PageNotFoundException();
        }

        $this->data['judul'] = lang('Admin.suntingX', [capitalize_first_letter($jenis)]);
        $this->data['mode'] = "sunting";
        $this->data['item'] = $acara;
        $this->data['rute'] = $jenis; // URL route
        $this->data['idJenis'] = $idJenis;

        return view('admin_agenda_pengumuman_editor', $this->data);
    }

    public function tambahAgenda(): string
    {
        $jenis = 'agenda'; // Jenis acara Pengumuman
        $dataJenis = $this->acaraJenisModel->getByNama($jenis);
        $idJenis = $dataJenis['id'] ?: null;

        $this->data['judul'] = lang('Admin.tambahAgenda');
        $this->data['mode'] = "tambah";
        $this->data['rute'] = "agenda"; // URL route
        $this->data['idJenis'] = $idJenis;

        return view('admin_agenda_pengumuman_editor', $this->data);
    }

    public function tambahPengumuman(): string
    {
        $jenis = 'pengumuman'; // Jenis acara Pengumuman
        $dataJenis = $this->acaraJenisModel->getByNama($jenis);
        $idJenis = $dataJenis['id'] ?: null;

        $this->data['judul'] = lang('Admin.tambahPengumuman');
        $this->data['mode'] = "tambah";
        $this->data['rute'] = "pengumuman"; // URL route
        $this->data['idJenis'] = $idJenis;

        return view('admin_agenda_pengumuman_editor', $this->data);
    }

    public function suntingAgenda(): string
    {
        $jenis = 'agenda'; // Jenis acara Agenda
        $dataJenis = $this->acaraJenisModel->getByNama($jenis);
        $idJenis = $dataJenis['id'] ?: null;

        $id = $this->request->getGet('id');
        $agenda = $this->agendaPengumumanModel->getByID($id); // 

        if (empty($agenda)) {
            throw new PageNotFoundException();
        }

        $this->data['judul'] = lang('Admin.suntingAgenda');
        $this->data['mode'] = "sunting";
        $this->data['item'] = $agenda;
        $this->data['rute'] = "agenda"; // URL route
        $this->data['idJenis'] = $idJenis;

        return view('admin_agenda_pengumuman_editor', $this->data);
    }

    public function suntingPengumuman(): string
    {
        $jenis = 'pengumuman'; // Jenis acara Pengumuman
        $dataJenis = $this->acaraJenisModel->getByNama($jenis);
        $idJenis = $dataJenis['id'] ?: null;
        // dd($idJenis);

        $id = $this->request->getGet('id');
        $pengumuman = $this->agendaPengumumanModel->getByID($id);

        if (empty($pengumuman)) {
            throw new PageNotFoundException();
        }

        $this->data['judul'] = lang('Admin.suntingPengumuman');
        $this->data['mode'] = "sunting";
        $this->data['item'] = $pengumuman; // 
        $this->data['rute'] = "pengumuman"; // URL route
        $this->data['idJenis'] = $idJenis;

        return view('admin_agenda_pengumuman_editor', $this->data);
    }

    public function getDTAgenda($status = null)
    {
        // $idJenis = 3; // Agenda

        // Call getDT and pass the required parameters
        return $this->getDT(status: $status, namaJenis: 'agenda');
    }

    public function getDTPengumuman($status = null)
    {
        // $idJenis = 4; // Pengumuman

        // Call getDT and pass the required parameters
        return $this->getDT(status: $status, namaJenis: 'pengumuman');
    }

    private function getDT(string $namaJenis, $status = null)
    {
        // dd($namaJenis);
        $dataJenis = $this->acaraJenisModel->getByNama($namaJenis);
        $idJenis = $dataJenis['id'];

        // $columns = ['id_jenis', 'judul', 'waktu_mulai', 'created_at', 'status']; // DEBUG id_jenis
        $columns = ['judul', 'waktu_mulai', 'created_at', 'status'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->agendaPengumumanModel->where('id_jenis', $idJenis)->countAllResults(); // Count Agenda
        $totalFiltered = $totalData;

        $agenda = $this->agendaPengumumanModel->getAcara($limit, $start, $status, $search, $order, $dir, idJenis: $idJenis);

        if ($search || $status) {
            $totalFiltered = $this->agendaPengumumanModel->getAcaraTotalRecords($status, $search, idJenis: $idJenis);
        }

        $data = [];
        if (!empty($agenda)) {
            foreach ($agenda as $row) {
                $nestedData['id'] = $row->id;
                $nestedData['judul'] = $row->judul;
                $nestedData['waktu_mulai'] = $row->waktu_mulai;
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


    // Simpan. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    public function simpanAgenda($id = null)
    {

        // dd($this->request->getVar());
        // Validasi
        $rules = [
            'judul' => [
                'label' => lang('Admin.agenda'),
                'rules' => 'required',
            ],
            'waktu_mulai' => [
                'label' => lang('Admin.waktuMulai'),
                'rules' => 'required',
            ],
            'status' => [
                'label' => lang('Admin.status'),
                'rules' => 'required',
            ],
            'file_gambar' => [
                'label' => lang('Admin.gambar'),
                'rules' => 'max_size[file_gambar,4096]|mime_in[file_gambar,image/png,image/jpeg,image/jpg]|is_image[file_gambar]',
            ]
        ];

        // Redireksi
        $redirectTo = ($id == null) ? '/admin/agenda/' : '/admin/agenda/sunting?id=' . $id;

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
                    'judul' => $this->request->getPost('judul_gambar'),
                    'alt' => $this->request->getPost('alt_gambar'),
                    'deskripsi' => $this->request->getPost('deskripsi_gambar'),
                ];
                $galeriModel->save($data);
                $galeriId = $galeriModel->getInsertID();
            } else {
                $galeriId = $this->request->getVar('galeri') != '' ? $this->request->getVar('galeri') : null; // Jika gambar tidak valid, ambil galeri (memungkinkan bernilai NULL)
            }
        } else {
            $galeriId = $this->request->getVar('galeri')  != '' ? $this->request->getVar('galeri') : null;
        }

        // Simpan agenda
        if ($id == null) {
            // Jika ID kosong, buat entri baru
            $data = [
                'id_jenis' => $this->request->getVar('id_jenis'),
                'judul' => $this->request->getVar('judul'),
                'konten' => $this->request->getVar('konten'),
                'waktu_mulai' => $this->request->getVar('waktu_mulai'),
                'waktu_selesai' => $this->request->getVar('waktu_selesai') != '' ? $this->request->getVar('waktu_selesai') : null,
                'status' => $this->request->getVar('status'),
                'id_galeri' => $galeriId,
            ];
            // dd($data);
            $this->agendaPengumumanModel->save($data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        } else {
            // Jika id terisi, perbarui yang sudah ada
            $this->agendaPengumumanModel->save([
                'id' => $id,
                'id_jenis' => $this->request->getVar('id_jenis'),
                'judul' => $this->request->getVar('judul'),
                'konten' => $this->request->getVar('konten'),
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

    // Tambah rilis media. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    public function simpanPengumuman($id = null)
    {

        // Validasi
        $rules = [
            'judul' => [
                'label' => lang('Admin.pengumuman'),
                'rules' => 'required',
            ],
            'waktu_mulai' => [
                'label' => lang('Admin.waktuMulai'),
                'rules' => 'required',
            ],
            'status' => [
                'label' => lang('Admin.status'),
                'rules' => 'required',
            ],
            'file_gambar' => [
                'label' => lang('Admin.gambar'),
                'rules' => 'max_size[file_gambar,4096]|mime_in[file_gambar,image/png,image/jpeg,image/jpg]|is_image[file_gambar]',
            ]
        ];

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
                    'judul' => $this->request->getPost('judul_gambar'),
                    'alt' => $this->request->getPost('alt_gambar'),
                    'deskripsi' => $this->request->getPost('deskripsi_gambar'),
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
                'id_jenis' => $this->request->getVar('id_jenis'),
                'judul' => $this->request->getVar('judul'),
                'konten' => $this->request->getVar('konten'),
                'waktu_mulai' => $this->request->getVar('waktu_mulai'),
                'waktu_selesai' => $this->request->getVar('waktu_selesai') != '' ? $this->request->getVar('waktu_selesai') : null,
                'status' => $this->request->getVar('status'),
                'id_galeri' => $galeriId,
            ];

            $this->agendaPengumumanModel->save($data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        } else {
            // Jika id terisi, perbarui yang sudah ada
            $this->agendaPengumumanModel->save([
                'id' => $id,
                'id_jenis' => $this->request->getVar('id_jenis'),
                'judul' => $this->request->getVar('judul'),
                'konten' => $this->request->getVar('konten'),
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

        $result = delete_many($selectedIds, $this->agendaPengumumanModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }
}
