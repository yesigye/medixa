<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| ADMIN ROUTING
| -------------------------------------------------------------------------
*/
$route['admin/login'] = 'login';
$route['admin/logout'] = 'logout';
$route['admin/settings'] = 'settings/index';
$route['admin/settings/languages'] = 'settings/languages';
$route['admin/settings/languages/(:any)'] = 'settings/languages/$1';
$route['admin/settings/languages/(:any)/(:any)'] = 'settings/languages/$1/$2';