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
$routes->get('/ppid', 'PPID');
$routes->get('/ppid/(:segment)', 'PPID::getByKategori/$1');
$routes->get('/ppid/detail/(:any)', 'PPID::get/$1');
$routes->get('test', 'BeritaAdmin::test');
$routes->get('xml-migration', 'XmlMigrationController::migrate');
$routes->get('xml-migration-lampiran', 'XmlMigrationLampiranController::migrate');
$routes->get('entitas', 'Entitas');
$routes->get('agenda', 'Agenda');
$routes->get('agenda/(:num)', 'Agenda::get/$1');
$routes->get('pengumuman', 'Pengumuman');
$routes->get('pengumuman/(:num)', 'Pengumuman::get/$1');

// TESTING ROUTES
// $routes->get('/entitas', 'Entitas');
$routes->options('api/(:any)', 'ApiController::handleOptions');

// Route dinamis untuk halaman yang dibuat
$routes->group('halaman', function ($routes) {
    $halamanModel = new \App\Models\HalamanModel();
    $pages = $halamanModel->findAll();

    foreach ($pages as $page) {
        $status = $page['status'];
        $slug = $page['slug'];

        if ($status == 'draf') {
            // Restrict access to "admin" and "superadmin" groups
            $routes->get($slug, 'Home::view/' . $slug, ['filter' => 'group:admin,superadmin']);
        } else {
            // Public access for other pages
            $routes->get($slug, 'Home::view/' . $slug);
        }
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

    // Komponen
    $routes->get('komponen/', 'KomponenAdmin::index');
    $routes->get('komponen/tambah', 'KomponenAdmin::tambah');
    $routes->post('komponen/simpan', 'KomponenAdmin::simpan');
    $routes->post('komponen/simpan/(:num)', 'KomponenAdmin::simpan/$1');
    $routes->get('komponen/sunting/(:num)', 'KomponenAdmin::sunting/$1');
    $routes->post('komponen/hapus', 'KomponenAdmin::hapusBanyak');

    // Komponen meta
    $routes->post('komponen/simpan/meta', 'KomponenAdmin::simpanMeta');

    if (ENVIRONMENT == 'development') {

        // Posting
        $routes->get('posting', 'PostingAdmin');
        $routes->get('posting/tambah', 'PostingAdmin::tambah');
        $routes->post('posting/tambah/simpan', 'PostingAdmin::simpan');
        $routes->get('posting/sunting', 'PostingAdmin::sunting');
        $routes->get('posting/sunting/(:num)', 'PostingAdmin::sunting/$1');
        $routes->post('posting/sunting/simpan/(:num)', 'PostingAdmin::simpan/$1');
        $routes->post('posting/hapus', 'PostingAdmin::hapusBanyak');
    }

    // Pengaturan
    $routes->get('pengaturan', 'PengaturanAdmin');
    $routes->post('pengaturan', 'PengaturanAdmin');

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
        // TODO: Remove due to failed concept, instead, use parent's berita-diajukan/terima-berita
        // $routes->post('berita/ajukan', 'BeritaAdmin::ajukanBanyak');
        // $routes->post('berita/batal-ajukan', 'BeritaAdmin::batalAjukanBanyak');
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

    // File
    $routes->group('file', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('/', 'FileAdmin::index');
        $routes->post('unggah', 'FileAdmin::unggah');
        $routes->post('simpanMetadata/(:num)', 'FileAdmin::simpanMetadata/$1');
        $routes->post('hapus', 'FileAdmin::hapusBanyak');
        // $routes->post('hapus-banyak', 'FileAdmin::hapusBanyak');
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
        $routes->post('situs/hapus', 'SitusAdmin::hapusBanyak');
    }

    // Manajemen menu
    $routes->get('menu', 'MenuAdmin::index');
    $routes->get('menu/tambah', 'MenuAdmin::tambah');
    $routes->get('menu/sunting/(:num)', 'MenuAdmin::sunting/$1');
    $routes->get('menu/sunting', 'MenuAdmin::sunting');
    $routes->post('menu/simpan', 'MenuAdmin::simpan');
    $routes->post('menu/simpan/(:num)', 'MenuAdmin::simpan/$1');
    $routes->post('menu/hapus', 'MenuAdmin::hapusBanyak');
});

// Redirect to dasbor
$routes->addRedirect('dasbor', 'dashboard');
$routes->addRedirect('dashboard', 'dashboard');

// Logout
$routes->get('/keluar', 'UserController::keluar');

// API
$routes->group('api', static function ($routes) {

    if (ENVIRONMENT == 'development') {

        // Halaman
        $routes->post('halaman', 'HalamanAdmin::getDT');
        $routes->post('halaman/(:any)', 'HalamanAdmin::getDT/$1');

        // Komponen
        $routes->post('komponen', 'KomponenAdmin::getDT');

        // Komponen Meta
        $routes->post('komponen/meta', 'KomponenAdmin::getMetaById');

        // Posting
        $routes->post('posting', 'PostingAdmin::fetchData');
        $routes->post('posting/(:any)', 'PostingAdmin::fetchData/$1');
    }

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

    // File
    $routes->get('file', 'FileAdmin::get'); // For file plugin
    $routes->post('file', 'FileAdmin::fetchData');
    // $routes->post('file', 'FileAdmin::fetchData');
    $routes->post('file', 'FileAdmin::getFiles');

    // Kotak masuk
    $routes->get('kotak-masuk', 'KotakMasukAdmin::getKotakMasuk');
    $routes->get('kotak-masuk/kritik-dan-saran', 'KotakMasukAdmin::getKotakMasukKritikDanSaran');
    $routes->get('kotak-masuk/pelaporan', 'KotakMasukAdmin::getKotakMasukPelaporan');

    // Pengguna
    $routes->get('pengguna', 'PenggunaAdmin::get');
    $routes->post('pengguna-ajax/edit', 'PenggunaAdmin::editAjax/$1');
    $routes->post('pengguna-ajax/tambah', 'PenggunaAdmin::tambahPenggunaAjax');
    $routes->get('pengguna/(:any)', 'PenggunaAdmin::get/$1');

    // Situs
    $routes->get('situs', 'SitusAdmin::get');
    $routes->post('situs/perbarui-status', 'SitusAdmin::perbaruiStatusSitus');
    $routes->get('situs/aktif', 'SitusAdmin::getAktif');
    $routes->get('situs/tidak-aktif', 'SitusAdmin::getTIdakAktif');

    // Shutdown dan restore sistem
    $routes->post('site-status', 'WebService::siteStatusCheck');
    $routes->post('compatibility-check', 'WebService::compatibilityCheck');
    $routes->post('shutdown', 'WebService::shutdown');
    $routes->post('restore', 'WebService::restore');

    // Menu
    $routes->post('menu', 'MenuAdmin::getDT');
    $routes->post('menu/getUrutanOptions', 'MenuAdmin::getUrutanOptions');
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


/* REFACTORING */
if (ENVIRONMENT == 'development') {
    $routes->group('refactor', static function ($routes) {
        $routes->get('berita/featured-image',  'BeritaAdmin::refactorFeaturedImages');
    });
}

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
