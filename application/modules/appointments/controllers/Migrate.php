<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

	public function index()
	{
		$this->load->library('migration');
		
        // Disable migration for production environments
		if (ENVIRONMENT == 'production') show_404();
		
		if ( ! $this->migration->version(500)) {
			show_error($this->migration->error_string());
		} else {
			redirect('languages/migrate');
		}
	}
}

/* End of file Migrate.php */
/* Location: ./application/modules/hospitals/controllers/Migrate.php */