<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_date_to_array;
use function App\Helpers\format_tanggal;

class PengumumanModel extends \CodeIgniter\Model
{
    protected $table = 'pengumuman';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_galeri', 'pengumuman', 'waktu'];

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
            ->orderBy('pengumuman.waktu', 'DESC')
            ->findAll();
    }

    /**
     * -------------------------------------------
     * Get Pengumuman Terbaru yang berstatus dipublikasikan
     * -------------------------------------------
     */
    public function getTerbaru($jumlah)
    {
        return $this->formatDateToArray($this->select('pengumuman.*, galeri.uri')
            ->where('status', 'dipublikasikan')
            ->join('galeri', 'galeri.id = pengumuman.id_galeri', 'left')
            ->orderBy('pengumuman.waktu', 'DESC')
            ->findAll($jumlah));
    }

    /**
     * -------------------------------------------------------------
     * Get Pengumuman for datatable
     * -------------------------------------------------------------
     */
    public function getPengumuman($limit, $start, $status = null, $search = null, $order = 'waktu', $dir = 'DESC')
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
                ->orLike('waktu', $search)
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
                ->orLike('waktu', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    function formatDateToArray($data)
    {
        foreach ($data as &$d) {
            if (is_array($d)) {
                $d['waktu_terformat'] = format_date_to_array($d['waktu']);
                $d['waktu_terformat_tanggal'] = $d['waktu_terformat'][0];
                $d['waktu_terformat_bulan'] = $d['waktu_terformat'][1];
            }
        }
        return $data;
    }
}
