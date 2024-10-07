<?php

namespace App\Models;

class EntitasModel extends \CodeIgniter\Model
{
    protected $table = 'entitas';

    protected $useTimestamps = true;

    protected $allowedFields = ["nama", "slug", "deskripsi", "gambar_sampul", "grup_id", "alamat", "telepon", "fax", "email", "website", "parent_id"];

    public function getById($id)
    {
        return ($this->select('entitas.*, entitas_grup.nama as grup')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->where('entitas.id', $id)
            ->first());
    }

    public function getParent($parentId = null)
    {
        if ($parentId) {
            return $this->select('entitas.*, entitas_grup.nama as grup')
                ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
                ->where('entitas.parent_id', $parentId)
                ->where('grup_id !=', 0)
                ->orderBy('grup_id', 'asc')
                ->orderBy('nama', 'asc')
                ->paginate(12, 'entitas');
        } else {
            return $this->select('entitas.*, entitas_grup.nama as grup')
                ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
                ->where('entitas.parent_id IS NULL')
                ->where('grup_id !=', 0)
                ->orderBy('grup_id', 'asc')
                ->orderBy('nama', 'asc')
                ->paginate(12, 'entitas');
        }
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
            ->where('grup_id !=', 0)
            ->orderBy('grup_id', 'asc')
            ->orderBy('nama', 'asc')
            ->paginate(12, 'entitas'));
    }

    public function getByGroup($grup_id)
    {
        return ($this->select('entitas.*, entitas_grup.nama as grup')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->where('entitas.parent_id') // Tampilkan yang NULL saja
            ->where('entitas.grup_id', $grup_id)
            ->paginate(12, 'entitas'));
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

        dd($this->findAll()); // TODO: Remove it
    }

    /**
     * Get data for DataTables server-side processing
     *
     * @param int $limit Number of records to retrieve
     * @param int $start Offset for the records
     * @param string|null $status Optional status filter
     * @param string|null $search Optional search term
     * @param string $order Column to order by (default: 'judul')
     * @param string $dir Direction of ordering (default: 'asc')
     * @return array Array of results
     */
    public function getDT($limit, $start, $search = null, $order = 'child.nama', $dir = 'asc', $grupNama = null)
    {
        $builder = $this->db->table('entitas as child')
            ->select('child.*, parent.nama as parent_nama, entitas_grup.nama as entitas_grup_nama')
            ->join('entitas as parent', 'child.parent_id = parent.id', 'left') // Left join to get parent details
            ->join('entitas_grup', 'entitas_grup.id = child.grup_id', 'left')
            // ->where('child.parent_id IS NOT NULL', null, false) // Exclude root-level items if needed
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($grupNama) {
            $builder->where('entitas_grup.nama', $grupNama);
        }

        if ($search) {
            $builder->groupStart()
                ->like('child.nama', $search)
                // ->orLike('parent.nama', $search)
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }


    /**
     * Get the number of filtered records for DataTables server-processing
     * 
     * @param string|null $status Optional status filter
     * @param string|null $search Optional search term
     * @return array Array of results
     */
    public function getTotalFilteredRecordsDT($search = null, $grupNama = null)
    {
        $builder = $this
            ->select('*')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left');

        if ($grupNama) {
            $builder->where('entitas_grup.nama', $grupNama);
        }

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function getParentByEntitasGrupParentId($entitasGrupParentId = 0)
    {
        return $this->select('entitas.*, entitas_grup.id as entitas_grup_id, entitas_grup.parent_id as entitas_grup_parent_id, entitas_grup.nama as entitas_grup_nama')
            ->join('entitas_grup', 'entitas_grup.id = entitas.grup_id', 'left')
            ->where('entitas_grup.parent_id', $entitasGrupParentId)
            ->findAll();
    }
}
