<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'users';

// AUTHENTICATIONS
$route['login'] = 'users/login';
$route['login/login_process'] = 'users/login_process';
$route['logout'] = 'users/logout';

$route['registration'] = 'users/register';
$route['registration/registration_process'] = 'users/registration_process';

// ADMIN
$route['dashboard'] = 'users/dashboard';
$route['get_order_html'] = 'orders/get_order_html/$1';
$route['get_filtered_orders/(:any)'] = 'orders/get_filtered_orders/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
