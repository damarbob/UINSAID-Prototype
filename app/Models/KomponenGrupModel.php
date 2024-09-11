<?php

namespace App\Models;

class KomponenGrupModel extends \CodeIgniter\Model
{
    protected $table = 'komponen_grup';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama'];

    public function getByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }
}
