<?php

namespace App\Controllers;

use App\Controllers\BaseControllerAdmin;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class KomponenAdmin extends BaseControllerAdmin
{

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->model = $this->komponenModel;
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.komponen');
        $this->data['komponen'] = $this->komponenModel->findAll();
        return view('admin_komponen', $this->data);
    }

    public function tambah()
    {
        $this->data['judul'] = lang('Admin.buatKomponen');
        return view('admin_komponen_editor', $this->data);
    }

    public function simpan($id = null)
    {
        $data = $this->request->getPost();

        // Check for file uploads
        $cssFile = $this->request->getFile('css_file');
        $jsFile = $this->request->getFile('js_file');

        // Initialize file paths
        $cssPath = null;
        $jsPath = null;

        // Handle CSS file upload
        if ($cssFile && $cssFile->isValid() && !$cssFile->hasMoved()) {
            $cssName = $cssFile->getRandomName(); // Generate a random file name
            $cssFile->move(FCPATH . 'assets/components/css/', $cssName);
            $cssPath = base_url('assets/components/css/' . $cssName);
            $data['css'] = $cssPath;
        }

        // Handle JS file upload
        if ($jsFile && $jsFile->isValid() && !$jsFile->hasMoved()) {
            $jsName = $jsFile->getRandomName(); // Generate a random file name
            $jsFile->move(FCPATH . 'assets/components/js/', $jsName);
            $jsPath = base_url('assets/components/js/' . $jsName);
            $data['js'] = $jsPath;
        }

        // Get grup from the request
        $grupNama = $this->request->getVar('grup') ?: $this->request->getVar('grup_lainnya');

        // Check if the grup exists
        $grup = $this->komponenGrupModel->getByNama($grupNama);

        // If the grup does not exist, create a new one
        if (!$grup) {
            $this->komponenGrupModel->save(['nama' => $grupNama]);
            $grup = $this->komponenGrupModel->getByNama($grupNama);
        }

        if ($id === null) {
            // Create new component
            $this->komponenModel->save($data);
        } else {
            // Update existing component
            $this->komponenModel->update($id, $data);
        }

        return redirect()->to('/admin/komponen');
    }


    public function sunting($id)
    {
        $komponen = $this->komponenModel->getByID($id);
        $this->data['komponen'] = $komponen;
        $this->data['komponen_grup'] = $this->komponenGrupModel->findAll();
        $this->data['komponen_css_file'] = (isset($komponen['css']) && $komponen['css'] != '') ? pathinfo($komponen['css'])['filename'] . "." . pathinfo($komponen['css'])['extension'] : null;
        $this->data['komponen_js_file'] = (isset($komponen['js']) && $komponen['js'] != '') ? pathinfo($komponen['js'])['filename'] . "." . pathinfo($komponen['js'])['extension'] : null;

        $this->data['judul'] = lang('Admin.suntingKomponen') . " - " . $komponen['nama'];
        return view('admin_komponen_editor', $this->data);
    }

    public function delete($id)
    {
        $this->komponenModel->delete($id);
        return redirect()->to('/admin/komponen');
    }

    /**
     * Get data for DataTables server-side processing
     *
     * @param string|null $status Optional status filter
     * @return $this
     */
    public function getDT($status = null)
    {
        $columns = ['nama', 'css', 'js', 'grup'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->komponenModel->countAll();
        $totalFiltered = $totalData;

        $komponen = $this->komponenModel->getDT($limit, $start, $status, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->komponenModel->getTotalFilteredRecordsDT($status, $search);
        }

        $data = [];
        if (!empty($komponen)) {
            foreach ($komponen as $row) {
                $nestedData['id'] = $row['id'];
                $nestedData['nama'] = $row['nama'];
                $nestedData['css'] = $row['css'];
                $nestedData['js'] = $row['js'];
                $nestedData['grup'] = $row['grup'];
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
}
