<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends CI_Controller {

	function __construct() 
    {
        parent::__construct();

		$this->load->database();
		$this->load->library(array('ion_auth','form_validation', 'session'));

		$this->load->config('app');
		$this->load->model(array('search_model', 'healthcare_model', 'address_model'));

		// Store all page alerts
		$this->alert = null;
		// Stores data used by view pages.
		$this->data  = null;
		$this->data['app']  = $this->config->item('app');
		$this->data['owner'] = $this->ion_auth->users('admin')->row();

		// Check if a non admin user is logged in.
		if ( $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			$this->data['user'] = $this->ion_auth->user()->result()[0];
		}
		else
		{
			$this->data['user'] = NULL;
		}
	}

	/**
	 * index
	 */ 
	function index()
    {
		$this->data['title'] = $this->data['app']['name'].' | Support';
    	
		$items_per_page = $this->data['app']['pagination_limit'];

		if ($this->input->post('search'))
		{
			$this->session->set_userdata('search_post', $_POST);
		}

		$this->data['results'] = $this->search_model->query($this->input->get('per_page') ? $this->input->get('per_page') : 1, $items_per_page);

		// Add some pagination to this page.
		$this->load->library('pagination');

		// Construct Url
		if ($this->input->get('q'))
			$url = site_url('search?q='.$this->input->get('q'));
		else
			$url = site_url('search');


		$config['base_url'] = $url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $items_per_page;
		$config['total_rows'] = $this->data['results']->doctors_count;
		$config['num_links']  = round($this->data['results']->doctors_count / $config['per_page']);
		$config['use_page_numbers']  = TRUE;
		$config['full_tag_open']  = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open']   = '<li>';
		$config['num_tag_close']  = '</li>';
		$config['cur_tag_open']   = '<li class="active"><a>';
		$config['cur_tag_close']  = '</a></li>';
		$config['prev_tag_open']  = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] 	  = 'prev';
		$config['next_link'] 	  = 'next';
		$config['next_tag_open']  = '<li class="next">';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$this->data['address_dropdowns'] = $this->load->address_model->generate_address_dropdowns('col-md-12');
		$this->data['types'] = $this->healthcare_model->get_types();
		$this->data['specialities'] = $this->healthcare_model->get_specialists();

		$this->load->view('public/search_results_view', $this->data);
	}

	function send_mail()
	{
		$this->load->library('email');

		$this->email->from('your@example.com', 'Your Name');
		$this->email->to('someone@example.com');
		$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		$this->email->send();
	}
}

/* End of file Support.php */
/* Location: ./application/controllers/Support.php */