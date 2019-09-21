<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get extends MX_Controller
{
	
	function __construct() 
	{
		parent::__construct();

		$this->load->database();

		$this->load->model('user');
		$this->load->library('users/ion_auth');
	}

	
	/**
	 * View a list of users and perform some
	 * CRUD functions through POST
	 *
	 * @return response
	 **/
	function users()
	{
		if (isset($_POST))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('selected[]', 'Selected', 'required');
			$this->form_validation->set_message('required', 'You need to select users first.');
		}

		// Activate multiple selected users
		if ($this->input->post('activate_selected'))
		{
			if ($this->form_validation->run() == true)
			{
				if ($this->user->activate_multiple($this->input->post('selected')))
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'success',
						'message' => 'User(s) have been activated'
					));
				}
				else
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'danger',
						'message' => $this->user->error_message
					));
				}
				redirect(current_url());
			}
		}

		// Deactivate multiple selected users
		if ($this->input->post('deactivate_selected'))
		{
			if ($this->form_validation->run() == true)
			{
				if ($this->user->deactivate_multiple($this->input->post('selected')))
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'success',
						'message' => 'User(s) have been deactivated'
					));
				}
				else
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'danger',
						'message' => $this->user->error_message
					));
				}
				redirect(current_url());
			}
		}

		// Delete multiple selected users
		if ($this->input->post('delete_selected'))
		{
			if ($this->form_validation->run() == true)
			{
				if ($this->user->delete_multiple($this->input->post('selected')))
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'success',
						'message' => 'User(s) have been deleted'
					));
				}
				else
				{
					$this->session->set_flashdata('alert', array(
						'type' => 'danger',
						'message' => $this->user->error_message
					));
				}
				redirect(current_url());
			}
		}

		// Get users.
		$this->load->library('users');

		$users = $this->users->all(array(
			'ignore_status' => TRUE // Both active and inactive users
		));

		$this->data['users'] = $users['rows'];	
		$this->data['users_total'] = $users['total'];	
		$this->data['pagination'] = $users['pagination'];
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('admin/users_view', $this->data);
	}

	/**
	 * Return a user
	 *
	 * @return array
	 **/
	function user($user_id)
	{
		return $this->user->details($user_id);
	}

	/**
	 * Return admin
	 *
	 * @return array
	 **/
	function admin()
	{
		return $this->user->admin();
	}

	/**
	 * Return current user
	 *
	 * @return array
	 **/
	function current()
	{
		return $this->user->current();
	}
}

/* End of file Get.php */
/* Location: ./application/modules/users/controllers/Get.php */