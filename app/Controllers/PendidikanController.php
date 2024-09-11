<?php

namespace App\Controllers;

class PendidikanController extends BaseController
{
    public function index()
    {
        $this->data['judul'] = 'Pendidikan';

        $this->data['fakultas'] = $this->entitasModel->getByFilter(null, "Fakultas");

        return view('pendidikan', $this->data);
    }
}
