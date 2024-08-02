<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\MasukanModel;
use App\Models\BeritaModel;
use App\Models\GaleriModel;
use App\Models\KategoriModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Models\UserModel;
use Psr\Log\LoggerInterface;

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
    protected $userModel;
    protected $beritaModel;
    protected $galeriModel;
    protected $masukanModel;
    protected $anggotaModel;
    protected $kategoriModel;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->beritaModel = new BeritaModel();
        $this->galeriModel = new GaleriModel();
        $this->masukanModel = new MasukanModel();
        $this->anggotaModel = null; //new AnggotaModel();
        $this->userModel = new UserModel();
        $this->kategoriModel = new KategoriModel();

        // Untuk notifikasi
        $this->data['peringatanBeritaKosong'] = count($this->beritaModel->get()) == 0;
        $this->data['peringatanPostingBerita'] = $this->beritaModel->isLatestDataOverThreeMonthsOld();
        $this->data['jumlahKotakMasukBelumTerbaca'] = count(format_tanggal($this->masukanModel->getKotakMasukBelumTerbaca()));
        $this->data['adaKotakMasukBelumTerbaca'] = ($this->data['jumlahKotakMasukBelumTerbaca'] > 0); // Ada kotak masuk yang belum terbaca

        // E.g.: $this->session = \Config\Services::session();
    }
}
