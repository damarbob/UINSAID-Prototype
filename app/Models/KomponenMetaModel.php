<?php

namespace App\Models;

class KomponenMetaModel extends \CodeIgniter\Model
{
    protected $table = 'komponen_meta';
    protected $useTimestamps = true;
    protected $allowedFields = ['instance_id', 'halaman_id', 'komponen_id', 'meta'];

    public function getById($idInstance, $idKomponen, $idHalaman)
    {
        return $this
            ->select('*')
            ->where('instance_id', $idInstance)
            ->where('komponen_id', $idKomponen)
            ->where('halaman_id', $idHalaman)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
