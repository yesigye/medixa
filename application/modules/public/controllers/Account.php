<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller {

    function __construct() 
    {
        parent::__construct();

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model(array('users/user'));
		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];

		modules::run('users/authenticate/user');
	}

	public function index()
	{
		if ($this->ion_auth->in_group('partners') OR $this->ion_auth->in_group('vendors')) {
			$this->partner_profile();
		} else {
			$this->user_profile();
		}
	}

	/**
	 * Login the user
	 *
	 * @return response
	 **/
	public function login()
	{
		$this->load->library('form_validation');
		//validate form input
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$remember = (bool) $this->input->post('remember'); // check for "remember me".

			if ($this->ion_auth->login($username, $password, $remember, 'email')) {
				// Redirect admin to the dashboard.
				if ($this->ion_auth->is_admin()) redirect('admin');
				// Redirect manager to their dashboard.
				if ($this->ion_auth->in_group(3)) redirect('dashboard');
				// Set welcome message
				$this->app->setAlert($this->ion_auth->messages());
				
				if ($this->session->userdata('login_redirect')) {
					// Redirect user from whence they came.
					redirect($this->session->userdata('login_redirect'));
				} else {
					// redirect to home page
					redirect(); 
				}
			} else {
				$this->app->setAlert($this->ion_auth->errors(), 'error');
				// Redirect user to login page to try again.
				redirect('login', 'refresh');
			}

		}

		$this->data['redirect'] = $this->session->userdata('login_redirect');
		// Get any status message that may have been set.
		$this->data['error_message'] = $this->ion_auth->errors();

		$this->load->view('auth/login_view', $this->data);
	}

	/**
	 * Logout the user
	 *
	 * @return response
	 **/
	function logout()
	{
		if ($this->ion_auth->logout()) {
			$this->app->setAlert('You have been logged out.');
		}

		redirect('login');
	}

	/**
	 * Change the user's password
	 *
	 * @return response
	 **/
	public function password()
	{
		$this->data['person'] = $this->ion_auth->user()->result();

		if (empty($this->data['person']))
		{
			$this->load->view('public/errors_view');
		}
		else
		{
			$this->data['person'] = $this->data['person'][0];


			if ($this->input->post('edit_user'))
			{
				$tables = $this->config->item('tables','ion_auth');

				$this->form_validation->set_rules('old_password', 'Old password', 'required|callback_password_check');

				if ($this->input->post('username'))
				{
					if ($this->input->post('username') !== $this->data['person']->username)
					{
						$identity_column = $this->config->item('identity','ion_auth');
						$this->data['identity_column'] = $identity_column;
						// validate form input
						$this->form_validation->set_rules('username', 'above', 'required|is_unique['.$tables['users'].'.'.$identity_column.']', array(
							'is_unique' => 'The new username must be different from the current username.'
						));
					}
					else
					{
						$this->form_validation->set_rules('username', 'above', 'required');
					}
				}

				if ($this->input->post('password'))
				{
					$this->form_validation->set_rules('password_confirm', 'password_confirm', 'required');
					$this->form_validation->set_rules('password', 'password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				}

				if ($this->form_validation->run() == true)
				{
					$data = array();

					if ($this->input->post('username'))
					{
						$data['username'] = $this->input->post('username');
					}

					if ($this->input->post('password'))
					{
						$data['password'] = $this->input->post('password');
					}

					if ($this->input->post('email'))
					{
						$data['email'] = $this->input->post('email');
					}

					if ($this->ion_auth->update($this->data['user']->id, $data))
					{
						$this->session->set_flashdata('alert', array(
							'type' => 'success',
							'message' => $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Your username was changed. Please login again.'
						));

						// Log the user out.
						$this->ion_auth->logout();

						// redirect them back to the login page
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('alert', array(
							'type' => 'danger',
							'message' => $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Your username could not be changed'
						));

						// redirect them back here
						redirect(current_url(), 'refresh');
					}
				}
			}

			$this->load->view('public/account/user_password_view', $this->data);
		}
	}

	/**
	 * Register a new user.
	 *
	 * @return response
	 **/
	public function register()
	{
		if ($this->input->post('register')) {
			
			$this->form_validation->set_rules('email', "Email Address", 'trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', "Password", 'trim|required');

			if($this->form_validation->run() === TRUE) {
				
				$email = strtolower($this->input->post('email'));
				$identity = $email;
				$password = $this->input->post('password');
				$details = [];

				// Set optional user details
				if($this->input->post('first_name')) $details['first_name'];
				if($this->input->post('last_name')) $details['last_name'];

				$register = $this->ion_auth->register($identity, $password, $email, [4], $details);

				if($register) {
					// Get the activate account email template
					$message = $this->load->view('public/email/activate_account.mail.php', [
						'user_id' => $register['id'],
						'code' => $register['activation']
					], true);

					// Define email parameters.
					$this->load->library('email');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
					
					$this->email->from($this->app->no_reply);
					$this->email->to($register['email']);
					$this->email->subject('Activate Your Account');
					$this->email->message($message);

					// Attempt to send email
					if ($this->email->send()) {
						// Success. Set message and sent user to login.
						$message = 'You account has created. We set you instructions via email on how to activate your account';
						$this->app->setAlert($this->ion_auth->messages() ? $this->ion_auth->messages() : $message);
						redirect('login');
					} else {
						// Email not reached. Set message and delete user.
						$this->app->setAlert("We can't reach this email address", 'error');
						$this->ion_auth->delete_user($register['id']);
					}
				} else {
					$this->app->setAlert($this->ion_auth->errors());
				}
			}
		}
		
		$this->data['form_fields'] = [
			'email' => [
				'attr' 	=> ['placeholder' => 'Email Address'],
				'type' 	=> 'text',
			],
			'password' => [
				'attr' => ['placeholder' => 'Password'],
				'type' => 'password',
			],
		];

		$this->load->view('public/auth/register_user', $this->data);
	}

	/**
	 * Register a new company.
	 *
	 * @return response
	 **/
	public function register_company()
	{
		if ($this->input->post('register')) {
			
			$this->load->library('form_validation');

			// Set validation rules. Validation rules are set by config file at
			// './application/modules/hospitals/config/Form_validation.php'
			$this->config->load('hospitals/form_validate');
			$this->form_validation->set_rules($this->config->item('hospital_submit'));

			if ($this->form_validation->run() == true) {
				
				$email = strtolower($this->input->post('email'));
				$identity = $email;
				
				// Generate a random password
				$this->load->helper('string');
				$random_password = random_string('alnum', 10);

				$register = $this->ion_auth->register($identity, $random_password, $email, [], [3]);
				
				if ($register) {
					// Get the activate account email template
					$message = $this->load->view('public/email/activate_account.mail.php', [
						'user_id' => $register['id'],
						'code' => $register['activation'],
						'password' => $random_password
					], true);

					// Define email parameters
					$this->load->library('email');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);

					$this->email->from($this->app->no_reply);
					$this->email->to($register['email']);
					$this->email->subject('Activate Your Account');
					$this->email->message($message);
					
					/* Attempt to send email */
					if (!$this->email->send()) {
						// Email failed.

						$this->load->model('users/user');
						// Remove user.
						$this->user->delete_user($register['id']);
						$this->app->setAlert("We can't reach you at this email address", 'error');
					} else {
						
						$this->load->model('hospitals/hospitals_model');
						
						$details = [
							'name' => $this->input->post('name'),
							'email' => $this->input->post('email'),
							'phone' => $this->input->post('phone'),
							'address' => $this->input->post('address'),
							'active' => 0
						];

						/* Attempt to add hospital */
						if ($this->hospitals_model->save($details)) {
							$id = $this->hospitals_model->id;
							// Assign user to hospital
							$this->hospitals_model->assign_user($id, $register['id']);
							// $message = $this->ion_auth->messages() ? $this->ion_auth->messages() : 'Registration was successful';
							$message = 'Your account was created with a password '.$random_password; 
							$this->app->setAlert($message);
							log_message('error', $random_password);
							// Log user in.
							$this->ion_auth->login($details['email'], $random_password, $remember = false);
							redirect('dashboard', 'refresh');
						} else {
							// Saving hospital failed.
							$this->app->setAlert('Registration could not be completed', 'error');
							// Remove user.
							$this->user->delete_user($register['id']);
							redirect('register_org', 'refresh');
						}
					}
				} else {
					// Register user failed.
					$error_message = $this->ion_auth->errors() ? $this->ion_auth->errors() : 'Sorry, Registeration has failed';
					$this->app->setAlert($error_message, 'error');
				}

			}
		}
		
		$this->load->model('hospitals/types_model');
		$types = $this->types_model->get_types();

		$this->data['form_fields'] = [
			'name' => [
				'attr' 	=> ['placeholder' => 'Business Name'],
			],
			'email' => [
				'attr' 	=> ['placeholder' => 'Email Address'],
				'type' 	=> 'email',
			],
			'address' => [
				'attr' => ['placeholder' => 'Adress'],
			],
			'phone' => [
				'attr' => ['placeholder' => 'Phone'],
				'type' => 'phone',
			]
		];
		$this->data['types'] = $types;

		$this->load->view('public/auth/company/register', $this->data);
	}

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 *
	 * @return response
	 */
	public function activate($id, $code = FALSE)
	{
		$activation = false;
		
		if ($code !== FALSE) {
			$activation = $this->ion_auth->activate($id, $code);
		}else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			// redirect them to the home page
			$this->app->setAlert($this->ion_auth->messages());
			redirect('login', 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->app->setAlert($this->ion_auth->errors(), 'error');
			redirect("forgot-password", 'refresh');
		}
	}

	/**
	 * Change a password
	 * 
	 * @return response
	 */
	public function change_password()
	{
		// Show 404 to non-logged in users.
		if (!$this->ion_auth->logged_in()) {
			show_404();
		}

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');

		if ($this->form_validation->run() == false) {
			$this->app->setAlert(validation_errors(), 'error');
		} else {
			$identity = $this->session->userdata('identity');
			$change = $this->ion_auth->change_password($identity, $this->input->post('new_password'), $this->input->post('new'));

			if ($change) {
				$this->app->setAlert('You successfully change your password');
			} else {
				$this->app->setAlert($this->ion_auth->errors(), 'error');

				if (!$this->ion_auth->hash_password_db($_SESSION['user_id'], $this->input->post('password'))) {
					$this->app->setAlert('The current password your provided is invalid', 'error');
				}
			}
		}

		if ($this->session->userdata('login_redirect')) {
			// Redirect user from whence they came.
			redirect($this->session->userdata('login_redirect'));
		} else {
			// redirect to home page
			redirect(); 
		}
	}

	/**
	 * Process to reset a user password
	 * 
	 * @return response
	 */
	public function forgot_password()
	{
		$sent_mail = false;
		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}

		if ($this->form_validation->run()) {
			$identity = $this->ion_auth->where('email', $this->input->post('identity'))->users()->row();

			if(empty($identity)) {

        		if($this->config->item('identity', 'ion_auth') != 'email') {
					$this->app->setAlert('No record of that username', 'error');
            	} else {
					$this->app->setAlert('No record of that email address', 'error');
            	}
    		} else {
				$email = $identity->{$this->config->item('identity', 'ion_auth')};
				
				// Attempt to email an activation code to the user
				$forgotten = $this->ion_auth->forgotten_password($email);

				if ($forgotten) {
					// Get the activate account email template
					$message = $this->load->view('public/email/forgotten_password.mail.php', [
						'code' => $forgotten['forgotten_password_code'],
					], true);

					// Define email parameters
					$this->load->library('email');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);

					$this->email->from($this->app->no_reply);
					$this->email->to($email);
					$this->email->subject('Reset Your Password');
					$this->email->message($message);
					
					/* Attempt to send email */
					if ($sent_mail = $this->email->send()) {
						// Success, display a confirmation page
						$this->app->setAlert($this->ion_auth->messages());
						$_POST = []; // Clear post data to prevent a re-post
						$this->data['email'] = $email;
					} else {
						// email not set.
						$this->app->setAlert('Sorry, mail communication faulted', 'error');
					}
				} else {
					$this->app->setAlert($this->ion_auth->errors(), 'error');
				}
    		}
		}
		
		$this->load->view(($sent_mail ? 'auth/forgot_password_complete' : 'auth/forgot_password'), $this->data);
	}

	/**
	 * Final step for forgotten password
	 * 
	 * @param string $code user forgotten password identifier
	 * 
	 * @return response
	 */
	public function reset_password($code = NULL)
	{
		if (!$code) show_404();

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			// if the code is valid then display the password reset form
			$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm Password', 'required');

			if ($this->form_validation->run() == false) {
				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');

				$this->data['form_fields'] = [
					'new' => array(
						'attr' => ['placeholder' => 'New password'],
						'type' => 'password',
					),
					'new_confirm' => array(
						'attr' => ['placeholder' => 'Confirm password'],
						'name'    => 'new_confirm',
						'type'    => 'password',
					)
				];

				// render
				$this->load->view('auth/reset_password', $this->data);
			} else {
				// finally change the password
				$identity = $user->{$this->config->item('identity', 'ion_auth')};

				$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

				if ($change) {
					// if the password was successfully changed
					$this->app->setAlert($this->ion_auth->messages());
					redirect("login", 'refresh');
				} else {
					$this->app->setAlert($this->ion_auth->errors(), 'error');
					redirect('reset-password/'. $code, 'refresh');
				}
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("forgot-password", 'refresh');
		}
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce(){
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')){
			return TRUE;
		}
			return FALSE;
	}
}