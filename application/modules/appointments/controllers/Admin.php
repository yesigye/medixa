<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

        modules::run('users/authenticate/admin');

		$this->load->model('appointments_model');
		$this->load->library('app');
		$this->load->helper(['form', 'language']);
		$this->data = array();
	}

	public function appointments()
	{
		$this->load->view('admin/appointments_list', $this->data);
	}

	public function edit($id)
	{
		$appointment = $this->appointments_model->details($id);

		$this->data['appointment'] = $appointment;
		$this->load->view('admin/appointment_view', $this->data);
	}
}

/* End of file Admin.php */
/* Location: ./application/modules/appointment/controllers/Admin.php */