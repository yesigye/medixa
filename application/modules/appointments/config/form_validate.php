<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Signup Validation Rules
|--------------------------------------------------------------------------
|
| Set Rules that a registration form that a new appointment must pass.
|
*/
$config['appointment_submit'] = array(
	array(
		'field' => 'name',
		'label' => 'Name',
		'rules' => 'required|is_unique[companies.name]'
	),
	array(
		'field' => 'email',
		'label' => 'Email Address',
		'rules' => 'required|valid_email'
	),
	array(
		'field' => 'types[]',
		'label' => 'Hospital Type',
		'rules' => 'required'
	),
);

/*
|--------------------------------------------------------------------------
| Doctor Profile Rules
|--------------------------------------------------------------------------
|
| Set Rules that an appointment update form must pass.
|
*/
$config['appointment_update'] = array(
	array(
		'field' => 'name',
		'label' => 'Name',
		'rules' => 'required'
	),
	array(
		'field' => 'email',
		'label' => 'Email Address',
		'rules' => 'required|valid_email'
	),
	array(
		'field' => 'types[]',
		'label' => 'Hospital Type',
		'rules' => 'required'
	),
);

/* End of file Form_validation.php */
/* Location: ./application/modules/hospitals/config/Form_validation.php */