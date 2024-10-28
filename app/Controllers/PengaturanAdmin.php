<?php

namespace App\Controllers;

use App\Controllers\BaseControllerAdmin;
use App\Libraries\FileCleanupService;
use App\Models\TemaModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PengaturanAdmin extends BaseControllerAdmin
{

    protected $fileCleanupService;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->model = $this->komponenModel;
        $this->fileCleanupService = new FileCleanupService();
    }

    public function index()
    {
        helper('setting'); // Must be declared to use setting helper function

        $temaModel = new TemaModel();

        $this->data['entitas'] = $this->entitasModel->findAll();
        $this->data['judul'] = lang('Admin.pengaturan');
        $this->data['halaman'] = $this->halamanModel->getPublikasi();
        $this->data['tema'] = $temaModel->findAll();

        /* Save settings */
        $post = $this->request->getPost();
        $files = $this->request->getFiles();

        if (!empty($post) || !empty($files)) {
            // dd($post);

            $rules = [
                'entitasSitus' => [
                    'label' => lang('Admin.entitasSitus'),
                    'rules' => 'required',
                ],
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
                'ikon_file' => [
                    'label' => lang('Admin.ikon'),
                    'rules' => 'max_size[ikon_file,4096]|mime_in[ikon_file,image/png,image/jpeg,image/jpg]|is_image[ikon_file]',
                ],
                'logo_file' => [
                    'label' => lang('Admin.logo'),
                    'rules' => 'max_size[logo_file,4096]|mime_in[logo_file,image/png,image/jpeg,image/jpg]|is_image[logo_file]',
                ],
                'logo_mobile_file' => [
                    'label' => lang('Admin.logoMobile'),
                    'rules' => 'max_size[logo_mobile_file,4096]|mime_in[logo_mobile_file,image/png,image/jpeg,image/jpg]|is_image[logo_mobile_file]',
                ],
                'logo_footer_file' => [
                    'label' => lang('Admin.logoFooter'),
                    'rules' => 'max_size[logo_footer_file,4096]|mime_in[logo_footer_file,image/png,image/jpeg,image/jpg]|is_image[logo_footer_file]',
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
                'targetUkuranThumbnail' => [
                    'label' => lang('Admin.targetUkuranThumbnail'),
                    'rules' => 'required',
                ],
                'bufferFactorThumbnail' => [
                    'label' => lang('Admin.bufferFactorThumbnail'),
                    'rules' => 'required',
                ],
            ];

            // Cek validasi input
            if (!$this->validate($rules)) {
                // Return to previous page  with validation error
                return redirect()->back()->withInput();
            }

            // Pengaturan umum
            service('settings')->set('App.entitasSitus', $post['entitasSitus']);
            service('settings')->set('App.judulSitus', $post['judulSitus']);
            service('settings')->set('App.deskripsiSitus', $post['deskripsiSitus']);
            service('settings')->set('App.kataKunciSitus', $post['kataKunciSitus']);
            service('settings')->set('App.seoSitus', $post['seoSitus']);

            // Pengaturan tampilan
            service('settings')->set('App.alamat', $post['alamat']);
            service('settings')->set('App.telepon', $post['telepon']);
            service('settings')->set('App.email', $post['email']);
            service('settings')->set('App.temaSitus', $post['temaSitus']);
            service('settings')->set('App.halamanUtamaSitus', $post['halamanUtamaSitus']);

            // Pengaturan personal
            $context = 'user:' . user_id(); // Context untuk pengguna
            service('settings')->set('App.temaDasborAdmin', $post['temaDasborAdmin'], $context);
            service('settings')->set('App.barisPerHalaman', $post['barisPerHalaman'], $context);

            /* Files upload */
            $ikonFile = $files['ikon_file'];
            $logoFile = $files['logo_file'];
            $logoMobileFile = $files['logo_mobile_file'];
            $logoFooterFile = $files['logo_footer_file'];

            // Initialize file paths
            $ikonPath = null;
            $logoPath = null;
            $logoMobilePath = null;
            $logoFooterPath = null;

            // Handle ikon file upload
            if ($ikonFile && $ikonFile->isValid() && !$ikonFile->hasMoved()) {
                $originalName = url_title(pathinfo($ikonFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                $randomName = $ikonFile->getRandomName(); // Generate a random file name
                $ikonFile->move(FCPATH . 'assets/img/ikon/', $originalName . '-' . $randomName);
                $ikonPath = ('assets/img/ikon/' . $originalName . '-' . $randomName);
            } else {
                $ikonPath = $post['ikon_old'];
            }

            // Handle logo file upload
            if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
                $originalName = url_title(pathinfo($logoFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                $randomName = $logoFile->getRandomName(); // Generate a random file name
                $logoFile->move(FCPATH . 'assets/img/logo/', $originalName . '-' . $randomName);
                $logoPath = ('assets/img/logo/' . $originalName . '-' . $randomName);
            } else {
                $logoPath = $post['logo_old'];
            }

            // Handle logo mobile file upload
            if ($logoMobileFile && $logoMobileFile->isValid() && !$logoMobileFile->hasMoved()) {
                $originalName = url_title(pathinfo($logoMobileFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                $randomName = $logoMobileFile->getRandomName(); // Generate a random file name
                $logoMobileFile->move(FCPATH . 'assets/img/logo/', $originalName . '-' . $randomName);
                $logoMobilePath = ('assets/img/logo/' . $originalName . '-' . $randomName);
            } else {
                $logoMobilePath = $post['logo_mobile_old'];
            }

            // Handle logo footer file upload
            if ($logoFooterFile && $logoFooterFile->isValid() && !$logoFooterFile->hasMoved()) {
                $originalName = url_title(pathinfo($logoFooterFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                $randomName = $logoFooterFile->getRandomName(); // Generate a random file name
                $logoFooterFile->move(FCPATH . 'assets/img/logo/', $originalName . '-' . $randomName);
                $logoFooterPath = ('assets/img/logo/' . $originalName . '-' . $randomName);
            } else {
                $logoFooterPath = $post['logo_footer_old'];
            }
            /* End of files upload */

            // Pengaturan dengan input file
            service('settings')->set('App.ikonSitus', $ikonPath);
            service('settings')->set('App.logoSitus', $logoPath);
            service('settings')->set('App.logoMobileSitus', $logoMobilePath);
            service('settings')->set('App.logoFooterSitus', $logoFooterPath);

            // Pengaturan lainnya
            service('settings')->set('App.sharingCaption', $post['sharingCaption']);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));

            // Return to previous page  with validation error
            return redirect()->to('admin/pengaturan')->withInput();
        }
        /* End of save settings */

        return view('admin_pengaturan', $this->data);
    }

    public function cleanupUnusedResources()
    {
        $folders = ['uploads']; // Define your folder paths
        $deletedFiles = $this->fileCleanupService->cleanUnusedFiles($folders);

        return dd($deletedFiles);
        return $this->response->setJSON(['deleted_files' => $deletedFiles]);
    }
}
