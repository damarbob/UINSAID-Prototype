<?php

namespace App\Models;

class AgendaModel extends \CodeIgniter\Model
{
    protected $table = 'agenda';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_galeri', 'agenda', 'deskripsi', 'waktu_mulai', 'waktu_selesai', 'status'];

    public function getByID($id)
    {
        return $this->select('agenda.*, galeri.uri')
            ->where('agenda.id', $id)
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->first();
    }


    public function get()
    {
        return $this->select('agenda.*, galeri.uri')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu_mulai', 'DESC')
            ->findAll();
    }

    public function getPublikasi()
    {
        return $this->select('*')
            ->where('agenda.status', 'publikasi')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu_mulai', 'DESC')
            ->findAll();
    }

    public function getDraf()
    {
        return $this->select('*')
            ->where('agenda.status', 'draf')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu_mulai', 'DESC')
            ->findAll();
    }

    /**
     * -------------------------------------------
     * Get Agenda Terbaru yang berstatus publikasi
     * -------------------------------------------
     * 
     * @return array
     */
    public function getTerbaru($jumlah)
    {
        $today = date('Y-m-d H:i:s');
        // return $this->db->table($this->table)
        //     ->select('agenda.*, galeri.uri')
        //     ->where('status', 'publikasi')
        //     ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
        //     ->orderBy("
        //         CASE
        //             WHEN waktu_mulai <= '$today' AND waktu_selesai >= '$today' THEN 1
        //             WHEN waktu_mulai > '$today' THEN 2
        //             ELSE 3
        //         END", 'ASC')
        //     ->orderBy("
        //         CASE
        //             WHEN waktu_mulai > '$today' THEN waktu_mulai
        //             ELSE NULL
        //         END", 'ASC')
        //     ->orderBy("
        //         CASE
        //             WHEN waktu_selesai < '$today' THEN waktu_selesai
        //             ELSE NULL
        //         END", 'DESC')
        //     ->limit($jumlah)
        //     ->get()
        //     ->getResultArray();

        $sql = "
            SELECT $this->table.*, galeri.uri
            FROM $this->table
            LEFT JOIN galeri ON $this->table.id_galeri = galeri.id
            WHERE status = 'publikasi'
            ORDER BY
                CASE
                    WHEN waktu_mulai <= '$today' AND waktu_selesai >= '$today' THEN 1
                    WHEN waktu_mulai > '$today' THEN 2
                    ELSE 3
                END ASC,
                CASE
                    WHEN waktu_mulai > '$today' THEN waktu_mulai
                    ELSE NULL
                END ASC,
                COALESCE(waktu_selesai, waktu_mulai) DESC
            LIMIT $jumlah
        ";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    /**
     * -------------------------------------------------------------
     * Get Agenda for datatable
     * -------------------------------------------------------------
     */
    public function getAgenda($limit, $start, $status = null, $search = null, $order = 'waktu_mulai', $dir = 'DESC')
    {
        $builder = $this->db->table($this->table)
            ->select('*')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($status) {
            $builder->where('status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('agenda', $search)
                ->orLike('waktu_mulai', $search)
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
    public function getTotalRecords($status = null, $search = null)
    {
        if ($status) {
            $builder = $this->db->table($this->table)
                ->select('*')
                ->where('status', $status);
        } else {
            $builder = $this->db->table($this->table)
                ->select('*');
        }

        if ($search) {
            $builder->groupStart()
                ->like('agenda', $search)
                ->orLike('waktu_mulai', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
