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
        $this->data['komponen_grup'] = $this->komponenGrupModel->findAll();
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

    public function simpanMeta()
    {
        $response = ['success' => false, 'message' => 'An error occurred'];

        // Retrieve componentId and halamanId from the request
        $componentId = $this->request->getPost('komponen_id');
        $halamanId = $this->request->getPost('halaman_id');
        $metaJson = $this->request->getPost('meta');

        // Initialize an array to store uploaded file URLs
        $fileUrls = [];

        // Handle file uploads
        if ($files = $this->request->getFiles()) {
            foreach ($files as $fileInputName => $uploadedFiles) {
                if (!is_array($uploadedFiles)) {
                    $uploadedFiles = [$uploadedFiles]; // Make it an array if it's a single file
                }

                foreach ($uploadedFiles as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(FCPATH . 'assets/components/uploads', $newName);
                        $fileUrls[$fileInputName][] = base_url("assets/components/uploads/" . $newName);
                    }
                }
            }
        }

        // Decode the existing meta JSON to a PHP array
        $metaDataArray = json_decode($metaJson, true);

        // Convert to associative array for easy lookup by 'id'
        $metaDataAssoc = [];
        foreach ($metaDataArray as $meta) {
            $metaDataAssoc[$meta['id']] = $meta['value'];
        }

        // Append or update file URLs in the associative array
        // foreach ($fileUrls as $fileInputName => $urls) {
        //     if (isset($metaDataAssoc[$fileInputName])) {
        //         // If the id already exists, merge existing and new URLs
        //         $existingValue = $metaDataAssoc[$fileInputName];
        //         if (is_array($existingValue)) {
        //             $metaDataAssoc[$fileInputName] = array_merge($existingValue, $urls);
        //         } else {
        //             $metaDataAssoc[$fileInputName] = array_merge([$existingValue], $urls);
        //         }
        //     } else {
        //         // If the id does not exist, add the new URLs
        //         $metaDataAssoc[$fileInputName] = count($urls) > 1 ? $urls : $urls[0];
        //     }
        // }

        // Append or update file URLs in the associative array
        foreach ($fileUrls as $fileInputName => $urls) {
            $metaDataAssoc[$fileInputName] = $urls; // Only store URLs, no merging needed
        }

        // Convert back to a simple indexed array
        $metaDataArray = [];
        foreach ($metaDataAssoc as $id => $value) {
            $metaDataArray[] = [
                'id' => $id,
                'value' => $value
            ];
        }

        // Re-encode the updated meta data to JSON
        $encodedMeta = json_encode($metaDataArray);

        // Save the meta data to the database
        $komponenMetaModel = $this->komponenMetaModel;
        $data = [
            'komponen_id' => $componentId,
            'halaman_id' => $halamanId,
            'meta' => $encodedMeta,
        ];

        if ($komponenMetaModel->insert($data)) {
            $response = ['success' => true, 'message' => 'Meta data and files processed successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to save meta data'];
        }

        return $this->response->setJSON($response);
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
