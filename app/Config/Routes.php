<?php

namespace Config;

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
$routes->setDefaultController('Front\HomeController');
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
$routes->get('/', 'Front\HomeController::index');
$routes->group('dashboard', function($routes)
{
    $routes->get('/', 'Back\HomeController::index', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
	$routes->group('categories', function($routes)
	{
		$routes->get('/', 'Back\CategoriesController::index', ['filter' => 'role:admin']);
		$routes->get('create', 'Back\CategoriesController::create', ['filter' => 'role:admin']);
		$routes->get('(:alpha)/create', 'Back\CategoriesController::create/$1', ['filter' => 'role:admin']);
		$routes->post('store', 'Back\CategoriesController::store', ['filter' => 'role:admin']);
		$routes->post('(:alpha)/store', 'Back\CategoriesController::store/$1', ['filter' => 'role:admin']);
		$routes->get('(:num)/show', 'Back\CategoriesController::show/$1', ['filter' => 'role:admin']);
		$routes->get('(:num)/show/(:alpha)', 'Back\CategoriesController::show/$1/$2', ['filter' => 'role:admin']);
		$routes->get('(:num)/edit', 'Back\CategoriesController::edit/$1', ['filter' => 'role:admin']);
		$routes->get('(:num)/edit/(:alpha)', 'Back\CategoriesController::edit/$1/$2', ['filter' => 'role:admin']);
		$routes->post('(:num)/update', 'Back\CategoriesController::update/$1', ['filter' => 'role:admin']);
		$routes->post('(:num)/update/(:alpha)', 'Back\CategoriesController::update/$1/$2', ['filter' => 'role:admin']);
		$routes->get('(:num)/delete', 'Back\CategoriesController::destroy/$1', ['filter' => 'role:admin']);
		$routes->get('(:num)/delete/(:alpha)', 'Back\CategoriesController::destroy/$1/$2', ['filter' => 'role:admin']);
		$routes->get('(:alpha)', 'Back\CategoriesController::index/$1', ['filter' => 'role:admin']);
	});
	$routes->group('data', function($routes)
	{
		$routes->get('/', 'Back\DataController::index', ['filter' => 'role:admin,seller']);
		$routes->get('create', 'Back\DataController::create', ['filter' => 'role:admin,seller']);
		$routes->get('(:alpha)/create', 'Back\DataController::create/$1', ['filter' => 'role:admin,seller']);
		$routes->post('store', 'Back\DataController::store', ['filter' => 'role:admin,seller']);
		$routes->post('(:alpha)/store', 'Back\DataController::store/$1', ['filter' => 'role:admin,seller']);
		$routes->get('(:num)/show', 'Back\DataController::show/$1', ['filter' => 'role:admin,seller']);
		$routes->get('(:num)/show/(:alpha)', 'Back\DataController::show/$1/$2', ['filter' => 'role:admin,seller']);
		$routes->get('(:num)/edit', 'Back\DataController::edit/$1', ['filter' => 'role:admin,seller']);
		$routes->get('(:num)/edit/(:alpha)', 'Back\DataController::edit/$1/$2', ['filter' => 'role:admin,seller']);
		$routes->post('(:num)/update', 'Back\DataController::update/$1', ['filter' => 'role:admin,seller']);
		$routes->post('(:num)/update/(:alpha)', 'Back\DataController::update/$1/$2', ['filter' => 'role:admin,seller']);
		$routes->get('(:num)/delete', 'Back\DataController::destroy/$1', ['filter' => 'role:admin,seller']);
		$routes->get('(:num)/delete/(:alpha)', 'Back\DataController::destroy/$1/$2', ['filter' => 'role:admin,seller']);
		$routes->get('(:alpha)', 'Back\DataController::index/$1', ['filter' => 'role:admin,seller']);
	});
	$routes->group('users', function($routes)
	{
		$routes->get('/', 'Back\UsersController::index', ['filter' => 'role:admin']);
		$routes->get('create', 'Back\UsersController::create', ['filter' => 'role:admin']);
		$routes->post('store', 'Back\UsersController::store', ['filter' => 'role:admin']);
		$routes->get('(:num)/show', 'Back\UsersController::show/$1', ['filter' => 'role:admin']);
		$routes->get('(:num)/edit', 'Back\UsersController::edit/$1', ['filter' => 'role:admin']);
		$routes->post('(:num)/update', 'Back\UsersController::update/$1', ['filter' => 'role:admin']);
		$routes->get('(:num)/delete', 'Back\UsersController::destroy/$1', ['filter' => 'role:admin']);
	});
	$routes->group('profile', function($routes)
	{
		$routes->get('/', 'Back\UsersController::profile', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
		$routes->get('edit', 'Back\UsersController::profileedit', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
		$routes->post('update', 'Back\UsersController::profileupdate', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
	});
	$routes->group('order', function($routes)
	{
		$routes->get('/', 'Back\OrderController::index', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
		$routes->get('(:num)/show', 'Back\OrderController::show/$1', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
		$routes->get('(:num)/show/(:alpha)', 'Back\OrderController::show/$1/$2', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
		$routes->get('(:num)/edit', 'Back\OrderController::edit/$1', ['filter' => 'role:seller,user,kurir,teknisi']);
		$routes->get('(:num)/edit/(:alpha)', 'Back\OrderController::edit/$1/$2', ['filter' => 'role:seller,user,kurir,teknisi']);
		$routes->post('(:num)/update', 'Back\OrderController::update/$1', ['filter' => 'role:seller,user,kurir,teknisi']);
		$routes->post('(:num)/update/(:alpha)', 'Back\OrderController::update/$1/$2', ['filter' => 'role:seller,user,kurir,teknisi']);
		$routes->get('(:alpha)', 'Back\OrderController::index/$1', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
	});
	$routes->get('orders', 'Back\OrderController::index', ['filter' => 'role:admin,seller,user,kurir,teknisi']);
	$routes->group('reports', function($routes)
	{
		$routes->get('/', 'Back\ReportsController::index', ['filter' => 'role:admin']);
		$routes->get('export', 'Back\ReportsController::export', ['filter' => 'role:admin']);
	});
});

$routes->get('about', 'Front\HomeController::about');
$routes->get('contact', 'Front\HomeController::contact');
$routes->post('checkout', 'Front\HomeController::checkout');

$routes->group('data', function($routes)
{	
	$routes->get('(:alpha)/(:any)/(:any)', 'Front\HomeController::details/$1/$2/$3');
	$routes->get('(:alpha)/(:any)', 'Front\HomeController::data/$1/$2');
	$routes->get('(:alpha)', 'Front\HomeController::data/$1');
	$routes->get('/', 'Front\HomeController::data');
});

$routes->group('cart', function($routes)
{
	$routes->get('/', 'Front\HomeController::cart', ['filter' => 'role:user']);
	$routes->post('store', 'Front\HomeController::addtocart', ['filter' => 'role:user']);
	$routes->get('clear', 'Front\HomeController::cartclear', ['filter' => 'role:user']);
	$routes->post('update', 'Front\HomeController::cartupdate', ['filter' => 'role:user']);
	$routes->get('(:any)/delete', 'Front\HomeController::cartdestroy/$1', ['filter' => 'role:user']);
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
