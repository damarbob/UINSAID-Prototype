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
        $builder = $this->db->table('auth_logins')
            // ->select('auth_logins.*, users.username, users.active, users.last_active')
            ->select('auth_logins.identifier, COUNT(auth_logins.id)')
            ->join('users', 'users.id = auth_logins.user_id', 'left')
            ->groupBy('auth_logins.identifier')
            // ->distinct() // Get unique values
            ->get();

        return $builder->getResultArray(); // Fetch all results
    }

    /**
     * -------------------------------------------------------------
     * Get Auth Logins for datatable
     * -------------------------------------------------------------
     */
    public function getDT($limit = 10, $start = 0, $search = null, $order = 'date', $dir = 'DESC', $email = null)
    {

        $builder = $this->db->table($this->table)
            ->select('auth_logins.*, , users.username, users.active, users.last_active')
            ->join('users', 'users.id = auth_logins.user_id', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($email) {
            $builder->where('auth_logins.identifier', $email);
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
    public function getDTTotalRecords($search = null, $email = null)
    {
        $builder = $this->db->table($this->table)
            ->select('auth_logins.*, , users.username, users.active, users.last_active')
            ->join('users', 'users.id = auth_logins.user_id', 'left');

        if ($email) {
            $builder->where('auth_logins.identifier', $email);
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
