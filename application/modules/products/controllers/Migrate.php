<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

	public function index()
	{
		$this->load->library('migration');
		
		if (ENVIRONMENT == 'production') {
			// Disable migration for production environments
			show_404();
			exit();
		}
		
		if ( ! $this->migration->version('600')) {
			show_error($this->migration->error_string());
		} else {
			// redirect('hospitals/migrate');
		}
	}
}

/* End of file Migrate.php */
/* Location: ./application/modules/users/controllers/Migrate.php */