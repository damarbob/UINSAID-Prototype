<?php

namespace App\Models;

use DateTime;

use function App\Helpers\format_tanggal;

class BeritaModel extends \CodeIgniter\Model
{
    protected $table = 'berita';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_penulis', 'id_kategori', 'id_jenis', 'judul', 'slug', 'konten', 'ringkasan', 'pengajuan', 'status', 'sumber', 'tgl_terbit'];

    public function getByKategori($kategori)
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->where('kategori.nama', $kategori)
            ->where('berita.status', 'publikasi')
            ->where('berita.tgl_terbit <= ', date('Y-m-d H:i:s'))
            ->paginate(12, 'berita'));
    }

    public function getByKategoriLimit($kategori, $limit)
    {
        // return $this->formatSampul(
        //     $this->select('berita.*, users.username as penulis, kategori.nama as kategori')
        //         ->join('users', 'users.id = berita.id_penulis', 'left')
        //         ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
        //         ->where('kategori.nama', $kategori)
        //         ->where('berita.status', 'publikasi')
        //         ->limit($limit)
        //         ->get()
        // );
        return $this->formatSampul(
            $this->select('berita.*, penulis.username as penulis, kategori.nama as kategori')
                ->join('users penulis', 'penulis.id = berita.id_penulis', 'left') // Alias 'users' as 'penulis'
                ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
                ->where('kategori.nama', $kategori)
                ->where('berita.status', 'publikasi')
                ->where('berita.tgl_terbit <= ', date('Y-m-d H:i:s'))
                ->orderBy('berita.tgl_terbit', 'DESC')
                ->findAll($limit)
        );
    }

    public function getBerita($limit, $start, $status = null, $search = null, $order = 'judul', $dir = 'asc')
    {
        $builder = $this->db->table($this->table)
            ->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($status) {
            $builder->where('berita.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('berita.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('berita.tgl_terbit', $search)
                ->orLike('berita.status', $search)
                ->groupEnd();
        }

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    public function getTotalRecords($status = null, $search = null)
    {
        if ($status) {
            $builder = $this->db->table($this->table)
                ->select('berita.*, users.username as penulis, kategori.nama as kategori')
                ->where('berita.status', $status)
                ->join('users', 'users.id = berita.id_penulis', 'left')
                ->join('kategori', 'kategori.id = berita.id_kategori', 'left');
        } else {
            $builder = $this->db->table($this->table)
                ->select('berita.*, users.username as penulis, kategori.nama as kategori')
                ->join('users', 'users.id = berita.id_penulis', 'left')
                ->join('kategori', 'kategori.id = berita.id_kategori', 'left');
        }

        if ($search) {
            $builder->groupStart()
                ->like('berita.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('berita.tgl_terbit', $search)
                ->orLike('berita.status', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    public function get()
    {
        return $this->formatSampul($this
            ->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->orderBy('berita.tgl_terbit', 'DESC')
            ->findAll());
    }

    public function getPaginated($search = null)
    {
        $builder = $this->table($this->table);

        if (!empty($search)) {
            $builder->like('judul', $search);
        }

        return $this->formatSampul($builder->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->where('berita.tgl_terbit <= ', date('Y-m-d H:i:s'))
            ->where('berita.status', 'publikasi')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->orderBy('berita.tgl_terbit', 'DESC')
            ->paginate(12, 'berita'));
    }

    public function getTerbaru($jumlah, $offset = 0)
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->where('berita.tgl_terbit <= ', date('Y-m-d H:i:s'))
            ->where('berita.status', 'publikasi')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->orderBy('berita.tgl_terbit', 'DESC')
            ->offset($offset)
            ->findAll($jumlah));
    }

    public function getByID($id)
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->where('berita.' . $this->primaryKey, $id)
            ->first());
    }

    public function getBySlug($slug)
    {
        return $this->formatSampulSingle($this->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->where('berita.slug', $slug)
            ->first());
    }

    public function getPublikasi()
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->where('berita.status', 'publikasi')
            ->orderBy('berita.tgl_terbit', 'DESC')
            ->findAll());
    }

    public function getDraf()
    {
        return $this->formatSampul($this->select('berita.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = berita.id_penulis', 'left')
            ->join('kategori', 'kategori.id = berita.id_kategori', 'left')
            ->where('berita.status', 'draf')
            ->orderBy('berita.tgl_terbit', 'DESC')
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
                $item['gambar_sampul'] = $this->extract_first_image($item['konten'], base_url('assets/img/logo-square.png'), false);

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

        $data['gambar_sampul'] = $this->extract_first_image($data['konten'], base_url('assets/img/logo-square.png'), false);

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
        $latestData = $this->orderBy('tgl_terbit', 'DESC')->first();

        if ($latestData) {
            // Calculate the difference in months between now and the tgl_terbit timestamp
            $createdAt = new DateTime($latestData['tgl_terbit']);
            $now = new DateTime();
            $interval = $now->diff($createdAt);
            $monthsDiff = $interval->y * 12 + $interval->m;

            // Check if the difference is greater than or equal to 3 months
            return $monthsDiff >= 3;
        }

        // If no data is found, do not consider it as over 3 months old. Instead, there will be another warning to invite users to write their first post.
        return false;
    }

    /* Refactoring */
    public function refactorFeaturedImages()
    {
        $berita = $this->where('featured_image IS NULL')->findAll();
        // dd($berita);

        foreach ($berita as $b) {
            dd($b['id']);
            $firstImage = $this->extract_first_image($b['konten'], base_url('assets/img/logo-square.png'), false);
            if (!$firstImage) {
                dd('WHAT');
            }
            $this->save(
                [
                    'id' => $b['id'],
                    'featured_image' => $firstImage,
                ]
            );
        }
    }

    public function updateFeaturedImages()
    {
        $berita = $this->where('featured_image IS NULL')->findAll();

        if (empty($berita)) {
            echo "No records found with NULL featured_image.";
            return;
        }

        foreach ($berita as $item) {
            $firstImage = $this->extract_first_image($item['konten'], base_url('assets/img/logo-square.png'), false);
            if ($firstImage) {
                $sql = "UPDATE berita SET featured_image = '$firstImage' WHERE id = " . $item['id'];
                $this->db->query($sql);
            }
        }

        echo "Featured images updated successfully.";
    }
}
