<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index',['filter' => 'authenticated']);
$routes->get('/register', 'Auth::register',['filter' => 'authenticated']);
$routes->get('/Auth', 'Auth::index',['filter' => 'authenticated']);
$routes->get('/update_user', 'Auth::update_user',['filter' => 'authenticate']);
$routes->match(['post'], '/update_user', 'Auth::update_user',['filter' => 'authenticate']);
$routes->get('/Auth/(:segment)', 'Auth::$1',['filter' => 'authenticated']);
$routes->match(['post'], '/register', 'Auth::register',['filter' => 'authenticated']);
$routes->match(['post'], '/login', 'Auth::index',['filter' => 'authenticated']);
$routes->get('/logout', 'Auth::logout');

$routes->group('Main', ['filter'=>'authenticate'], static function($routes){
    $routes->get('', 'Main::index');
    $routes->get('(:segment)', 'Main::$1');
    $routes->get('(:segment)/(:any)', 'Main::$1/$2');
    $routes->match(['post'], 'user_add', 'Main::user_add');
    $routes->match(['post'], 'user_edit/(:num)', 'Main::user_edit/$1');
    $routes->match(['post'], 'department_edit/(:num)', 'Main::department_edit/$1');
    $routes->match(['post'], 'department_add', 'Main::department_add/$1');
    $routes->match(['post'], 'designation_edit/(:num)', 'Main::designation_edit/$1');
    $routes->match(['post'], 'designation_add', 'Main::designation_add/$1');
    $routes->match(['post'], 'employee_edit/(:num)', 'Main::employee_edit/$1');
    $routes->match(['post'], 'employee_add', 'Main::employee_add/$1');
    $routes->match(['post'], 'payroll_edit/(:num)', 'Main::payroll_edit/$1');
    $routes->match(['post'], 'payroll_add', 'Main::payroll_add/$1');
    $routes->match(['post'], 'payslip_edit/(:num)', 'Main::payslip_edit/$1');
    $routes->match(['post'], 'payslip_add', 'Main::payslip_add/$1');
    //$routes->match(['post'], 'country_edit/(:num)', 'Countryctl::country_edit/$1');
    //$routes->match(['post'], 'country_add', 'Countryctl::country_add/$1');
    $routes->match(['post'], 'staff_edit/(:num)', 'Main::staff_edit/$1');
    $routes->match(['post'], 'staff_add', 'Main::staff_add/$1');
    $routes->match(['post'], 'upload', 'Main::upload/$1');
    

});

//rout for country 
$routes->get('Countryctl/countrys', 'Countryctl::countrys');
$routes->get('Countryctl/country_delete/(:num)', 'Countryctl::country_delete/$1');
$routes->get('Countryctl/country_edit/(:num)', 'Countryctl::country_edit/$1');
$routes->post('Countryctl/country_edit/(:num)', 'Countryctl::country_edit/$1');
$routes->get('Countryctl/country_add', 'Countryctl::country_add/$1');
$routes->post('Countryctl/country_add', 'Countryctl::country_add/$1');

//rout for IT_ISSUE
$routes->get('IT_issuectl/it_issuef', 'IT_issuectl::it_issuef');
$routes->get('IT_issuectl/issue_delete/(:num)', 'IT_issuectl::issue_delete/$1');
$routes->get('IT_issuectl/issue_edit/(:num)', 'IT_issuectl::issue_edit/$1');
$routes->post('IT_issuectl/issue_edit/(:num)', 'IT_issuectl::issue_edit/$1');
$routes->get('IT_issuectl/issue_add', 'IT_issuectl::issue_add/$1');
$routes->post('IT_issuectl/issue_add', 'IT_issuectl::issue_add/$1');


//rout for IT_ISSUEDetail
$routes->get('IT_issuedetailctl/it_issuedf', 'IT_issuedetailctl::it_issuedf');
$routes->get('IT_issuedetailctl/issued_delete/(:num)', 'IT_issuedetailctl::issued_delete/$1');
$routes->get('IT_issuedetailctl/issued_edit/(:num)', 'IT_issuedetailctl::issued_edit/$1');
$routes->post('IT_issuedetailctl/issued_edit/(:num)', 'IT_issuedetailctl::issued_edit/$1');
$routes->get('IT_issuedetailctl/issued_add', 'IT_issuedetailctl::issued_add/$1');
$routes->post('IT_issuedetailctl/issued_add', 'IT_issuedetailctl::issued_add/$1');

//rout for IT_PC
$routes->get('IT_pcctl/it_pcf', 'IT_pcctl::it_pcf');
$routes->get('IT_pcctl/pc_delete/(:num)', 'IT_pcctl::pc_delete/$1');
$routes->get('IT_pcctl/pc_edit/(:num)', 'IT_pcctl::pc_edit/$1');
$routes->post('IT_pcctl/pc_edit/(:num)', 'IT_pcctl::pc_edit/$1');
$routes->get('IT_pcctl/pc_add', 'IT_pcctl::pc_add/$1');
$routes->post('IT_pcctl/pc_add', 'IT_pcctl::pc_add/$1');

//rout for IT_BUY
$routes->get('IT_buyctl/it_buyf', 'IT_buyctl::it_buyf');
$routes->get('IT_buyctl/buy_delete/(:num)', 'IT_buyctl::buy_delete/$1');
$routes->get('IT_buyctl/buy_edit/(:num)', 'IT_buyctl::buy_edit/$1');
$routes->post('IT_buyctl/buy_edit/(:num)', 'IT_buyctl::buy_edit/$1');
$routes->get('IT_buyctl/buy_add', 'IT_buyctl::buy_add/$1');
$routes->post('IT_buyctl/buy_add', 'IT_buyctl::buy_add/$1');

//rout for ICODE
$routes->get('I_codectl/i_codef', 'I_codectl::i_codef');
$routes->get('I_codectl/icode_delete/(:num)', 'I_codectl::icode_delete/$1');
$routes->get('I_codectl/icode_edit/(:num)', 'I_codectl::icode_edit/$1');
$routes->post('I_codectl/icode_edit/(:num)', 'I_codectl::icode_edit/$1');
$routes->get('I_codectl/icode_add', 'I_codectl::icode_add/$1');
$routes->post('I_codectl/icode_add', 'I_codectl::icode_add/$1');

//rout for Expanse
$routes->get('I_expansectl/i_expansef', 'I_expansectl::i_expansef');
$routes->get('I_expansectl/expanse_delete/(:num)', 'I_expansectl::expanse_delete/$1');
$routes->get('I_expansectl/expanse_edit/(:num)', 'I_expansectl::expanse_edit/$1');
$routes->post('I_expansectl/expanse_edit/(:num)', 'I_expansectl::expanse_edit/$1');
$routes->get('I_expansectl/expanse_add', 'I_expansectl::expanse_add/$1');
$routes->post('I_expansectl/expanse_add', 'I_expansectl::expanse_add/$1');
$routes->get('I_expansectl/expanse_view', 'I_expansectl::expanse_view/$1');
//report for expanse
$routes->get('I_expansectl/i_expanseR', 'I_expansectl::i_expanseR');
$routes->post('I_expansectl/expansedatereport', 'I_expansectl::expansedatereport');
$routes->get('I_expansectl/expansedatereport', 'I_expansectl::expansedatereport');


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
