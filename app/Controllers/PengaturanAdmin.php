<?php

namespace App\Controllers;

use App\Controllers\BaseControllerAdmin;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PengaturanAdmin extends BaseControllerAdmin
{

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->model = $this->komponenModel;
    }

    public function index()
    {
        helper('setting'); // Must be declared to use setting helper function

        $this->data['judul'] = lang('Admin.pengaturan');
        $this->data['halaman'] = $this->halamanModel->getPublikasi();

        /* Save settings */
        $post = $this->request->getPost();

        if (!empty($post)) {
            // dd($post);

            $rules = [
                'judulSitus' => [
                    'label' => lang('Admin.judulSitus'),
                    'rules' => 'required|max_length[255]|min_length[5]',
                ],
                'deskripsiSitus' => [
                    'label' => lang('Admin.deskripsiSitus'),
                    'rules' => 'required|max_length[255]|min_length[50]',
                ],
                'kataKunciSitus' => [
                    'label' => lang('Admin.kataKunciSitus'),
                    'rules' => 'required|max_length[255]|min_length[5]',
                ],
                'seoSitus' => [
                    'label' => lang('Admin.optimasiMesinPencari'),
                    'rules' => 'required',
                ],
                'temaSitus' => [
                    'label' => lang('Admin.temaSitus'),
                    'rules' => 'permit_empty',
                ],
                'halamanUtamaSitus' => [
                    'label' => lang('Admin.halamanUtamaSitus'),
                    'rules' => 'permit_empty',
                ],
                'temaDasborAdmin' => [
                    'label' => lang('Admin.temaDasborAdmin'),
                    'rules' => 'required',
                ],
                'barisPerHalaman' => [
                    'label' => lang('Admin.barisPerHalaman'),
                    'rules' => 'required',
                ],
            ];

            // Cek validasi input
            if (!$this->validate($rules)) {
                // Return to previous page  with validation error
                return redirect()->back()->withInput();
            }

            service('settings')->set('App.judulSitus', $post['judulSitus']);
            service('settings')->set('App.deskripsiSitus', $post['deskripsiSitus']);
            service('settings')->set('App.kataKunciSitus', $post['kataKunciSitus']);
            service('settings')->set('App.seoSitus', $post['seoSitus']);
            service('settings')->set('App.temaSitus', $post['temaSitus']);
            service('settings')->set('App.halamanUtamaSitus', $post['halamanUtamaSitus']);

            // Pengaturan personal
            $context = 'user:' . user_id(); // Context untuk pengguna
            service('settings')->set('App.temaDasborAdmin', $post['temaDasborAdmin'], $context);
            service('settings')->set('App.barisPerHalaman', $post['barisPerHalaman'], $context);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));

            // Return to previous page  with validation error
            return redirect()->to('admin/pengaturan')->withInput();
        }
        /* End of save settings */

        return view('admin_pengaturan', $this->data);
    }
}
