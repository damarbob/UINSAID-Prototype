<?php

namespace App\Models;

use DateTime;

class GaleriModel extends \CodeIgniter\Model
{
    protected $table = 'galeri';

    protected $useTimestamps = true;

    protected $allowedFields = ['uri', 'judul', 'alt'];

    public function get()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getPaginated($page, $perPage, $search = '')
    {
        $offset = ($page - 1) * $perPage;

        // Build the query
        $builder = $this->table($this->table);

        if (!empty($search)) {
            // Apply search filtering if search term is provided
            $builder->like('judul', $search)
                    ->orLike('alt', $search);
        }

        return $builder->orderBy('created_at', 'DESC') // Optional: order by created_at or another field
                        ->findAll($perPage, $offset);
    }
}
