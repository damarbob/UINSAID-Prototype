<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_date_to_array;
use function App\Helpers\format_tanggal;

class SitusModel extends \CodeIgniter\Model
{
    protected $table = 'situs';

    protected $useTimestamps = true;

    protected $allowedFields = ['nama', 'alamat', 'status'];

    public function getByID($id)
    {
        return $this->select('*')
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
