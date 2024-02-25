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
$route['profile'] = 'users/profile_layout';
$route['get_profile'] = 'users/get_profile';
$route['get_address'] = 'users/get_address';
$route['add_update_address_process'] = 'users/add_update_address_process';
$route['cart'] = 'carts';
$route['get_cart'] = 'carts/get_cart';
$route['view_product/(:any)'] = 'products/view_product/$1';

// CRUD
$route['add_product'] = 'products/add_product';
$route['update_status'] = 'orders/update_status';
$route['get_product_details/(:any)'] = 'products/get_product_details/$1';
$route['delete_image'] = 'products/delete_image';
$route['update_product'] = 'products/update_product';
$route['add_category'] = 'products/add_category';
$route['add_to_cart'] = 'carts/add_to_cart';
$route['delete_cart_item/(:any)'] = 'carts/delete_cart_item/$1';
$route['receive_item/(:any)'] = 'carts/receive_item/$1';
$route['validate_information'] = 'carts/validate_information';

// STRIPE
$route['handleStripePayment']['post'] = "StripePayments/handlePayment";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
