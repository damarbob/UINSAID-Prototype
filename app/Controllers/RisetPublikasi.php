<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class RisetPublikasi extends BaseControllerAdmin
{

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.berita');
        return view('berita_item', $this->data);
    }
}
