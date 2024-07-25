<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\update_many;

class KotakMasukAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $this->data['judul'] = "Kotak Masuk";
        return view('admin_kotak_masuk', $this->data);
    }

    public function sunting(): string
    {
        $id = $this->request->getGet('id');

        $this->data['kotakMasuk'] = format_tanggal($this->masukanModel->getKotakMasukById($id)); // Ambil kotak masuk sesuai ID
        $this->data['judul'] = $this->data['kotakMasuk']['keperluan_terformat']; // Harus dibawah $this->data['kotakMasuk'] agar dapat mengakses variabel tersebut

        return view('admin_kotak_masuk_detail', $this->data);
    }

    public function getKotakMasuk()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->masukanModel->getKotakMasuk())
        ]));
    }

    public function getKotakMasukKritikDanSaran()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->masukanModel->getKotakMasukKritikDanSaran())
        ]));
    }

    public function getKotakMasukPelaporan()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->masukanModel->getKotakMasukPelaporan())
        ]));
    }

    public function tandaiTerbacaBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        // Define the data to update for each record
        $updateData = [
            'terbaca' => '1',
        ];

        $result = update_many($selectedIds, $this->masukanModel, $updateData);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDitandai')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.gagalDitandai')]);
        }
    }

    public function tandaiBelumTerbacaBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        // Define the data to update for each record
        $updateData = [
            'terbaca' => '0',
        ];

        $result = update_many($selectedIds, $this->masukanModel, $updateData);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDitandai')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.gagalDitandai')]);
        }
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->masukanModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.hapusBanyakSukses')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.hapusBanyakGagal')]);
        }
    }
}
