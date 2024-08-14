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

        $berita = format_tanggal($this->beritaModel->getPaginated());
        // dd(format_tanggal($berita));
        $this->data['berita'] = format_tanggal($berita);
        $this->data['pagerBerita'] = $this->beritaModel->pager;
        $this->data['beritaTerbaru'] = format_tanggal($this->beritaModel->getTerbaru(3));

        return view('berita', $this->data);
    }

    public function get($slug)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $berita = $this->beritaModel->getBySlug($slug);
        // dd(format_tanggal($berita));
        $this->data['berita'] = format_tanggal($berita);
        $this->data['beritaTerbaru'] = format_tanggal($this->beritaModel->getTerbaru(3));

        // dd($berita);

        return view('berita_item', $this->data);
    }
}
