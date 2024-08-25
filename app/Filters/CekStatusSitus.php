<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\SitusModel;

class CekStatusSitus implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $situsModel = new SitusModel();
        $site = $situsModel->orderBy('id', 'ASC')->first(); // Get the first entry

        if ($site && $site['status'] === 'inactive') {
            $currentPath = $request->getUri()->getPath();

            // dd($request->getUri()->getPath());

            // Avoid redirecting if already on the maintenance page or API endpoints
            if ($currentPath !== 'maintenance' && strpos($currentPath, 'api/') !== 0) {
                return redirect()->to('/maintenance');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
