<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MX_Controller {

    function __construct() 
    {
		parent::__construct();
		
        modules::run('users/authenticate/user');

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model([
			'appointments/appointments_model',
		]);
			
		// Remember url.
		$this->session->set_userdata('login_redirect', current_url());
		
		// redirect non-logged in users.
		if ( !$this->ion_auth->logged_in()) redirect('login');

		// Stores data used by view pages.
		$this->data  = array();
	}

	function index()
	{
		$this->load->model('users/user');

		$user_id = $_SESSION['user_id'];
		
		// We use the variable "person" because
		// the global "user" is already being used for currently signed in user.
		$this->data['person'] = $this->user->details($user_id);

		if ($this->input->post('save')) {
			// Attempt to update user details
			if($this->user->update($user_id)) {
				$this->app->setAlert('User profile has been updated');
				redirect(current_url());
			} else {
				$message = $this->user->error_message ? $this->user->error_message : 'Profile could not be updated';
				$this->app->setAlert($message, 'error');
			}
		}
		
		$this->data['form_fields'] = [
			'avatar' =>	[
				'type'  => 'image',
				'label' => 'Avatar',
				'value' => (isset($this->data['person']['avatar'])) ? $this->data['person']['avatar'] : null
			],
			'username' => [
				'label' => 'Username',
				'value' => $this->data['person']['username'],
				'col' => 'col-md-6'
			],
			'email' => [
				'type'  => 'email',
				'label' => 'Email Address',
				'value' => $this->data['person']['email'],
				'col' => 'col-md-6'
			],
			'first_name' => [
				'label' => 'First Name',
				'value' => $this->data['person']['first_name'],
				'col' => 'col-md-6'
			],
			'last_name' => [
				'label' => 'Last Name',
				'value' => $this->data['person']['last_name'],
				'col' => 'col-md-6'
			],
			'address' => [
				'label' => 'Address',
				'value' => $this->data['person']['address'],
				'col' => 'col-md-6'
			],
			'phone' => [
				'type' => 'phone',
				'label' => 'Phone',
				'value' => $this->data['person']['phone'],
				'col' => 'col-md-6'
			],
		];

		$this->load->view('public/auth/user/profile', $this->data);
	}

	function medical()
	{
		if (!$this->ion_auth->in_group('doctors')) show_404();

		$this->load->model([
			'users/user',
			'locations/locations_model',
			'hospitals/specialities_model',
			'hospitals/physicians_model'
		]);

		$user_id = $_SESSION['user_id'];
		
		$this->load->library('hospitals/doctors');
		
		$profile = $this->physicians_model->details($user_id);

		if ($this->input->post('save')) {
			
			$this->load->library('form_validation');
			// Validation rules are in config file at
			// ./application/modules/hospitals/config/Form_validate.php
			$this->config->load('hospitals/form_validate');
			$validation_rules = $this->config->item('doctor_update');
			$this->form_validation->set_rules($validation_rules);

			if ($this->form_validation->run() == true) {
				
				foreach ($this->input->post() as $key => $value) {
					if (substr($key, 0, 8) == 'locType_' && $value) {
						$location_code = $this->input->post($key);
					}
				}
				if (isset($location_code)) {
					// Set location ID
					$_POST['location_id'] = $this->locations_model->get_location_id($location_code);
				}
	
				if ($this->physicians_model->save($user_id)) {
					$this->app->setAlert('Profile has been updated');
				} else {
					$this->app->setAlert('Profile could not be updated', 'error');
				}
				redirect(current_url());
			}
		}

        $this->data['profile']       = $profile;
        $this->data['user_id']       = $user_id;
		$this->data['username']      = $this->user->row($user_id, 'username');
		$this->data['locationTypes'] = $this->locations_model->tiers();
		$this->data['selectedLocationTypes'] = $this->app->lineage('locations', $profile['location_id'], ['code', 'name']);

		$this->load->view('public/auth/user/profile_medical', $this->data);
	}
}
