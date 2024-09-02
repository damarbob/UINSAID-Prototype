<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_date_to_array;
use function App\Helpers\format_tanggal;

class PengumumanModel extends \CodeIgniter\Model
{
    protected $table = 'pengumuman';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_galeri', 'pengumuman', 'deskripsi', 'waktu_mulai', 'waktu_selesai', 'status'];

    public function getByID($id)
    {
        return $this->select('pengumuman.*, galeri.uri')
            ->where('pengumuman.id', $id)
            ->join('galeri', 'galeri.id = pengumuman.id_galeri', 'left')
            ->first();
    }

    public function get()
    {
        return $this->select('pengumuman.*, galeri.uri')
            ->join('galeri', 'galeri.id = pengumuman.id_galeri', 'left')
            ->orderBy('pengumuman.waktu_mulai', 'DESC')
            ->findAll();
    }

    /**
     * -------------------------------------------
     * Get Pengumuman Terbaru yang berstatus publikasi
     * -------------------------------------------
     */
    public function getTerbaru($jumlah)
    {
        $today = date('Y-m-d H:i:s');
        // return $this->formatDateToArray($this->db->table($this->table)
        //     ->select('pengumuman.*, galeri.uri')
        //     ->where('status', 'publikasi')
        //     ->join('galeri', 'galeri.id = pengumuman.id_galeri', 'left')
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

        // ->orderBy("
        // CASE
        //     WHEN waktu_mulai <= '$today' AND waktu_selesai >= '$today' THEN 1
        //     WHEN waktu_mulai > '$today' THEN 2
        //     ELSE 3
        // END", 'ASC')
        // ->orderBy("
        // CASE
        //     WHEN waktu_mulai > '$today' THEN waktu_mulai
        //     ELSE NULL
        // END", 'ASC')
        // ->orderBy('COALESCE(waktu_selesai, waktu_mulai)', 'DESC')
        // ->limit($jumlah)
        // ->get()
        // ->getResultArray());
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
        return $this->formatDateToArray($query->getResultArray());
    }

    /**
     * -------------------------------------------------------------
     * Get Pengumuman for datatable
     * -------------------------------------------------------------
     */
    public function getPengumuman($limit, $start, $status = null, $search = null, $order = 'waktu_mulai', $dir = 'DESC')
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
                ->like('pengumuman', $search)
                ->orLike('waktu_mulai', $search)
                ->groupEnd();
        }

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    /**
     * -------------------------------------------------------------
     * Get total record of Pengumuman for datatable
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
                ->like('pengumuman', $search)
                ->orLike('waktu_mulai', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    function formatDateToArray($data)
    {
        foreach ($data as &$d) {
            if (is_array($d)) {
                $d['waktu_mulai_terformat'] = format_date_to_array($d['waktu_mulai']);
                $d['waktu_mulai_terformat_tanggal'] = $d['waktu_mulai_terformat'][0];
                $d['waktu_mulai_terformat_bulan'] = $d['waktu_mulai_terformat'][1];

                if ($d) {
                    $d['waktu_selesai_terformat'] = format_date_to_array($d['waktu_selesai']);
                    $d['waktu_selesai_terformat_tanggal'] = $d['waktu_selesai_terformat'][0];
                    $d['waktu_selesai_terformat_bulan'] = $d['waktu_selesai_terformat'][1];
                }
            }
        }
        return $data;
    }
}
