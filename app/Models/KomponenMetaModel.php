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

    public function getAllById($idInstance, $idKomponen, $idHalaman)
    {
        return $this
            ->select('*')
            ->where('instance_id', $idInstance)
            ->where('komponen_id', $idKomponen)
            ->where('halaman_id', $idHalaman)
            ->orderBy('created_at', 'desc')
            ->get()
            ->getResultArray();
    }

    public function clearAllExceptFirst($idInstance = null, $idKomponen = null, $idHalaman = null)
    {
        // Initialize the query builder
        $builder = $this->db->table($this->table)
            ->select('id')
            ->orderBy('created_at', 'desc')
            ->limit(1);

        // Apply conditions only if parameters are not null
        if ($idInstance !== null) {
            $builder->where('instance_id', $idInstance);
        }
        if ($idKomponen !== null) {
            $builder->where('komponen_id', $idKomponen);
        }
        if ($idHalaman !== null) {
            $builder->where('halaman_id', $idHalaman);
        }

        // Get the first record
        $firstRecord = $builder->get()->getRowArray();

        // If a record exists, proceed with the deletion
        if ($firstRecord) {
            $deleteBuilder = $this->db->table($this->table);

            // Apply the same conditions for deletion
            if ($idInstance !== null) {
                $deleteBuilder->where('instance_id', $idInstance);
            }
            if ($idKomponen !== null) {
                $deleteBuilder->where('komponen_id', $idKomponen);
            }
            if ($idHalaman !== null) {
                $deleteBuilder->where('halaman_id', $idHalaman);
            }

            // Exclude the first record from deletion
            $deleteBuilder->where('id !=', $firstRecord['id']);

            // Execute the deletion
            $deleteBuilder->delete();
        }

        return true; // Return status or response
    }
}
