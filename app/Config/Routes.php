<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('\Modules\Login\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('/logout', 'Login::logout');
// $routes->get('lang/{locale}', 'Language::index');
$routes->group('lang', ['namespace' => '\Modules\Language\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('(:any)', 'Language::index/$1');
});


$routes->group('dropzone', ['namespace' => '\Modules\Dropzone\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dropzone::index');
});

$routes->group('main', ['namespace' => '\Modules\Main\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Main::index');
    $routes->get('menu1', 'Main::menu1');
    $routes->get('menu2', 'Main::menu2');
    $routes->get('update_country', 'Main::update_country');
    $routes->get('export_dashboard', 'Main::export_dashboard');
    $routes->post('saveImg2Report', 'Main::saveImg2Report');

    $routes->get('monthly', 'Main::monthly');
    $routes->get('monthly_period', 'Main::monthly_period');
    
});

$routes->group('report', ['namespace' => '\Modules\Report\Controllers'], function ($routes) {
    $routes->get('/', 'Report::index');
    $routes->get('nation', 'Report::nation');
    $routes->get('port', 'Report::port');
    $routes->get('nation_compare', 'Report::nation_compare');
    $routes->get('port_compare', 'Report::port_compare');
    $routes->get('nation_daily', 'Report::nation_daily');
    $routes->get('port_daily', 'Report::port_daily');
    $routes->get('market', 'Report::market');

    $routes->get('export_nation', 'Report::export_nation');
    $routes->get('export_port', 'Report::export_port');

    $routes->get('monthly', 'Report::monthly');
});

$routes->group('import', ['namespace' => '\Modules\Import\Controllers'], function ($routes) {
    $routes->get('/', 'Import::index');
    $routes->post('import_file', 'Import::import_file');

    $routes->get('monthly', 'Import::monthly');
    $routes->post('import_file_monthly', 'Import::import_file_monthly');

    $routes->get('raw_monthly', 'Import::raw_monthly');
    $routes->post('import_file_raw_monthly', 'Import::import_file_raw_monthly');
});

$routes->group('setting', ['namespace' => '\Modules\Setting\Controllers'], function ($routes) {
    $routes->get('/', 'Setting::index');

    $routes->get('country','Setting::country');
    $routes->get('port','Setting::port');
    $routes->get('visa','Setting::visa');

    $routes->post('savePort','Setting::savePort');
    $routes->post('savePortRatio','Setting::savePortRatio');
    $routes->get('getPortRatio/(:num)','Setting::getPortRatio/$1');
    $routes->post('deletePort', 'Setting::deletePort');

    $routes->post('saveVisa', 'Setting::saveVisa');
    $routes->post('saveVisaRatio','Setting::saveVisaRatio');
    $routes->get('getVisaRatio/(:num)','Setting::getVisaRatio/$1');
    $routes->post('deleteVisa', 'Setting::deleteVisa');


});



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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
