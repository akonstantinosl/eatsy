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

// Customers management
$routes->group('customers', function($routes) {
    $routes->get('', 'CustomerController::index');
    $routes->get('create', 'CustomerController::create');
    $routes->post('store', 'CustomerController::store');
    $routes->get('edit/(:segment)', 'CustomerController::edit/$1');
    $routes->post('update/(:segment)', 'CustomerController::update/$1');
    $routes->get('delete/(:segment)', 'CustomerController::delete/$1');
});

// Sales management
$routes->group('sales', function($routes) {
    $routes->get('', 'SaleController::index');
    $routes->get('details/(:segment)', 'SaleController::details/$1');
    $routes->get('customer', 'SaleController::selectCustomer');
    $routes->post('customer', 'SaleController::storeCustomer');
    $routes->get('products/(:segment)', 'SaleController::selectProducts/$1');
    $routes->post('', 'SaleController::store');
    $routes->get('update-status/(:segment)/(:segment)', 'SaleController::updateStatus/$1/$2');
});

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
    // $routes->get('products/categories', 'CategoryController::index');
    // $routes->get('products/categories/create', 'CategoryController::create');
    // $routes->post('products/categories/store', 'CategoryController::store');
    // $routes->get('products/categories/edit/(:segment)', 'CategoryController::edit/$1');
    // $routes->post('products/categories/update/(:segment)', 'CategoryController::update/$1');
    // $routes->get('products/categories/delete/(:segment)', 'CategoryController::delete/$1');

    // Suppliers management routes
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

    // Purchases Report
    $routes->group('reports', ['filter' => 'admin'], function($routes) {
        $routes->get('purchases', 'PurchaseReportController::index');
        $routes->post('purchases/generate', 'PurchaseReportController::generateReport');
        $routes->get('purchases/export-pdf', 'PurchaseReportController::exportPdf');
    });

    // Sales Report
    $routes->group('reports', ['filter' => 'admin'], function($routes) {
        $routes->get('sales', 'SalesReportController::index');
        $routes->post('sales/generate', 'SalesReportController::generateReport');
        $routes->get('sales/export-pdf', 'SalesReportController::exportPdf');
    });

    // Ajax Routes
    $routes->group('ajax', ['filter' => 'admin'], function($routes) {
        $routes->get('purchase-transactions', 'AjaxController::getPurchaseTransactions');
    });
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
