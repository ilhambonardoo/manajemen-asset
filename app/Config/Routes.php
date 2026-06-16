<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->get('lokasi', 'Api::lokasi');
    $routes->get('generate_kode/(:any)', 'Api::generate_kode/$1');
});

$routes->get('login', 'Auth::index');
$routes->post('login/process', 'Auth::loginProcess');

$routes->get('register', 'Auth::register');
$routes->post('register/process', 'Auth::registerProcess');

$routes->get('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('laporan', 'Laporan::index', ['filter' => 'laporan']);
    $routes->post('laporan/generate', 'Laporan::generate', ['filter' => 'laporan']);
    $routes->post('laporan/preview', 'Laporan::preview', ['filter' => 'laporan']);
    
    // Daftar aset tetap untuk Admin, Supervisor, Staff Finance, dan Staff Accounting
    $routes->group('asset', ['filter' => 'role:Admin,Supervisor,Staff Finance,Staff Accounting,Staff GA'], function ($routes) {
        $routes->get('daftar', 'Assets::index');
    });

    // UPDATE: Menambahkan Staff Accounting untuk aksi kelola penyusutan, pencatatan transaksi dasar tetap di Staff Finance
    $routes->group('asset', ['filter' => 'role:Admin,Staff Finance,Staff Accounting'], function ($routes) {
        $routes->get('create', 'Assets::create');
        $routes->post('store', 'Assets::store');
        $routes->get('edit/(:num)', 'Assets::edit/$1');
        $routes->post('update/(:num)', 'Assets::update/$1');
        $routes->post('simpan-lokasi', 'Assets::simpanLokasi');
        
    });
    $routes->group('asset', ['filter' => 'role:Admin,Staff Accounting'], function ($routes) {
        $routes->post('ajukan', 'Assets::ajukan'); // Untuk pengajuan penjualan/penghentian oleh Accounting
    });

    $routes->group('asset', ['filter' => 'role:Admin,Supervisor, Staff Finance, Staff Accounting, Staff GA'], function($routes){
        $routes->get('detail/(:num)', 'Assets::detail/$1');
    });

    $routes->group('asset', ['filter' => 'role:Admin,Supervisor, Staff Finance, Staff Accounting'], function($routes){
        $routes->get('penyusutan', 'Penyusutan::index');
        $routes->get('penyusutan/pdf', 'Penyusutan::exportPdf');
    });

    $routes->group('asset', ['filter' => 'role:Admin, Staff Finance'], function ($routes) {
        $routes->get('delete/(:num)', 'Assets::delete/$1');
        $routes->post('delete-batch', 'Assets::deleteBatch');
    });

    $routes->group('admin', ['filter' => 'role:Admin'], function ($routes) {
        $routes->get('users', 'Users::index');
        $routes->get('users/create', 'Users::create');
        $routes->post('users/store', 'Users::store');
        $routes->get('users/edit/(:num)', 'Users::edit/$1');
        $routes->post('users/update/(:num)', 'Users::update/$1');
        $routes->get('users/delete/(:num)', 'Users::delete/$1');
    });

    $routes->group(
        'approval',
        [
            'filter' => 'role:Admin,Manager',
        ],
        function ($routes) {
            $routes->get('', 'Approval::index');
            $routes->post('approve/(:num)', 'Approval::approve/$1');
            $routes->post('reject/(:num)', 'Approval::reject/$1');
        }
    );

    // Staff GA dapat melihat dan mengelola modul lokasi aset sesuai kebutuhan operasional
    $routes->group('lokasi', ['filter' => 'role:Admin'], function ($routes) {
        $routes->get('', 'LokasiAsset::index');
        $routes->post('tambah', 'LokasiAsset::tambahLokasi');
        $routes->get('penempatan/(:any)/(:any)', 'LokasiAsset::penempatan/$1/$2');
        $routes->post('simpan_penempatan', 'LokasiAsset::simpan_penempatan');
        $routes->get('detail/(:any)', 'LokasiAsset::detail/$1');
        $routes->post('delete/(:num)', 'LokasiAsset::delete/$1');
    });
});