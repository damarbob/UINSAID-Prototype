<?php

namespace App\Models;

class AgendaModel extends \CodeIgniter\Model
{
    protected $table = 'agenda';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_galeri', 'agenda', 'waktu', 'status'];

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
            ->orderBy('agenda.waktu', 'DESC')
            ->findAll();
    }

    public function getDipublikasikan()
    {
        return $this->select('*')
            ->where('agenda.status', 'dipublikasikan')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu', 'DESC')
            ->findAll();
    }

    public function getDraf()
    {
        return $this->select('*')
            ->where('agenda.status', 'draf')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu', 'DESC')
            ->findAll();
    }

    /**
     * -------------------------------------------
     * Get Agenda Terbaru yang berstatus dipublikasikan
     * -------------------------------------------
     */
    public function getTerbaru($jumlah)
    {
        return $this->select('agenda.*, galeri.uri')
            ->where('status', 'dipublikasikan')
            ->join('galeri', 'galeri.id = agenda.id_galeri', 'left')
            ->orderBy('agenda.waktu', 'DESC')
            ->findAll($jumlah);
    }

    /**
     * -------------------------------------------------------------
     * Get Agenda for datatable
     * -------------------------------------------------------------
     */
    public function getAgenda($limit, $start, $status = null, $search = null, $order = 'waktu', $dir = 'DESC')
    {
        if ($status) {
            $builder = $this->db->table($this->table)
                ->select('*')
                ->where('status', $status)
                ->orderBy($order, $dir)
                ->limit($limit, $start);
        } else {
            $builder = $this->db->table($this->table)
                ->select('*')
                ->orderBy($order, $dir)
                ->limit($limit, $start);
        }

        if ($search) {
            $builder->groupStart()
                ->like('agenda', $search)
                ->orLike('waktu', $search)
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
                ->orLike('waktu', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
