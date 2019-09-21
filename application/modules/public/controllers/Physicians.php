<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Physicians extends MX_Controller {

    function __construct() 
    {
        parent::__construct();
		
        modules::run('users/authenticate/user');

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model(array('users/user'));
		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];

		// Remember to bring user back here after login
		$this->session->set_userdata('login_redirect', current_url());
	}

	public function index()
	{
		$this->load->model([
			'hospitals/physicians_model',
			'hospitals/specialities_model'
			]);
		$page_limit = $this->app->pageLimit;
		
		$options['limit'] = $page_limit;
		if ($this->input->get('spec')) $options['speciality'] = $this->input->get('spec');
		if ($this->input->get('mobile')) $options['mobile'] = $this->input->get('mobile');
		if ($this->input->get('hospital')) $options['hospital'] = $this->input->get('hospital');

		if (!isset($options['search'])) {

			if ($this->input->post('search')) {
				redirect(current_url().($_SERVER['QUERY_STRING'].($_SERVER['QUERY_STRING'] ? '&q=' : '?q=').$this->input->post('q')));
			}
			
			if ($this->input->get('q')) $options['search'] = $this->input->get('q');
		}
		
		$page_num = $this->input->get('per_page');
		
		if ($page_num) {
			$options['start'] = ( ($page_num*$options['limit'])-$options['limit'] ) + 1;
		} else {
			$options['start'] = 0;
		}

		$physicians = $this->physicians_model->getAll($options);
		$subTotal = $this->physicians_model->count;
		
		if ($page_num) {
			$resultStart = (($page_num - 1) * $page_limit) + 1;
			$resultEnd   = ($resultStart + count($physicians)) - 1;
		} else {
			$resultStart = 1;
			$resultEnd = ($page_limit < count($physicians)) ? $page_limit : count($physicians);
		}
		
		// Add some pagination to this page.
		$this->load->library('pagination');
		
		// Construct Url
		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];
		
		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $page_limit;
		$config['total_rows'] = $subTotal;
		$config['use_page_numbers'] = TRUE;
		if (isset($options['uri_segment'])) {
			$config['query_string_segment'] = $options['uri_segment'];
		}
		// $config['num_links']  = round($config['total_rows'] / $config['per_page']);
		$this->pagination->initialize($config);

		$specialities = $this->specialities_model->get_specialists();

		/* Toggling cards types (tiles or list) */
		$linkToggleTile = site_url($this->uri->segment(1).'?'.($this->input->get('toggleCards') ? preg_replace('/(^|&)toggleCards=[^&]*/', '&toggleCards=tile', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&toggleCards=tile'));
		$linkToggleList = site_url($this->uri->segment(1).'?'.($this->input->get('toggleCards') ? preg_replace('/(^|&)toggleCards=[^&]*/', '&toggleCards=list', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&toggleCards=list'));

		$this->session->set_userdata('docCardsType', 'tile');

		if ($this->input->get('toggleCards')) {
			$this->session->set_userdata('docCardsType', $this->input->get('toggleCards'));
			// Remove the toggle query string.
			$_SERVER['QUERY_STRING'] = preg_replace('/(^|&)toggleCards=[^&]*/', '', $_SERVER['QUERY_STRING']);
		}	

		// Filtering options
		$isFiltered = false;
		// Remove pagination uri from query string.
		$filterUri = preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']);
		$fliterOptions['speciality']['options'] = [];
		$fliterOptions['speciality']['reset']   = site_url('physicians?'.($this->input->get('spec') ? preg_replace('/(^|&)spec=[^&]*/', '', $filterUri) : $filterUri));
		$fliterOptions['speciality']['active']  = 'All Specialities';

		array_push($fliterOptions['speciality']['options'], [
			'name' => 'All Specialities',
			'isActive' => $this->input->get('spec') ? false : true,
			'link' => $fliterOptions['speciality']['reset'],
		]);
		
		foreach ($specialities as $key => $speciality) {
			$f['name'] = $speciality['name'];
			$f['link'] = site_url('physicians?'.($this->input->get('spec') ? preg_replace('/(^|&)spec=[^&]*/', '&spec='.$speciality['code'], $filterUri) : $filterUri.'&spec='.$speciality['code']));
			$f['isActive'] = ($this->input->get('spec') == $speciality['code']) ? true : false;
			if ($f['isActive']) {
				$fliterOptions['speciality']['active'] = $f['name'];
				$isFiltered = true;
			}
			// Push specilialies filter data.
			array_push($fliterOptions['speciality']['options'], $f);
		}

		$this->data['cardsType'] = $this->session->userdata('docCardsType');;
		$this->data['linkToggleTile'] = $linkToggleTile;
		$this->data['linkToggleList'] = $linkToggleList;
		$this->data['doctors'] = $physicians;
		$this->data['resultTotal'] = $subTotal;
		$this->data['resultStart'] = $resultStart;
		$this->data['resultEnd'] = $resultEnd;
		$this->data['specialities']  = $specialities;
		$this->data['fliterOptions'] = $fliterOptions;
		$this->data['isFiltered']  = $isFiltered;
		$this->data['filterURI']  = $filterUri;
		
		$this->load->view('physicians_view', $this->data);
	}
	
	public function details($reg_no)
	{
		$this->load->model([
			'hospitals/physicians_model',
			'appointments/appointments_model'
		]);
		// We use a variable other that "user" because
		// the global "user" is already being used for currently signed in user.
		$doctor = $this->physicians_model->full_details($reg_no, true);

		// 404 for inactive doctors
		if ((int)$doctor['active'] !== 1) show_404();

		if ($this->input->post('book_appointment')) {
			$this->load->library('form_validation');

			// Set validate rules.
			$this->form_validation->set_rules('book_date', 'Date', 'required|valid_date|date_not_passed');
			$this->form_validation->set_rules('book_message', 'Message', 'required');
			// Run form validation.
			if ($this->form_validation->run()) {
				// Record appointment in database.
				$this->load->model('appointments/appointments_model');
				$save = $this->appointments_model->add(array(
					'user_id' => $doctor['id'],
					'date' => $this->input->post('book_date'),
					'doctor_id' => $doctor['id'],
					'message' => $this->input->post('book_message'),
				));
				if ($save) {
					// Load email template as string.
					$message = $this->load->view('public/email/appointment.mail.php', array(
						'date' => $this->input->post('book_date'),
						'message' => $this->input->post('book_message'),
						'recepient' => $doctor['first_name']
					), TRUE);
					// Define email parameters
					$this->load->library('email');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);

					$this->email->clear();
					$this->email->from($this->app->no_reply);
					$this->email->to($doctor['email']);
					$this->email->reply_to($this->data['user']['email']);
					$this->email->subject('Request for appointment');
					$this->email->message($message, true);
					
					// Attempt to send email to the physician
					if ($this->email->send()) {
						// Email was sent and appointment was added.
						$this->app->setAlert('An email has been sent to '.$doctor['first_name'].' '.$doctor['last_name']);
					} else {
						// Email not send. But appointment was added.
						$this->app->setAlert('Your appointment has been made');
					}
					redirect(current_url());
				} else{
					$this->app->setAlert($this->appointments_model->error_message(), 'error');
				}
			}
		}

		$this->data['appointment_form'] =  array(
			'book_type' => array(
				'label' => '',
				'help-text' => 'Choose the type of appointment',
				'attr' => ['placeholder' => 'Message to physician'],
				'type' => 'select',
				'options' => ['call' => 'Consult Online', 'visit' => 'Physical meetup'],
				'selected' => []
			),
			'book_date' => array(
				'class' => 'form-control datepicker',
				'attr' => ['placeholder' => 'Date',
						   'help_text' => 'Set the date of your appointment.'],
			),
			'book_message' => array(
				'attr' => ['placeholder' => 'Message to physician'],
				'type' => 'textarea',
			),
		);

		$othersLimit = 6;
		$doctors = $this->physicians_model->getAll(array(
			'limit' => $othersLimit,
			'except' => [$doctor['reg_no']],
			'speciality' => $doctor['speciality_code'],
		));
		if (count($doctors) < $othersLimit) {
			$more = $this->physicians_model->getAll(array(
				'limit' => ($othersLimit - count($doctors)),
				'except' => [$doctor['reg_no']],
			));
			$doctors = array_merge($doctors, $more);
		}
		$this->load->model('hospitals/hospitals_model', 'hospital');
		$this->data['hospitals'] = $this->hospital->get_doctor_hospital($doctor['id']);
		$this->data['doctor'] = $doctor;
		$this->data['doctors'] = $doctors;
		$this->data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
		$this->load->view('physician_details_view', $this->data);
	}
}

/* End of file Physicians.php */
/* Location: ./application/modules/public/controllers/Physicians.php */