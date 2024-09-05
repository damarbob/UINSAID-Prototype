<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home');
$routes->get('pendidikan', 'PendidikanController');
$routes->get('riset-publikasi', 'RisetPublikasi');
$routes->get('tentang-kami', 'TentangKami');
$routes->get('/berita', 'Berita');
$routes->get('/berita/(:any)', 'Berita::get/$1');
$routes->get('/kategori/(:any)', 'Berita::getByKategori/$1');
$routes->get('test', 'BeritaAdmin::test');
$routes->get('xml-migration', 'XmlMigrationController::migrate');
$routes->get('xml-migration-lampiran', 'XmlMigrationLampiranController::migrate');
$routes->get('entitas', 'Entitas');

// TESTING ROUTES
// $routes->get('/entitas', 'Entitas');

// Route dinamis untuk halaman yang dibuat
$routes->group('halaman', function ($routes) {
    $halamanModel = new \App\Models\HalamanModel();
    $pages = $halamanModel->findAll();

    foreach ($pages as $page) {
        $slug = $page['slug'];
        $routes->get($slug, 'HalamanAdmin::view/' . $page['id']);
    }
});

// Route dinamis untuk entitas yang dibuat
$routes->group('entitas', function ($routes) {
    $entitasModel = new \App\Models\EntitasModel();
    $entitas = $entitasModel->findAll();

    foreach ($entitas as $e) {
        $slug = $e['slug'];
        $routes->get($slug, 'Entitas::get/' . $e['slug']);
    }
});

// Maintenance
$routes->get('maintenance', function () {
    return view('maintenance');
});

// Admin
$routes->group('admin', ['filter' => 'group:admin,superadmin'], function ($routes) {

    // Dasbor
    $routes->get('dasbor', 'DasborAdmin', ['as' => 'dashboard']);
    $routes->addRedirect('/', 'dashboard');

    // Manajemen halaman
    $routes->get('halaman', 'HalamanAdmin::index');
    $routes->get('halaman/tambah', 'HalamanAdmin::tambah');
    $routes->get('halaman/sunting/(:num)', 'HalamanAdmin::sunting/$1');
    $routes->post('halaman/simpan', 'HalamanAdmin::simpan');
    $routes->post('halaman/simpan/(:num)', 'HalamanAdmin::simpan/$1');
    $routes->post('halaman/hapus', 'HalamanAdmin::hapusBanyak');

    // Berita
    $routes->get('berita', 'BeritaAdmin');
    $routes->get('berita/tambah', 'BeritaAdmin::tambah');
    $routes->post('berita/tambah/simpan', 'BeritaAdmin::simpan');
    $routes->get('berita/sunting', 'BeritaAdmin::sunting');
    $routes->get('berita/sunting/(:num)', 'BeritaAdmin::sunting/$1');
    $routes->post('berita/sunting/simpan/(:num)', 'BeritaAdmin::simpan/$1');
    $routes->post('berita/hapus', 'BeritaAdmin::hapusBanyak');

    // Berita (selain web utama)
    if (env('app.siteType') == null || env('app.siteType') == 'child' || env('app.siteType') == 'super') {
        $routes->post('berita/ajukan', 'BeritaAdmin::ajukanBanyak');
        $routes->post('berita/batal-ajukan', 'BeritaAdmin::batalAjukanBanyak');
    }

    // Agenda
    $routes->get('agenda', 'AgendaAdmin', ['as' => 'agenda_admin']);
    $routes->get('agenda/tambah', 'AgendaAdmin::tambah', ['as' => 'agenda_admin_tambah']);
    $routes->post('agenda/tambah/simpan', 'AgendaAdmin::simpan', ['as' => 'agenda_admin_simpan_baru']);
    $routes->get('agenda/sunting', 'AgendaAdmin::sunting', ['as' => 'agenda_admin_sunting']);
    $routes->get('agenda/sunting/(:num)', 'AgendaAdmin::sunting/$1', ['as' => 'agenda_admin_sunting']);
    $routes->post('agenda/sunting/simpan/(:num)', 'AgendaAdmin::simpan/$1', ['as' => 'agenda_admin_simpan_sunting']);
    $routes->post('agenda/hapus', 'AgendaAdmin::hapusBanyak', ['as' => 'agenda_admin_hapus']);

    // Pengumuman
    $routes->get('pengumuman', 'PengumumanAdmin', ['as' => 'pengumuman_admin']);
    $routes->get('pengumuman/tambah', 'PengumumanAdmin::tambah', ['as' => 'pengumuman_admin_tambah']);
    $routes->post('pengumuman/tambah/simpan', 'PengumumanAdmin::simpan', ['as' => 'pengumuman_admin_simpan']);
    $routes->get('pengumuman/sunting', 'PengumumanAdmin::sunting', ['as' => 'pengumuman_admin_sunting']);
    $routes->get('pengumuman/sunting/(:num)', 'PengumumanAdmin::sunting/$1', ['as' => 'pengumuman_admin_sunting']);
    $routes->post('pengumuman/sunting/simpan/(:num)', 'PengumumanAdmin::simpan/$1', ['as' => 'pengumuman_admin_simpan_sunting']);
    $routes->post('pengumuman/hapus', 'PengumumanAdmin::hapusBanyak', ['as' => 'pengumuman_admin_hapus']);

    // Unggah dan hapus gambar berita
    $routes->post('berita/unggah-gambar', 'BeritaAdmin::unggahGambar');
    $routes->post('berita/hapus-gambar', 'BeritaAdmin::hapusGambar');

    // Berita diajukan (web utama)
    if (env('app.siteType') == 'parent' || env('app.siteType') == 'super') {
        $routes->get('berita-diajukan', 'BeritaDiajukanAdmin');
        $routes->post('berita-diajukan/publikasi', 'BeritaDiajukanAdmin::publikasiBanyak');
        $routes->post('berita-diajukan/hapus', 'BeritaDiajukanAdmin::hapusBanyak');
    }

    // Galeri
    $routes->group('galeri', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('/', 'GaleriAdmin::index');
        $routes->post('unggah', 'GaleriAdmin::unggah');
        $routes->post('simpanMetadata/(:num)', 'GaleriAdmin::simpanMetadata/$1');
        $routes->post('hapus/(:num)', 'GaleriAdmin::hapus/$1');
        $routes->post('hapus-banyak', 'GaleriAdmin::hapusBanyak');
    });

    // Kotak masuk
    $routes->get('kotak-masuk', 'KotakMasukAdmin');
    $routes->get('kotak-masuk/sunting', 'KotakMasukAdmin::sunting');
    $routes->get('kotak-masuk/sunting/(:num)', 'KotakMasukAdmin::sunting/$1');
    $routes->post('kotak-masuk/hapus', 'KotakMasukAdmin::hapusBanyak');
    $routes->post('kotak-masuk/tandai/terbaca', 'KotakMasukAdmin::tandaiTerbacaBanyak');
    $routes->post('kotak-masuk/tandai/belum_terbaca', 'KotakMasukAdmin::tandaiBelumTerbacaBanyak');

    // Manajemen pengguna
    $routes->get('pengguna', 'PenggunaAdmin');
    $routes->post('pengguna/edit/(:num)', 'PenggunaAdmin::edit/$1');
    $routes->post('pengguna/tambah', 'PenggunaAdmin::tambahPengguna');
    $routes->post('pengguna/hapus', 'PenggunaAdmin::hapusBanyak');

    if (env('app.siteType') == 'parent' || env('app.siteType') == 'super') {
        // Manajemen situs
        $routes->get('situs', 'SitusAdmin');
        $routes->get('situs/tambah', 'SitusAdmin::tambah');
        $routes->post('situs/tambah/simpan', 'SitusAdmin::simpan');
        $routes->get('situs/sunting', 'SitusAdmin::sunting');
        $routes->post('situs/sunting/simpan', 'SitusAdmin::simpan');
        $routes->post('situs/sunting/simpan/(:num)', 'SitusAdmin::simpan/$1');
    }
});

$routes->group('admin/komponen', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'KomponenAdmin::index');
    $routes->get('tambah', 'KomponenAdmin::tambah');
    $routes->post('simpan', 'KomponenAdmin::simpan');
    $routes->post('simpan/(:num)', 'KomponenAdmin::simpan/$1');
    // $routes->post('store', 'KomponenAdmin::store');
    // $routes->post('update/(:num)', 'KomponenAdmin::update/$1');
    $routes->get('sunting/(:num)', 'KomponenAdmin::sunting/$1');
    $routes->post('hapus', 'KomponenAdmin::hapusBanyak');
});

// Redirect to dasbor
$routes->addRedirect('dasbor', 'dashboard');
$routes->addRedirect('dashboard', 'dashboard');

// Logout
$routes->get('/keluar', 'UserController::keluar');

// API
$routes->group('api', static function ($routes) {

    // Halaman
    $routes->post('halaman', 'HalamanAdmin::getDT');
    $routes->post('halaman/(:any)', 'HalamanAdmin::getDT/$1');

    // Komponen
    $routes->post('komponen', 'KomponenAdmin::getDT');
    $routes->post('komponen/(:any)', 'KomponenAdmin::getDT/$1');

    // Berita
    // $routes->get('berita', 'BeritaAdmin::get');
    $routes->post('berita', 'BeritaAdmin::fetchData');
    $routes->post('berita/(:any)', 'BeritaAdmin::fetchData/$1');
    $routes->post('berita/(dipublikasikan)', 'BeritaAdmin::fetchData/$1');
    $routes->post('berita/draf', 'BeritaAdmin::fetchData/$1');

    $routes->post('agenda', 'AgendaAdmin::fetchData');
    $routes->post('agenda/(:any)', 'AgendaAdmin::fetchData/$1');
    // $routes->post('agenda/draf', 'AgendaAdmin::fetchData/$1');

    $routes->post('pengumuman', 'PengumumanAdmin::fetchData');
    $routes->post('pengumuman/(:any)', 'PengumumanAdmin::fetchData/$1');
    // $routes->get('pengumuman/draf', 'PengumumanAdmin::getDraf');

    // Berita pengajuan (web utama)
    if (env('app.siteType') == 'parent' || env('app.siteType') == 'super') {
        $routes->post('berita-diajukan', 'BeritaDiajukanAdmin::fetchData');
        $routes->post('berita-diajukan/terima-berita', 'BeritaDiajukanAdmin::terimaBeritaBanyak');
        $routes->post('berita-diajukan/(:any)', 'BeritaDiajukanAdmin::fetchData/$1');
    }

    // Galeri
    $routes->get('galeri', 'GaleriAdmin::get');

    // Kotak masuk
    $routes->get('kotak-masuk', 'KotakMasukAdmin::getKotakMasuk');
    $routes->get('kotak-masuk/kritik-dan-saran', 'KotakMasukAdmin::getKotakMasukKritikDanSaran');
    $routes->get('kotak-masuk/pelaporan', 'KotakMasukAdmin::getKotakMasukPelaporan');

    // Pengguna
    $routes->get('pengguna', 'PenggunaAdmin::get');

    // Situs
    $routes->get('situs', 'SitusAdmin::get');
    $routes->get('situs/aktif', 'SitusAdmin::getAktif');
    $routes->get('situs/tidak-aktif', 'SitusAdmin::getTIdakAktif');

    // Shutdown dan restore sistem
    $routes->post('shutdown', 'Shutdown::shutdown');
    $routes->post('restore', 'Shutdown::restore');
});

$routes->group('fakultas', static function ($routes) {
    $routes->get('/', 'BerandaFakultas', ['as' => 'beranda_fakultas']);
    $routes->get('profil', 'BerandaFakultas', ['as' => 'profil_fakultas']);
});

$routes->group('prodi', static function ($routes) {
    $routes->get('/', 'BerandaProdi', ['as' => 'beranda_prodi']);
    $routes->get('profil', 'BerandaProdi', ['as' => 'profil_prodi']);
});

service('auth')->routes($routes);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
