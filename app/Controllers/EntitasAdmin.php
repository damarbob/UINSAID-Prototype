<?php

namespace App\Controllers;

use App\Models\EntitasGrupModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;

class EntitasAdmin extends BaseControllerAdmin
{
    protected $entitasGrupModel;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // $this->entitasModel = $this->entitasModel;
        $this->entitasGrupModel = new EntitasGrupModel();
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.entitas');
        $this->data['entitas'] = $this->entitasModel->findAll();
        return view('admin_entitas', $this->data);
    }

    /**
     * Get data for DataTables server-side processing
     *
     * @return $this
     */
    /**
     * Get data for DataTables server-side processing
     * 
     * @return JSON JSON entitas data
     */
    public function getDT()
    {
        $columns = ['id', 'parent_nama', 'nama', 'slug', 'deskripsi', 'gambar_sampul', 'grup_id', 'parent_id', 'alamat', 'telepon', 'fax', 'email', 'website', 'entitas_grup_nama'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->entitasModel->countAll();
        $totalFiltered = $totalData;

        $entitas = $this->entitasModel->getDT($limit, $start, $search, $order, $dir);

        if ($search) {
            $totalFiltered = $this->entitasModel->getTotalFilteredRecordsDT($search);
        }

        $data = [];
        if (!empty($entitas)) {
            foreach ($entitas as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['parent_nama'] = $row['parent_nama']; // Include parent_nama
                $nestedData['nama'] = $row['nama'];
                $nestedData['entitas_grup_nama'] = $row['entitas_grup_nama'];
                $nestedData['website'] = $row['website'];
                // $nestedData['urutan'] = $row['urutan'];
                // $nestedData['created_at'] = $row['created_at'];
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

    public function tambah()
    {
        // Get parent options
        $this->data['parents'] = $this->entitasModel->getParentByEntitasGrupParentId();

        // Get Entitas utama
        $this->data['universitas'] = $this->entitasModel->join('entitas_grup', 'entitas.grup_id = entitas_grup.id', 'left')->where('entitas_grup.nama', 'Universitas')->first();

        // If creating, calculate the urutan for the selected parent_id
        // $parentId = $this->request->getPost('parent_id');
        // $this->data['urutanOptions'] = $this->entitasModel->getUrutanOptions();

        $this->data['judul'] = lang('Admin.tambahEntitas');
        $this->data['mode'] = "tambah";
        $this->data['grup'] = array_reverse($this->entitasGrupModel->findAll());
        // $this->data['semuaEntitas'] = $this->entitasModel->findAll();
        return view('admin_entitas_editor', $this->data);
    }

    // Edit a specific entitas
    public function sunting($id = null)
    {
        if ($id == null) $id = $this->request->getGet('id');
        $entitas = $this->entitasModel->find($id);
        if (empty($entitas)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Entitas tidak ditemukan.');
        }

        // Get parent options
        $this->data['parents'] = $this->entitasModel->getParentByEntitasGrupParentId();

        // Get Entitas utama
        $this->data['universitas'] = $this->entitasModel->join('entitas_grup', 'entitas.grup_id = entitas_grup.id', 'left')->where('entitas_grup.nama', 'Universitas')->first();

        // If editing, get current parent and child urutan
        // $parentId = $entitas['parent_id'] ?? null;
        // $this->data['urutanOptions'] = $this->entitasModel->getUrutanOptions($parentId, $id);

        $this->data['judul'] = lang('Admin.suntingEntitas');
        $this->data['mode'] = "sunting";
        $this->data['entitas'] = $entitas;
        $this->data['grup'] = array_reverse($this->entitasGrupModel->findAll());
        // $this->data['semuaEntitas'] = $this->entitasModel->findAll();
        return view('admin_entitas_editor', $this->data);
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
        $redirectTo = ($id == null) ? base_url('/admin/entitas/') : base_url('/admin/entitas/sunting?id=') . $id;

        if (!$this->validate($rules)) {
            // dd("Dead by input validation");

            if ($id == null) {
                return redirect()->back()->withInput();
            }

            return redirect()->to($redirectTo)->withInput();
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'slug' => url_title($this->request->getPost('nama'), lowercase: true),
            'website' => $this->request->getPost('website'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'fax' => $this->request->getPost('fax'),
            'email' => $this->request->getPost('email'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'parent_id' => $this->request->getPost('parent_id'),
            'grup_id' => $this->request->getPost('grup_id'),
            'urutan' => $this->request->getPost('urutan'),
        ];

        $gambarSampulFile = $this->request->getFile('gambar_sampul_file');

        // Handle JS file upload
        if ($gambarSampulFile && $gambarSampulFile->isValid() && !$gambarSampulFile->hasMoved()) {
            $originalName = url_title(pathinfo($gambarSampulFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
            $randomName = $gambarSampulFile->getRandomName(); // Generate a random file name
            $gambarSampulFile->move(FCPATH . 'assets/img/logo/', $originalName . '-' . $randomName);
            $path = ('assets/img/logo/' . $originalName . '-' . $randomName);
        } else {
            $path = $this->request->getPost('gambar_sampul_old');
        }
        $data['gambar_sampul'] = $path;

        // If editing, get the old parent_id before updating the record
        // $oldParentId = null;
        if ($id) {
            // $oldEntitas = $this->entitasModel->find($id);
            // $oldParentId = $oldEntitas['parent_id'];

            // Update existing entitas
            $this->entitasModel->update($id, $data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        } else {
            // Create new entitas
            $this->entitasModel->insert($data);
            // $id = $this->entitasModel->getInsertID(); // Get the new entitas's ID

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
        }

        // Reorder entitass after insert/update
        // $this->entitasModel->reorderEntitass($data['parent_id'], $data['urutan'], $id, $oldParentId);

        return redirect()->to($redirectTo)->withInput();
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->entitasModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }
}
