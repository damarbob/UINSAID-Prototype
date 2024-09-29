<?php

namespace App\Filters;

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SuperAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Get the current user
        $auth = service('auth');
        $user = $auth->user();

        // Check if the user is logged in and belongs to the "superadmin" group
        if (!$user || !$user->inGroup('superadmin')) {
            return redirect()->to('/admin/dasbor')->with('galat', lang('Admin.aksesDitolakAndaTidakMemilikiIzin'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action required after the request
    }
}
