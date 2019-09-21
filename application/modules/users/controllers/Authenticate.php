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
		// User is logged in.
		if ($this->ion_auth->logged_in()) return true;

		// Also ignores redirects that point back to login page.
		if ($this->uri->segment(1) == 'login') return false;

		if ($redirect && !$this->ion_auth->is_admin()) {
			// Login redirect requested, remember current URL before redirect.
			$this->session->set_userdata('login_redirect', ($this->uri->segment(1) == 'admin') ? '':current_url());
			redirect('login');
		}
				
		return false;
	}
	
	function admin() 
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// Admin user is logged in.
			return true;
		} else {
			// redirect if user is not requesting login page.
			if ($this->uri->segment(2) !== 'login') {
				$this->session->set_userdata('login_redirect', ($this->uri->segment(1) !== 'admin') ? '':current_url());
				redirect('admin/login');
			}
		}
	}
}