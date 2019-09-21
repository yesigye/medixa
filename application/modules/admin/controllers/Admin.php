<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library(array('app', 'users/ion_auth', 'form_validation'));

		$this->data = array();
		
		// Check if admin user is logged in.
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else {
			// redirect if user is not requesting login page.
			if ($this->uri->segment(2) !== 'login' && $this->uri->segment(2) !== 'logout') {
				redirect('admin/login');
			}
		}
	}

	/**
	 * access the admin
	 *
	 * @return response
	 **/
	function access()
	{
		// Check that the user is not logged in or is not an admin
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
			// Save the url the user was requesting.
			// Remember to redirect the user after successful login.
			$this->session->set_userdata('login_redirect', current_url());

			redirect('admin/login?redirect='.uri_string());
		}
	}

	/**
	 * Login the admin
	 *
	 * @return response
	 **/
	function login()
	{
		$this->load->helper('form');

		$this->load->library('form_validation');

		//validate form input
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->ion_auth->set_error_delimiters('', '');		

		if ($this->form_validation->run() == true) {
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember, 'username')) {
				//The login is successful

				if (!$this->ion_auth->is_admin()) {
					// user is not an admin. Log them out
					$this->ion_auth->logout();
					$this->app->setAlert(lang('alert_access_denied'), 'error');
					// Reload login page.
					redirect(current_url());
				}
				$this->app->setAlert(lang('alert_logged_in'));
				$redirect_url = $this->session->userdata('login_redirect');
				if ($redirect_url && strpos(strtolower($redirect_url), 'admin') !== false) {
					redirect($this->session->userdata('login_redirect'));
				} else {
					redirect('admin');
				}
			}
		}
		
		$this->data['redirect'] = $this->session->userdata('login_redirect');
		// Get any status message that may have been set.
		$this->data['error_message'] = $this->ion_auth->errors();
		$this->data['message'] = $this->session->userdata('login_message');

		$this->load->view('admin/login_view', $this->data);
	}

	/**
	 * Logout the admin
	 *
	 * @return response
	 **/
	function logout()
	{
		// log the user out
		$redirect = $this->session->userdata('login_redirect');
		$this->ion_auth->logout();
		$this->session->set_userdata('login_redirect', $redirect);
		redirect('admin/login');
	}

	/**
	 * Update the admin profile
	 *
	 * @return response
	 **/
	function profile()
	{
		// Set when an admin changes their profile.
		$this->session->unset_userdata('login_redirect');

		$user = $this->ion_auth->user()->result();
		$user = empty($user) ? $user : $user[0];
		$this->data['username'] = $user->username;
		// Form fields for user editing
		$this->data['form_fields'] = [
			'email' => [
				'type'  => 'email',
				'label' => lang('form_users_email'),
				'value' => $user->email,
			],
			'password' => [
				'label' => lang('form_users_change_password'),
				'attr' => ['placeholder' => '***************']
			],
		];
		
		if ($this->input->post('update')) {
			$this->load->config('users/ion_auth');
			
			$this->form_validation->set_rules('email', lang('form_users_email'), 'required|valid_email');
			$this->form_validation->set_rules('old_password', lang('form_users_old_password'), 'required|password_check['.$user->id.']');

			if ($this->input->post('password')) {
				// Rules for the password if it was posted
				$this->form_validation->set_rules('password', lang('form_users_email'), 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']');
				$this->form_validation->set_rules('old_password', lang('form_users_password'), 'required');
			}


			if ($this->form_validation->run($this) == TRUE) {
				if ($this->ion_auth->update($user->id, [
					'email'	=> $this->input->post('email'),
					'password' => $this->input->post('password'),
				])) {
					$this->session->set_userdata('login_message', lang('alert_login_required'));
					$this->session->set_userdata('login_redirect', current_url());
				} else {
					$this->app->setAlert(lang('alert_fail_general'), 'error');
				}
				
				redirect('admin/logout');
				// redirect('admin/profile');
			}
		}

		$this->load->view('admin/user_profile', $this->data);
	}
	
	/**
	 * Admin Dashboard View
	 *
	 * @return response
	 **/
	function index()
	{
		$this->load->helper('text');
		$this->load->model('users/user');
		$this->load->model('appointments/appointments_model', 'appointments');
		
		$active_users = $this->user->all(array(
			'status' => 'active',
			'count' => true,
		));
		$inactive_users = $this->user->all(array(
			'status' => 'inactive',
			'count' => true,
		));
		$total_physicians = $this->db->count_all_results('doctors_profiles');
		$total_hospitals = $this->db->count_all_results('companies');
		$total_specialties = $this->db->count_all_results('doctor_specialities');
		$total_appointments = $this->appointments->all(['count' => true]);

		// Query which speciality has most physicians.
		$this->db->select('doctor_specialities.name, profiles.count')->limit(1);
		$this->db->order_by('profiles.count', 'DESC');
		$this->db->group_by('doctor_specialities.id');
		$this->db->join(
			'(	
				SELECT doctors_profiles.speciality_id, COUNT(*) count
				FROM doctors_profiles
				GROUP BY doctors_profiles.speciality_id
			) profiles',
			'profiles.speciality_id = doctor_specialities.id'
		);
		$largest_speciality = $this->db->get('doctor_specialities')->result_array();

		// Query which hospital has most physicians.
		// $this->db->select('companies.id, companies.name, doc.count')->limit(1);
		// $this->db->order_by('doc.count', 'DESC');
		// $this->db->group_by('companies.id, doc.count');
		// $this->db->join(
		// 	'(	
		// 		SELECT companies_users.company_id, COUNT(*) count
		// 		FROM companies_users
		// 		JOIN doctors_profiles ON doctors_profiles.user_id = companies_users.user_id
		// 		GROUP BY doctors_profiles.user_id, companies_users.company_id
		// 	) doc',
		// 	'doc.company_id = companies.id'
		// );
		$this->db->select('companies.id, companies.name, doc.count')->limit(1);
		$this->db->order_by('doc.count', 'DESC');
		$this->db->group_by('companies.id, doc.count');
		$this->db->join(
			'(	
				SELECT companies_users.company_id, COUNT(*) count
				FROM companies_users
				JOIN doctors_profiles ON doctors_profiles.user_id = companies_users.user_id
				GROUP BY companies_users.company_id
			) doc',
			'doc.company_id = companies.id'
		);
		$largest_hospital = $this->db->get('companies')->result_array();

		// Query number of booked physicians.
		$this->db->select('doctor_id');
		$this->db->group_by('appointments.doctor_id');
		$booked_physicians = $this->db->count_all_results('appointments');

		// Get latest users.
		$latest_users = $this->user->all(array(
			'ignore_status' => TRUE, // Both active and inactive users
			'order' => ['column' => 'id', 'dir' => 'desc'],
			'limit' => 3,
		));
	
		// Get latest hospitals.
		$this->load->model('hospitals/hospitals_model');
		$latest_hospitals = $this->hospitals_model->get_hospitals(array(
			'ignore_status' => TRUE, // Both active and inactive hospitals
			'order' => ['column' => 'id', 'dir' => 'desc'],
			'limit' => 3,
		));
		
		$this->data['latest_users'] = $latest_users;
		$this->data['latest_hospitals'] = $latest_hospitals;
		$this->data['active_users'] = $active_users;
		$this->data['inactive_users'] = $inactive_users;
		$this->data['total_users'] = $inactive_users + $active_users;
		$this->data['total_physicians'] = $total_physicians;
		$this->data['total_hospitals'] = $total_hospitals;
		$this->data['total_specialties'] = $total_specialties;
		$this->data['total_appointments'] = $total_appointments;
		$this->data['booked_physicians'] = $booked_physicians;
		$this->data['largest_hospital'] = empty($largest_hospital) ? [] : $largest_hospital[0];
		$this->load->view('admin/dashboard_view', $this->data);
	}

	private function time_elapsed_string($datetime, $full = false) {
		$this->load->helper('date');
		$datetime = unix_to_human($datetime);
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
			);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}

/* End of file Admin.php */
/* Location: ./application/modules/admin/controllers/Admin.php */