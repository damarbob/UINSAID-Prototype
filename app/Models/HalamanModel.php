<?php

namespace App\Models;

class HalamanModel extends \CodeIgniter\Model
{
    protected $table = 'halaman';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'slug', 'id_komponen', 'css', 'js', 'status'];

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
    public function getDT($limit, $start, $status = null, $search = null, $order = 'judul', $dir = 'asc')
    {
        $builder = $this
            ->select('*')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($status) {
            $builder->where('status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('judul', $search)
                ->orLike('slug', $search)
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
                ->like('judul', $search)
                ->orLike('slug', $search)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }
}
