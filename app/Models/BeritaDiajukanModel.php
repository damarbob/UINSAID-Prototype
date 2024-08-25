<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_tanggal;

class BeritaDiajukanModel extends \CodeIgniter\Model
{
    protected $table = 'berita_diajukan';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_penulis', 'judul', 'slug', 'konten', 'ringkasan', 'pengajuan', 'id_kategori', 'status', 'sumber', 'tgl_terbit'];

    public function getByKategori($kategori)
    {
        return $this->formatSampul($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->where('kategori.nama', $kategori)
            ->paginate(10, 'berita_diajukan'));
    }

    public function getBerita($limit, $start, $search = null, $order = 'judul', $dir = 'asc')
    {
        $builder = $this->db->table($this->table)
            ->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($search) {
            $builder->groupStart()
                ->like('berita_diajukan.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('berita_diajukan.created_at', $search)
                ->orLike('berita_diajukan.status', $search)
                ->groupEnd();
        }

        // dd($builder->getCompiledSelect());
        // dd($builder->get()->getResult());

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    public function getTotalRecords($search = null)
    {
        $builder = $this->db->table($this->table)
            ->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('berita_diajukan.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('berita_diajukan.created_at', $search)
                ->orLike('berita_diajukan.status', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    public function get()
    {
        return $this->formatSampul($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->orderBy('berita_diajukan.created_at', 'DESC')
            ->findAll());
    }

    public function getPaginated()
    {
        return $this->formatSampul($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->orderBy('berita_diajukan.created_at', 'DESC')
            ->paginate(10, 'berita_diajukan'));
    }

    public function getTerbaru($jumlah, $offset = 0)
    {
        return $this->formatSampul($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->orderBy('berita_diajukan.created_at', 'DESC')
            ->offset($offset)
            ->findAll($jumlah));
    }

    public function getByID($id)
    {
        return $this->formatSampul($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->where('berita_diajukan.' . $this->primaryKey, $id)
            ->first());
    }

    public function getBySlug($slug)
    {
        return $this->formatSampulSingle($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->where('berita_diajukan.slug', $slug)
            ->first());
    }

    public function getDipublikasikan()
    {
        return $this->formatSampul($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->where('berita_diajukan.status', 'published')
            ->orderBy('berita_diajukan.created_at', 'DESC')
            ->findAll());
    }

    public function getDraf()
    {
        return $this->formatSampul($this->select('berita_diajukan.*, users.username as penulis_username, kategori.nama as kategori')
            ->join('users', 'users.id = berita_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita_diajukan.id_kategori', 'left')
            ->where('berita_diajukan.status', 'draft')
            ->orderBy('berita_diajukan.created_at', 'DESC')
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
                $item['gambar_sampul'] = $this->extract_first_image($item['konten'], base_url('assets/img/esmonde-yong-wFpJV5EWrSM-unsplash.jpg'), false);

                // Uncomment the following and comment above code if the image is from base url
                // $item['gambar_sampul'] = base_url('uploads/' . $this->extract_first_image_filename($item['konten'], base_url('assets/img/esmonde-yong-wFpJV5EWrSM-unsplash.jpg')));
            }
        }

        // dd($data);

        return $data;
    }

    public function formatSampulSingle($data)
    {
        // tampilan error kalau tidak ada slug artikel yang ada di database
        if (empty($data)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }

        $data['gambar_sampul'] = $this->extract_first_image($data['konten'], base_url('assets/img/esmonde-yong-wFpJV5EWrSM-unsplash.jpg'), false);

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
