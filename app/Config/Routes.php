<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/(:any)','Home::index');

$routes->get('/', 'Home::index');
$routes->get('/state/(:any)', 'Home::index');
$routes->get('/users', 'Dashboard::index');
$routes->get('/users/fetchpostaddata', 'Users::fetchpostaddata');
$routes->get('logout', 'Users::logout');
$routes->match(['get','post'],'login', 'Users::login');
$routes->match(['get','post'],'contact-us', 'Users::contactus');
$routes->match(['get','post'],'register', 'Users::register');
$routes->match(['get','post'],'profile', 'Users::profile');
$routes->get('/searchinvoices', 'Admin::searchinvoices');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('admin', 'Admin::index');
$routes->get('postad', 'Users::postad');
$routes->get('search', 'Subcategory::search');

$routes->get('disclaimer', 'Users::disclaimer');
$routes->get('privacy-policy', 'Users::privacypolicy');
$routes->get('contact-us', 'Users::contact');
$routes->get('pricing', 'Users::pricing');
$routes->get('refund-cancellation', 'Users::refundcancellation');
$routes->get('terms-condition', 'Users::termscondition');
$routes->get('about-us', 'Users::aboutus');
$routes->get('/download', 'PdfController::index');
$routes->match(['get','post'],'search', 'Home::search');

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
