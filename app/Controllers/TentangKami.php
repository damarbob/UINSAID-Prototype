<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class TentangKami extends BaseController
{
    public function index()
    {
        $this->data['judul'] = 'Tentang Kami';

        return view('tentang_kami', $this->data);
    }
}
