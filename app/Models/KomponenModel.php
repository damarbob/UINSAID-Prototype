<?php

namespace App\Models;

class KomponenModel extends \CodeIgniter\Model
{
    protected $table = 'komponen';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'konten', 'css', 'js', 'grup_id'];

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
    public function getDT($limit, $start, $status = null, $search = null, $order = 'nama', $dir = 'asc')
    {
        $builder = $this->db->table($this->table)
            ->select('komponen.*, komponen_grup.nama as grup')
            ->join('komponen_grup', 'komponen_grup.id = komponen.grup_id', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($status) {
            $builder->where('komponen.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('komponen.nama', $search)
                ->orLike('komponen.konten', $search)
                ->groupEnd();
        }

        return $builder->get()->getResultArray(); // or getResult() if you prefer objects
    }

    /**
     * Get the number of filtered records for DataTables server-processing
     * 
     * @param string|null $status Optional status filter
     * @param string|null $search Optional search term
     * @return array Array of results
     */
    public function getTotalFilteredRecordsDT($status = null, $search = null)
    {
        $builder = $this
            ->select('*');

        if ($status) {
            $builder->where('status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('konten', $search)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function getByID($id)
    {
        return ($this->select('komponen.*, komponen_grup.nama as grup')
            ->join('komponen_grup', 'komponen_grup.id = komponen.grup_id', 'left')
            ->where('komponen.id', $id)
            ->first());
    }
}
