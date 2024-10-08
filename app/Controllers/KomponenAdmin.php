<?php

namespace App\Controllers;

use App\Controllers\BaseControllerAdmin;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\hasAttributesSyntax;

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
        $this->data['grup'] = $this->komponenGrupModel->findAll();
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
        helper('syntax_processor');

        $data = $this->request->getPost();

        // dd($data);

        // Check for file uploads
        $cssFile = $this->request->getFile('css_file');
        $jsFile = $this->request->getFile('js_file');

        /* Files validation */
        $fileRules = []; // Contains file rules

        $cssFileValid = $cssFile && $cssFile->isValid();
        $jsFileValid = $jsFile && $jsFile->isValid();

        if ($cssFileValid || $jsFileValid) {
            if ($cssFileValid) {
                $fileRules = array_merge(
                    $fileRules,
                    [
                        'css_file' => [
                            'label' => 'CSS',
                            'rules' => [
                                'uploaded[css_file]',
                                'ext_in[css_file,css]',
                            ]
                        ]
                    ]
                );
            }
            if ($jsFileValid) {
                $fileRules = array_merge(
                    $fileRules,
                    [
                        'js_file' => [
                            'label' => 'JS',
                            'rules' => [
                                'uploaded[js_file]',
                                'ext_in[js_file,js]',
                            ]
                        ],
                    ]
                );
            }
            if (!$this->validateData([], $fileRules)) {
                return redirect()->back()->withInput();
            }
        }
        /* End of files validation */

        /* Input validation */
        $rules = [
            'nama' => [
                'label' => lang('Admin.nama'),
                'rules' => 'required',
            ],
            'konten' => [
                'label' => lang('Admin.konten'),
                'rules' => 'required',
            ],
            'grup_lainnya' => [
                'label' => lang('Admin.namaGrup'),
                'rules' => 'required_without[grup]'
            ],
            'tunggal' => [
                'label' => lang('Admin.komponenTunggal'),
                'rules' => 'required',
            ]
        ];

        // Cek validasi input
        if (!$this->validate($rules)) {

            // dd($halamanLama);
            // dd("Dead by validation");

            return redirect()->back()->withInput();
        }
        /* End of input validation */

        /* Grup assignment or creation */
        // Check if the grup exists
        // $grup = $this->komponenGrupModel->getByNama($data['grup']);

        // If the grup does not exist, create a new one
        // if (!$grup) {
        //     $this->komponenGrupModel->save(['nama' => $data['grup']]);
        //     $grup = $this->komponenGrupModel->getByNama($data['grup']);
        // }

        // unset($data['grup']); // Unset the data grup variable as  it's not in the model
        // $data['grup_id'] = $grup['id']; // Set  the grup ID in the data array
        /* End of grup assignment or creation */

        /* Files upload */
        // Initialize file paths
        $cssPath = null;
        $jsPath = null;

        // Handle CSS file upload
        if ($cssFile && $cssFile->isValid() && !$cssFile->hasMoved()) {
            $originalName = url_title(pathinfo($cssFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
            $randomName = $cssFile->getRandomName(); // Generate a random file name
            $cssFile->move(FCPATH . 'assets/components/css/', $originalName . '-' . $randomName);
            $cssPath = ('assets/components/css/' . $originalName . '-' . $randomName);
            $data['css'] = $cssPath;
        } else {
            $data['css'] = $data['css_old'];
        }

        // Handle JS file upload
        if ($jsFile && $jsFile->isValid() && !$jsFile->hasMoved()) {
            $originalName = url_title(pathinfo($jsFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
            $randomName = $jsFile->getRandomName(); // Generate a random file name
            $jsFile->move(FCPATH . 'assets/components/js/', $originalName . '-' . $randomName);
            $jsPath = ('assets/components/js/' . $originalName . '-' . $randomName);
            $data['js'] = $jsPath;
        } else {
            $data['js'] = $data['js_old'];
        }
        /* End of files upload */

        /* Determine whether komponen is tunggal (singular) or not */
        // $data['tunggal'] = !hasAttributesSyntax($data['konten']); // Set to false if has attributes syntax // CANCELED
        $data['tunggal'] = $data['tunggal'] == "on" ? true : false; // 
        /* End of determination */

        /* CRUD */
        // Get grup from the request
        $grupNama = $this->request->getVar('grup') ?: $this->request->getVar('grup_lainnya');

        // Check if the grup exists
        $grup = $this->komponenGrupModel->getByNama($grupNama);

        // If the grup does not exist, create a new one
        if (!$grup) {
            $this->komponenGrupModel->save(['nama' => $grupNama]);
            $grup = $this->komponenGrupModel->getByNama($grupNama);
        }

        unset($data['grup']); // Unset the data grup variable as  it's not in the model
        unset($data['grup_lainnya']); // Unset the data grup variable as  it's not in the model
        $data['grup_id'] = $grup['id']; // Set  the grup ID in the data array

        if ($id === null) {
            // Create new component
            $this->komponenModel->save($data);

            // Pesan berhasil dibuat
            session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));

            return redirect()->to('admin/komponen/');
        } else {
            // Update existing component
            $this->komponenModel->update($id, $data);

            // Pesan berhasil diperbarui
            session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
        }

        return redirect()->to('admin/komponen/sunting/' . $id);
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

    public function getMetaById()
    {
        // Retrieve componentId and halamanId from the request
        $componentInstanceId = $this->request->getPost('idInstance');
        $componentId = $this->request->getPost('idKomponen');
        $halamanId = $this->request->getPost('idHalaman');

        return $this->response->setJSON(json_encode([
            "data" => $this->komponenMetaModel->getById($componentInstanceId, $componentId, $halamanId)
        ]));
    }

    public function simpanMeta()
    {
        $response = ['success' => false, 'message' => lang('Admin.terjadiGalat')];

        $postNoMeta = $this->request->getPost();
        // $postNoMeta['meta'] = '';

        // return $this->response->setJSON(['error' => false, 'message' => json_encode($postNoMeta['meta'])]);

        // Retrieve componentId and halamanId from the request
        $componentInstanceId = $this->request->getPost('instance_id');
        $componentId = $this->request->getPost('komponen_id');
        $halamanId = $this->request->getPost('halaman_id');
        $metaJson = $this->request->getPost('meta');

        // Get meta lama
        $metaLama = $this->komponenMetaModel->getById($componentInstanceId, $componentId, $halamanId);
        // return $this->response->setJSON(['error' => false, 'message' => $componentInstanceId]);
        // return $this->response->setJSON(['error' => false, 'message' => $metaJson]);
        // return $this->response->setJSON(['error' => false, 'message' => $metaLama['meta']]);

        // Initialize an array to store uploaded file URLs
        $fileUrls = [];
        $log = [];

        $files = $this->request->getFiles();
        // return $this->response->setJSON(['error' => false, 'message' => json_encode($files)]);
        $log['received_files'] = $files;
        // $log['post'] = $this->request->getPost();

        // Handle file uploads
        if ($files) {
            foreach ($files as $fileInputName => $uploadedFiles) {
                // return $this->response->setJSON(['error' => false, 'message' => json_encode($fileInputName)]);

                if (!is_array($uploadedFiles)) {
                    $uploadedFiles = [$uploadedFiles]; // Make it an array if it's a single file
                }

                foreach ($uploadedFiles as $file) { // Ensure $file is an instance of UploadedFile
                    // return $this->response->setJSON(['error' => false, 'message' => json_encode($file)]);

                    if ($file instanceof UploadedFile) {
                        if ($file->isValid() && !$file->hasMoved()) {

                            // Log file details
                            $log['file_details'][] = [
                                'input_name' => $fileInputName,
                                'original_name' => $file->getClientName(),
                                'temp_path' => $file->getTempName(),
                                'file_size' => $file->getSize(),
                                'file_type' => $file->getMimeType(),
                            ];

                            $originalName = url_title(pathinfo($file->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
                            $randomName = $file->getRandomName();
                            $file->move(FCPATH . 'assets/components/uploads', $originalName . '-' . $randomName);
                            $fileUrls[$fileInputName][] = ("assets/components/uploads/" . $originalName . '-' . $randomName);
                        } else {
                            // If the file is invalid, log the error
                            $log['file_errors'][] = [
                                'input_name' => $fileInputName,
                                'error_message' => $file->getErrorString(),
                            ];
                        }
                    }
                }
            }
        }

        if (sizeof($fileUrls) == 0) {
        }

        // return $this->response->setJSON(['error' => false, 'message' => json_encode($log)]);

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
            'instance_id' => $componentInstanceId,
            'komponen_id' => $componentId,
            'halaman_id' => $halamanId,
            'meta' => $encodedMeta,
        ];

        if ($komponenMetaModel->insert($data)) {
            $response = ['success' => true, 'message' => lang('Admin.metaDataBerhasilDisimpan')];
        } else {
            $response = ['success' => false, 'message' => lang('Admin.gagalMenyimpanMetaData')];
        }

        return $this->response->setJSON($response);
    }


    /**
     * Get data for DataTables server-side processing
     *
     * @param string|null $status Optional status filter
     * @return $this
     */
    public function getDT()
    {
        $columns = ['nama', 'css', 'js', 'grup'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $grupNama = $this->request->getPost('grup') ?? null;
        $search = $this->request->getPost('search')['value'] ?? null;

        $totalData = $this->komponenModel->countAll();
        $totalFiltered = $totalData;

        $komponen = $this->komponenModel->getDT($limit, $start, $grupNama, $search, $order, $dir);

        if ($search || $grupNama) {
            $totalFiltered = $this->komponenModel->getTotalFilteredRecordsDT($grupNama, $search);
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
