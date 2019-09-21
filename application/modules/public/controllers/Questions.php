<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->model('qa_model');
		$this->load->model('hospitals/specialities_model');
		$this->data = array();
		$this->data['user'] = modules::run('users/get/current');
	}

	public function index()
	{
		$this->load->library('app');
		$appConfig = $this->app->config();

		// Define options to query questions.
		$options['limit'] = $appConfig['pagination_limit'];

		if ($this->input->get('elapsed')) $options['time_elapsed'] = $this->input->get('elapsed');

		if ($this->input->get('spec')) $options['speciality'] = $this->input->get('spec');

		if ($this->input->get('featured')) $options['featured'] = $this->input->get('featured');

		if ($this->input->get('per_page'))
		{
			$options['start'] = (($this->input->get('per_page') * $this->data['app']['pagination_limit']) - $this->data['app']['pagination_limit']) + 1;
		}
		else
		{
			$options['start'] = 0;
		}

		$this->data['questions'] = $this->qa_model->get_questions($options);

		// Add some pagination to this page.
		$this->load->library('pagination');

		$page_url = $this->input->get('per_page') ? preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'];

		$config['base_url'] = current_url().'?'.$page_url;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $options['limit'];

		// To get all doctors, remove pagination restrictions.
		if (isset($options['limit']))
			unset($options['limit']);
		$options['count'] = TRUE;

		$num_qns = $this->qa_model->get_questions($options);

		$config['total_rows'] = $num_qns;
		$config['num_links']  = round($config['total_rows'] / $config['per_page']);
		$config['num_links']  = 3;
		$config['use_page_numbers']  = TRUE;
		$config['full_tag_open']  = '<ul class="pagination sort-docs">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open']   = '<li>';
		$config['num_tag_close']  = '</li>';
		$config['cur_tag_open']   = '<li class="active"><a class="sort-doc-link">';
		$config['cur_tag_close']  = '</a></li>';
		$config['prev_tag_open']  = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] 	  = 'prev';
		$config['next_link'] 	  = 'next';
		$config['next_tag_open']  = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open']  = '<li class="next">';
		$config['first_tag_open']  = '<li class="next">';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$this->data['unanswered'] = $this->qa_model->get_unanswered(array('limit' => 8));

		$this->load->view('public/questions_view', $this->data);
	}

	public function details($slug)
	{
		if ($this->input->post('voting'))
		{
			$this->form_validation->set_rules('vote', 'vote', 'required');

			if ($this->form_validation->run())
			{
				$response = $this->qa_model->vote_answer($this->input->post('answer_id'));
				$this->session->set_flashdata('alert', $response['alert']);
				redirect(current_url());
			}
			else
			{
				$this->session->set_flashdata('alert', array(
					'type' => 'danger',
					'message' => validation_errors()
				));
			}
		}
		if ($this->input->post('answer_question'))
		{
			$this->form_validation->set_rules('answer', 'answer', 'required');
			$this->form_validation->set_rules('q_id', 'Question', 'required');
			$this->form_validation->set_rules('user_id', 'User ID', 'required|callback_user_group_check');

			if ($this->form_validation->run())
			{
				$response = $this->qa_model->answer_question($this->input->post('q_id'));
				$this->session->set_flashdata('alert', $response['alert']);
				redirect(current_url());
			}
		}

		$this->data['question'] = $this->qa_model->get_question($slug);
		$this->data['specialities'] = $this->specialities_model->get_specialists();

		$this->load->view('public/question_view', $this->data);
	}

	public function ask()
	{
		if ($this->input->post('ask') OR $this->input->post('login')) {
			// Authenticate the user.
			modules::run('users/authenticate/user');
			// Redifine the user after authentication.
			$this->data['user'] = modules::run('users/get/current');

			if (!empty($this->data['user'])) {
				// User is logged in.
				$this->load->library('form_validation');
				$this->form_validation->set_rules('question', 'above', 'required|trim');
				$this->form_validation->set_rules('title', 'above title', 'required|is_unique[questions.title]');

				if ($this->form_validation->run()) {
					
					if ($this->qa_model->add_question($this->data['user']['id'])) {
						// Email physicians that there is a new question.
						$this->load->model('users/user');
						$owner = $this->user->admin();

						$this->data['redirect'] = site_url('questions/'.url_title($this->input->post('title')));
						$this->email->clear();
						$this->email->from($owner['email']);

						$doctors = $this->user->all(array(
							'users' => 'doctors',
							'spec_id' => $this->input->post('speciality')
						));
						foreach ($doctors as $key => $doc) {
							$this->email->to($doc['email']);
						}

						$this->email->subject('['.$owner['name'].'] A user asked a question');
						$this->email->message($this->load->view('public/email/question', $this->data, TRUE));
						$this->email->send();

						$link = anchor('questions/'.url_title($this->input->post('title')), 'Your question');
						modules::run('notify/alerts/set_message', $link.' has been posted', 'public');
					} else {
						modules::run('notify/alerts/set_message', 'Sorry, your question could not be posted', 'public', 'error');
					}

					redirect(current_url());
				}
			}
		}

		$this->data['specialities'] = $this->specialities_model->get_specialists();

		$this->load->view('public/questions_ask_view', $this->data);
	}

	// Custom validation for user uploaded files
	public function user_group_check($user_id)
	{
		if ($this->ion_auth->in_group('doctors'))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('user_group_check', 'Sorry, must be a physician.');
			return FALSE;
		}
	}
}

/* End of file Questions.php */
/* Location: ./application/modules/public/controllers/Questions.php */