<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\AgendaModel;
use App\Models\AgendaPengumumanModel;
use App\Models\EntitasGrupModel;
use App\Models\EntitasModel;
use App\Models\HalamanModel;
use App\Models\KomponenMetaModel;
use App\Models\KomponenModel;
use App\Models\MediaSosialModel;
use App\Models\MenuModel;
use App\Models\PengumumanModel;
use App\Models\PostingModel;
use App\Models\PPIDModel;
use App\Models\TemaModel;
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

    protected TemaModel $temaModel;
    protected MediaSosialModel $mediaSosialModel;
    protected MenuModel $menuModel;

    protected BeritaModel $beritaModel;
    protected KategoriModel $kategoriModel;
    protected AgendaPengumumanModel $agendaPengumumanModel;
    protected AgendaModel $agendaModel;
    protected PengumumanModel $pengumumanModel;
    protected PPIDModel $ppidModel;
    protected EntitasModel $entitasModel;
    protected EntitasGrupModel $entitasGrupModel;
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
        $this->temaModel = new TemaModel();
        $this->mediaSosialModel = new MediaSosialModel();
        $this->menuModel = new MenuModel();

        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriModel();
        $this->agendaPengumumanModel = new AgendaPengumumanModel();
        $this->agendaModel = new AgendaModel();
        $this->pengumumanModel = new PengumumanModel();
        $this->ppidModel = new PPIDModel();
        $this->entitasModel = new EntitasModel();
        $this->entitasGrupModel = new EntitasGrupModel();
        $this->postingModel = new PostingModel();

        $this->halamanModel = new HalamanModel();
        $this->komponenModel = new KomponenModel();
        $this->komponenMetaModel = new KomponenMetaModel();

        // Data
        $this->data['renderDefaultMeta'] = true; // Overwrite this value to prevent default meta data from being loaded

        $this->data['tema'] = $this->temaModel->find(setting()->get('App.temaSitus'));
        $this->data['mediaSosial'] = $this->mediaSosialModel->get();
        $this->data['menuHierarchy'] = $this->menuModel->getMenuHierarchy();
        // dd($this->data['menuHierarchy']);

        $entitas = $this->entitasModel->find(setting()->get('App.entitasSitus'));
        $this->data['entitasSitus'] = $entitas;
        $this->data['entitasModel'] = $this->entitasModel;
        $this->data['entitasGrup'] = $this->entitasGrupModel->find($entitas['grup_id']);
    }
}
