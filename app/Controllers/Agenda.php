<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class Agenda extends BaseController
{
    public function index()
    {
        $this->data['judul'] = 'Agenda';

        $search = $this->request->getGet('search') ?? '';
        $this->data['agenda'] = $this->agendaModel->getPaginated($search);
        $this->data['pagerAgenda'] = $this->agendaModel->pager;

        return view('agenda', $this->data);
    }

    public function get($id)
    {
        helper('format');
        $this->data['judul'] = lang('Admin.berita');

        $agenda = $this->agendaModel->getByID($id);
        // dd(format_tanggal($agenda));
        $this->data['agenda'] = format_tanggal($agenda);
        $this->data['agendaTerbaru'] = format_tanggal($this->agendaModel->getTerbaru(3));

        // dd($agenda);

        return view('agenda_item', $this->data);
    }
}
