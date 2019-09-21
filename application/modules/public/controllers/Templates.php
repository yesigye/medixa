<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

		$this->load->database();
		$this->load->helper('form');
		
		// Stores data used by view pages.
		$this->data  = null;
		$this->data['owner'] = modules::run('users/get/admin');
		$this->data['user'] = modules::run('users/get/current');
	}

	// Serve header template.
	public function header($options = array())
	{
		// Define default data
		if ( ! isset($this->data['title'])) $this->data['title'] = '';
		if ( ! isset($this->data['link'])) $this->data['link'] = false;
		if ( ! isset($this->data['sub_link'])) $this->data['sub_link'] = false;
		if ( ! isset($this->data['import_css'])) $this->data['import_css'] = array();
		if ( ! isset($this->data['breadcrumbs'])) $this->data['breadcrumbs'] = array();

		$this->data['user'] = $this->user->current();
		$this->data['alert'] = modules::run('notify/alerts/get_message_object', 'public');

		while ($value = current($options))
		{
			$this->data[key($options)] = $value;
			next($options); 
		}
		$this->load->view('templates/header', $this->data);
	}

	// Serve header template.
	public function footer($options = array())
	{
		while ($value = current($options))
		{
			$this->data[key($options)] = $value;
			next($options); 
		}
		if (!isset($data['scripts'])) $data['scripts'] = array();
		$this->load->view('templates/footer', $this->data);
	}

	// Serve doctors template.
	public function doctors($options = array())
	{
		while ($value = current($options))
		{
			$this->data[key($options)] = $value;
			next($options); 
		}
		$this->load->view('templates/doctors_tiles_view', $this->data);
	}

	// Serve doctors template.
	public function hospitals($options = array())
	{
		while ($value = current($options))
		{
			$this->data[key($options)] = $value;
			next($options); 
		}
		$this->load->view('templates/hospitals_tiles_view', $this->data);
	}
}
