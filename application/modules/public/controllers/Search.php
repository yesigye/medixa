<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MX_Controller {

	function __construct() 
    {
        parent::__construct();
		
        modules::run('users/authenticate/user');

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model([
			'users/user',
			'hospitals/specialities_model',
		]);
		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];

		// Remember to bring user back here after login
		$this->session->set_userdata('login_redirect', current_url());
	}

	/**
	 * Search page
	 * 
	 * @return response
	 */ 
	function index()
    {
		$this->load->model([
			'hospitals/physicians_model',
			'hospitals/specialities_model'
			]);
		$page_limit = $this->app->pageLimit;

		if($this->input->get('q') === $this->session->userdata('search_query')) {
			// Query is in memory. Use Cache
			$options['cache'] = true;
		} else {
			// Remove cache
			$this->db->cache_delete('search', 'index');
			$this->session->set_userdata('search_query', $this->input->get('q'));
		}
		
		$options['limit'] = $page_limit;
		if ($this->input->get('spec')) $options['speciality'] = $this->input->get('spec');
		if ($this->input->get('mobile')) $options['mobile'] = $this->input->get('mobile');
		if ($this->input->get('hospital')) $options['hospital'] = $this->input->get('hospital');

		$options['search'] = $this->session->userdata('search_query');
		
		$doc_page_num = $this->input->get('per_page');
		
		if ($doc_page_num) {
			$options['start'] = ( ($doc_page_num*$options['limit'])-$options['limit'] ) + 1;
		} else {
			$options['start'] = 0;
		}

		// $physicians = $this->physicians_model->getAll($options);
		$physicians = $this->physicians_model->search($this->session->userdata('search_query'), $options);

		$subTotal = $this->physicians_model->count;
		
		if ($doc_page_num) {
			$docResultStart = (($doc_page_num - 1) * $page_limit) + 1;
			$docResultEnd   = ($docResultStart + count($physicians)) - 1;
		} else {
			$docResultStart = 1;
			$docResultEnd = ($page_limit < count($physicians)) ? $page_limit : count($physicians);
		}
		
		// Add some pagination to this page.
		$this->load->library('pagination');
		
		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];
		
		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $subTotal;
		$config['use_doc_page_numbers'] = TRUE;
		if (isset($options['uri_segment'])) {
			$config['query_string_segment'] = $options['uri_segment'];
		}
		// $config['num_links']  = round($config['total_rows'] / $config['per_page']);
		$this->pagination->initialize($config);

		$this->data['doctors'] = $physicians;
		$this->data['doc_total'] = $this->physicians_model->count;
		$this->data['resultTotal'] = $subTotal;
		$this->data['docResultStart'] = $docResultStart;
		$this->data['docResultEnd'] = $docResultEnd;
		$this->data['docs_pagination'] = $this->pagination->create_links();

		$this->_findHospitals();

		$this->load->view('search_view', $this->data);
	}

	
	/**
	 * Search for hospitals
	 * 
	 * @return response
	 */ 
	private function _findHospitals()
    {
		$this->load->model([
			'hospitals/hospitals_model',
			]);
		$page_limit = $this->app->pageLimit;

		if($this->input->get('q') === $this->session->userdata('search_query')) {
			// Query is in memory. Use Cache
			$options['cache'] = true;
		} else {
			$this->session->set_userdata('search_query', $this->input->get('q'));
		}
		
		$options['limit'] = $page_limit;
		if ($this->input->get('spec')) $options['speciality'] = $this->input->get('spec');
		if ($this->input->get('mobile')) $options['mobile'] = $this->input->get('mobile');
		if ($this->input->get('hospital')) $options['hospital'] = $this->input->get('hospital');

		$options['search'] = $this->session->userdata('search_query');
		
		$doc_page_num = $this->input->get('per_page');
		
		if ($doc_page_num) {
			$options['start'] = ( ($doc_page_num*$options['limit'])-$options['limit'] ) + 1;
		} else {
			$options['start'] = 0;
		}

		// $physicians = $this->physicians_model->getAll($options);
		$hospitals = $this->hospitals_model->search($this->session->userdata('search_query'), $options);
		$hospSubTotal = count($hospitals);
		$hospGrandTotal = $this->hospitals_model->count;
		
		if ($doc_page_num) {
			$hospResultStart = (($doc_page_num - 1) * $page_limit) + 1;
			$hospResultEnd   = ($docResultStart + $hospSubTotal) - 1;
		} else {
			$hospResultStart = 1;
			$hospResultEnd = ($page_limit < $hospSubTotal) ? $page_limit : $hospSubTotal;
		}
		
		// Add some pagination to this page.
		$this->load->library('pagination');
		
		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];
		
		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $hospSubTotal;
		$config['use_doc_page_numbers'] = TRUE;
		if (isset($options['uri_segment'])) {
			$config['query_string_segment'] = $options['uri_segment'];
		}
		// $config['num_links']  = round($config['total_rows'] / $config['per_page']);
		$this->pagination->initialize($config);

		$this->data['hospitals'] = $hospitals;
		$this->data['hosp_total'] = $hospGrandTotal;
		$this->data['hospResultTotal'] = $hospSubTotal;
		$this->data['hospResultStart'] = $hospResultStart;
		$this->data['hospResultEnd'] = $hospResultEnd;
	}
}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */