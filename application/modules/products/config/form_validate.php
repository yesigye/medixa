<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Product Validation Rules
|--------------------------------------------------------------------------
|
| Set Rules that a product form must pass before it is added or updated.
|
*/
$config['product_insert'] = array(
);

$config['product_update'] = array(
);

/*
|--------------------------------------------------------------------------
| Category Validation Rules
|--------------------------------------------------------------------------
|
| Set Rules that a category form must pass before it is added or updated.
|
*/
$config['category_insert'] = array(
	array(
		'field' => 'name',
		'label' => lang('form_category_name'),
		'rules' => 'required|is_unique[product_categories.name]'
	),
);

$config['category_update'] = array(
	array(
		'field' => 'name',
		'label' => lang('form_category_name'),
		'rules' => 'required'
	),
);

/*

/* End of file Form_validation.php */
/* Location: ./application/modules/products/config/Form_validation.php */