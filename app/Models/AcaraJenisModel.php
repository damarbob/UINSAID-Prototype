<?php

namespace App\Models;

use CodeIgniter\Model;

class AcaraJenisModel extends Model
{
    protected $table = 'acara_jenis';
    protected $allowedFields = ['nama'];
    protected $useTimeStamps = true;

    public function getByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }
}
