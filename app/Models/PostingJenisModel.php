<?php

namespace App\Models;

use CodeIgniter\Model;

class PostingJenisModel extends Model
{
    protected $table = 'posting_jenis';
    protected $allowedFields = ['nama'];
    protected $useTimestamps = true;

    public function getByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }

    public function getForDatatables(
        $search = null,
        $limit = null,
        $start = null,
        $order = null,
        $dir = null
    ) {
        $builder = $this->builder($this->table);
        if ($limit && ($start || $start === 0)) {
            $builder->limit($limit, $start);
        }
        if ($dir) {
            $builder->orderBy($order, $dir);
        }
        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('created_at', $search)
                ->orLike('updated_at', $search)
                ->groupEnd();
        }
        return $builder->get()->getResultArray();
    }
}
