<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_tanggal;

class FileModel extends \CodeIgniter\Model
{
    protected $table = 'file';

    protected $useTimestamps = true;

    protected $allowedFields = ['uri', 'judul', 'alt', 'deskripsi'];

    public function get()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // public function getPaginated($page, $perPage, $search = '')
    // {
    //     $offset = ($page - 1) * $perPage;

    //     // Build the query
    //     $builder = $this->table($this->table);

    //     if (!empty($search)) {
    //         // Apply search filtering if search term is provided
    //         $builder->like('judul', $search)
    //             ->orLike('alt', $search);
    //     }

    //     return $builder->orderBy('created_at', 'DESC') // Optional: order by created_at or another field
    //         ->findAll($perPage, $offset);
    // }

    public function getPaginated($page, $perPage, $search = '')
    {
        $offset = ($page - 1) * $perPage;

        $builder = $this->table($this->table);

        if (!empty($search)) {
            $builder->like('judul', $search)
                ->orLike('alt', $search);
        }

        $total = $builder->countAllResults(false);

        $data = $builder->orderBy('created_at', 'DESC')
            ->findAll($perPage, $offset);

        return [
            'data' => format_tanggal($data),
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page
        ];
    }

    /**
     * -------------------------------------------------------------
     * Get Files for datatable
     * -------------------------------------------------------------
     */
    public function getFiles($limit, $start, $search = null, $order = 'created_at', $dir = 'DESC')
    {
        $builder = $this->db->table($this->table)
            ->select('*')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($search) {
            $builder->groupStart()
                ->like('judul', $search)
                ->groupEnd();
        }

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    /**
     * -------------------------------------------------------------
     * Get total record of Agenda for datatable
     * -------------------------------------------------------------
     */
    public function getTotalRecords($search = null)
    {
        $builder = $this->db->table($this->table)
            ->select('*');

        if ($search) {
            $builder->groupStart()
                ->like('judul', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
