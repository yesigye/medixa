<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Signup Validation Rules
|--------------------------------------------------------------------------
|
| Set Rules that a registration form that a new hospital must pass.
|
*/
$config['hospital_submit'] = array(
	array(
		'field' => 'name',
		'label' => lang('form_hospital_name'),
		'rules' => 'required|is_unique[companies.name]'
	),
	array(
		'field' => 'email',
		'label' => lang('form_email'),
		'rules' => 'required|valid_email'
	),
	array(
		'field' => 'types[]',
		'label' => lang('form_hospital_type'),
		'rules' => 'required'
	),
);
$config['hospital_update'] = array(
	array(
		'field' => 'name',
		'label' => lang('form_hospital_name'),
		'rules' => 'required',
		'rules' => 'required'
	),
	array(
		'field' => 'slug',
		'label' => lang('form_hospital_name'),
		'rules' => 'required',
		'rules' => 'required'
	),
	array(
		'field' => 'email',
		'label' => lang('form_email'),
		'rules' => 'required|valid_email'
	),
	array(
		'field' => 'types[]',
		'label' => lang('form_hospital_type'),
		'rules' => 'required',
		'rules' => 'required'
	),
);

/*
|--------------------------------------------------------------------------
| Doctor Profile Rules
|--------------------------------------------------------------------------
|
| Set Rules that a doctor profile update form must pass.
|
*/
$config['doctor_insert'] = array(
	array(
		'field' => 'reg_no',
		'label' => lang('form_doctor_reg_no'),
		'rules' => 'required|is_unique[doctors_profiles.reg_no]'
	),
	array(
		'field' => 'speciality',
		'label' => lang('form_doctor_speciality'),
		'rules' => 'required'
	),
	array(
		'field' => 'first_qualification',
		'label' => lang('form_doctor_qualification'),
		'rules' => 'required'
	),
);
$config['doctor_update'] = array(
	array(
		'field' => 'reg_no',
		'label' => lang('form_doctor_reg_no'),
		'rules' => 'required'
	),
	array(
		'field' => 'speciality',
		'label' => lang('form_doctor_speciality'),
		'rules' => 'required'
	),
	array(
		'field' => 'first_qualification',
		'label' => lang('form_doctor_qualification'),
		'rules' => 'required'
	),
);

/* End of file Form_validation.php */
/* Location: ./application/modules/hospitals/config/Form_validation.php */