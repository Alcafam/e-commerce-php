<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'users';

// AUTHENTICATIONS
$route['login'] = 'users/login';
$route['login/login_process'] = 'users/login_process';
$route['logout'] = 'users/logout';

$route['registration'] = 'users/register';
$route['registration/registration_process'] = 'users/registration_process';
$route['dashboard'] = 'users/dashboard';

// ADMIN
$route['orders'] = 'orders';
$route['get_order_html'] = 'orders/get_order_html';
$route['products'] = 'products';
$route['get_product_table'] = 'products/get_product_table';

//USER
$route['catalog'] = 'catalogs';
$route['get_catalog_html'] = 'catalogs/get_catalog_html';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
