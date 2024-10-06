<?php

namespace App\Models;

use DateTime;

class PostingDiajukanModel extends \CodeIgniter\Model
{
    protected $table = 'posting_diajukan';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_penulis', 'id_kategori', 'id_jenis', 'judul', 'slug', 'konten', 'ringkasan', 'pengajuan', 'status', 'gambar_sampul', 'sumber', 'tanggal_terbit', 'created_at'];

    public function getByFilter($jenis = null, $limit, $start, $status = null, $search = null, $order = 'judul', $dir = 'asc')
    {
        $builder = $this->db->table($this->table)
            ->select('posting_diajukan.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting_diajukan.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = kategori.id_jenis', 'left')
            // ->where('posting_jenis.name', $jenis)
            // ->where('kategori.id_jenis', $jenis)
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($jenis) {
            $builder
                // ->groupStart()
                ->where('posting_jenis.nama', $jenis);
            // ->orWhere('posting_jenis.nama IS NULL')
            //         ->groupEnd();
            // } else {
            //     $builder
            //         ->where('posting_jenis.nama', $jenis);
        }

        if ($status) {
            $builder->where('posting_diajukan.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('posting_diajukan.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('posting_diajukan.created_at', $search)
                ->orLike('posting_diajukan.status', $search)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function getTotalRecords($jenis, $status = null, $search = null)
    {
        if ($status) {
            $builder = $this->db->table($this->table)
                ->select('posting_diajukan.*, users.username as penulis, kategori.nama as kategori')
                ->where('posting_diajukan.status', $status);
        } else {
            $builder = $this->db->table($this->table)
                ->select('posting_diajukan.*, users.username as penulis, kategori.nama as kategori');
        }

        if ($search) {
            $builder->groupStart()
                ->like('posting_diajukan.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('posting_diajukan.created_at', $search)
                ->orLike('posting_diajukan.status', $search)
                ->groupEnd();
        }

        return $builder
            ->join('users', 'users.id = posting_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting_diajukan.id_kategori', 'left')
            // ->where('posting_jenis.name', $jenis)
            ->where('kategori.id_jenis', $jenis)
            ->countAllResults();
    }

    public function getByID($id)
    {
        return $this->formatSampul($this->select('posting_diajukan.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting_diajukan.id_kategori', 'left')
            ->where('posting_diajukan.' . $this->primaryKey, $id)
            ->first());
    }

    public function formatSampul($data)
    {
        // Check if $data is an array
        if (!is_array($data)) {
            $data = array($data); // Convert single item to array
        }

        foreach ($data as &$item) {
            // Check if $item is an array
            if (is_array($item)) {
                $item['gambar_sampul_sementara'] = $this->extract_first_image($item['konten'], base_url('assets/img/icon-notext.png'), false);

                // Uncomment the following and comment above code if the image is from base url
                // $item['gambar_sampul'] = base_url('uploads/' . $this->extract_first_image_filename($item['konten'], base_url('assets/img/esmonde-yong-wFpJV5EWrSM-unsplash.jpg')));
            }
        }

        return $data;
    }

    public function formatSampulSingle($data)
    {
        // tampilan error kalau tidak ada slug artikel yang ada di database
        if (empty($data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }

        $data['gambar_sampul_sementara'] = $this->extract_first_image($data['konten'], base_url('assets/img/icon-notext.png'), false);

        return $data;
    }
}
