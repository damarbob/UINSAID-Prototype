<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_tanggal;

class AgendaModel extends \CodeIgniter\Model
{
    protected $table = 'agenda';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_galeri', 'agenda', 'waktu'];

    public function getByID($id)
    {
        return $this->select('*')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->where('agenda.id', $id)
            ->first();
    }

    public function get()
    {
        return $this->select('*')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu', 'DESC')
            ->findAll();
    }

    public function getTerbaru($jumlah)
    {
        return $this->select('*')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu', 'DESC')
            ->findAll($jumlah);
    }
}
