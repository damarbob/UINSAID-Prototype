<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    public function handleOptions()
    {
        // Set the CORS headers for preflight request
        return $this
            ->response
            ->setHeader('Access-Control-Allow-Origin', '*') // or specific origin
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-API-KEY')
            ->setStatusCode(200); // Preflight success
    }

    // Other API methods (POST, GET, etc.)
}
