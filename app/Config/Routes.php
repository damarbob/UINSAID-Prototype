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

// Maintenance
$routes->get('maintenance', function () {
    return view('maintenance');
});

// Admin
$routes->group('admin', ['filter' => 'group:admin,superadmin'], function ($routes) {

    // Dasbor
    $routes->get('dasbor', 'DasborAdmin', ['as' => 'dashboard']);
    $routes->addRedirect('/', 'dashboard');

    // Berita
    $routes->get('berita', 'BeritaAdmin');
    $routes->get('berita/tambah', 'BeritaAdmin::tambah');
    $routes->post('berita/tambah/simpan', 'BeritaAdmin::simpan');
    $routes->get('berita/sunting', 'BeritaAdmin::sunting');
    $routes->get('berita/sunting/(:num)', 'BeritaAdmin::sunting/$1');
    $routes->post('berita/sunting/simpan/(:num)', 'BeritaAdmin::simpan/$1');
    $routes->post('berita/hapus', 'BeritaAdmin::hapusBanyak');

    // Berita (selain web utama)
    $routes->post('berita/ajukan', 'BeritaAdmin::ajukanBanyak');
    $routes->post('berita/batal-ajukan', 'BeritaAdmin::batalAjukanBanyak');

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
    $routes->get('berita-diajukan', 'BeritaDiajukanAdmin');
    $routes->post('berita-diajukan/publikasi', 'BeritaDiajukanAdmin::publikasiBanyak');
    $routes->post('berita-diajukan/hapus', 'BeritaDiajukanAdmin::hapusBanyak');

    // Galeri
    $routes->group('galeri', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('/', 'GaleriAdmin::index');
        $routes->post('upload', 'GaleriAdmin::upload');
        $routes->post('updateMetadata/(:num)', 'GaleriAdmin::updateMetadata/$1');
        $routes->post('delete/(:num)', 'GaleriAdmin::delete/$1');
        $routes->post('delete-multiple', 'GaleriAdmin::deleteMultiple');
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

    // Manajemen situs
    $routes->get('situs', 'SitusAdmin');
    $routes->get('situs/tambah', 'SitusAdmin::tambah');
    $routes->post('situs/tambah/simpan', 'SitusAdmin::simpan');
    $routes->get('situs/sunting', 'SitusAdmin::sunting');
    $routes->post('situs/sunting/simpan', 'SitusAdmin::simpan');
    $routes->post('situs/sunting/simpan/(:num)', 'SitusAdmin::simpan/$1');
});

// Redirect to dasbor
$routes->addRedirect('dasbor', 'dashboard');
$routes->addRedirect('dashboard', 'dashboard');

// Logout
$routes->get('/keluar', 'UserController::keluar');

// API
$routes->group('api', static function ($routes) {

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
    $routes->post('berita-diajukan/terima-berita', 'BeritaDiajukanAdmin::terimaBeritaBanyak');
    $routes->post('berita-diajukan/(:any)', 'BeritaDiajukanAdmin::fetchData/$1');

    // Berita diajukan (selain web utama)
    $routes->post('berita-diajukan', 'BeritaDiajukanAdmin::fetchData');

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
