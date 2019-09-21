<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctors
{

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
	public function updateForm($user_id)
	{
		$this->load->model([
			'locations/locations_model',
			'hospitals/physicians_model',
			'hospitals/specialities_model',
		]);
		
		$this->load->helper('form');

		$doctor = $this->physicians_model->details($user_id);

		// Define update form fields
		$form_fields['reg_no'] = [
			'label' => lang('form_doctor_reg_no'),
			'col' => 'col-md-6',
			'value' => $doctor['reg_no']
		];
		// Get Specialities
		$specialities = $this->specialities_model->get_specialists();
		$specialityOptions[''] = '--';
		foreach ($specialities as $speciality) {
			$specialityOptions[$speciality['id']] = $speciality['name'];
		}
		$form_fields['speciality'] = [
			'label' => lang('form_doctor_speciality'),
			'type' => 'select',
			'col' => 'col-md-6',
			'options' => $specialityOptions,
			'selected' => [$doctor['speciality_id']],
		];
		$form_fields['description'] = [
			'label' => lang('form_doctor_description'),
			'help-text' => lang('form_doctor_description_txt'),
			'type' => 'textarea',
			'value' => $doctor['description'],
			'col' => 'col-md-12',
		];
		
		$locTypes = $this->locations_model->tiers();
		$locations = $this->locations_model->getChildren();
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
			$form_fields['locType_'.$type['name']]['col'] = 'col-md-4';
			$form_fields['locType_'.$type['name']]['attr'] = [
				'id' => $type['code']
			];
			$form_fields['locType_'.$type['name']]['value'] = $doctor['location_code'];
		}
		
		$form_fields['first_qualification'] = [
			'label' => lang('form_doctor_qualification'),
			'help-text' => lang('form_doctor_qualification_txt'),
			'value' => $doctor['first_qualification'],
			'col' => 'col-md-6',
		];
		$form_fields['other_qualification'] = [
			'label' => lang('form_doctor_qualification_2'),
			'help-text' => lang('form_doctor_qualification_2_txt'),
			'value' => $doctor['other_qualification'],
			'col' => 'col-md-6',
		];
		$form_fields['is_mobile'] = [
			'label' => lang('form_doctor_mobile_service'),
			'help-text' => lang('form_doctor_mobile_service_txt'),
			'type' => 'checkbox',
			'value' => 1,
			'checked' => set_checkbox('is_mobile', 1) ? true : (bool) $doctor['is_mobile'],
			'col' => 'col-md-6',
		];

		$this->load->view('form_fields', ['fields'=>$form_fields]);
	}

		/**
	 * all
	 *
	 * @param Array $options filters for querying users
	 * @return Array
	 **/
	public function all($options = array())
	{
		$this->load->model('Physicians_model');

		$page_limit = $this->app->pageLimit;

		if (!isset($options['limit'])) $options['limit'] = $page_limit;

		if ($this->input->get('group')) $options['group'] = $this->input->get('group');

		if ($this->input->get('u_not_group')) $options['exclude_group'] = $this->input->get('u_not_group');

		if (!isset($options['limit'])) $options['limit'] = $page_limit;

		if ($this->input->get('u_addr')) $options['address_id'] = $this->input->get('u_addr');

		if ($this->input->get('u_spec')) $options['speciality'] = $this->input->get('u_spec');

		if ($this->input->get('az')) $options['order'] = $this->input->get('az');

		if ($this->input->get('u_fac')) $options['fac'] = $this->input->get('u_fac');

		if ($this->input->get('u_mobile')) $options['mobile'] = $this->input->get('u_mobile');

		if ($this->input->get('status')) $options['status'] = $this->input->get('status');

		if (!isset($options['search'])) {

			if ($this->input->post('search'))
			{
				redirect(current_url().($_SERVER['QUERY_STRING'].($_SERVER['QUERY_STRING'] ? '&u_query=' : '?u_query=').$this->input->post('q')));
			}
			
			if ($this->input->get('u_query')) $options['search'] = $this->input->get('u_query');
		}

		if ($page_num = $this->input->get('per_page')) {
			$options['start'] = ( ($page_num*$options['limit'])-$options['limit'] ) + 1;
		} else {
			$options['start'] = 0;
		}

		$users = $this->Physicians_model->getAll($options);
		$result_total = $this->Physicians_model->count;

		// Add some pagination to this page.
		$this->load->library('pagination');

		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];

		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $result_total;
		if (isset($options['uri_segment'])) {
			$config['query_string_segment'] = $options['uri_segment'];
		}
		// $config['num_links']  = round($config['total_rows'] / $config['per_page']);
		$this->pagination->initialize($config);

		return array(
			'rows' => $users,
			'total' => $result_total,
			'pagination' => $this->pagination->create_links(),
		);
	}
}