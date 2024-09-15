<?php

namespace App\Models;

class SitusModel extends \CodeIgniter\Model
{
    protected $table = 'situs';

    protected $useTimestamps = true;

    protected $allowedFields = ['nama', 'alamat', 'status'];

    public function getByID($id)
    {
        return $this->select('*')
            ->where('id', $id)
            ->first();
    }

    public function get()
    {
        // return $this->orderBy('created_at', 'DESC')->findAll();
        return $this->findAll();
    }

    public function getAktif()
    {
        return $this
            ->where('status', 'active')
            ->findAll();
    }

    public function getTidakAktif()
    {
        return $this
            ->where('status', 'inactive')
            ->findAll();
    }
}
