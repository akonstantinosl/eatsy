<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
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
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->get('login', 'AuthController::loginPage');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Admin routes group
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'HomeController::adminDashboard');
    
    // Users management
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:segment)', 'UserController::edit/$1'); 
    $routes->post('users/update/(:segment)', 'UserController::update/$1'); 
    $routes->get('users/delete/(:segment)', 'UserController::delete/$1'); 

    // Products management
    $routes->get('products', 'ProductController::index');
    $routes->get('products/create', 'ProductController::create');
    $routes->post('products/store', 'ProductController::store');
    $routes->get('products/edit/(:segment)', 'ProductController::edit/$1'); 
    $routes->post('products/update/(:segment)', 'ProductController::update/$1'); 
    $routes->get('products/delete/(:segment)', 'ProductController::delete/$1');
    
    // Product Categories management
    $routes->get('products/categories', 'CategoryController::index');
    $routes->get('products/categories/create', 'CategoryController::create');
    $routes->post('products/categories/store', 'CategoryController::store');
    $routes->get('products/categories/edit/(:segment)', 'CategoryController::edit/$1');
    $routes->post('products/categories/update/(:segment)', 'CategoryController::update/$1');
    $routes->get('products/categories/delete/(:segment)', 'CategoryController::delete/$1');

    // Supplier management routes
    $routes->get('suppliers', 'SupplierController::index');
    $routes->get('suppliers/create', 'SupplierController::create');
    $routes->post('suppliers/store', 'SupplierController::store');
    $routes->get('suppliers/edit/(:segment)', 'SupplierController::edit/$1');
    $routes->post('suppliers/update/(:segment)', 'SupplierController::update/$1');
    $routes->get('suppliers/delete/(:segment)', 'SupplierController::delete/$1');
        
    // Purchases Management
    $routes->get('purchases', 'PurchaseController::index');
    $routes->get('purchases/details/(:segment)', 'PurchaseController::details/$1');
    $routes->get('purchases/supplier', 'PurchaseController::selectSupplier');
    $routes->post('purchases/supplier', 'PurchaseController::storeSupplier');
    $routes->get('purchases/products/(:segment)', 'PurchaseController::selectProducts/$1');
    $routes->post('purchases', 'PurchaseController::store');
    $routes->get('purchases/update-status/(:segment)/(:segment)', 'PurchaseController::updateStatus/$1/$2');
    
    // Customers management
    $routes->get('customers', 'CustomerController::index');
    $routes->get('customers/create', 'CustomerController::create');
    $routes->post('customers/store', 'CustomerController::store');
    $routes->get('customers/edit/(:segment)', 'CustomerController::edit/$1');
    $routes->post('customers/update/(:segment)', 'CustomerController::update/$1');
    $routes->get('customers/delete/(:segment)', 'CustomerController::delete/$1');
});

// Staff routes group
$routes->group('staff', ['filter' => 'staff'], function($routes) {
    $routes->get('dashboard', 'HomeController::staffDashboard');
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
