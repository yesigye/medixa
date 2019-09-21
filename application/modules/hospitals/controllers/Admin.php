<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

		modules::run('users/authenticate/admin');

		$this->load->library('app');
		$this->load->model(['hospitals_model', 'types_model', 'specialities_model']);
		$this->load->helper(['form', 'language']);
		$this->data = array();
	}

	public function index()
	{
		$this->hospitals();
	}

	public function hospitals()
	{
		$this->load->library('form_validation');

		if ($this->input->post('add_hospital')) {
			$this->_add();
		}

		/* Activate multiple selected hospitals */
		if ($this->input->post('activate_selected')) {
			$this->form_validation->set_rules('selected[]', 'Selected', 'required');
			$this->form_validation->set_message('required', 'You need to select hospitals first.');
			
			if ($this->form_validation->run() == true) {
				if ($this->hospitals_model->activate_multiple($this->input->post('selected'))) {
					$this->app->setAlert('Hospitals(s) have been activated');
				} else {
					$this->app->setAlert('Hospitals(s) could not be activated', 'error');
				}
				redirect(current_url(), 'redirect');
			}
		}
		/* Deactivate multiple selected hospitals */
		if ($this->input->post('deactivate_selected')) {
			$this->form_validation->set_rules('selected[]', 'Selected', 'required');
			$this->form_validation->set_message('required', 'You need to select hospitals first.');
			
			if ($this->form_validation->run() == true) {
				if ($this->hospitals_model->deactivate_multiple($this->input->post('selected'))) {
					$this->app->setAlert('Hospitals(s) have been deactivated');
				} else {
					$this->app->setAlert('Hospitals(s) could not be deactivated', 'error');
				}
				redirect(current_url(), 'redirect');
			}
		}
		/* Delete multiple selected hospitals */
		if ($this->input->post('delete_selected')) {
			$this->form_validation->set_rules('selected[]', 'Selected', 'required');
			$this->form_validation->set_message('required', 'You need to select hospitals first.');

			if ($this->form_validation->run() == true) {
				$count = 0;
				foreach ($this->input->post('selected') as $id) {
					
					if ($this->hospitals_model->delete_hospital($id)) $count++;
				}
				if ($count > 0) {
					$this->app->setAlert($count.' hospitals have been deleted');
				} else {
					$this->app->setAlert('Hospitals(s) could not be deleted', 'error');
				}
				redirect(current_url(), 'redirect');
			}
		}
		
		$this->load->model('hospitals/types_model');
		$types = $this->types_model->get_types();
		$type_options = [];
		foreach ($types as $key => $type) {
			$type_options[$type['id']] = $type['name'];
		}

		$this->data['form_fields'] = [
			'name' => [
				'label' => lang('form_hospital_name'),	
			],
			'types[]' => [
				'label' => lang('form_hospital_type'),	
				'type' => 'select',
				'options' => $type_options,
				'selected' => [],
			],
			'email' => [
				'label' => lang('form_email'),	
				'type' 	=> 'text',
			],
			'address' => [
				'label' => lang('form_address'),	
			],
			'phone' => [
				'label' => lang('form_phone'),	
			],
		];

		$this->load->view('admin/hospitals_view', $this->data);
	}

 	/**
	 * Add a new hospital
	 *
	 * @return response
	 **/
	private function _add() {
		$this->load->library('form_validation');

		// Set validation rules. Validation rules are set by config file at
		// './application/modules/hospitals/config/Form_validation.php'
		$this->config->load('hospitals/form_validate');
		$this->form_validation->set_rules($this->config->item('hospital_submit'));

		if ($this->form_validation->run() == true) {
			if ($this->hospitals_model->add()) {
				$this->app->setAlert(lang('alert_hospital_add_success'));
				redirect('admin/hospitals/edit/'.$this->hospitals_model->id);
			} else {
				$this->app->setAlert(lang('alert_hospital_add_fail'), 'error');
				redirect('admin/hospitals', 'refresh');
			}
		}
	}

	/**
	 * Edit hospital details
	 * 
	 * @return response
	 **/
	public function edit($id)
	{
		$this->load->library('form_validation');
		
		if ($this->input->post('update')) {
			$this->load->library('form_validation');
			
			// Set validation rules. Validation rules are set by config file at
			// './application/modules/hospitals/config/Form_validation.php'
			$this->config->load('hospitals/form_validate');
			$this->form_validation->set_rules($this->config->item('hospital_update'));
			
			if ($this->form_validation->run() == true) {

				// Get the last child node's location code
				$this->load->model('locations/locations_model');
				foreach ($this->input->post() as $key => $value) {
					if (substr($key, 0, 8) == 'locType_') {
						$location_code = $this->input->post($key);
					}
				}
				if (isset($location_code)) {
					// Set location ID
					$_POST['location_id'] = $this->locations_model->get_location_id($location_code);
				}

				if ($this->hospitals_model->update($id)) {
					$this->app->setAlert('Hospital details have been updated');
				} else {
					$this->app->setAlert($this->hospitals_model->error_message(), 'error');
				}

				redirect(current_url());
			}
		}

		$hospital = $this->hospitals_model->details(array(
			'id' => $id,
		));

		$this->load->model(['tree_model', 'locations/locations_model']);
		
		$facilities = [];
		$hospital_types = [];
		$hospital_facilities = [];
		
		if (!empty($hospital)) {
			$types = [];
			foreach ($this->types_model->get_types() as $value) $types[$value['id']] = $value['name'];
			$hospital_types = $this->types_model->inHospitals($id);
			$facilities = $this->types_model->facilities($hospital_types, ['inherit' => true]);
			$hospital_facilities = $this->types_model->facilitiesInHospital($id);
		}

		$this->data['form_fields'] = [
			'name' => [
				'label' => lang('form_hospital_name'),
				'required' => true,
				'value' => $hospital['name']
			],
			'slug' => [
				'label' => lang('form_hospital_slug'),
				'required' => true,
				'value' => $hospital['slug']
			],
			'types[]' => [
				'type'  => 'select',
				'label' => lang('form_hospital_type'),
				'required' => true,
				'options' => $types,
				'selected' => $hospital_types,
				'attr' => ['multiple' => 'multiple']
			],
			'slogan' => [
				'label' => lang('form_hospital_slogan'),
				'value' => $hospital['slogan']
			],
			'open_hrs' => [
				'label' => lang('form_hospital_hours'),
				'value' => $hospital['open_hrs']
			],
			'phone' => [
				'type' => lang('form_phone'),
				'label' => 'Phone',
				'required' => true,
				'value' => $hospital['phone']
			],
			'email' => [
				'label' => lang('form_email'),
				'type' => 'email',
				'required' => true,
				'value' => $hospital['email']
			],
			'about' => [
				'type' => 'textarea',
				'label' => lang('form_hospital_about'),
				'value' => $hospital['description'],
				'attr' => ['rows' => 8]
			],
			'active' => [
				'label' => lang('form_status'),
				'type' => 'checkbox',
				'value' => '1',
				'checked' => set_checkbox('active', '1') ? true : (bool) $hospital['active']
			]
		];
		$this->data['hospital_id'] = $id;
		$this->data['hospital'] = $hospital;
		$this->data['all_facilities'] = $facilities;
		$this->data['facilities'] = $hospital_facilities;
		$this->data['types'] = $hospital_types;

		$this->load->view('admin/edit/hospital_edit_view', $this->data);
	}

	/**
	 * Edit hospital location
	 * 
	 * @return response
	 **/
	public function edit_location($id)
	{
		$hospital = $this->hospitals_model->details(array(
			'id' => $id,
		));

		if ($this->input->post('update')) {
			$this->load->model('locations/locations_model');
			$data = [
				'address' => $this->input->post('address'),
				'latitude' => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude'),
			];
			
			foreach ($this->input->post() as $key => $value) {
				// Get the location code in the last node of locations
				if (substr($key, 0, 8) == 'locType_') $location_code = $this->input->post($key);
			}
			
			if (isset($location_code)) {
				$location_id = $this->locations_model->get_location_id($location_code);
				$_POST['location_id'] = $data['location_id'] = $location_id;
			}
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('location_id', 'location id', 'required');
			
			if ($this->form_validation->run() == true) {
				if ($this->hospitals_model->save($data, $id)) {
					$this->app->setAlert(lang('alert_success_general'));
				} else {
					$this->app->setAlert(lang('alert_fail_general'), 'error');
				}

				redirect(current_url());
			}
		}

		$this->load->model(['tree_model', 'locations/locations_model']);
		
		if (!empty($hospital)) {
			$this->data['form_fields'] = [];
			$tiers = $this->locations_model->tiers(); 
			$lineage = $this->app->lineage('locations', $hospital['location_id'], ['id', 'name', 'code', 'location_type_id']);
			if (empty($lineage)) $lineage = $tiers; 
			
			foreach ($tiers as $key => $tier) {
				$locOpts = [null => null];
				if(!isset($lineage[$key]['location_type_id'])) {
					$locations = $this->locations_model->locations($tier['id'], $tier['parent_id']);
					$selected = [null];
				} else {
					$locations = $this->locations_model->locations($lineage[$key]['location_type_id'], $lineage[$key]['parent_id']);
					$selected = [$lineage[$key]['code']];
				}
				foreach ($locations as $l) $locOpts[$l['code']] = $l['name'];

				$this->data['form_fields']['locType_'.$tiers[$key]['name']] = [
					'type' => 'select',
					'label' => $tiers[$key]['name'],
					'options' => $locOpts,
					'selected' => $selected,
					'attr' => ['id' => $tiers[$key]['code']],
				];
			}
			
			$types = [null => ''];
			foreach ($this->types_model->get_types() as $value) $types[$value['id']] = $value['name'];
			$hospital_types = $this->types_model->inHospitals($id);
			

			$facilities = $this->types_model->facilities($hospital_types, ['inherit' => true]);
			$hospitalFacilities = $this->types_model->facilitiesInHospital($id);
			
			$this->data['all_facilities'] = $facilities;
			$this->data['facilities'] = $hospitalFacilities;
			$this->data['types'] = $hospital_types;
		}

		$this->data['hospital_id'] = $id;
		$this->data['hospital'] = $hospital;		
		$this->data['locationTypes'] = $this->locations_model->tiers();
		
		$this->load->library('locations/forms');
		$this->data['location_form'] = $this->forms->inputs();

		
		$this->data['location_lineage'] = $lineage;

		$this->load->view('admin/edit/hospital_edit_location_view', $this->data);
	}

	public function edit_images($id)
	{
		if ($this->input->post('edit_image')) {

			$image_id = $this->input->post('edit_image');

			if ($this->hospitals_model->update_hospital_image($id, $image_id)) {
				$this->app->setAlert('images have been updated');
			} else {
				$this->app->setAlert('images could not be updated', 'error');
			}
			redirect(current_url());
		}

		if ($this->input->post('upload_images')) {

			if ($this->hospitals_model->upload_hospital_images($this->input->post('id'))) {
				$this->app->setAlert('images have been uploaded');
			} else {
				$this->app->setAlert('images could not be uploaded', 'error');
			}
			redirect(current_url());
		}

		if ($this->input->post('delete_images')) {
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('selected[]', 'Images', 'required');
			if ($this->form_validation->run())
			{
				foreach ($this->input->post('selected') as $image_id) {
					$this->hospitals_model->delete_hospital_image($image_id);
				}
				$this->app->setAlert('images have been deleted');
				redirect(current_url());
			}
		}
		
		$this->data['hospital_id'] = $id;
		$this->data['hospital_name'] = $this->hospitals_model->getName($id);
		$this->data['images'] = $this->hospitals_model->get_hospital_images($id);
		// Upload file limit.
		$this->data['upload_limit'] = $this->app->config('upload_limit');

		$this->load->view('admin/edit/hospital_edit_images_view', $this->data);	
	}

	public function edit_doctors($id)
	{
	// 	$this->load->model('physicians_model');
	// $options['out_hospital'] = $id;
	// $users = $this->physicians_model->getAll($options);
	// var_dump(count($users));
	// exit();
		if ($this->input->post('assign')) {
			$users = $this->input->post('selected');

			if ($this->hospitals_model->assign_doctors($id, $users)) {
				$this->app->setAlert('Doctors have been assigned to hospital');
			} else {
				$this->app->setAlert('Doctor(s) could not be assigned.', 'error');
			}
			redirect(current_url());
		}
		
		if ($this->input->post('remove')) {
			$users = $this->input->post('selected');

			if ($this->hospitals_model->remove_doctors($id, $users)) {
				$this->app->setAlert('Doctors have been removed to hospital');
			} else {
				$this->app->setAlert('Doctor(s) could not be removed.', 'error');
			}
			redirect(current_url());
		}

		// Get users.
		$this->load->library('doctors');

		$users = $this->doctors->all(array(
			'company' => $id,
			'ignore_status' => TRUE // Both active and inactive users
		));

		$this->data['users'] = $users['rows'];	
		$this->data['users_total'] = $users['total'];	
		$this->data['pagination'] = $users['pagination'];

		$this->db->reset_query();
		$non_users = $this->doctors->all(array(
			'not_company' => $id,
			'ignore_status' => TRUE // Both active and inactive users
		));

		$this->data['non_users'] = $non_users['rows'];	
		$this->data['non_users_total'] = $non_users['total'];	
		$this->data['non_users_pagination'] = $non_users['pagination'];

		$this->data['hospital_id'] = $id;
		$this->data['hospital_name'] = $this->hospitals_model->getName($id);

		$this->load->view('admin/edit/hospital_edit_physicians_view', $this->data);
	}

	public function types()
	{
		$this->data['insertRows'] = 1;
		
		if ($this->input->post('add_types')) {
			$this->data['insertRows'] = count($this->input->post('insert'));
			if ($num = $this->types_model->addTypes() > 0) {
				$this->app->setAlert($num.' new types have been set');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert($this->types_model->error_message(), 'error');
				}
			}
			redirect(current_url());
		}

		if ($this->input->post('update_types')) {
			if ($this->types_model->updateTypes()) {
				$this->app->setAlert('Types have been updated');
				redirect(current_url());
			} else {
				$this->app->setAlert('Types could not be updated', 'error');
				if(validation_errors() == '') {
					redirect(current_url());
				}
			}
		}

		if ($this->input->post('delete_types')) {
			if ($this->types_model->delete_types()) {
				$this->app->setAlert($num.' types have been deleted');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert($this->types_model->error_message(), 'error');
					redirect(current_url(), 'refresh');
				}
			}
		}

		$this->load->view('admin/types_view', $this->data);
	}
	
	public function facilities()
	{
		$this->data['insertRows'] = 1;
		
		if ($this->input->post('create')) {
			$this->data['insertRows'] = count($this->input->post('insert'));
			if ($num = $this->types_model->addFacilities() > 0) {
				$this->app->setAlert($num.' new facilities have been set');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('facilites could not be added', 'error');
					redirect(current_url(), 'refresh');
				}
			}
		}

		if ($this->input->post('update_facilities')) {
			if ($this->types_model->updateFacilities()) {
				$this->app->setAlert('Facilities have been updated');
				redirect(current_url());
			} else {
				$this->app->setAlert('Facilities could not be updated', 'error');
				if(validation_errors() == '') {
					redirect(current_url(), 'refresh');
				}
			}
		}

		if ($this->input->post('delete_facilities')) {
			if ($this->types_model->deleteFacilities($id)) {
				$this->app->setAlert($num.' types have been deleted');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert($this->types_model->error_message(), 'error');
					redirect(current_url(), 'refresh');
				}
			}
		}

		$this->load->view('admin/facilities_view', $this->data);
	}

	public function specialities()
	{
		$this->load->model('specialities_model');

		$this->data['insertRows'] = 1;
		if ($this->input->post('create')) {
			$this->data['insertRows'] = count($this	->input->post('insert'));
			
			$countAdded = $this->specialities_model->add_specialities();
			if ($countAdded > 0) {
				$this->app->setAlert($countAdded.' specialities were added');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Specialities could not be added', 'error');
					redirect(current_url());
				}
			}
		}

		if ($this->input->post('edit')) {
			if ($this->specialities_model->update_specialities()) {
				$this->app->setAlert('Specialities were updated');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Specialities could not be updated', 'error');
					redirect(current_url());
				}
			}
		}

		if ($this->input->post('delete')) {
			$countDeleted = $this->specialities_model->delete_specialities();
			if ($countDeleted > 0) {
				$this->app->setAlert($countDeleted.' specialities were deleted');
				redirect(current_url());
			} else {
				if(validation_errors() == '') {
					$this->app->setAlert('Specialities could not be deleted', 'error');
					redirect(current_url());
				}
			}
		}
		
		$this->load->view('admin/specialities_view', $this->data);
	}
}

/* End of file Admin.php */
/* Location: ./application/modules/hospitals/controllers/Admin.php */