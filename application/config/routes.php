<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'public/welcome/index';
$route['404_override'] = 'public/errors/_404';
$route['translate_uri_dashes'] = FALSE;

$route['migrate'] = 'migrate/index';
$route['hospitals/migrate'] = 'hospitals/migrate/index';

// Urls that point to admin settings route to the admin/settings controller.
$route['admin/login'] = 'admin/login';
$route['admin/logout'] = 'admin/logout';
$route['admin/settings'] = 'admin/settings';
$route['admin/profile'] = 'admin/profile';
$route['admin/settings/(.*)'] = 'admin/settings/$1';

$route['admin/(:any)/test'] = '$1/test/index';
$route['admin/(:any)/test/(:any)'] = '$1/test/index/$2';

for ($i=1; $i < 5; $i++) {
    // All other admin urls route to the corresponding module/admin controllers.
    // The number $i is maximum number of uri segments to route.
    $route['admin'.str_repeat('/(:any)', $i)] = '$1/admin/$'.(($i == 1) ? $i : implode(range(2, $i), '/$'));
}

for ($i=0; $i < 5; $i++) {
    // Route api calls to the corresponding module/api controllers.
    $route['(:any)/api'.str_repeat('/(:any)', $i)] = '$1/api'.(($i == 0) ? '' : '/$'.implode(range(2, $i+1), '/$'));
}


// Route everything else to public module
$route['login'] = 'public/account/login';
$route['logout'] = 'public/account/logout';
$route['register'] = 'public/account/register';
$route['activate/(:any)/(:any)'] = 'public/account/activate/$1/$2';
$route['register_org'] = 'public/account/register_company';
$route['change_password'] = 'public/account/change_password';
$route['reset-password/(:any)'] = 'public/account/reset_password/$1';
$route['forgot-password'] = 'public/account/forgot_password';
$route['profile'] = 'public/profile/index';
$route['profile/(:any)'] = 'public/profile/$1';

$route['legal'] = 'public/legal/index';
$route['legal/terms-of-service'] = 'public/legal/terms_of_service';
$route['legal/privacy-policy'] = 'public/legal/privacy_policy';

$doc_similar_routes = ['doctors', 'physicians'];
foreach ($doc_similar_routes as $value) {
    $route["$value"] = "public/physicians/index";
    $route["$value/(:any)"] = "public/physicians/details/$1";
    $route["$value/(:any)/(:any)"] = "public/physicians/details/$1";
}

$route['hospitals'] = 'public/hospitals/index';
$route['hospitals/(:any)'] = 'public/hospitals/details/$1';

$route['appointments'] = 'public/appointments/index';
$route['appointments/view'] = 'public/appointments/view';
$route['appointments/calendar'] = 'public/appointments/calendar';
$route['appointments/calendar/(:any)/(:any)'] = 'public/appointments/calendar/$1/$2';

$route['questions'] = 'public/questions/index';
$route['questions/ask'] = 'public/questions/ask';
$route['questions/(:any)'] = 'public/questions/details/$1';

$route['search'] = 'public/search/index';

$route['dashboard'] = 'public/dashboard/index';
$route['dashboard/(:any)'] = 'public/dashboard/$1';