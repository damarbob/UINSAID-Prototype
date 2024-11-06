<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseControllerAdmin;

use function App\Helpers\format_tanggal;

class DasborAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.dasborAdmin');
        $users = auth()->getProvider(); //Ambil list user

        $user = $users->findById(auth()->id()); // Ambil user

        $this->data['user'] = $user;

        // Ambil data-data terbaru untuk preview di dasbor
        $this->data['rilisMediaTerbaru'] = []; //format_tanggal($this->rilisMediaModel->getRilisMediaTerbaru(1));
        $this->data['kotakMasukTerbaru'] = []; //format_tanggal($this->masukanModel->getKotakMasukTerbaru(1));
        $this->data['kotakMasukBelumTerbaca'] = []; //format_tanggal($this->masukanModel->getKotakMasukBelumTerbaca());
        $this->data['anggotaMenungguTerbaru'] = []; //format_tanggal($this->anggotaModel->getAnggotaMenungguTerbaru(1));

        // Statistik dasbor
        $this->data['statistikBerita'] = $this->postingModel->countAll();
        // $this->data['statistikAgenda'] = $this->agendaPengumumanModel->countAll();
        // $this->data['statistikPengumuman'] = $this->pengumumanModel->countAll();
        $this->data['statistikAgenda'] = $this->agendaPengumumanModel->getAcaraTotalRecords(jenisNama: 'agenda');
        $this->data['statistikPengumuman'] = $this->agendaPengumumanModel->getAcaraTotalRecords(jenisNama: 'pengumuman');
        $this->data['statistikGaleri'] = $this->galeriModel->countAll();
        $this->data['statistikPengguna'] = $this->combinedModel->countAll();
        $this->data['statistikSitus'] = $this->situsModel->countAll();

        return view('admin_dasbor', $this->data);
    }

    // Tampilkan notifikasi terpaginasi
    public function getNotifikasi()
    {
        $limit = $this->request->getGet('limit') ?? 10;  // Default limit of 10
        $offset = $this->request->getGet('offset') ?? null;  // Default offset of 10
        $newerThan = $this->request->getGet('newer_than') ?? null;  // Default offset of 10

        $notifikasi = $this->notifikasiModel->getNotifikasiSebagian($limit, $offset, $newerThan);
        return $this->response->setJSON($notifikasi);
    }

    public function tandaiSemuaNotifikasiSudahDibaca()
    {
        // Update all notifications to mark as read
        if ($this->notifikasiModel->tandaiSemuaSudahDibaca()) return $this->response->setStatusCode(200)->setJSON(['message' => 'All notifications marked as read']);
        else return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'server error']);
    }

    public function tandaiNotifikasiSudahDibaca($id)
    {
        // Update all notifications to mark as read
        if ($this->notifikasiModel->tandaiSudahDibaca($id)) return $this->response->setStatusCode(200)->setJSON(['message' => 'All notifications marked as read']);
        else return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'server error']);
    }
}
