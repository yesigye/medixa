<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

	public function index()
	{
		$this->load->library('migration');

		if ( ! $this->migration->version(201)) {
			show_error($this->migration->error_string());
		} else {
			redirect('users/migrate');
		}
	}
}

/* End of file Migrate.php */
/* Location: ./application/modules/locations/controllers/Migrate.php */