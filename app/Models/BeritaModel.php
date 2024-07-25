<?php

namespace App\Models;

use DateTime;

class BeritaModel extends \CodeIgniter\Model
{
    protected $table = 'berita';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_penulis', 'judul', 'konten', 'ringkasan', 'kategori', 'status'];

    public function get()
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis_username')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->orderBy('berita.created_at', 'DESC')
            ->findAll());
    }

    public function getTerbaru($jumlah)
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis_username')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->orderBy('berita.created_at', 'DESC')
            ->findAll($jumlah));
    }

    public function getByID($id)
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis_username')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->where('berita.' . $this->primaryKey, $id)
            ->first());
    }

    public function getDipublikasikan()
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis_username')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->where('berita.status', 'published')
            ->orderBy('berita.created_at', 'DESC')
            ->findAll());
    }

    public function getDraf()
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis_username')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->where('berita.status', 'draft')
            ->orderBy('berita.created_at', 'DESC')
            ->findAll());
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
                $item['gambar_sampul'] = base_url('uploads/' . $this->extract_first_image_filename($item['konten'], base_url('assets/img/esmonde-yong-wFpJV5EWrSM-unsplash.jpg')));
            }
        }

        return $data;
    }

    /**
     * Extracts the filename with extension of the first image from HTML content.
     *
     * @param string $html The HTML content.
     * @param string $defaultImageUrl The default image URL if no image found.
     * @return string The filename with extension of the first image found.
     */
    function extract_first_image_filename(string $html, string $defaultImageUrl): string
    {
        // Create a DOMDocument object
        $dom = new \DOMDocument();
        // Suppress errors caused by malformed HTML
        libxml_use_internal_errors(true);
        // Load HTML content into the DOMDocument
        $dom->loadHTML($html);
        // Restore error handling
        libxml_clear_errors();

        // Get all img elements
        $images = $dom->getElementsByTagName('img');

        // Check if there is at least one image
        if ($images->length > 0) {
            // Get the src attribute of the first image
            $firstImageSrc = $images->item(0)->getAttribute('src');
            // Extract the filename with extension from the src attribute
            $filenameWithExtension = basename($firstImageSrc);
            return $filenameWithExtension;
        } else {
            // If no image found, return the filename with extension of the default image URL
            return basename(parse_url($defaultImageUrl, PHP_URL_PATH));
        }
    }

    public function isLatestDataOverThreeMonthsOld(): bool
    {
        // Get the latest created data
        $latestData = $this->orderBy('created_at', 'DESC')->first();

        if ($latestData) {
            // Calculate the difference in months between now and the created_at timestamp
            $createdAt = new DateTime($latestData['created_at']);
            $now = new DateTime();
            $interval = $now->diff($createdAt);
            $monthsDiff = $interval->y * 12 + $interval->m;

            // Check if the difference is greater than or equal to 3 months
            return $monthsDiff >= 3;
        }

        // If no data is found, do not consider it as over 3 months old. Instead, there will be another warning to invite users to write their first post.
        return false;
    }
}
