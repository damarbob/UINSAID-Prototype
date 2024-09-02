<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\SitusModel;

class Shutdown extends ResourceController
{
    // Untuk mematikan website
    public function shutdown()
    {
        $apiKey = $this->request->getHeaderLine('X-API-Key');

        // Cek API Key apakah sesuai dengan di file .env
        if ($apiKey !== env('app.apiKey')) {
            return $this->failUnauthorized(lang('Admin.kunciAPISalah'));
        }

        $situsModel = new SitusModel();
        $site = $situsModel->orderBy('id', 'ASC')->first(); // Get the first entry

        if ($site) {
            $situsModel->update($site['id'], ['status' => 'inactive']);
            return $this->respond(['message' => lang('Admin.situsBerhasilDinonaktifkan')], 200);
        }

        return $this->failNotFound(lang('Admin.situsTidakDitemukan'));
    }

    // Untuk mengembalikan website
    public function restore()
    {
        $apiKey = $this->request->getHeaderLine('X-API-Key');

        // Cek API Key apakah sesuai dengan di file .env
        if ($apiKey !== env('app.apiKey')) {
            return $this->failUnauthorized(lang('Admin.kunciAPISalah'));
        }

        $situsModel = new SitusModel();
        $site = $situsModel->orderBy('id', 'ASC')->first(); // Get the first entry

        if ($site) {
            $situsModel->update($site['id'], ['status' => 'active']);
            return $this->respond(['message' => lang('Admin.situsBerhasilDipulihkan')], 200);
        }

        return $this->failNotFound(lang('Admin.situsTidakDitemukan'));
    }
}
