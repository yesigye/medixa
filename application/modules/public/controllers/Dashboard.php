<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	protected $hospital_id;

    function __construct() 
    {
		parent::__construct();
		
        modules::run('users/authenticate/user', $redirect = true);

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);

		$this->load->model([
			'hospitals/hospitals_model',
		]);
		
		$hospital = $this->hospitals_model->userHospital($_SESSION['user_id']);
		
		if ($this->ion_auth->in_group('manager') && !empty($hospital)) {
			// This user is a manager with a hospital.
			$this->hospital_id = $hospital['id'];
			$this->hospital_name = $hospital['name'];
			$this->hospital_logo = base_url('image/'.$hospital['logo']);
		} else {
			// Users is not manager and/or has no hospital.
			show_404();
		}
		
		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];
		
		// Remember to bring user back here after login
		$this->session->set_userdata('login_redirect', current_url());
	}
		
	/**
	 * Display hospital dashboard.
	 *
	 * @return response
	 */
	public function index()
	{
		$this->load->model([
			'hospitals/tree_model',
			'hospitals/types_model',
			'hospitals/physicians_model',
			'locations/locations_model'
		]);
		
		$doctors = $this->physicians_model->getAll(array(
			'count' => true,
			'in_hospital' => $this->hospital_id
		));
		$inactive_doctors = $this->physicians_model->getAll(array(
			'count' => true,
			'active' => true,
			'in_hospital' => $this->hospital_id
		));
		$recent_doctors = $this->physicians_model->getAll(array(
			'limit' => 6,
			'order' => [
				'column' => 'id',
				'dir' => 'desc'
			],
			'in_hospital' => $this->hospital_id,
			'show_appointments' => true
		));
		$hospital_facilities = $this->types_model->facilitiesInHospital($this->hospital_id, true);
		$images_count = $this->hospitals_model->images($this->hospital_id, true);
		$hospital = $this->hospitals_model->details(array(
			'id' => $this->hospital_id,
		));
		
		$this->data['hospital'] = $hospital;
		$this->data['hospital_id'] = $this->hospital_id;
		$this->data['hospital_name'] = $this->hospital_name;
		$this->data['hospital_logo'] = $this->hospital_logo;
		$this->data['doctors'] = $recent_doctors;
		$this->data['images_count'] = $images_count;
		$this->data['doctors_count'] = $doctors;
		$this->data['inactive_doctors_count'] = $inactive_doctors;
		$this->data['hospital_facilities_count'] = $hospital_facilities;
		// Upload file limit.
		$this->data['upload_limit'] = $this->app->config('upload_limit');

		$this->load->view('public/dashboard/manager/index', $this->data);
	}

	/**
	 * Display hospital details.
	 *
	 * @return response
	 */
	public function profile()
	{
		$this->load->model([
			'hospitals/tree_model',
			'hospitals/types_model',
			'hospitals/physicians_model',
			'locations/locations_model'
		]);

		if ($this->input->post('update'))
		{
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

				if ($this->hospitals_model->update($this->hospital_id)) {
					$this->app->setAlert('Hospital profile has been updated');
				} else {
					$this->app->setAlert("Hospital profile could not be updated", 'error');
				}

				redirect(current_url());
			}
		}

		$hospital = $this->hospitals_model->details(array(
			'id' => $this->hospital_id,
		));
		$this->data['locationTypes'] = $this->locations_model->tiers();
		
		$this->load->library('locations/forms');
		$this->data['location_form'] = $this->forms->inputs();
		$lineage = $this->app->lineage('locations', $hospital['location_id'], ['id', 'name']);
		$this->data['location_lineage'] = $lineage;
		
		if (!empty($hospital)) {
			$types_tree = $this->tree_model->generate_node_tree(array(
				'table' => 'company_types',
				'padding' => '20',
				'form' => ['type'=>'checkbox', 'name'=>'types[]'],
				'values' => $this->types_model->inHospitals($this->hospital_id),
			));
			$types = $this->types_model->inHospitals($this->hospital_id);
			$facilities = $this->types_model->facilities($types, ['inherit'=>true]);
			$hospitalFacilities = $this->types_model->facilitiesInHospital($this->hospital_id);
			
			$this->data['types'] = $types;
			$this->data['types_tree'] = $types_tree;
			$this->data['all_facilities'] = $facilities;
			$this->data['facilities'] = $hospitalFacilities;
		}
		$types_options = [];
		foreach ($this->types_model->get_types() AS $type) {
			$types_options[$type['id']] = $type['name'];
		}
		$this->data['form_fields'] = [
			'types[]' => [
				'label' => 'Type',
				'type'  => 'select',
				'required' => true,
				'options' => $types_options,
				'selected' => $types
			],
			'name' => [
				'type'  => 'name',
				'label' => 'Name',
				'required' => true,
				'value' => $hospital['name']
			],
			'slug' => [
				'label' => lang('form_hospital_slug'),
				'required' => true,
				'value' => $hospital['slug']
			],
			'slogan' => [
				'label' => 'Slogan',
				'value' => $hospital['slogan']
			],
			'open_hrs' => [
				'label' => 'Open Hours',
				'value' => $hospital['open_hrs']
			],
			'address' => [
				'label' => 'Address',
				'required' => true,
				'value' => $hospital['address']
			],
			'phone' => [
				'type' => 'phone',
				'label' => 'Phone',
				'required' => true,
				'value' => $hospital['phone']
			],
			'email' => [
				'label' => 'Email Address',
				'type' => 'email',
				'required' => true,
				'value' => $hospital['email']
			],
			'about' => [
				'type' => 'textarea',
				'label' => 'About the clinic',
				'value' => $hospital['description']
			],
		];
		$this->data['geocode_fields'] = [
			'latitude' => [
				'label' => 'Latitude',
				'value' => $hospital['latitude']
			],
			'longitude' => [
				'label' => 'Longitude',
				'value' => $hospital['longitude']
			],
		];

		$this->data['hospital'] = $hospital;
		$this->data['hospital_id'] = $this->hospital_id;
		$this->data['hospital_name'] = $this->hospital_name;
		$this->data['hospital_logo'] = $this->hospital_logo;	
		$this->data['locationTypes'] = $this->locations_model->tiers();

		$this->load->view('public/dashboard/manager/profile', $this->data);
	}

	/**
	 * Display hospital facilities.
	 *
	 * @return response
	 */
	public function facilities()
	{
		$this->load->model([
			'hospitals/tree_model',
			'hospitals/types_model',
			'hospitals/physicians_model',
			'locations/locations_model'
		]);

		if ($this->input->post('update')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('facilities[]', 'Facilities', 'required');
			
			if ($this->form_validation->run() == true) {

				if ($this->hospitals_model->update_facilities($this->hospital_id, $this->input->post('facilities[]'))) {
					$this->app->setAlert('Hospital facilities were updated');
				} else {
					$this->app->setAlert("Hospital facilities could not be updated", 'error');
				}
				redirect(current_url());
			}
		}

		$hospital = $this->hospitals_model->details(array(
			'id' => $this->hospital_id,
		));
		$types = $this->types_model->inHospitals($this->hospital_id);
		$facilities = $this->types_model->facilities($types, ['inherit'=>true]);
		$hospitalFacilities = $this->types_model->facilitiesInHospital($this->hospital_id);

		$this->data['types'] = $types;
		$this->data['all_facilities'] = $facilities;
		$this->data['facilities'] = $hospitalFacilities;

		$this->data['hospital'] = $hospital;
		$this->data['hospital_id'] = $this->hospital_id;
		$this->data['hospital_name'] = $this->hospital_name;
		$this->data['hospital_logo'] = $this->hospital_logo;		

		$this->load->view('public/dashboard/manager/facilities', $this->data);
	}

	public function physicians(Type $var = null)
	{
		$this->load->model([
			'users/user',
			'hospitals/hospitals_model',
			'hospitals/physicians_model',
			'hospitals/specialities_model',
			'locations/locations_model',
		]);

		if ($this->input->post('assign')) {
			$this->load->helper('form');
			$this->load->library('form_validation');
			// Set validation rules
			// Validation rules are set by config file at
			// ./application/modules/users/config/Form_validation.php
			$this->config->load('users/form_validate');
			$validation_rules = $this->config->item('assign');
			$this->form_validation->set_rules($validation_rules);

			if ($this->form_validation->run('signup') == true) {
				
				$email = strtolower($this->input->post('email'));
				// Generate a random password
				$this->load->helper('string');
				$random_pass = random_string('alnum', 10);
				$register = $this->ion_auth->register($email, $random_pass, $email, [], [2]);
				// Attempt to register user.
				if ($register) {
					// profile data
					$profile = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
					);
					// Attempt to add user profile data.
					if($this->user->save($register['id'], $profile)) {
						// Add medical profile
						$med_profile = [
							'reg_no' => $this->input->post('reg_no'),
							'speciality_id' => $this->input->post('speciality'),
						];
						// Get the last child node's location code
						foreach ($this->input->post() as $key => $value) {
							if (substr($key, 0, 8) == 'locType_') $location_code = $this->input->post($key);
						}
						if (isset($location_code)) {
							// Set location ID
							$med_profile['location_id'] = $this->locations_model->get_location_id($location_code);
						}
						
						// Attempt to save the medical profile.
						if ($this->physicians_model->save($register['id'], $med_profile)) {
							// Get the activate account email template
							$message = $this->load->view('public/email/activate_account.mail.php', [
								'user_id' => $register['id'],
								'code' => $register['activation'],
								'password' => $random_pass
							], true);

							// Define email parameters
							$this->load->library('email');
							$config['mailtype'] = 'html';
							$this->email->initialize($config);

							$this->email->from($this->app->no_reply);
							$this->email->to($register['email']);
							$this->email->subject('Activate Your Account');
							$this->email->message($message);
							
							/* Attempt to send email */
							if ($this->email->send()) {
								$this->app->setAlert("The physician has been sent an activation email");
							} else {
								// Email failed.
								log_message('error', 'Activation email could not send - Manager is assigning');
								$this->app->setAlert("CODE AHP04: Failed to email the physician", 'warning');
							}

							// Assign to hospital
							$this->hospitals_model->assign_user($this->hospital_id, $register['id']);
						} else {
							log_message('error', 'Medical profile could not save - Manager is assigning');
							$this->app->setAlert("CODE AHP03: Physician could not be registered", 'error');
							$this->user->delete_user($register['id']);
						}
					} else {
						log_message('error', 'User profile could not save - Manager is assigning');
						$this->app->setAlert("CODE AHP02: Physician could not be registered", 'error');
						$this->user->delete_user($register['id']);
					}
				} else {
					log_message('error', 'User could not save - Manager is assigning');
					$this->app->setAlert("CODE AHP01: Physician could not be registered", 'error');
					$this->user->delete_user($register['id']);
				}
				redirect(current_url());
			}
		}
		
		$specialities = $this->specialities_model->get_specialists();
		$form_speclty = [];
		foreach ($specialities as $key => $speciality) {
			$form_speclty[$speciality['id']] = $speciality['name'];
		}

		$this->data['form_fields'] = [
			'reg_no' => [
				'label' => 'Registration Number',
			],
			'speciality' => [
				'label' => 'Speciality',
				'type' => 'select',
				'options' => $form_speclty,
				'selected' => [],
			],
			'first_name' => [
				'label' => 'First Name',
			],
			'last_name' => [
				'label' => 'Last Name',
			],
			'email' => [
				'label' => 'Email Address',
			],
		];

		$this->load->model('locations/locations_model');
		$this->data['locationTypes'] = $this->locations_model->tiers();
		$this->load->library('locations/forms');
		$this->data['location_form'] = $this->forms->inputs();
		$lineage = $this->app->lineage('locations', $this->hospital_id, ['id', 'name']);
		$this->data['location_lineage'] = $lineage;

		// Get users.
		$this->load->library('hospitals/doctors');

		$users = $this->doctors->all(array(
			'in_hospital' => $this->hospital_id,
			'ignore_status' => false // Both active and inactive users
		));

		$this->data['users'] = $users['rows'];	
		$this->data['users_total'] = $users['total'];	
		$this->data['pagination'] = $users['pagination'];
		$this->data['hospital_id'] = $this->hospital_id;
		$this->data['hospital_logo'] = $this->hospital_logo;
		$this->data['hospital_name'] = $this->hospital_name;
		$this->data['hospital_logo'] = $this->hospital_logo;

		$this->load->view('public/dashboard/manager/physicians', $this->data);
	}

	public function photos()
	{
		if ($this->input->post('upload_images')) {

			if ($this->hospitals_model->upload_hospital_images($this->input->post('id'))) {
				$this->app->setAlert('photo(s) have been uploaded');
			} else {
				$this->app->setAlert('photo(s) could not be uploaded', 'error');
			}
			redirect(current_url());
		}
		if ($this->input->post('edit_image')) {

			$image_id = $this->input->post('edit_image');

			if ($this->hospitals_model->update_hospital_image($this->hospital_id, $image_id)) {
				$this->app->setAlert('photo has been updated');
			} else {
				$this->app->setAlert('photo could not be updated', 'error');
			}
			redirect(current_url());
		}
		if ($this->input->post('delete_image')) {

			if ($this->hospitals_model->delete_hospital_image($this->input->post('delete_image'))) {
				$this->app->setAlert('photo has been deleted');
			} else {
				$this->app->setAlert('photo could not be deleted', 'error');
			}
			redirect(current_url());
		}
		
		$images = $this->hospitals_model->images($this->hospital_id);
		$max_allowed = $this->app->config('upload_limit');
		$max_upload = $max_allowed - count($images);

		$this->data['hospital_id'] = $this->hospital_id;
		$this->data['hospital_name'] = $this->hospital_name;
		$this->data['hospital_logo'] = $this->hospital_logo;
		$this->data['images'] = $images;
		$this->data['max_upload'] = $max_upload;
		$this->data['max_allowed'] = $max_allowed;

		$this->load->view('public/dashboard/manager/photos', $this->data);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/modules/public/controllers/Dashboard.php */