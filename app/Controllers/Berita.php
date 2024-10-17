<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\format_tanggal_suatu_kolom;

class Berita extends BaseController
{
    protected $postingJenisNama;
    protected $formatKolom = 'tanggal_terbit';

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->postingJenisNama = 'berita';
        $this->formatKolom = 'tanggal_terbit';

        $this->data['renderDefaultMeta'] = false; // Overwrite default meta
    }

    public function index(): string
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $search = $this->request->getGet('search') ?? null;

        $berita = $this->postingModel->getPaginated($this->postingJenisNama, $search);
        // dd(format_tanggal($this->postingModel->getPaginated($search)));
        $this->data['berita'] = format_tanggal_suatu_kolom($berita, $this->formatKolom, humanize: true);
        $this->data['pagerBerita'] = $this->postingModel->pager;
        $this->data['beritaTerbaru'] = format_tanggal_suatu_kolom($this->postingModel->getTerbaru($this->postingJenisNama, 3), $this->formatKolom, humanize: true);

        $this->data['kategori'] = $this->kategoriModel->getKategoriByJenisNama($this->postingJenisNama);

        return view('berita', $this->data);
    }

    public function get($slug)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $berita = $this->postingModel->getBySlug($slug);
        // dd(format_tanggal($berita));
        $this->data['berita'] = format_tanggal_suatu_kolom($berita, $this->formatKolom, true);
        $this->data['beritaTerbaru'] = format_tanggal_suatu_kolom($this->postingModel->getTerbaru($this->postingJenisNama, 3), $this->formatKolom, humanize: true);

        // dd($berita);

        return view('berita_item', $this->data);
    }

    public function getByKategori($kategori)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $berita = $this->postingModel->getByKategori($this->postingJenisNama, $kategori);
        // dd(format_tanggal($berita));
        $this->data['berita'] = format_tanggal_suatu_kolom($berita, $this->formatKolom, humanize: true);
        $this->data['pagerBerita'] = $this->postingModel->pager;
        $this->data['beritaTerbaru'] = null;

        $this->data['kategori'] = $this->kategoriModel->getKategoriByJenisNama($this->postingJenisNama);
        $this->data['namaKategori'] = $kategori;

        // dd(sizeof($berita));

        return view('berita_kategori', $this->data);
    }
}
