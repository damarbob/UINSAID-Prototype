<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class HalamanAdmin extends BaseControllerAdmin
{
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->model = $this->halamanModel;
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.halaman');
        $this->data['halaman'] = $this->model->findAll();
        return view('admin_halaman', $this->data);
    }

    /**
     * Get data for DataTables server-side processing
     *
     * @param string|null $status Optional status filter
     * @return $this
     */
    public function getDT($status = null)
    {
        $columns = ['id', 'judul', 'slug', 'id_komponen', 'css', 'js', 'status', 'created_at'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->model->countAll();
        $totalFiltered = $totalData;

        $halaman = $this->model->getDT($limit, $start, $status, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->model->getTotalFilteredRecordsDT($status, $search);
        }

        $data = [];
        if (!empty($halaman)) {
            foreach ($halaman as $row) {

                $nestedData['id'] = $row['id'];
                $nestedData['judul'] = $row['judul'];
                $nestedData['slug'] = $row['slug'];
                $nestedData['id_komponen'] = $row['id_komponen'];
                $nestedData['css'] = $row['css'];
                $nestedData['js'] = $row['js'];
                $nestedData['status'] = $row['status'];
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

    public function tambah()
    {
        $this->data['judul'] = lang('Admin.buatHalaman');
        $this->data['availableComponents'] = $this->komponenModel->findAll();
        return view('admin_halaman_editor', $this->data);
    }

    // Edit a specific page
    public function sunting($id)
    {
        $halaman = $this->model->find($id);
        $this->data['judul'] = lang('Admin.suntingHalaman') . " - " . $halaman['judul'];
        $id_komponen = json_decode($halaman['id_komponen']);
        $komponen = [];
        if ($id_komponen) {
            foreach ($id_komponen as $id) {
                $komponen[] = $this->komponenModel->find($id);
            }
        }
        $this->data['halaman'] = $halaman;
        $this->data['komponen'] = $komponen;
        $this->data['availableComponents'] = $this->komponenModel->findAll();

        return view('admin_halaman_editor', $this->data);
    }

    // Save the reordered components
    public function simpan($id = null)
    {
        $newOrder = $this->request->getPost('id_komponen');
        $data = [
            'judul' => $this->request->getPost('judul'),
            'slug' => $this->request->getPost('slug'),
            'id_komponen' => $newOrder,
            'css' => $this->request->getPost('css'),
            'js' => $this->request->getPost('js'),
        ];

        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->insert($data);
        }

        return redirect()->to('/admin/halaman')->with('message', 'Halaman saved successfully.');
    }

    /**
     * Frontend view
     * 
     * @param int Id of the page
     * @return string Halaman page
     */
    public function view($id)
    {
        $halaman = $this->model->find($id);
        $id_komponen = json_decode($halaman['id_komponen']);
        $komponen = [];

        if ($id_komponen) {
            foreach ($id_komponen as $id_komponen) {
                $komponen[] = $this->komponenModel->find($id_komponen);
            }
        }

        $this->data['halaman'] = $halaman;
        $this->data['komponen'] = $komponen;

        return view('halaman', $this->data);
    }
}
