<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class Berita extends BaseController
{

    public function index(): string
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $berita = format_tanggal($this->beritaModel->get());
        // dd(format_tanggal($berita));
        $this->data['berita'] = $berita;

        return view('berita', $this->data);
    }

    public function get($slug)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $berita = $this->beritaModel->getBySlug($slug);
        // dd(format_tanggal($berita));
        $this->data['berita'] = format_tanggal($berita);

        return view('berita_item', $this->data);
    }
}
