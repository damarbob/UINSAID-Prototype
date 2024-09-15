<?php

namespace App\Models;

use DateTime;

class PostingModel extends \CodeIgniter\Model
{
    protected $table = 'posting';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_penulis', 'id_kategori', 'id_jenis', 'judul', 'slug', 'konten', 'ringkasan', 'pengajuan', 'status', 'gambar_sampul', 'sumber', 'tanggal_terbit'];

    public function getByKategori($jenis, $kategori)
    {
        return $this->formatSampul($this->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = posting.id_jenis', 'left')
            ->where('kategori.nama', $kategori)
            ->where('posting.status', 'publikasi')
            ->where('posting_jenis.name', $jenis)
            ->where('kategori.id_jenis', $jenis)
            ->paginate(10, 'posting'));
    }

    public function getByKategoriLimit($jenis, $kategori, $limit)
    {
        return $this->formatSampul(
            $this->select('posting.*, penulis.username as penulis, kategori.nama as kategori')
                ->join('users penulis', 'penulis.id = posting.id_penulis', 'left') // Alias table 'users' as 'penulis' due error non unique
                ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
                ->join('posting_jenis', 'posting_jenis.id = posting.id_jenis', 'left')
                ->where('kategori.nama', $kategori)
                ->where('posting.status', 'publikasi')
                ->where('posting_jenis.nama', $jenis)
                ->where('kategori.id_jenis', $jenis)
                ->orderBy('posting.created_at', 'DESC')
                ->findAll($limit)
        );
    }

    public function getByFilter($jenis, $limit, $start, $status = null, $search = null, $order = 'judul', $dir = 'asc')
    {
        $builder = $this->db->table($this->table)
            ->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = posting.id_jenis', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if (!$jenis || $jenis == 'berita') {
            $builder
                ->groupStart()
                ->where('posting_jenis.nama', $jenis)
                ->orWhere('posting_jenis.nama IS NULL')
                ->groupEnd();
        } else {
            $builder
                ->where('posting_jenis.nama', $jenis);
        }

        if ($status) {
            $builder->where('posting.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('posting.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('posting.tanggal_terbit', $search)
                ->orLike('posting.status', $search)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function getTotalRecords($jenis, $status = null, $search = null)
    {

        $builder = $this->db->table($this->table)
            ->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = posting.id_jenis', 'left')
            ->where('kategori.id_jenis', $jenis);

        if (!$jenis || $jenis == 'berita') {
            $builder
                ->groupStart()
                ->where('posting_jenis.nama', $jenis)
                ->orWhere('posting_jenis.nama IS NULL')
                ->groupEnd();
        } else {
            $builder
                ->where('posting_jenis.nama', $jenis);
        }

        if ($status) {
            $builder
                ->where('posting.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('posting.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('posting.created_at', $search)
                ->orLike('posting.status', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    public function getPaginated($jenis, $search = '')
    {
        $builder = $this->table($this->table);

        if (!empty($search)) {
            $builder->like('judul', $search);
        }

        return $this->formatSampul($builder->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->where('posting.status', 'publikasi')
            ->where('posting_jenis.name', $jenis)
            ->where('kategori.id_jenis', $jenis)
            ->orderBy('posting.created_at', 'DESC')
            ->paginate(12, 'posting'));
    }

    public function getTerbaru($jenis, $jumlah, $offset = 0)
    {
        return $this->formatSampul($this->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->where('posting_jenis.name', $jenis)
            ->where('kategori.id_jenis', $jenis)
            ->orderBy('posting.created_at', 'DESC')
            ->offset($offset)
            ->findAll($jumlah));
    }

    public function getByID($id)
    {
        return $this->formatSampul($this->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->where('posting.' . $this->primaryKey, $id)
            ->first());
    }

    public function getBySlug($slug)
    {
        return $this->formatSampulSingle($this->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->where('posting.slug', $slug)
            ->first());
    }

    public function getPublikasi(string $jenis)
    {
        return $this->formatSampul($this->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->where('posting.status', 'publikasi')

            ->groupStart()
            ->where('posting_jenis.nama', $jenis)
            ->orWhere('posting_jenis.nama IS NULL')
            ->groupEnd()

            ->orderBy('posting.created_at', 'DESC')
            ->findAll());
    }

    public function getDraf(string $jenis)
    {
        return $this->formatSampul($this->select('posting.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting.id_kategori', 'left')
            ->where('posting.status', 'draft')

            ->groupStart()
            ->where('posting_jenis.nama', $jenis)
            ->orWhere('posting_jenis.nama IS NULL')
            ->groupEnd()

            ->orderBy('posting.created_at', 'DESC')
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
                $item['gambar_sampul_sementara'] = $this->extract_first_image($item['konten'], base_url('assets/img/logo-square.png'), false);

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

        $data['gambar_sampul_sementara'] = $this->extract_first_image($data['konten'], base_url('assets/img/logo-square.png'), false);

        return $data;
    }

    /**
     * Extracts the filename with extension of the first image from HTML content.
     *
     * @param string $html The HTML content.
     * @param string $defaultImageUrl The default image URL if no image found.
     * @return string The filename with extension of the first image found.
     */
    function extract_first_image(string $html, string $defaultImageUrl, bool $filenameOnly): string
    {
        // Check if $html is not empty
        if (empty($html)) {
            // Return default image if no HTML content is provided
            return $defaultImageUrl;
        }

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
            return $filenameOnly ? $filenameWithExtension : $firstImageSrc;
        } else {
            // If no image found, return the default image URL
            return $defaultImageUrl;
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
