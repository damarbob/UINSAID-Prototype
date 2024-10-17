<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\format_tanggal_suatu_kolom;

class PPID extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->data['renderDefaultMeta'] = false; // Overwrite default meta
    }

    public function index(): string
    {
        helper('format');
        $this->data['judul'] = lang('Admin.ppid');

        $search = $this->request->getGet('search') ?? '';

        // $ppid = format_tanggal($this->postingModel->getPaginated('ppid', $search));
        // dd(format_tanggal($ppid));
        // $this->data['ppid'] = format_tanggal($ppid);
        $this->data['pagerPPID'] = $this->postingModel->pager;
        $this->data['ppidTerbaru'] = format_tanggal($this->postingModel->getTerbaru('ppid', 3));

        $this->data['kategori'] = $this->kategoriModel->getKategoriByJenisNama('ppid');

        return view('ppid', $this->data);
    }

    public function get($slug)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.ppid');

        $ppid = $this->postingModel->getBySlug($slug);
        // dd($ppid);
        $this->data['ppid'] = format_tanggal_suatu_kolom($ppid, 'tanggal_terbit');
        $this->data['beritaTerbaru'] = format_tanggal_suatu_kolom($this->postingModel->getTerbaru('berita', 3), 'tanggal_terbit');

        // dd($ppid);

        return view('ppid_item', $this->data);
    }

    public function getByKategori($kategori)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.ppid');

        // dd(urldecode($kategori));

        $ppid = $this->postingModel->getByKategori('ppid', urldecode($kategori));
        // dd(format_tanggal($ppid));
        $this->data['ppid'] = format_tanggal_suatu_kolom($ppid, 'tanggal_terbit');
        $this->data['pagerPPID'] = $this->postingModel->pager;
        $this->data['ppidTerbaru'] = null;

        $this->data['kategori'] = $this->kategoriModel->getKategoriByJenisNama('ppid');
        $this->data['namaKategori'] = $kategori;

        // dd(sizeof($ppid));

        return view('ppid_kategori', $this->data);
    }
}
