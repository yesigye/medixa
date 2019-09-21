<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate extends MX_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('ion_auth');
		$this->data = array();
	}
	
	/**
	 * checks for a logged in user.
	 *
	 * Sets a session variable "login_redirect" if no user is logged in.
	 * This variable contains the current url of the user.
	 * After login, the user will be redirected here.
	 *
	 * @return	array
	 */
	function user($redirect = false) {
		if ($this->ion_auth->logged_in()) {
			// User is logged in.
			return true;
		} else {
			// redirect if user is not requesting login page.
			if ($this->uri->segment(1) !== 'login') {
				$this->session->set_userdata('login_redirect', current_url());
				
				if ($redirect) redirect('login');
			}
		}
	}
	
	function admin() 
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// Admin user is logged in.
			return true;
		} else {
			// redirect if user is not requesting login page.
			if ($this->uri->segment(2) !== 'login') {
				$this->session->set_userdata('login_redirect', current_url());
				redirect('admin/login');
			}
		}
	}
}