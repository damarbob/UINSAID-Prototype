<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class AgendaPengumuman extends BaseController
{
    public function index()
    {
        $this->data['judul'] = 'Agenda';

        $search = $this->request->getGet('search') ?? '';
        $this->data['item'] = $this->agendaPengumumanModel->getAgendaPaginated($search);
        $this->data['pagerAgenda'] = $this->agendaPengumumanModel->pager;

        return view('agenda_pengumuman', $this->data);
    }

    public function indexPengumuman()
    {
        $this->data['judul'] = 'Pengumuman';

        $search = $this->request->getGet('search') ?? '';
        $this->data['item'] = $this->agendaPengumumanModel->getPengumumanPaginated($search);
        $this->data['pagerAgenda'] = $this->agendaPengumumanModel->pager;

        return view('agenda_pengumuman', $this->data);
    }

    public function get($id)
    {
        helper('format');

        $item = format_tanggal($this->agendaPengumumanModel->getByID($id));
        // dd(format_tanggal($item));

        $this->data['judul'] = $item['judul'];
        $this->data['item'] = $item;
        $this->data['itemTerbaru'] = format_tanggal($this->agendaPengumumanModel->getAgendaTerbaru(3));

        // dd($item);

        return view('agenda_pengumuman_item', $this->data);
    }
}
