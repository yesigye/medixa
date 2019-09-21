<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms
{
	public function __construct()
	{
		$this->load->model([
			'locations/locations_model',
		]);
		$this->load->helper('form');
	}
	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	/**
	 * Generate update form
	 *
	 * @return Array
	 **/
	public function inputs($col = 'col-md-12')
	{
		
		$locTypes = $this->locations_model->tiers();
		$locations = $this->locations_model->getChildren();
		$form_fields = [];
		if (!empty($locTypes)) {
			// Generate select fields for locations.
			foreach ($locTypes as $type) {
				$form_fields['locType_'.$type['name']] = [];
				// Initiate select options.
				$formOptions = [];
				if (isset($locations[$type['name']])) {
					// Default select option.
					$formOptions[''] = 'select';
					foreach ($locations[$type['name']] as $rows) {
						// Push select options.
						$formOptions[$rows['code']] = $rows['name'];
					}
				}
				// Define other form parameters.
				$form_fields['locType_'.$type['name']]['type'] = 'select';
				$form_fields['locType_'.$type['name']]['label'] = $type['name'];
				$form_fields['locType_'.$type['name']]['options'] = $formOptions;
				$form_fields['locType_'.$type['name']]['col'] = $col;
				$form_fields['locType_'.$type['name']]['attr'] = [
					'id' => $type['code']
				];
			}
		}
		
		return $this->load->view('form_fields', ['fields'=>$form_fields], true);
	}
}