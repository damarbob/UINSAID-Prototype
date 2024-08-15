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

        $this->data['kategori'] = $this->kategoriModel->findAll();

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

    public function getByKategori($kategori)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $berita = $this->beritaModel->getByKategori($kategori);
        // dd(format_tanggal($berita));
        $this->data['berita'] = format_tanggal($berita);
        $this->data['pagerBerita'] = $this->beritaModel->pager;
        $this->data['beritaTerbaru'] = null;

        $this->data['kategori'] = $this->kategoriModel->findAll();
        $this->data['namaKategori'] = $kategori;

        // dd(sizeof($berita));

        return view('berita_kategori', $this->data);
    }
}
