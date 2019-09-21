<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospitals extends MX_Controller {

	function __construct() 
    {
        parent::__construct();
		
        modules::run('users/authenticate/user');

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model([
			'users/user',
			'hospitals/hospitals_model',
			'hospitals/types_model',
			'hospitals/physicians_model',
			'hospitals/specialities_model',
		]);
		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];

		// Remember to bring user back here after login
		$this->session->set_userdata('login_redirect', current_url());
	}

	/**
	 * Hospitals landing page
	 * 
	 * @return response
	 */ 
	function index()
    {
		$this->options = [];
		
		if ($this->input->get('addr')) $this->options['address_id'] = $this->input->get('addr');
		if ($this->input->get('spec')) $this->options['spec'] = $this->input->get('spec');
		if ($this->input->get('type')) $this->options['type'] = $this->input->get('type');
		if ($this->input->get('fac')) $this->options['fac'] = $this->input->get('fac');
		if ($this->input->get('az')) $this->options['az'] = $this->input->get('az');


		/* Toggling cards types (tiles or list) */
		$linkToggleTile = site_url('hospitals?'.($this->input->get('toggleCards') ? preg_replace('/(^|&)toggleCards=[^&]*/', '&toggleCards=tile', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&toggleCards=tile'));
		$linkToggleList = site_url('hospitals?'.($this->input->get('toggleCards') ? preg_replace('/(^|&)toggleCards=[^&]*/', '&toggleCards=list', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&toggleCards=list'));

		if ($this->input->get('toggleCards')) {
			$this->session->set_userdata('cardsType', $this->input->get('toggleCards'));
			// Remove the toggle query string.
			$_SERVER['QUERY_STRING'] = preg_replace('/(^|&)toggleCards=[^&]*/', '', $_SERVER['QUERY_STRING']);
		}
		
		// Recommended doctors
		$doctors = $this->physicians_model->getAll(array(
			'limit' => 6,
			'order' => ['column' => 'id', 'dir' => 'RANDOM'],
		));

		$this->_set_filter_options();

		$this->data['linkToggleTile'] = $linkToggleTile;
		$this->data['linkToggleList'] = $linkToggleList;
		$this->data['doctors'] = $doctors;
		
		// Load corresponding view type
		($this->session->userdata('viewType') == 'map') ? $this->_load_map_view() : $this->_load_list_view();
	}
	
	private function _set_filter_options($isFiltered = false) {
		$specialties = $this->specialities_model->get_specialists();
		$facilities = $this->types_model->facilities();
		$types = $this->types_model->get_types();
		
		// Construct Url
		$page_url = current_url().'?'.$_SERVER['QUERY_STRING'];
		
		/* Toggling cards types (tiles or list) */
		$linkToggleTile = site_url($this->uri->segment(1).'?'.($this->input->get('toggleCards') ? preg_replace('/(^|&)toggleCards=[^&]*/', '&toggleCards=tile', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&toggleCards=tile'));
		$linkToggleList = site_url($this->uri->segment(1).'?'.($this->input->get('toggleCards') ? preg_replace('/(^|&)toggleCards=[^&]*/', '&toggleCards=list', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&toggleCards=list'));
		
		if ($this->input->get('toggleCards')) {
			$this->session->set_userdata('docCardsType', $this->input->get('toggleCards'));
			// Remove the toggle query string.
			$_SERVER['QUERY_STRING'] = preg_replace('/(^|&)toggleCards=[^&]*/', '', $_SERVER['QUERY_STRING']);
		}
		
		if ($this->input->get('viewType')) $this->session->set_userdata('viewType', $this->input->get('viewType'));
		$viewTypeOpp = ['map'=>'list', 'list'=>'map'];
		$viewType = $this->session->userdata('viewType') ? $this->session->userdata('viewType') : 'map';
		$viewTypeLink = site_url($this->uri->segment(1).'?'.($this->input->get('viewType') ? preg_replace('/(^|&)viewType=[^&]*/', '&viewType='.$viewTypeOpp[$viewType], $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&viewType='.$viewTypeOpp[$viewType]));
		// Remove the toggle query string.
		$_SERVER['QUERY_STRING'] = preg_replace('/(^|&)viewType=[^&]*/', '', $_SERVER['QUERY_STRING']);
		
		// Remove pagination uri from query string.
		$filter_uri = preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']);
		
		// Initialize query filters
		$isFiltered = false;
		$filter_options = [];
		$default_select_value = '';
		$filter_options['type']['active'] = $default_select_value;
		$filter_options['speciality']['active'] = $default_select_value;
		$filter_options['location']['active'] = '';
		$filter_options['facilities']['active'] = $default_select_value;
		$filter_options['type']['options'] = [];
		$filter_options['speciality']['options'] = [];
		$filter_options['facilities']['options'] = [];
		$filter_options['type']['reset'] = site_url('hospitals?'.($this->input->get('type') ? preg_replace('/(^|&)type=[^&]*/', '', $filter_uri) : $filter_uri));
		$filter_options['speciality']['reset'] = site_url('hospitals?'.($this->input->get('spec') ? preg_replace('/(^|&)spec=[^&]*/', '', $filter_uri) : $filter_uri));
		$filter_options['facilities']['reset'] = site_url('hospitals?'.($this->input->get('fac') ? preg_replace('/(^|&)fac=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING']));
		
		/* Define specialities filters. */
		foreach ($specialties as $key => $speciality) {
			$f['name'] = $speciality['name'];
			$f['link'] = site_url('hospitals?'.($this->input->get('spec') ? preg_replace('/(^|&)spec=[^&]*/', '&spec='.$speciality['code'], $filter_uri) : $filter_uri.'&spec='.$speciality['code']));
			$f['isActive'] = ($this->input->get('spec') == $speciality['code']) ? true : false;
			if ($f['isActive']) {
				$filter_options['speciality']['active'] = $f['name'];
				$isFiltered = true;
			}
			// Push specilialies filter data.
			array_push($filter_options['speciality']['options'], $f);
		}

		/* Define type filters. */
		foreach ($types as $key => $row) {
			$f['name'] = $row['name'];
			$f['isActive'] = ($this->input->get('type') === $row['code']) ? true : false;
			$f['link'] = site_url('hospitals?'.($this->input->get('type') ? preg_replace('/(^|&)type=[^&]*/', '&type='.$row['code'], $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&type='.$row['code']));
			
			if ($f['isActive']) {
				// Set the active link for type filters
				$filter_options['type']['active'] = $f['name'];
				$isFiltered = true;
			}
			array_push($filter_options['type']['options'], $f);	
		}
		
		/* Define facility filters */
		foreach ($facilities as $key => $facility) {
			$f['name'] = $facility['name'];
			$f['isActive'] = ($this->input->get('fac') === $facility['code']) ? true : false;
			$f['link'] = site_url('hospitals?'.($this->input->get('fac') ? preg_replace('/(^|&)fac=[^&]*/', '&fac='.$facility['code'], $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&fac='.$facility['code']));
			
			if ($f['isActive']) {
				// Set the active link for type filters
				$filter_options['facilities']['active'] = $f['name'];
				$isFiltered = true;
			}
			array_push($filter_options['facilities']['options'], $f);
		}
		
		$this->load->library('locations/forms');
		$this->load->model(['hospitals/tree_model', 'locations/locations_model']);
		$tiers = $this->locations_model->tiers();
		$location_fields = [];
		foreach ($tiers as $key => $tier) {
			$locations = $this->locations_model->locations($tier['id']);
			$location_options[null] = $tiers[$key]['name'];
			if($key == 0) {
				foreach ($locations as $l) $location_options[$l['code']] = $l['name'];
			}
			
			array_push($location_fields, [
				'name' => 'locType_'.$tiers[$key]['name'],
				'code' => $tiers[$key]['code'],
				'label' => $tiers[$key]['name'],
				'options' => $location_options,
			]);
		}
			
		$typeIds = [];
		foreach ($types as $key => $value) array_push($typeIds, $value['id']);
		$facilities = $this->types_model->facilities($typeIds, ['inherit'=>true]);
		
		$this->data['filters'] = $filter_options;
		$this->data['isFiltered'] = $isFiltered;
		$this->data['isFiltered']  = $isFiltered;		
		$this->data['filter_options'] = $filter_options;
		$this->data['locationTypes'] = $tiers;
		$this->data['location_fields'] = $location_fields;
		$this->data['linkToggleContainer'] = $viewTypeLink;
		$this->data['viewType'] = $viewType;
		$this->data['page_url'] = $page_url;
	}
	
	private function _load_map_view() {
		$page_limit = intval($this->app->config('pagination_limit'));
		$this->options['limit'] = $page_limit;
		$this->options['start'] = $this->input->get('per_page') ? ($this->input->get('per_page')-1) : 0;
		$hospitals = $this->hospitals_model->get_hospitals($this->options);

		$this->data['hospitals'] = $hospitals;
		$this->data['content'] = $this->load->view('public/hospitals/map_view', $this->data, true);
		$this->load->view('public/hospitals/container', $this->data);
	}
	
	private function _load_list_view() {
		$page_limit = intval($this->app->config('pagination_limit'));
		$this->options['limit'] = $page_limit;
		$this->options['start'] = $this->input->get('per_page') ? ($this->input->get('per_page')-1) : 0;
		$hospitals = $this->hospitals_model->get_hospitals($this->options);
		$subTotal = $this->hospitals_model->count;
		/* Calculate start & end points of results */
		$page_num = $this->input->get('per_page');
		if ($page_num) {
			$resultStart = (($page_num - 1) * $page_limit) + 1;
			$resultEnd   = ($resultStart + count($hospitals)) - 1;
		} else {
			$resultStart = 1;
			$resultEnd = ($page_limit < count($hospitals)) ? $page_limit : count($hospitals);
		}
		
		// Add some pagination to this page.
		$this->load->library('pagination');
		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];
		
		$config['base_url'] = current_url().($page_url ? '?'.$page_url : '');
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $subTotal;
		$config['use_page_numbers']  = TRUE;
		if (isset($this->options['uri_segment'])) {
			$config['query_string_segment'] = $this->options['uri_segment'];
		}
		
		$this->pagination->initialize($config);
		
		$this->data['hospitals'] = $hospitals;
		$this->data['resultTotal'] = $subTotal;
		$this->data['resultStart'] = $resultStart;
		$this->data['resultEnd'] = $resultEnd;
		$this->data['content'] = $this->load->view('public/hospitals/list_view', $this->data, true);
		$this->load->view('public/hospitals/container', $this->data);
	}
	
	public function details($slug)
	{
		$this->load->library('form_validation');
		
		$this->load->helper('text');
		
		$this->load->model([
			'hospitals/physicians_model',
			'hospitals/hospitals_model',
			'hospitals/types_model'
			]);
	
			// Details of this hospital
		$hospital = $this->hospitals_model->details(array(
			'slug' => $slug,
		));
		
		// Doctors belonging to this hospital
		$doctors = $this->physicians_model->getAll(array(
			'limit' => 12,
			'in_hospital' => $hospital['id']
		));
		
		// Other hospitals except this one.
		$moreHospitals = $this->hospitals_model->get_hospitals(array(
			'limit' => 6,
			'out_hospital' => $hospital['id'],
		));
	
		// More information on hospital type, specialities and facilities.
		$types = $this->types_model->inHospitals($hospital['id']);
		$this->data['facilitiesList'] = $this->types_model->facilities($types, ['inherit'=>true]);
		$this->data['facilities'] = $this->types_model->facilitiesInHospital($hospital['id']);
		$this->data['specialities'] = $this->hospitals_model->get_hospital_specialities($hospital['id']);
		$this->data['images'] = $this->hospitals_model->get_hospital_images($hospital['id'], 4);
		$this->data['hospitals'] = $moreHospitals;
		$this->data['hospital'] = $hospital;
		$this->data['doctors'] = $doctors;
	
		$this->load->view('hospital_details_view', $this->data);
	}
}

/* End of file Hospitals.php */
/* Location: ./application/modules/public/controllers/Hospitals.php */