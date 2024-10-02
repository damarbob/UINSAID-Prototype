<?php

namespace App\Models;

class EntitasModel extends \CodeIgniter\Model
{
    protected $table = 'entitas';

    protected $useTimestamps = true;

    protected $allowedFields = ["nama", "slug", "deskripsi", "gambar_sampul", "grup_id", "alamat", "telepon", "fax", "email", "website",];

    public function getById($id)
    {
        return ($this->select('entitas.*, entitas_grup.nama as grup')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->where('entitas.id', $id)
            ->first());
    }

    public function getParent()
    {
        return ($this->select('entitas.*, entitas_grup.nama as grup')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->where('entitas.parent_id') // Tampilkan yang NULL saja
            ->paginate(10, 'entitas'));
    }

    public function getByFilter($cari = null, $grup = null, $parentId = null)
    {
        $builder = $this->table($this->table);

        if (!empty($cari)) {
            $builder->like('entitas.nama', $cari);
        }

        if (!empty($grup)) {
            $builder->where('entitas_grup.nama', $grup);
        }

        if (!empty($parentId)) {
            $builder->where('entitas.parent_id', $parentId);
        }

        return ($builder->select('entitas.*, entitas_grup.nama as grup')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->paginate(10, 'entitas'));
    }

    public function getByGroup($grup_id)
    {
        return ($this->select('entitas.*, entitas_grup.nama as grup')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->where('entitas.parent_id') // Tampilkan yang NULL saja
            ->where('entitas.grup_id', $grup_id)
            ->paginate(10, 'entitas'));
    }

    public function getBySlug($slug)
    {
        return ($this->select('entitas.*, entitas_grup.nama as grup')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->where('entitas.slug', $slug)
            ->first());
    }

    public function buatSlug()
    {
        $all = $this->findAll();

        foreach ($all as $e) {

            $data = [
                'id'       => $e['id'],
                'slug' => $this->create_slug($e['nama']),
            ];

            $this->save($data);
        }

        dd($this->findAll());
    }
}
