<?php

namespace App\Models;

use CodeIgniter\Model;

class PostingJenisModel extends Model
{
    protected $table = 'posting_jenis';
    protected $allowedFields = ['nama'];

    public function getByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }
}
