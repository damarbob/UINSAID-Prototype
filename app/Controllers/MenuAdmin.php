<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;

class MenuAdmin extends BaseControllerAdmin
{

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // $this->menuModel = $this->menuModel;
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.menu');
        $this->data['menu'] = $this->menuModel->findAll();
        $this->data['parents'] = $this->menuModel->getParents();
        // dd($this->menuModel->getDT(10, 0));
        return view('admin_menu', $this->data);
    }

    /**
     * Get data for DataTables server-side processing
     *
     * @return $this
     */
    public function getDT()
    {
        $columns = ['parent_nama', 'nama', 'uri', 'urutan'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $parentNama = $this->request->getPost('parent');
        $totalData = $this->menuModel->countAll();
        $totalFiltered = $totalData;

        $menu = $this->menuModel->getDT($limit, $start, $search, $order, $dir, $parentNama);

        if ($search || $parentNama) {
            $totalFiltered = $this->menuModel->getTotalFilteredRecordsDT($search, $parentNama);
        }

        $data = [];
        if (!empty($menu)) {
            foreach ($menu as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['parent_nama'] = $row['parent_nama']; // Include parent_nama
                $nestedData['nama'] = $row['nama'];
                $nestedData['uri'] = $row['uri'];
                $nestedData['link_eksternal'] = $row['link_eksternal'];
                $nestedData['urutan'] = $row['urutan'];
                $nestedData['created_at'] = $row['created_at'];
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $this->response->setJSON($json_data);
    }

    /**
     * Get options to urutan when create or edit menu based on parent_id
     * 
     * @return JSON JSON of urutan and current
     */
    public function getUrutanOptions()
    {
        $parent_id = $this->request->getPost('parent_id');
        $menu_id = $this->request->getPost('menu_id');
        return $this->response->setJSON(["data" => $this->menuModel->getUrutanOptions($parent_id, $menu_id)]);
    }

    public function tambah()
    {
        // Get parent options where parent_id is null (top-level menus)
        $this->data['parents'] = $this->menuModel->where('parent_id', 0)->findAll();

        // If creating, calculate the urutan for the selected parent_id
        // $parentId = $this->request->getPost('parent_id');
        $this->data['urutanOptions'] = $this->menuModel->getUrutanOptions();

        $this->data['judul'] = lang('Admin.tambahMenu');
        $this->data['mode'] = "tambah";
        $this->data['semuaMenu'] = $this->menuModel->findAll();
        return view('admin_menu_editor', $this->data);
    }

    // Edit a specific menu
    public function sunting($id = null)
    {
        if ($id == null) $id = $this->request->getGet('id');
        $menu = $this->menuModel->find($id);
        if (empty($menu)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Menu tidak ditemukan.');
        }

        // Get parent options where parent_id is null (top-level menus)
        $this->data['parents'] = $this->menuModel->where('parent_id', 0)->findAll();

        // If editing, get current parent and child urutan
        $parentId = $menu['parent_id'] ?? null;
        $this->data['urutanOptions'] = $this->menuModel->getUrutanOptions($parentId, $id);

        $this->data['judul'] = lang('Admin.suntingMenu');
        $this->data['mode'] = "sunting";
        $this->data['menu'] = $menu;
        $this->data['semuaMenu'] = $this->menuModel->findAll();
        return view('admin_menu_editor', $this->data);
    }

    // Save the reordered components
    public function simpan($id = null)
    {
        // Validasi
        $rules = [
            'nama' => [
                'label' => lang('Admin.nama'),
                'rules' => 'required',
            ],
        ];

        // Redireksi
        $redirectTo = ($id == null) ? base_url('/admin/menu/') : base_url('/admin/menu/sunting?id=') . $id;

        if (!$this->validate($rules)) {
            // dd("Dead by input validation");

            if ($id == null) {
                return redirect()->back()->withInput();
            }

            return redirect()->to($redirectTo)->withInput();
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'uri' => $this->request->getPost('uri'),
            'link_eksternal' => $this->request->getPost('link_eksternal') == "1" ? 1 : 0,
            'parent_id' => $this->request->getPost('parent_id'),
            'urutan' => $this->request->getPost('urutan'),
        ];

        // If editing, get the old parent_id before updating the record
        $oldParentId = null;
        if ($id) {
            $oldMenu = $this->menuModel->find($id);
            $oldParentId = $oldMenu['parent_id'];

            // Update existing menu
            $this->menuModel->update($id, $data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        } else {
            // Create new menu
            $this->menuModel->insert($data);
            $id = $this->menuModel->getInsertID(); // Get the new menu's ID

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        }

        // Reorder menus after insert/update
        $this->menuModel->reorderMenus($data['parent_id'], $data['urutan'], $id, $oldParentId);

        return redirect()->to($redirectTo)->withInput();
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->menuModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }
}
