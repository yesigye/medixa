<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Legal extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model(array('users/user'));
		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];
	}

	public function index()
	{
		redirect('legal/terms-of-service', 'refresh');
    }
    
	public function terms_of_service()
	{
        $this->data['terms_of_service'] = $this->app->config('terms_of_service');

		$this->load->view('public/legal/terms_of_service', $this->data);
    }
    
	public function privacy_policy()
	{
        $this->data['privacy_policy'] = $this->app->config('privacy_policy');

		$this->load->view('public/legal/privacy_policy', $this->data);
	}
}