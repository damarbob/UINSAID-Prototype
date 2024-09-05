<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Entitas extends BaseController
{
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $this->data['judul'] = "Entitas";

        $grup_id = $this->request->getGet('grup_id');

        if (isset($grup_id)) {
            $entitas = $this->entitasModel->getByGroup($grup_id);
        } else {
            $entitas = $this->entitasModel->getParent();
        }

        $this->data['entitas'] = $entitas;
        $this->data['pagerEntitas'] = $this->entitasModel->pager;
        return view('entitas', $this->data);
    }

    public function get($slug)
    {
        helper('format');

        $entitas = $this->entitasModel->getBySlug($slug);

        $this->data['judul'] = $entitas['nama'];

        // dd(format_tanggal($berita));
        $this->data['entitas'] = $entitas;

        // dd($berita);

        return view('entitas_item', $this->data);
    }
}
