<?php

namespace App\Models;

class KomponenMetaModel extends \CodeIgniter\Model
{
    protected $table = 'komponen_meta';
    protected $useTimestamps = true;
    protected $allowedFields = ['halaman_id', 'komponen_id', 'meta'];

    public function getById($idKomponen, $idHalaman)
    {
        return $this
            ->select('*')
            ->where('komponen_id', $idKomponen)
            ->where('halaman_id', $idHalaman)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
