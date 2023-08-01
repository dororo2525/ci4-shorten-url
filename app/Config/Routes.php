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
$routes->setDefaultController('HomeController');
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
$routes->get('/short/(:segment)', 'HomeController::index');
$routes->get('/', 'Frontend\AuthController::login', ['filter' => 'is_login']);
$routes->post('/login', 'Frontend\AuthController::postLogin');
$routes->get('/logout', 'Frontend\AuthController::logout');
$routes->get('/register', 'Frontend\AuthController::register');
$routes->post('/register', 'Frontend\AuthController::postRegister');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->resource('manage-url' , ['controller' => 'Backend\ManageUrlController']);
    $routes->get('report/(:segment)', 'Backend\ManageUrlController::report');
    $routes->post('report/chart/get-report-by-current-year', 'Backend\ManageUrlController::getReportByCurrentYear');
    $routes->post('report/chart/get-report-by-date-range', 'Backend\ManageUrlController::getReportByDateRange');
    $routes->get('qrcode/(:segment)', 'Backend\ManageUrlController::generateQrCode');
    $routes->post('manage-url/switch-status' , 'Backend\ManageUrlController::switchStatus');
}); 

$routes->get('/(:any)', 'HomeController::index');
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
