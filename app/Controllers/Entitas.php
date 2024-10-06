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
        $this->data['judul'] = "Akademik";

        $grup = $this->request->getGet('grup') ?? '';
        $cari = $this->request->getGet('cari') ?? '';

        if (!isset($grup) && !isset($cari)) {
            $entitas = $this->entitasModel->getParent();
        } else {
            $entitas = $this->entitasModel->getByFilter($cari, $grup);
        }

        $this->data['entitas'] = $entitas;
        $this->data['pagerEntitas'] = $this->entitasModel->pager;
        return view('entitas', $this->data);
    }

    public function get($slug)
    {
        helper('format');

        $entitas = $this->entitasModel->getBySlug($slug);
        $parent = (isset($entitas['parent_id'])) ? $this->entitasModel->getById($entitas['parent_id']) : null;

        $this->data['judul'] = $entitas['nama'];

        // dd(format_tanggal($berita));
        $this->data['entitas'] = $entitas;
        $this->data['entitasParent'] = $parent;

        // Apakah entitas fakultas atau prodi
        $jenisEntitas = $this->entitasGrupModel->find($entitas['id']);
        $this->data['fakultasAtauProdi'] = $jenisEntitas == 'Fakultas' || $jenisEntitas == 'Program Studi' ? true : false;

        return view('entitas_item', $this->data);
    }
}
