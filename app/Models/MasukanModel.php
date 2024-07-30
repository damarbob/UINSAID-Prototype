<?php

namespace App\Models;

class MasukanModel extends \CodeIgniter\Model
{
    protected $table = 'masukan';

    protected $useTimestamps = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ['keperluan', 'isi', 'terbaca'];

    public function getKotakMasuk()
    {
        return $this->orderBy('created_at', 'DESC') // Urutkan dari tanggal terbaru
            ->formatKeperluan($this->findAll());
    }

    public function getKotakMasukTerbaca()
    {
        return $this->orderBy('created_at', 'DESC') // Urutkan dari tanggal terbaru
            ->formatKeperluan($this->where(['terbaca' => 'false'])->findAll());
    }

    public function getKotakMasukBelumTerbaca()
    {
        return $this->orderBy('created_at', 'DESC') // Urutkan dari tanggal terbaru
            ->formatKeperluan($this->where(['terbaca' => 'false'])->findAll());
    }

    public function getKotakMasukTerbaru($jumlah)
    {
        return $this->orderBy('created_at', 'DESC') // Urutkan dari tanggal terbaru
            ->formatKeperluan($this->findAll($jumlah));
    }

    public function getKotakMasukKritikDanSaran()
    {
        return $this->orderBy('created_at', 'DESC') // Urutkan dari tanggal terbaru
            ->formatKeperluan($this->where(['keperluan' => 'kritik dan saran'])->findAll());
    }

    public function getKotakMasukPelaporan()
    {
        return $this->orderBy('created_at', 'DESC') // Urutkan dari tanggal terbaru
            ->formatKeperluan($this->where(['keperluan' => 'pelaporan'])->findAll());
    }

    /**
     * Ambil item spesifik berdasarkan ID
     * @param id ID item
     */
    public function getKotakMasukByID($id)
    {
        return $this->formatKeperluan($this->where([$this->primaryKey => $id])->first());
    }

    public function formatKeperluan($data)
    {
        $isNotArray = false; // For use in return statement

        // Check if $data is an array
        if (!is_array($data) || isset($data['keperluan'])) {
            $isNotArray = true;
            $data = array($data); // Convert single item to array
        }

        // Loop through each data and format 'keperluan' field
        foreach ($data as &$row) {
            $row['keperluan_terformat'] = ucfirst($row['keperluan']);
        }
        return $isNotArray ? $data[0] : $data; // Return first data directly if it's not array (single data), otherwise return array
    }
}
