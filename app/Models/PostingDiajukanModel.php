<?php

namespace App\Models;

use DateTime;

class PostingDiajukanModel extends \CodeIgniter\Model
{
    protected $table = 'posting_diajukan';

    protected $useTimestamps = true;

    protected $allowedFields = ['id_penulis', 'id_kategori', 'id_jenis', 'judul', 'slug', 'konten', 'ringkasan', 'pengajuan', 'status', 'gambar_sampul', 'sumber', 'tanggal_terbit', 'created_at'];

    public function getPosting($postingId = null, $slug = null, $jenisNama = null, $kategoriNama = null, $search = null, $status = null, $showFuture = false, $paginated = false, $perPage = 12, $returnType = 'array', $jenisId = null, $kategoriId = null, $grupNama = 'posting', $limit = null, $start = null, $order = null, $dir = null, $additionalConditions = null)
    {
        // dd($kategoriNama);
        $builder = $this->table($this->table)
            ->select('posting_diajukan.*, users.username as penulis, GROUP_CONCAT(kategori.nama) as kategori, GROUP_CONCAT(kategori.id) as id_kategori, posting_jenis.id as id_posting_jenis, posting_jenis.nama as posting_jenis_nama')
            ->join('users', 'users.id = posting_diajukan.id_penulis', 'left')
            ->join('posting_diajukan_kategori', 'posting_diajukan_kategori.id_posting = posting_diajukan.id', 'left')
            ->join('kategori', 'kategori.id = posting_diajukan_kategori.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = kategori.id_jenis', 'left')
            ->groupBy('posting_diajukan.id');

        if ($postingId) {
            $builder->where('posting_diajukan.id', $postingId);
        }

        if ($slug) {
            $builder->where('posting_diajukan.slug', $slug);
        }

        if ($jenisNama) {
            $builder->where('posting_jenis.nama', $jenisNama);
        }

        if ($jenisId) {
            $builder->where('posting_jenis.id', $jenisId);
        }

        if ($kategoriNama) {
            $builder->where('kategori.nama', $kategoriNama);
        }

        if ($kategoriId) {
            $builder->where('kategori.id', $kategoriId);
        }

        if ($status) {
            $builder->where('posting_diajukan.status', $status);
        }

        // Show only now or past
        if (!$showFuture) {
            $builder->where('posting_diajukan.tanggal_terbit <= ', date('Y-m-d H:i:s'));
        }

        if ($additionalConditions) {
            $builder->groupStart();
            foreach ($additionalConditions as $x) {
                if ($x['operator'] == QB_CLAUSE_WHERE) {
                    $builder->where($x['key'], $x['value']);
                } elseif ($x['operator'] == QB_CLAUSE_OR_WHERE) {
                    $builder->orWhere($x['key'], $x['value']);
                } elseif ($x['operator'] == QB_CLAUSE_WHERE_IN) {
                    $builder->whereIn($x['key'], $x['value']);
                } elseif ($x['operator'] == QB_CLAUSE_WHERE_NOT_IN) {
                    $builder->whereNotIn($x['key'], $x['value']);
                }
            }
            $builder->groupEnd();
        }

        if ($order && $dir) {
            $builder->orderBy($order, $dir);
        }

        if ($limit && ($start || $start === 0)) {
            $builder->limit($limit, $start);
        }

        if ($search) {
            $builder->groupStart()
                ->like('posting_diajukan.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('posting_diajukan.tanggal_terbit', $search)
                ->orLike('posting_diajukan.status', $search)
                ->groupEnd();
        }

        $results = $paginated ? $builder->paginate($perPage, $grupNama) : $builder->get()->getResultArray();

        // Process categories to be array
        foreach ($results as &$result) {
            $result['kategori'] = explode(',', $result['kategori']);
            $result['id_kategori'] = explode(',', $result['id_kategori']);
        }

        return $returnType === 'array' ? $results : json_decode(json_encode($results));

        // if ($paginated) return $builder->paginate($perPage, $grupNama);
        // else return $builder->get()->getResult($returnType);
    }

    /**
     * Get posting for datatables admin
     * 
     * @param array $idBanyakKategori Ids of Posting categories
     * @param string $jenisNama Name of post type
     * @param int $limit Array size
     * @param int $start Query result offset
     * @param string $status Posts's status
     * @param string $search Search key
     * @param string $order Field to be ordered by
     * @param string $dir Direction of order ('asc' or 'desc')
     * @return array Array of posting
     */
    public function getForDatatables($idBanyakKategori = null, $jenisNama = 'berita', $limit = 10, $start = 0, $status = null, $search = null, $order = 'judul', $dir = 'asc')
    {
        if ($idBanyakKategori) {
            $additionalConditions = [
                [
                    'operator'  => QB_CLAUSE_WHERE_IN,
                    'key'       => 'posting_kategori.id_kategori',
                    'value'     => $idBanyakKategori
                ]
            ];
        } else $additionalConditions = null;
        return $this->getPosting(jenisNama: $jenisNama, showFuture: true, status: $status, additionalConditions: $additionalConditions, limit: $limit, start: $start, search: $search, order: $order, dir: $dir, returnType: 'object');
    }

    public function getByFilter($limit, $start, $status = null, $search = null, $order = 'judul', $dir = 'asc', $jenisNama = null)
    {
        $builder = $this->db->table($this->table)
            ->select('posting_diajukan.*, users.username as penulis, kategori.nama as kategori, posting_jenis.nama as posting_jenis_nama')
            ->join('users', 'users.id = posting_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting_diajukan.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = kategori.id_jenis', 'left')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($jenisNama) {
            $builder->where('posting_jenis.nama', $jenisNama);
        }

        if ($status) {
            $builder->where('posting_diajukan.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('posting_diajukan.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('posting_diajukan.tanggal_terbit', $search)
                ->orLike('posting_diajukan.status', $search)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function getTotalRecords($jenisNama = null, $status = null, $search = null)
    {
        $builder = $this->db->table($this->table)
            ->select('posting_diajukan.*, users.username as penulis, kategori.nama as kategori')
            ->join('users', 'users.id = posting_diajukan.id_penulis', 'left')
            ->join('kategori', 'kategori.id = posting_diajukan.id_kategori', 'left')
            ->join('posting_jenis', 'posting_jenis.id = kategori.id_jenis', 'left');

        if ($jenisNama) {
            $builder
                ->where('posting_jenis.nama', $jenisNama);
        }

        if ($status) {
            $builder
                ->where('posting_diajukan.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('posting_diajukan.judul', $search)
                ->orLike('users.username', $search)
                ->orLike('kategori.nama', $search)
                ->orLike('posting_diajukan.tanggal_terbit', $search)
                ->orLike('posting_diajukan.status', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
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
