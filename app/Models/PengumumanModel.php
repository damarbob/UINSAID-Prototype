<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_date_to_array;
use function App\Helpers\format_tanggal;

class PengumumanModel extends \CodeIgniter\Model
{
    protected $table = 'pengumuman';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_galeri', 'pengumuman', 'waktu'];

    public function getByID($id)
    {
        return $this->select('*')
            ->join('galeri', 'galeri.id = pengumuman.id_galeri', 'left')
            ->where('pengumuman.id', $id)
            ->first();
    }

    public function get()
    {
        return $this->formatDateToArray($this->select('*')
            ->join('galeri', 'galeri.id = pengumuman.id_galeri', 'left')
            ->orderBy('pengumuman.waktu', 'DESC')
            ->findAll());
    }

    public function getTerbaru($jumlah)
    {
        return $this->formatDateToArray($this->select('*')
            ->join('galeri', 'galeri.id = pengumuman.id_galeri', 'left')
            ->orderBy('pengumuman.waktu', 'DESC')
            ->findAll($jumlah));
    }

    function formatDateToArray($data)
    {
        foreach ($data as &$d) {
            if (is_array($d)) {
                $d['waktu_terformat'] = format_date_to_array($d['waktu']);
                $d['waktu_terformat_tanggal'] = $d['waktu_terformat'][0];
                $d['waktu_terformat_bulan'] = $d['waktu_terformat'][1];
            }
        }
        return $data;
    }
}
