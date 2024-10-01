<?php

namespace App\Models;

class MenuModel extends \CodeIgniter\Model
{
    protected $table = 'menu';

    protected $useTimestamps = true;

    protected $allowedFields = ['parent_id', 'nama', 'uri', 'link_eksternal', 'urutan'];

    /**
     * Get data for DataTables server-side processing
     *
     * @param int $limit Number of records to retrieve
     * @param int $start Offset for the records
     * @param string|null $status Optional status filter
     * @param string|null $search Optional search term
     * @param string $order Column to order by (default: 'judul')
     * @param string $dir Direction of ordering (default: 'asc')
     * @return array Array of results
     */
    public function getDT($limit, $start, $search = null, $order = 'parent.urutan', $dir = 'asc')
    {
        $builder = $this->db->table('menu as child')
            ->select('child.*, parent.nama as parent_nama, parent.urutan as parent_urutan')
            ->join('menu as parent', 'child.parent_id = parent.id', 'left') // Left join to get parent details
            // ->where('child.parent_id IS NOT NULL', null, false) // Exclude root-level items if needed
            ->orderBy($order, $dir) // Order by parent urutan
            ->orderBy('child.urutan', $dir)  // Then order by child urutan
            ->limit($limit, $start);

        if ($search) {
            $builder->groupStart()
                ->like('child.nama', $search)
                // ->orLike('parent.nama', $search)
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }


    /**
     * Get the number of filtered records for DataTables server-processing
     * 
     * @param string|null $status Optional status filter
     * @param string|null $search Optional search term
     * @return array Array of results
     */
    public function getTotalFilteredRecordsDT($search = null)
    {
        $builder = $this
            ->select('*');

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    /**
     * Get the urutan's option 
     * 
     * @param int|null $parentId Optional menu's parent_id
     * @param int|null $menuId Optional menu's id
     * @return array Array of options and current urutan
     */
    public function getUrutanOptions($parentId = 0, $menuId = null)
    {
        // Get children of the parent
        $children = $this->where('parent_id', $parentId)->orderBy('urutan', 'asc')->findAll();
        // d($children);

        // Get current menu
        $currentMenu = $this->find($menuId);

        $urutanOptions = [];
        $currentUrutan = 0;

        // If editing, find the current position of the menu
        if ($menuId) {
            foreach ($children as $key => $child) {
                if ($child['id'] == $menuId) {
                    $currentUrutan = $key + 1;
                    break;
                }
            }
        }

        // If creating a new menu or current menu's parent_id not equal to $parentId, add 1 to the count of children
        $maxUrutan = count($children) + ($menuId && $currentMenu['parent_id'] == $parentId ? 0 : 1);

        for ($i = 1; $i <= $maxUrutan; $i++) {
            $urutanOptions[] = $i;
        }

        return [
            'options' => $urutanOptions,
            'current' => $currentUrutan ?: $maxUrutan // If creating, preselect the last
        ];
    }

    public function reorderMenus($parent_id, $newUrutan, $menu_id = null, $oldParentId = null)
    {
        // Reorder old parent_id children if the menu is being moved
        if ($oldParentId && $oldParentId != $parent_id) {
            $this->reorderOldParentMenus($oldParentId);
        }

        // Fetch all sibling menus (menus with the same new parent_id)
        $siblings = $this
            ->where('parent_id', $parent_id)
            ->orderBy('urutan', 'asc')
            ->findAll();

        // If editing an existing menu, exclude the current menu from reordering
        if ($menu_id) {
            $siblings = array_filter($siblings, function ($menu) use ($menu_id) {
                return $menu['id'] !== $menu_id;
            });
        }

        // Initialize a counter for the urutan
        $urutan = 1;

        // Loop through the siblings and reorder them
        foreach ($siblings as $sibling) {
            // Skip the new menu's position (insert the new/edited menu in this slot)
            if ($urutan == $newUrutan) {
                $urutan++;
            }

            // Update the urutan for the current sibling menu
            $this->update($sibling['id'], ['urutan' => $urutan]);
            $urutan++;
        }

        // If editing an existing menu, update the urutan of the edited menu last
        if ($menu_id) {
            $this->update($menu_id, ['urutan' => $newUrutan]);
        }
    }

    public function reorderOldParentMenus($oldParentId)
    {
        // Reorder the old parent's child menus
        $oldSiblings = $this
            ->where('parent_id', $oldParentId)
            ->orderBy('urutan', 'asc')
            ->findAll();

        $urutan = 1;
        foreach ($oldSiblings as $sibling) {
            // Update the urutan for the current sibling menu
            $this->update($sibling['id'], ['urutan' => $urutan]);
            $urutan++;
        }
    }

    public function getMenuHierarchy()
    {
        // Fetch all menus ordered by parent and urutan
        $menus = $this->orderBy('parent_id', 'ASC')
            ->orderBy('urutan', 'ASC')
            ->findAll();

        // Initialize an empty array for the hierarchy
        $menuHierarchy = [];

        // Build the menu hierarchy
        foreach ($menus as $menu) {
            if ($menu['parent_id'] == 0) {
                // Top-level menu item
                $menuHierarchy[$menu['id']] = $menu;
                $menuHierarchy[$menu['id']]['children'] = [];
            } else {
                // Child menu item
                $menuHierarchy[$menu['parent_id']]['children'][] = $menu;
            }
        }

        return $menuHierarchy;
    }
}
