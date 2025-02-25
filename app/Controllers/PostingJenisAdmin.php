<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\update_many;

class PostingJenisAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->model = $this->postingJenisModel;
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.jenisPosting');
        return view('admin_posting_jenis', $this->data);
    }

    // Fetch data untuk datatable
    public function fetchData()
    {

        $columns = ['nama', 'created_at', 'updated_at'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;

        $draw = $this->request->getPost('draw');
        $totalData = $this->postingModel->countAllResults();
        $totalFiltered = $totalData;

        $items = $this->postingJenisModel->getForDatatables(
            $search,
            $limit,
            $start,
            $order,
            $dir
        );

        if ($search) {
            $totalFiltered = sizeof($items);
        }

        // return response()->setJSON($items);

        $data = [];
        if (!empty($items)) {
            foreach ($items as $i) {
                $nestedData['id'] = $i['id'];
                $nestedData['nama'] = $i['nama'];
                $nestedData['created_at'] = $i['created_at'];
                $nestedData['updated_at'] = $i['updated_at'];
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $this->response->setJSON($json_data);
    }

    public function tambah()
    {
        $data = $this->request->getPost();

        // Prepare data for users table
        $userData = [];
        if (!empty($data['nama'])) {
            $userData['nama'] = $data['nama'];
        }

        // Validation
        $validation = Services::validation();
        $validation->setRules(
            [
                'nama' => [
                    'label' => lang('Admin.nama'),
                    'rules' => 'required|is_unique[posting_jenis.nama]'
                ]
            ]
        );

        // Validate input
        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $validation->getErrors()
            ]);
        }

        $this->postingJenisModel->save($userData);

        return $this->response->setJSON([
            'success' => true,
            'message' => lang('Admin.berhasilDibuat')
        ]);
    }

    public function sunting()
    {
        $data = $this->request->getPost();

        // Prepare data for users table
        $userData = [];
        $userData['id'] = $data['id'];
        if (!empty($data['nama'])) {
            $userData['nama'] = $data['nama'];
        }

        // Validation
        $validation = Services::validation();
        $validation->setRules(
            [
                'nama' => [
                    'label' => lang('Admin.nama'),
                    'rules' => 'required'
                ]
            ]
        );

        // Validate input
        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $validation->getErrors()
            ]);
        }

        $this->postingJenisModel->save($userData);

        return $this->response->setJSON([
            'success' => true,
            'message' => lang('Admin.berhasilDiperbarui')
        ]);
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->postingJenisModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }
}
