<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal_suatu_kolom;

class AgendaPengumuman extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->data['renderDefaultMeta'] = false; // Overwrite default meta
    }

    public function index()
    {
        helper('format');

        $this->data['judul'] = 'Agenda';

        // Setting manual pagination
        $pagerService = service('pager'); // Load the pager service

        // Current page (from the query string, defaults to 1)
        $page = (int) ($this->request->getGet('page') ?? 1);

        // Number of results per page
        $perPage = 12;

        // Get data
        $search = $this->request->getGet('search') ?? '';
        $dataAll = $this->agendaPengumumanModel->getAcaraPublikasi('agenda', $search);
        $this->data['item'] = format_tanggal_suatu_kolom(array_slice($dataAll, ($page - 1) * $perPage, $perPage), 'waktu_mulai');

        // Get the total number of items
        $total = sizeof($dataAll);

        // Generate pagination links
        $this->data['pager'] = $pagerService->makeLinks($page, $perPage, $total, 'pager');

        return view('agenda_pengumuman', $this->data);
    }

    public function indexPengumuman()
    {
        helper('format');

        $this->data['judul'] = 'Pengumuman';

        // Setting manual pagination
        $pagerService = service('pager'); // Load the pager service

        // Current page (from the query string, defaults to 1)
        $page = (int) ($this->request->getGet('page') ?? 1);

        // Number of results per page
        $perPage = 12;

        // Get data
        $search = $this->request->getGet('search') ?? '';
        $dataAll = $this->agendaPengumumanModel->getAcaraPublikasi('pengumuman', $search);
        $this->data['item'] = format_tanggal_suatu_kolom(array_slice($dataAll, ($page - 1) * $perPage, $perPage), 'waktu_mulai');

        // Get the total number of items
        $total = sizeof($dataAll);

        // Generate pagination links
        $this->data['pager'] = $pagerService->makeLinks($page, $perPage, $total, 'pager');

        return view('agenda_pengumuman', $this->data);
    }

    public function getAll()
    {
        helper('format');

        $this->data['judul'] = 'Agenda dan Pengumuman';

        // Setting manual pagination
        $pagerService = service('pager'); // Load the pager service

        // Current page (from the query string, defaults to 1)
        $page = (int) ($this->request->getGet('page') ?? 1);

        // Number of results per page
        $perPage = 12;

        // Get data
        $search = $this->request->getGet('search') ?? '';
        $dataAll = $this->agendaPengumumanModel->getAcaraPublikasi(search: $search);
        $this->data['item'] = format_tanggal_suatu_kolom(array_slice($dataAll, ($page - 1) * $perPage, $perPage), 'waktu_mulai');

        // Get the total number of items
        $total = sizeof($dataAll);

        // Generate pagination links
        $this->data['pager'] = $pagerService->makeLinks($page, $perPage, $total, 'pager');

        return view('agenda_pengumuman', $this->data);
    }

    public function get($slug)
    {
        helper('format');

        $item = format_tanggal_suatu_kolom($this->agendaPengumumanModel->getBySlug($slug), showWaktu: true);
        // dd(format_tanggal($item));

        $this->data['judul'] = $item['judul'];
        $this->data['item'] = $item;
        $this->data['itemTerbaru'] = format_tanggal_suatu_kolom($this->agendaPengumumanModel->getTerbaru('pengumuman', 3));

        // dd($item);

        return view('agenda_pengumuman_item', $this->data);
    }
}
