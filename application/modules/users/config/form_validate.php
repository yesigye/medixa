<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Signup Validation Rules
|--------------------------------------------------------------------------
|
| Set Rules that a signup form must pass before the user is registered.
|
| The avatar field is commented out because most websites don't
| required users to upload avatars before they can be registered
|
*/
$config['signup'] = array(
	// array(
	// 	'field' => 'avatar',
	// 	'label' => 'Avatar',
	// 	'rules' => 'file_required|file_min_size[10KB]|file_max_size[500KB]|file_allowed_type[jpg,jpeg,png]'
	// ),
	array(
		'field' => 'first_name',
		'label' => 'First Name',
		'rules' => 'required'
	),
	array(
		'field' => 'last_name',
		'label' => 'Last Name',
		'rules' => 'required'
	),
	array(
		'field' => 'password',
		'label' => 'Password',
		'rules' => 'required|min_length[8]|max_length[24]'
	),
	array(
		'field' => 'email',
		'label' => 'Email',
		'rules' => 'required|valid_email'
	)
);

$config['assign'] = array(
	array(
		'field' => 'reg_no',
		'label' => 'Registration Number',
		'rules' => 'required|is_unique[doctors_profiles.reg_no]'
	),
	array(
		'field' => 'speciality',
		'label' => 'Speciality',
		'rules' => 'required'
	),
	array(
		'field' => 'first_name',
		'label' => 'First Name',
		'rules' => 'required'
	),
	array(
		'field' => 'last_name',
		'label' => 'Last Name',
		'rules' => 'required'
	),
	array(
		'field' => 'email',
		'label' => 'Email',
		'rules' => 'required|valid_email'
	)
);

/*
|--------------------------------------------------------------------------
| Profile Updating Validation Rules
|--------------------------------------------------------------------------
|
| Set Rules that a user profile update form must pass before it is updated.
|
*/
$config['profile_update'] = array(
	array(
		'field' => 'first_name',
		'label' => 'First Name',
		'rules' => 'required'
	),
	array(
		'field' => 'last_name',
		'label' => 'Last Name',
		'rules' => 'required'
	),
);

/*
|--------------------------------------------------------------------------
| User Group Validation Rules
|--------------------------------------------------------------------------
|
| Set Rules that a user group insert and update form must pass.
|
*/
$config['user_group'] = array(
	array(
		'field' => 'name',
		'label' => 'Group Name',
		'rules' => 'required|is_unique[groups.name]'
	),
	array(
		'field' => 'description',
		'label' => 'Group Description',
		'rules' => 'required'
	),
);

$config['user_group_edit'] = array(
	array(
		'field' => 'name',
		'label' => 'Group Name',
		'rules' => 'required'
	),
	array(
		'field' => 'description',
		'label' => 'Group Description',
		'rules' => 'required'
	),
);

/* End of file Form_validation.php */
/* Location: ./application/modules/users/config/Form_validation.php */