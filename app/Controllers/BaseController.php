<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\AgendaModel;
use App\Models\EntitasModel;
use App\Models\HalamanModel;
use App\Models\KomponenMetaModel;
use App\Models\KomponenModel;
use App\Models\PengumumanModel;
use App\Models\PostingModel;
use App\Models\PPIDModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

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
abstract class BaseController extends Controller
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
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    protected BeritaModel $beritaModel;
    protected KategoriModel $kategoriModel;
    protected AgendaModel $agendaModel;
    protected PengumumanModel $pengumumanModel;
    protected PPIDModel $ppidModel;
    protected EntitasModel $entitasModel;
    protected PostingModel $postingModel;

    // Page builder models
    protected $halamanModel;
    protected $komponenModel;
    protected KomponenMetaModel $komponenMetaModel;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        // Models
        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriModel();
        $this->agendaModel = new AgendaModel();
        $this->pengumumanModel = new PengumumanModel();
        $this->ppidModel = new PPIDModel();
        $this->entitasModel = new EntitasModel();
        $this->postingModel = new PostingModel();

        $this->halamanModel = new HalamanModel();
        $this->komponenModel = new KomponenModel();
        $this->komponenMetaModel = new KomponenMetaModel();
    }
}
