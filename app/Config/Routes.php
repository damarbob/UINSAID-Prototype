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
$routes->get('/', 'Home::index');

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

    // Unggah dan hapus gambar berita
    $routes->post('berita/unggah-gambar', 'BeritaAdmin::unggahGambar');
    $routes->post('berita/hapus-gambar', 'BeritaAdmin::hapusGambar');

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
    $routes->get('pengguna', 'PenggunaAdmin::index');
    $routes->post('pengguna/edit/(:num)', 'PenggunaAdmin::edit/$1');
    $routes->post('pengguna/tambah', 'PenggunaAdmin::tambahPengguna');
    $routes->post('pengguna/hapus', 'PenggunaAdmin::hapusBanyak');
});

// Redirect to dasbor
$routes->addRedirect('dasbor', 'dashboard');
$routes->addRedirect('dashboard', 'dashboard');

// Logout
$routes->get('/keluar', 'UserController::keluar');

// API
$routes->group('api', static function ($routes) {
    // $routes->get('berita', 'BeritaAdmin::get');
    $routes->post('berita', 'BeritaAdmin::fetchData');
    $routes->get('berita/dipublikasikan', 'BeritaAdmin::getDipublikasikan');
    $routes->get('berita/draf', 'BeritaAdmin::getDraf');

    $routes->get('galeri', 'GaleriAdmin::get');

    $routes->get('kotak-masuk', 'KotakMasukAdmin::getKotakMasuk');
    $routes->get('kotak-masuk/kritik-dan-saran', 'KotakMasukAdmin::getKotakMasukKritikDanSaran');
    $routes->get('kotak-masuk/pelaporan', 'KotakMasukAdmin::getKotakMasukPelaporan');

    $routes->get('pengguna', 'PenggunaAdmin::get');
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
