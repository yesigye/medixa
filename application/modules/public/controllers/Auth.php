<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library(['app', 'users/ion_auth']);

		// Check if an admin user is logged in.
		if ($this->ion_auth->is_admin()) {
			redirect();
		} else {
			// Stores data used by view pages.
			$this->data = null;
			
			$this->load->library(array('session', 'form_validation', 'ion_auth'));
			$this->load->model(array('users/users_model'));

			$this->load->config('app');
			$this->data['app']   = $this->config->item('app');
			$this->data['owner'] = $this->users_model->admin();

			// Check if a non admin user is logged in.
			if ( $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin()) {
				$this->data['user']  = $this->users_model->current();
			} else {
				$this->data['user'] = NULL;
			}
		}
	}

	// log the user in
	public function login()
	{
		if ($this->ion_auth->logged_in() || $this->ion_auth->is_admin()) {
			// Logged in users or admins get sent to home page
			redirect();
		}

		//validate form input
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember, 'username'))
			{
				//The login is successful

				if ($this->ion_auth->is_admin())
				{
					// The user is an admin!
					$this->ion_auth->logout(); // Log the admin out
					$this->data['message'] = 'You cannot log in here';

					// Display login page.
					$this->load->view('auth/login_view', $this->data);
				}
				else
				{
					$this->load->model('users_model');
					$user = $this->users_model->current();

					// Welcome user by name.
					$this->session->set_flashdata('alert',
						array('type' => 'success', 'message' => 'Hi, '.$user->username.'. welcome back!')
					);

					if ($this->ion_auth->in_group('vendors') OR $this->ion_auth->in_group('partners'))
					{
						// redirect them back to the appropriate page
						redirect(($this->session->userdata('login_redirect')) ? $this->session->userdata('login_redirect') : 'user_dashboard');
					}
					else
					{
						// redirect them back to the appropriate page
						redirect(($this->session->userdata('login_redirect')) ? $this->session->userdata('login_redirect') : 'appointments');
					}
					
				}
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('alert', array('type' => 'danger', 'message' => $this->ion_auth->errors()));
				// use redirects instead of loading views for compatibility with MY_Controller libraries
				redirect('auth/login', 'refresh');
			}
		} else {
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = validation_errors();

			$this->load->view('auth/login_view', $this->data);
		}
	}

	// log the user out
	public function logout()
	{
		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('alert', array('type' => 'success', 'message' => $this->ion_auth->messages()));
		redirect('auth/login', 'refresh');
	}
}

/* End of file Auth.php */
/* Location: ./application/modules/public/controllers/Auth.php */