<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $allowedFields = ['nama', 'id_jenis', 'terkunci'];
    protected $useTimestamps = true;

    public function getKategoriByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }

    public function getKategoriByJenisNama($jenisNama)
    {
        return $this->db->table($this->table)
            ->select('kategori.*')
            ->join('posting_jenis', 'kategori.id_jenis = posting_jenis.id', 'right')
            ->where('posting_jenis.nama', $jenisNama)
            ->get()->getResultArray();
    }

    public function getArrayIdKategoriByNama($nama)
    {
        return [$this->getKategoriByNama($nama)['id']];
    }

    public function getArrayIdKategoriByBanyakNama($banyakNama)
    {
        $arrayIdKategori = [];
        foreach ($banyakNama as $nama) {
            $arrayIdKategori[] = $this->getKategoriByNama($nama)['id'];
        }
        return $arrayIdKategori;
    }

    public function getByNamaAndJenisId($kategoriNama, $jenisId)
    {
        return $this
            ->where('nama', $kategoriNama)
            ->where('id_jenis', $jenisId)
            ->first();
    }

    public function getKategori($kategoriId = null, $jenisNama = null, $kategoriNama = null, $search = null, $paginated = false, $perPage = 12, $returnType = 'array', $jenisId = null, $grupNama = 'kategori', $limit = null, $start = null, $order = null, $dir = null, $additionalConditions = null)
    {
        // dd($kategoriNama);
        $builder = $this->table($this->table)
            ->select('kategori.*, posting_jenis.id as id_posting_jenis, posting_jenis.nama as posting_jenis_nama')
            ->join('posting_jenis', 'posting_jenis.id = kategori.id_jenis', 'left');

        if ($kategoriId) {
            $builder->where('kategori.id', $kategoriId);
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
                ->like('posting_jenis.nama', $search)
                ->orLike('kategori.nama', $search)
                ->groupEnd();
        }

        $results = $paginated ? $builder->paginate($perPage, $grupNama) : $builder->get()->getResultArray();

        return $returnType === 'array' ? $results : json_decode(json_encode($results));
    }

    /**
     * Get posting for datatables admin
     *      
     * @param string $jenisNama Name of post type
     * @param int $limit Array size
     * @param int $start Query result offset
     * @param string $search Search key
     * @param string $order Field to be ordered by
     * @param string $dir Direction of order ('asc' or 'desc')
     * @return array Array of kategori
     */
    public function getForDatatables($jenisNama = null, $limit = 10, $start = 0, $search = null, $order = 'judul', $dir = 'asc')
    {

        return $this->getKategori(jenisNama: $jenisNama, limit: $limit, start: $start, search: $search, order: $order, dir: $dir, returnType: 'object');
    }
}
