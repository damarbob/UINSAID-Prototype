<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $allowedFields = ['nama', 'id_jenis'];
    protected $useTimestamps = true;

    public function getKategoriByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }

    public function getKategoriByJenisNama($jenisNama)
    {
        return $this->db->table($this->table)
            ->select('kategori.*')
            ->join('posting_jenis', 'kategori.id_jenis = posting_jenis.id', 'right')
            ->where('posting_jenis.nama', $jenisNama)
            ->get()->getResultArray();
    }
}
