<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class Pengumuman extends BaseController
{
    public function index()
    {
        $this->data['judul'] = 'Pengumuman';

        $search = $this->request->getGet('search') ?? '';
        $this->data['pengumuman'] = $this->pengumumanModel->getPaginated($search);
        $this->data['pagerPengumuman'] = $this->pengumumanModel->pager;

        return view('pengumuman', $this->data);
    }

    public function get($id)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $pengumuman = $this->pengumumanModel->getByID($id);
        // dd(format_tanggal($pengumuman));
        $this->data['pengumuman'] = format_tanggal($pengumuman);
        $this->data['pengumumanTerbaru'] = format_tanggal($this->pengumumanModel->getTerbaru(3));

        // dd($pengumuman);

        return view('pengumuman_item', $this->data);
    }
}
