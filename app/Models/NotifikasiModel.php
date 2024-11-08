<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiModel extends Model
{
    protected $table = 'notifikasi';
    protected $allowedFields = ['judul', 'konten', 'terbaca', 'link', 'jenis'];
    protected $useTimestamps = true;

    function getNotifikasi($id = null, $jenis = null, $terbaca = null, $order = null, $dir = 'ASC', $limit = null, $offset = null, $paginated = false, $perPage = 12, $additionalConditions = null)
    {
        $builder = $this->table($this->table)->select('*')->orderBy('created_at', 'DESC');

        if ($id) {
            if (is_array($id)) {
                $builder->whereIn('id', $id);
            } else {
                $builder->where('id', $id);
            }
        }

        if ($jenis) {
            $builder->where('jenis', $jenis);
        }

        if ($terbaca) {
            $builder->where('terbaca', $terbaca);
        }

        if ($additionalConditions) {
            $builder->groupStart();
            foreach ($additionalConditions as $x) {
                if ($x['operator'] == QB_CLAUSE_WHERE) {
                    $builder->where($x['key'], $x['value']);
                } elseif ($x['operator'] == QB_CLAUSE_OR_WHERE) {
                    $builder->orWhere($x['key'], $x['value']);
                }
            }
            $builder->groupEnd();
        }

        if ($order) {
            $builder->orderBy($order, $dir);
        }

        if ($limit) {
            $builder->limit($limit);
        }

        if ($offset) {
            $builder->offset($offset);
        }

        if ($paginated) return $builder->paginate($perPage, 'notifikasi');
        else return $builder->get()->getResultArray();
    }


    public function getNotifikasiBelumTerbaca()
    {
        return $this->getNotifikasi(terbaca: 0);
    }

    public function getNotifikasiSebagian($limit, $offset, $newerThan)
    {
        if ($newerThan) {
            $additionalConditions =
                [
                    [
                        'key'       => 'id >',
                        'value'     => $newerThan,
                        'operator'  => QB_CLAUSE_WHERE
                    ]
                ];
        } else $additionalConditions = null;
        return $this->getNotifikasi(order: 'terbaca', dir: 'ASC', limit: $limit, offset: $offset, additionalConditions: $additionalConditions);
    }

    public function tandaiSudahDibaca($id)
    {
        return $this->update($id, ['terbaca' => 1]);
    }

    public function tandaiSemuaSudahDibaca()
    {
        $notifikasi = $this->where('terbaca', 0)->findAll();
        foreach ($notifikasi as $x) {
            if (!$this->update($x['id'], ['terbaca' => 1])) return false;
        }
        return true;
    }
}
