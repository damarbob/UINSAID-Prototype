<?php

namespace App\Models;

class AgendaPengumumanModel extends \CodeIgniter\Model
{
    protected $table = 'acara';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_jenis', 'id_galeri', 'judul', 'slug', 'konten', 'waktu_mulai', 'waktu_selesai', 'status'];

    public function getByID($id)
    {
        return $this->select('acara.*, galeri.uri, acara_jenis.nama as acara_jenis_nama')
            ->where('acara.id', $id)
            ->join('galeri', 'galeri.id = acara.id_galeri', 'left')
            ->join('acara_jenis', 'acara_jenis.id = acara.id_jenis', 'left')
            ->first();
    }

    public function getBySlug($slug)
    {
        return $this->select('acara.*, galeri.uri, acara_jenis.nama as acara_jenis_nama')
            ->where('acara.slug', $slug)
            ->join('galeri', 'galeri.id = acara.id_galeri', 'left')
            ->join('acara_jenis', 'acara_jenis.id = acara.id_jenis', 'left')
            ->first();
    }

    public function getAcaraPublikasi($jenisNama = null, $search = '')
    {
        $today = date('Y-m-d H:i:s');
        $jenisNamaCondition = !is_null($jenisNama) ? "acara_jenis.nama = '$jenisNama' AND" : '';

        $searchCondition = !empty($search) ? "AND judul LIKE '%$search%' ESCAPE '!'" : '';

        $sql = "
        SELECT $this->table.*, galeri.uri, acara_jenis.nama as acara_jenis_nama
        FROM $this->table
        LEFT JOIN galeri ON $this->table.id_galeri = galeri.id
        LEFT JOIN acara_jenis ON $this->table.id_jenis = acara_jenis.id
        WHERE $jenisNamaCondition status = 'publikasi' $searchCondition
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
    ";

        $query = $this->query($sql);
        return $query->getResultArray();
    }


    public function getAgendaPaginated($search = '')
    {
        $idJenis = 1; // Agenda

        $builder = $this->table($this->table);

        if (!empty($search)) {
            $builder->like('acara', $search);
        }

        return $builder->select('acara.*, galeri.uri')
            ->where('id_jenis', $idJenis)
            ->where('acara.status', 'publikasi')
            ->join('galeri', 'galeri.id = acara.id_galeri', 'left')
            ->orderBy('acara.waktu_mulai', 'DESC')
            ->paginate(12, 'acara');
    }

    public function getPengumumanPaginated($search = '')
    {
        $idJenis = 2; // Pengumuman

        $builder = $this->table($this->table);

        if (!empty($search)) {
            $builder->like('acara', $search);
        }

        return $builder->select('acara.*, galeri.uri')
            ->where('id_jenis', $idJenis)
            ->where('acara.status', 'publikasi')
            ->join('galeri', 'galeri.id = acara.id_galeri', 'left')
            ->orderBy('acara.waktu_mulai', 'DESC')
            ->paginate(12, 'acara');
    }

    /**
     * -------------------------------------------
     * Get Agenda Terbaru yang berstatus publikasi
     * -------------------------------------------
     * 
     * @return array
     */
    public function getTerbaru($jenisNama, $jumlah)
    {
        $today = date('Y-m-d H:i:s');

        $sql = "
            SELECT $this->table.*, galeri.uri, acara_jenis.nama as acara_jenis_nama
            FROM $this->table
            LEFT JOIN galeri ON $this->table.id_galeri = galeri.id
            LEFT JOIN acara_jenis ON $this->table.id_jenis = acara_jenis.id
            WHERE acara_jenis.nama = '$jenisNama' AND status = 'publikasi'
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
        // $query = $this->db->query($sql);
        $query = $this->query($sql);
        return $query->getResultArray();
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
        $idJenis = 1; // Agenda

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
        // $query = $this->db->query($sql);
        $query = $this->query($sql);
        return $query->getResultArray();
    }

    /**
     * -------------------------------------------------------------
     * Get Acara for datatable
     * -------------------------------------------------------------
     */
    public function getAcara($limit, $start, $status = null, $search = null, $order = 'waktu_mulai', $dir = 'DESC', $idJenis = null)
    {

        // dd($idJenis);
        $builder = $this->db->table($this->table)
            ->select('acara.*, acara_jenis.nama as acara_jenis_nama')
            ->join('acara_jenis', 'acara_jenis.id = acara.id_jenis', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($idJenis) {
            $builder->where('acara.id_jenis', $idJenis);
        }

        if ($status) {
            $builder->where('acara.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('acara.judul', $search)
                ->orLike('acara.waktu_mulai', $search)
                ->groupEnd();
        }

        // dd($builder->get()->getResult());

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    /**
     * -------------------------------------------------------------
     * Get total record of Acara for datatable
     * -------------------------------------------------------------
     */
    public function getAcaraTotalRecords($status = null, $search = null, $idJenis = null, $jenisNama = null)
    {
        $builder = $this->db->table($this->table)
            ->select('acara.*, acara_jenis.nama as acara_jenis_nama')
            ->join('acara_jenis', 'acara_jenis.id = acara.id_jenis', 'left');

        if ($jenisNama) {
            $builder->where('acara_jenis.nama', $jenisNama);
        }

        if ($idJenis) {
            $builder->where('id_jenis', $idJenis);
        }

        if ($status) {
            $builder->where('status', $status);
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
     * Get Agenda for datatable
     * -------------------------------------------------------------
     */
    public function getAgenda($limit, $start, $status = null, $search = null, $order = 'waktu_mulai', $dir = 'DESC', $idJenis = 1)
    {

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
        $idJenis = 2; // Pengumuman

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
    public function getAgendaTotalRecords($status = null, $search = null, $idJenis = 1)
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
        $idJenis = 2; // Pengumuman

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
