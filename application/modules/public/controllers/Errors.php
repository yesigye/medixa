<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends MX_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->helper('form');
	}

	/**
	 * page not found
	 */ 
	function _404()
	{
		$this->load->view('errors_view');
	}
}

/* End of file Errors.php */
/* Location: ./application/modules/public/controllers/Errors.php */