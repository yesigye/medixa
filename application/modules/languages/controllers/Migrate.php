<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

	public function index()
	{
		$this->load->library('migration');

		if ( ! $this->migration->version(700)) {
			show_error($this->migration->error_string());
		} else {
			redirect('admin');
		}
	}
}

/* End of file Migrate.php */
/* Location: ./application/modules/languages/controllers/Migrate.php */