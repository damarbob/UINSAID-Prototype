<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\BeritaDiajukanModel;
use App\Models\AgendaModel;
use App\Models\PengumumanModel;
use App\Models\MasukanModel;
use App\Models\BeritaModel;
use App\Models\EntitasModel;
use App\Models\FileModel;
use App\Models\GaleriModel;
use App\Models\HalamanModel;
use App\Models\KategoriModel;
use App\Models\KomponenGrupModel;
use App\Models\KomponenModel;
use App\Models\SitusModel;
use CodeIgniter\BaseModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Models\UserModel;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseControllerAdmin extends Controller
{

        protected $data;

        /**
         * Instance of the main Request object.
         *
         * @var CLIRequest|IncomingRequest
         */
        protected $request;

        /**
         * An array of helpers to be loaded automatically upon
         * class instantiation. These helpers will be available
         * to all other controllers that extend BaseController.
         *
         * @var array
         */
        protected $helpers = ['format', 'operation'];

        /**
         * Be sure to declare properties for any property fetch you initialized.
         * The creation of dynamic property is deprecated in PHP 8.2.
         */
        // protected $session;

        // Initialize models
        protected BaseModel $model; // MUST BE DECLARED ON EACH CONTROLLER

        protected UserModel $userModel;
        protected AgendaModel $agendaModel;
        protected PengumumanModel $pengumumanModel;
        protected BeritaModel $beritaModel;
        protected BeritaDiajukanModel $beritaDiajukanModel;
        protected FileModel $fileModel;
        protected GaleriModel $galeriModel;
        protected MasukanModel $masukanModel;
        protected KategoriModel $kategoriModel;
        protected SitusModel $situsModel;
        protected EntitasModel $entitasModel;

        // Page builder models
        protected HalamanModel $halamanModel;
        protected KomponenModel $komponenModel;
        protected KomponenGrupModel $komponenGrupModel;

        // Site type
        protected bool $isParentSite;
        protected bool $isChildSite;

        /**
         * Constructor.
         */
        public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
        {
                // Do Not Edit This Line
                parent::initController($request, $response, $logger);

                // Custom init
                // Site type
                $this->isParentSite = (env('app.siteType') == 'parent' || env('app.siteType') == 'super');
                $this->isChildSite = (env('app.siteType') == null || env('app.siteType') == 'child' || env('app.siteType') == 'super');

                // Preload any models, libraries, etc, here.
                $this->beritaModel = new BeritaModel();
                $this->beritaDiajukanModel = new BeritaDiajukanModel();
                $this->agendaModel = new AgendaModel();
                $this->pengumumanModel = new PengumumanModel();
                $this->fileModel = new FileModel();
                $this->galeriModel = new GaleriModel();
                $this->masukanModel = new MasukanModel();
                $this->userModel = new UserModel();
                $this->kategoriModel = new KategoriModel();
                $this->situsModel = new SitusModel();
                $this->entitasModel = new EntitasModel();

                $this->halamanModel = new HalamanModel();
                $this->komponenModel = new KomponenModel();
                $this->komponenGrupModel = new KomponenGrupModel();

                // Untuk notifikasi
                $this->data['peringatanBeritaKosong'] = count($this->beritaModel->get()) == 0;
                $this->data['peringatanPostingBerita'] = $this->beritaModel->isLatestDataOverThreeMonthsOld();
                $this->data['jumlahKotakMasukBelumTerbaca'] = count(format_tanggal($this->masukanModel->getKotakMasukBelumTerbaca()));
                $this->data['adaKotakMasukBelumTerbaca'] = ($this->data['jumlahKotakMasukBelumTerbaca'] > 0); // Ada kotak masuk yang belum terbaca

                // E.g.: $this->session = \Config\Services::session();
        }

        /**
         * AJAX operation API endpoint. Hapus banyak or delete many data using operation helper.
         * Use DataTables and processBulkNew.js to make life easier.
         */
        function hapusBanyak()
        {
                $selectedData = $this->request->getPost('selectedData');

                // Extract IDs from the selected data
                $ids = array_column($selectedData, 'id');

                $result = delete_many($ids, $this->model);

                if ($result) {
                        return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
                } else {
                        // Return an error message or any relevant response
                        return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
                }
        }
}
