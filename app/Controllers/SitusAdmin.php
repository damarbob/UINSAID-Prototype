<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\update_many;

class SitusAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.situs');
        return view('admin_situs', $this->data);
    }

    public function tambah(): string
    {
        $this->data['judul'] = lang('Admin.tambahSitus');
        $this->data['mode'] = "tambah";
        return view('admin_situs_editor', $this->data);
    }

    public function sunting(): string
    {
        $id = $this->request->getGet('id');
        $this->data['judul'] = lang('Admin.suntingSitus');
        $this->data['mode'] = "sunting";
        $this->data['situs'] = $this->situsModel->getById($id); // 
        // dd($this->data['situs']);
        return view('admin_situs_editor', $this->data);
    }

    public function get()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->situsModel->get())
        ]));
    }

    public function getAktif()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->situsModel->getAktif())
        ]));
    }

    public function getTidakAktif()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->situsModel->getTidakAktif())
        ]));
    }

    // Tambah rilis media. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    public function simpan($id = null)
    {
        // Validasi
        // Jika buat baru, tambahkan kondisi is_unique agar tidak ada judul berita yang sama.
        $rules = ($id == null) ? $this->formRulesTambah() : $this->formRulesSunting();

        // Redireksi
        $redirectTo = ($id == null) ? base_url('/admin/situs/') : base_url('/admin/situs/sunting?id=') . $id;

        if (!$this->validate($rules)) {
            // dd("Dead by input validation");

            if ($id == null) {
                return redirect()->back()->withInput();
            }

            return redirect()->to($redirectTo)->withInput();
        }

        // Simpan rilis media
        if ($id == null) {
            $user = [
                'nama' => $this->request->getVar('nama_situs'),
                'alamat' => $this->request->getVar('alamat_situs'),
            ];

            // Jika ID kosong, buat entri baru
            $this->situsModel->save($user);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        } else {

            // Jika id terisi, perbarui yang sudah ada
            $this->situsModel->save([
                'id' => $id,
                'nama' => $this->request->getVar('nama_situs'),
                'alamat' => $this->request->getVar('alamat_situs'),
            ]);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        }

        return redirect()->to($redirectTo)->withInput();
    }

    public function perbaruiStatusSitus()
    {
        // Get the 'id' and 'status' from the POST data
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        // Check if both 'id' and 'status' are present
        if (!$id || !$status) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Admin.inputError')
            ]);
        }

        // Fetch the site by ID
        $site = $this->situsModel->find($id);

        if (!$site) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Admin.siteNotFound')
            ]);
        }

        // Update the site status if it's valid
        if (in_array($status, ['active', 'inactive'])) {
            $this->situsModel->update($id, ['status' => $status]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => lang('Admin.statusUpdated')
            ]);
        }

        // Invalid status value
        return $this->response->setJSON([
            'status' => 'error',
            'message' => lang('Admin.invalidStatus')
        ]);
    }


    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->situsModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }

    // Aturan validasi form tambah
    public function formRulesTambah()
    {
        $rules = [
            'nama_situs' => [
                'rules' => 'required|is_unique[situs.nama]',
            ],
            'alamat_situs' => [
                'rules' => 'required|is_unique[situs.alamat]',
            ],
        ];

        return $rules;
    }

    // Aturan validasi form sunting
    public function formRulesSunting()
    {
        $rules = [
            'nama_situs' => [
                'rules' => 'required',
            ],
            'alamat_situs' => [
                'rules' => 'required',
            ],
        ];

        return $rules;
    }
}
