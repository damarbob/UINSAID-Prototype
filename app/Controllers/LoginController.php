<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends ShieldLogin
{
    public function loginAction(): RedirectResponse
    {
        $credentials['email']    = $this->request->getPost('email');
        $credentials['password'] = $this->request->getPost('password');

        $validCreds = auth()->check($credentials);
        $result = $validCreds->isOK();

        // Buat notifikasi
        $notifikasiModel = new NotifikasiModel();
        $notifikasiModel->insert([
            'jenis'     => NOTIFIKASI_PERINGATAN,
            'judul'     => lang('Admin.aktivitasLoginBaru'),
            'konten'    => $result ? lang('Admin.xBerhasilLogin', [$credentials['email']]) : lang('Admin.xGagalLogin', [$credentials['email']]),
            'link'      => base_url('admin/aktivitas-login')
        ]);
        return parent::loginAction();
    }

    public function logoutAction(): RedirectResponse
    {
        // Capture logout redirect URL before auth logout,
        // otherwise you cannot check the user in `logoutRedirect()`.
        $url = config('Auth')->logoutRedirect();

        auth()->logout();
        
        // Optionally, destroy the session
        session()->destroy();

        return redirect()->to($url)->with('message', lang('Auth.successLogout'));
    }
}
