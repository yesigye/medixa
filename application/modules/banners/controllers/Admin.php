<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller {
	
	private $error_message;

	function __construct() 
	{
		parent::__construct();

		// Get admin access
		modules::run('admin/admin/access');

		$this->data = array();

		// Load the model
		$this->load->model('banners_model');
	}

	/**
	 * Set error message
	 *
	 * @param string str error message
	 **/
	function set_error($str)
	{
		$this->error_message = $str;
	}

	/**
	 * Get error message
	 *
	 * @return string str error message
	 **/
	function get_error($str)
	{
		return $this->error_message;
	}

	/**
	 * View and edit user banners
	 *
	 * @param string $id banner id
	 *
	 * @return response
	 **/
	public function banners()
	{
		$this->load->library('form_validation');

		if ($this->input->post('delete_selected'))
		{
			$this->form_validation->set_rules('selected[]', 'above', 'required');

			if ($this->form_validation->run())
			{
				$this->banners_model->delete_multiple($this->input->post('selected[]'));
				redirect(current_url());
			}
		}

		if ($this->input->post('update_banner'))
		{
			$this->form_validation->set_rules('name', 'above', 'required');
			$this->form_validation->set_rules('body', 'above', 'required');

			if ($this->form_validation->run())
			{
				$response = $this->pages_model->update_page($id);
				redirect(current_url());
			}
		}

		$this->data['banners'] = $this->banners_model->get_banners();
		
		$this->load->view('banners_view', $this->data);
	}

	/**
	 * Add a new banner
	 *
	 * @return response
	 **/
	public function add()
	{
		$this->load->model('banners_model');

		$this->load->library('form_validation');

		if ($this->input->post('insert_banner'))
		{
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|date_not_passed');
			$this->form_validation->set_rules('end_date', 'End Date', 'required|date_not_passed');

			if ($this->form_validation->run())
			{
				$is_banner_inserted = $this->banners_model->insert_banner();

				if ($this->input->post('add_another') OR !$is_banner_inserted)
				{
					// Display insert banner page if user indicated so
					// or if the banner was not added successfully
					redirect(current_url());
				}
				else
				{
					redirect('admin/banners');
				}
			}
		}
		
		$this->load->view('banner_insert_view', $this->data);
	}

	/**
	 * Update a banner
	 *
	 * @param int $id banner identifier
	 *
	 * @return response
	 **/
	public function update($id)
	{
		$this->load->model('banners_model');

		$this->load->library('form_validation');

		if ($this->input->post('update_banner'))
		{
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|date_not_passed');
			$this->form_validation->set_rules('end_date', 'End Date', 'required|date_not_passed');

			if ($this->form_validation->run())
			{
				$this->banners_model->update_banner($id);
				redirect(current_url());
			}
		}

		$this->data['banner'] = $this->banners_model->get_banner_details($id);
		
		$this->load->view('banner_update_view', $this->data);
	}
}

/* End of file Mail.php */
/* Location: ./application/modules/notify/controllers/Mail.php */