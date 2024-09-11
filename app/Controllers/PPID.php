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

    public function index(): string
    {
        helper('format');
        $this->data['judul'] = lang('Admin.ppid');

        $search = $this->request->getGet('search') ?? '';

        $ppid = format_tanggal($this->ppidModel->getPaginated($search));
        // dd(format_tanggal($ppid));
        $this->data['ppid'] = format_tanggal($ppid);
        $this->data['pagerPPID'] = $this->ppidModel->pager;
        $this->data['ppidTerbaru'] = format_tanggal($this->ppidModel->getTerbaru(3));

        $this->data['kategori'] = $this->ppidModel->getUniqueCategories();

        return view('ppid', $this->data);
    }

    public function get($slug)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.ppid');

        $ppid = $this->ppidModel->getBySlug($slug);
        // dd(format_tanggal($ppid));
        $this->data['ppid'] = format_tanggal_suatu_kolom($ppid, 'tgl_terbit');
        $this->data['beritaTerbaru'] = format_tanggal($this->beritaModel->getTerbaru(3));

        // dd($ppid);

        return view('ppid_item', $this->data);
    }

    public function getByKategori($kategori)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.ppid');

        // dd(urldecode($kategori));

        $ppid = $this->ppidModel->getByKategori(urldecode($kategori));
        // dd(format_tanggal($ppid));
        $this->data['ppid'] = format_tanggal_suatu_kolom($ppid, 'tgl_terbit');
        $this->data['pagerPPID'] = $this->ppidModel->pager;
        $this->data['ppidTerbaru'] = null;

        // $this->data['kategori'] = $this->kategoriModel->findAll();
        $this->data['namaKategori'] = $kategori;

        // dd(sizeof($ppid));

        return view('ppid_kategori', $this->data);
    }
}
