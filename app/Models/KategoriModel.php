<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $allowedFields = ['nama'];

    public function getKategoriByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }
}
