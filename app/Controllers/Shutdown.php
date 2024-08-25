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

        if ($apiKey !== SAID_API_KEY) {
            return $this->failUnauthorized('Invalid API Key');
        }

        $situsModel = new SitusModel();
        $site = $situsModel->orderBy('id', 'ASC')->first(); // Get the first entry

        if ($site) {
            $situsModel->update($site['id'], ['status' => 'inactive']);
            return $this->respond(['message' => 'Site successfully shut down'], 200);
        }

        return $this->failNotFound('Site not found.');
    }

    // Untuk mengembalikan website
    public function restore()
    {
        $apiKey = $this->request->getHeaderLine('X-API-Key');

        if ($apiKey !== SAID_API_KEY) {
            return $this->failUnauthorized('Invalid API Key');
        }

        $situsModel = new SitusModel();
        $site = $situsModel->orderBy('id', 'ASC')->first(); // Get the first entry

        if ($site) {
            $situsModel->update($site['id'], ['status' => 'active']);
            return $this->respond(['message' => 'Site successfully restored'], 200);
        }

        return $this->failNotFound('Site not found.');
    }
}
