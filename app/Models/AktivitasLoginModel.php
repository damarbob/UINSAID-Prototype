<?php

namespace App\Models;

use CodeIgniter\Model;

class AktivitasLoginModel extends Model
{
    protected $table = 'auth_logins';

    public function getByIdPengguna($IdPengguna)
    {
        return $this->where('user_id', $IdPengguna)->findAll();
    }

    public function getUniqueUserLogins()
    {
        $builder = $this->db->table('users')
            // ->select('auth_logins.*, users.username, users.active, users.last_active')
            // ->join('users', 'users.id = auth_logins.user_id', 'left')
            // ->distinct() // Get unique values
            ->get();

        return $builder->getResultArray(); // Fetch all results
    }

    /**
     * -------------------------------------------------------------
     * Get Auth Logins for datatable
     * -------------------------------------------------------------
     */
    public function getDT($limit = 10, $start = 0, $search = null, $order = 'date', $dir = 'DESC', $userId = null)
    {

        $builder = $this->db->table($this->table)
            ->select('auth_logins.*, , users.username, users.active, users.last_active')
            ->join('users', 'users.id = auth_logins.user_id', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($userId) {
            $builder->where('auth_logins.user_id', $userId);
        }

        if ($search) {
            $builder->groupStart()
                ->like('users.username', $search)
                ->orLike('identifier', $search)
                ->groupEnd();
        }

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    /**
     * -------------------------------------------------------------
     * Get total record of Auth Logins for datatable
     * -------------------------------------------------------------
     */
    public function getDTTotalRecords($search = null, $userId = null)
    {
        $builder = $this->db->table($this->table)
            ->select('auth_logins.*, , users.username, users.active, users.last_active')
            ->join('users', 'users.id = auth_logins.user_id', 'left');

        if ($userId) {
            $builder->where('auth_logins.user_id', $userId);
        }

        if ($search) {
            $builder->groupStart()
                ->like('users.username', $search)
                ->orLike('identifier', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
