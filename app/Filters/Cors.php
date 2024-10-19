<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    // public function before(RequestInterface $request, $arguments = null)
    // {
    //     // Define allowed origins
    //     $allowedOrigins = [
    //         'http://localhost:8000',
    //         'http://uinsaid.ac.id',
    //         'http://*.uinsaid.ac.id'
    //     ];

    //     $origin = $request->getServer('HTTP_ORIGIN');

    //     // Check if the origin is allowed
    //     if (in_array($origin, $allowedOrigins)) {
    //         header('Access-Control-Allow-Origin: ' . $origin);
    //         header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    //         header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-API-KEY');

    //         // Handle OPTIONS request (Preflight request)
    //         if ($request->getMethod() === 'options') {
    //             header('Access-Control-Allow-Credentials: true');
    //             header('Access-Control-Max-Age: 86400'); // Cache the preflight response for 24 hours
    //             header('HTTP/1.1 200 OK');
    //             exit; // Stop further execution for preflight
    //         }
    //     }
    // }

    public function before(RequestInterface $request, $arguments = null)
    {
        // Get the origin of the request
        $origin = $request->getServer('HTTP_ORIGIN');

        // Dynamically get the base URL from the configuration
        $baseUrl = parse_url(base_url(), PHP_URL_HOST);

        // Define localhost pattern to allow all ports
        $localhostPattern = '/^http:\/\/localhost:\d+$/';

        // Check if the origin is a subdomain of the base URL
        // $isBaseUrlOrigin = preg_match("/^(https?:\/\/)?([a-z0-9-]+\.)?$baseUrl$/", $origin);
        $isBaseUrlOrigin = preg_match("/^(https?:\/\/)?([a-z0-9-]+\.)?" . preg_quote($baseUrl) . "$/", $origin);

        $isLocalhostOrigin = false;
        $isWebdemoOrigin = false;

        // If the environment is 'development'
        if (ENVIRONMENT === 'development') {

            // Check if the origin is localhost
            $isLocalhostOrigin = preg_match($localhostPattern, $origin);

            // Check if the origin is webdemo
            $isWebdemoOrigin = preg_match("/^(https?:\/\/)?([a-z0-9-]+\.)?$baseUrl$/", $origin);
        }

        // Allow CORS if the origin is a subdomain of the base URL or localhost (in development)
        if ($isBaseUrlOrigin || $isLocalhostOrigin || $isWebdemoOrigin) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-API-KEY');
            header('Access-Control-Allow-Credentials: true');

            // Handle preflight (OPTIONS) request
            if ($request->getMethod() === 'options') {
                header('Access-Control-Max-Age: 86400');
                header('HTTP/1.1 200 OK');
                exit;
            }
        }
    }



    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Additional after request logic if needed
    }
}
