<?php

namespace App\Models;

use CodeIgniter\Model;

class PostingKategoriModel extends Model
{
    protected $table = 'posting_kategori';
    protected $allowedFields = ['id_posting', 'id_kategori'];
    protected $useTimestamps = true;

    public function getPostingByNamaKategori($namaKategori = null, $paginated = false, $perPage = 12, $grupNama = 'posting')
    {
        $builder = $this->table($this->table)
            ->select('posting.*, users.username as penulis, kategori.nama as kategori, posting_jenis.id as id_posting_jenis')
            ->join('posting', 'posting_kategori.id_posting = posting.id', 'left')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting_kategori.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = kategori.id_jenis', 'left');

        if ($namaKategori) {
            $builder->where('kategori.nama', $namaKategori);
        }

        if ($paginated) return $builder->paginate($perPage, $grupNama);
        else return $builder->get()->getResultArray();
    }

    public function getByPostingId($id)
    {
        return $this->table($this->table)
            ->where('id_posting', $id)
            ->findAll();
    }
}
