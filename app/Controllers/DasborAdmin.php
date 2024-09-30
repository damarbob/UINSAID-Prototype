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
        $this->data['statistikBerita'] = $this->beritaModel->countAll();
        $this->data['statistikAgenda'] = $this->agendaModel->countAll();
        $this->data['statistikPengumuman'] = $this->pengumumanModel->countAll();
        $this->data['statistikGaleri'] = $this->galeriModel->countAll();
        $this->data['statistikPengguna'] = $this->combinedModel->countAll();
        $this->data['statistikSitus'] = $this->situsModel->countAll();

        return view('admin_dasbor', $this->data);
    }
}
