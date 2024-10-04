<?php

namespace App\Models;

class MediaSosialModel extends \CodeIgniter\Model
{
    protected $table = 'media_sosial';

    protected $useTimestamps = true;

    protected $allowedFields = ['nama', 'url', 'ikon', 'urutan'];

    public function getByID($id)
    {
        return $this
            ->select('*')
            ->where('id', $id)
            ->first();
    }


    public function get()
    {
        return $this
            ->select('*')
            ->orderBy('urutan', 'asc')
            ->findAll();
    }

    /**
     * -------------------------------------------------------------
     * Get Agenda for datatable
     * -------------------------------------------------------------
     */
    public function getDT($limit, $start, $search = null, $order = 'waktu_mulai', $dir = 'DESC')
    {
        $builder = $this->db->table($this->table)
            ->select('*')
            ->orderBy($order, $dir)
            ->limit($limit, $start);

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('url', $search)
                ->orLike('ikon', $search)
                ->groupEnd();
        }

        // return $this->formatSampul($builder->get()->getResult());
        return $builder->get()->getResult();
    }

    /**
     * -------------------------------------------------------------
     * Get total record of Agenda for datatable
     * -------------------------------------------------------------
     */
    public function getDTTotalRecords($search = null)
    {
        $builder = $this->db->table($this->table)
            ->select('*');

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('url', $search)
                ->orLike('ikon', $search)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    /**
     * Get the urutan's option 
     * 
     * @param int|null $parentId Optional menu's parent_id
     * @param int|null $id Optional menu's id
     * @return array Array of options and current urutan
     */
    public function getUrutan($id = null)
    {
        // Get items
        $items = $this->orderBy('urutan', 'asc')->findAll();

        $urutanOptions = [];
        $currentUrutan = 0;

        // If editing, find the current position of the menu
        if ($id) {
            $currentUrutan = $this->getByID($id)['urutan'];
        }

        // If creating a new menu, add 1 to the count of items
        $maxUrutan = count($items) + ($id ? 0 : 1);

        for ($i = 1; $i <= $maxUrutan; $i++) {
            $urutanOptions[] = $i;
        }

        return [
            'options' => $urutanOptions,
            'current' => $currentUrutan ?: $maxUrutan // If creating, preselect the last
        ];
    }

    public function reorder($newUrutan, $id = null)
    {

        // Fetch all sibling menus (menus with the same new parent_id)
        $items = $this
            ->orderBy('urutan', 'asc')
            ->findAll();

        // If editing an existing menu, exclude the current menu from reordering
        if ($id) {
            $items = array_filter($items, function ($menu) use ($id) {
                return $menu['id'] !== $id;
            });
        }

        // Initialize a counter for the urutan
        $urutan = 1;

        // Loop through the items and reorder them
        foreach ($items as $x) {
            // Skip the new menu's position (insert the new/edited menu in this slot)
            if ($urutan == $newUrutan) {
                $urutan++;
            }

            // Update the urutan for the current x menu
            $this->update($x['id'], ['urutan' => $urutan]);
            $urutan++;
        }

        // If editing an existing menu, update the urutan of the edited menu last
        if ($id) {
            $this->update($id, ['urutan' => $newUrutan]);
        }
    }
}
