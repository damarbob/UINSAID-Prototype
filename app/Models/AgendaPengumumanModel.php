<?php

namespace App\Models;

class AgendaPengumumanModel extends \CodeIgniter\Model
{
    protected $table = 'agenda_dan_pengumuman';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_jenis', 'id_galeri', 'judul', 'konten', 'waktu_mulai', 'waktu_selesai', 'status'];

    public function getByID($id)
    {
        return $this->select('agenda_dan_pengumuman.*, galeri.uri')
            ->where('agenda_dan_pengumuman.id', $id)
            ->join('galeri', 'galeri.id = agenda_dan_pengumuman.id_galeri', 'left')
            ->first();
    }

    public function getAgendaPaginated($search = '')
    {
        $idJenis = 3; // Agenda

        $builder = $this->table($this->table);

        if (!empty($search)) {
            $builder->like('agenda_dan_pengumuman', $search);
        }

        return $builder->select('agenda_dan_pengumuman.*, galeri.uri')
            ->where('id_jenis', $idJenis)
            ->where('agenda_dan_pengumuman.status', 'publikasi')
            ->join('galeri', 'galeri.id = agenda_dan_pengumuman.id_galeri', 'left')
            ->orderBy('agenda_dan_pengumuman.waktu_mulai', 'DESC')
            ->paginate(12, 'agenda_dan_pengumuman');
    }

    public function getPengumumanPaginated($search = '')
    {
        $idJenis = 4; // Pengumuman

        $builder = $this->table($this->table);

        if (!empty($search)) {
            $builder->like('agenda_dan_pengumuman', $search);
        }

        return $builder->select('agenda_dan_pengumuman.*, galeri.uri')
            ->where('id_jenis', $idJenis)
            ->where('agenda_dan_pengumuman.status', 'publikasi')
            ->join('galeri', 'galeri.id = agenda_dan_pengumuman.id_galeri', 'left')
            ->orderBy('agenda_dan_pengumuman.waktu_mulai', 'DESC')
            ->paginate(12, 'agenda_dan_pengumuman');
    }

    /**
     * -------------------------------------------
     * Get Agenda Terbaru yang berstatus publikasi
     * -------------------------------------------
     * 
     * @return array
     */
    public function getAgendaTerbaru($jumlah)
    {
        $idJenis = 3; // Agenda

        $today = date('Y-m-d H:i:s');

        $sql = "
            SELECT $this->table.*, galeri.uri
            FROM $this->table
            LEFT JOIN galeri ON $this->table.id_galeri = galeri.id
            WHERE id_jenis = '$idJenis' AND status = 'publikasi'
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
    public function getAgenda($limit, $start, $status = null, $search = null, $order = 'waktu_mulai', $dir = 'DESC', $idJenis = 3)
    {
        // $idJenis = 3; // Agenda

        $builder = $this->db->table($this->table)
            ->select('*')
            ->where('id_jenis', $idJenis)
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($status) {
            $builder->where('status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('judul', $search)
                ->orLike('waktu_mulai', $search)
                ->groupEnd();
        }

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    /**
     * -------------------------------------------------------------
     * Get Pengumuman for datatable
     * -------------------------------------------------------------
     */
    public function getPengumuman($limit, $start, $status = null, $search = null, $order = 'waktu_mulai', $dir = 'DESC')
    {
        $idJenis = 4; // Pengumuman

        $builder = $this->db->table($this->table)
            ->select('*')
            ->where('id_jenis', $idJenis)
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($status) {
            $builder->where('status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('judul', $search)
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
    public function getAgendaTotalRecords($status = null, $search = null, $idJenis = 3)
    {
        // $idJenis = 3; // Agenda

        if ($status) {
            $builder = $this->db->table($this->table)
                ->select('*')
                ->where('id_jenis', $idJenis)
                ->where('status', $status);
        } else {
            $builder = $this->db->table($this->table)
                ->select('*');
        }

        if ($search) {
            $builder->groupStart()
                ->like('judul', $search)
                ->orLike('waktu_mulai', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    /**
     * -------------------------------------------------------------
     * Get total record of Agenda for datatable
     * -------------------------------------------------------------
     */
    public function getPengumumanTotalRecords($status = null, $search = null)
    {
        $idJenis = 4; // Pengumuman

        if ($status) {
            $builder = $this->db->table($this->table)
                ->select('*')
                ->where('id_jenis', $idJenis)
                ->where('status', $status);
        } else {
            $builder = $this->db->table($this->table)
                ->select('*');
        }

        if ($search) {
            $builder->groupStart()
                ->like('judul', $search)
                ->orLike('waktu_mulai', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
