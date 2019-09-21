<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MX_Controller {

	function __construct() 
    {
        parent::__construct();
		
        modules::run('users/authenticate/user');

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model([
			'users/user',
			'hospitals/hospitals_model',
			'hospitals/specialities_model',
		]);
		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];

		// Remember to bring user back here after login
		$this->session->set_userdata('login_redirect', current_url());
	}

	/**
	 * index - Landing page
	 * 
	 * @return response
	 */ 
	function index()
    {
		$specialities = $this->specialities_model->get_specialists();
		
		// Get random hospitals.
		$hospitals = $this->hospitals_model->get_hospitals(array(
			'limit' => 4,
			'order' => ['column' => 'id', 'dir' => 'RANDOM'],
		));

		// Form fields for quick registering of users
		$this->data['form_fields'] = [
			'email' => [
				'label' => lang('form_users_email'),
				'help-text' => 'We do not share your email address with anyone',
				'class' => 'form-control form-dark',
				'attr' => ['placeholder' => 'Enter your email address'],
				'col' => 'col-md-12'
			],
			'first_name' => [
				'label' => lang('form_users_fname'),
				'class' => 'form-control form-dark',
				'attr' => ['placeholder' => 'Enter your first name'],
				'col' => 'col-md-6'
			],
			'last_name' => [
				'label' => lang('form_users_lname'),
				'class' => 'form-control form-dark',
				'attr' => ['placeholder' => 'Enter your last name'],
				'col' => 'col-md-6'
			],
			'password' => [
				'type' => 'password',
				'label' => lang('form_users_password'),
				'class' => 'form-control form-dark',
				'attr' => ['placeholder' => 'Enter your password'],
				'col' => 'col-md-12'
			],
			'newsletter' => [
				'label' => 'Company newsletters',
				'help-text' => 'Yes, i want to stay informed with product updates, event information, special offers and more.',
				'type' => 'checkbox',
				'class' => 'form-control form-dark',
				'attr' => ['placeholder' => 'Enter your password'],
				'col' => 'col-md-12'
			],
		];
		
		$this->data['specialities'] = $specialities;
		$this->data['hospitals'] = $hospitals;
		$this->load->view('public/home_view', $this->data);
	}
}

/* End of file Welcome.php */
/* Location: ./application/controllers/Welcome.php */