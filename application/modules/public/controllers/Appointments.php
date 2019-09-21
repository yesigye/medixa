<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointments extends MX_Controller {

    function __construct() 
    {
		parent::__construct();
		
        modules::run('users/authenticate/user');

		$this->load->database();
		$this->load->library(['app','users/ion_auth','form_validation']);
		$this->load->model([
			'appointments/appointments_model',
			]);
			
		// only logged in users get access.
		if ( !$this->ion_auth->logged_in()) {
			// Remember to bring user back here after login
			$this->session->set_userdata('login_redirect', current_url());
			redirect('login');
		}

		// Stores data used by view pages.
		$this->data  = array();
		$this->data['user'] = [];
	}

	public function index()
	{
		$date = date('Y-m');
		$user_id = $_SESSION['user_id'];

		if ($this->input->post('approve') && $this->ion_auth->in_group('doctors')) {
			$this->_approve_event($this->input->post('id'), $this->input->post('start_date'));
		}
		if ($this->input->post('delete') && $this->ion_auth->in_group('doctors')) {
			$this->_delete_event();
		}
		if ($this->input->post('update') && $this->ion_auth->in_group('doctors')) {
			$this->_update_event();
		}

		$y = $this->uri->segment(3);
		$m = $this->uri->segment(4);
		$d = $this->uri->segment(5);

		// Set year to current year if not set.
		$year  = $y ? $y : date('Y');
		// Set month to now.
		$month = $m ? $m : date('m');
		$now  = nice_date($y.'-'.$m.'-'.$d);

		if ($d) {
			if ($this->input->post('approve')) {
				// Profile Details of the physician booked.
				$this->data['sender'] 	 = $this->users_model->get_details($this->data['user']->id);
				// Profile Details of the person booking.
				$this->data['recipient'] = $this->users_model->get_details($this->input->post('user_id'));
				// Where to take user from email to view booking details.
				$this->data['redirect']  = site_url('appointments/view/'.nice_date($this->input->post('date'), 'y/m/d'));

				// Load the email helper.
				$this->load->helper('email');

				$this->email->clear();
				$this->email->from($this->data['app']['email']);
				$this->email->to($this->data['recipient']->email);
				$this->email->subject('['.$this->data['app']['name'].'] A user has requested an appointment');
				$this->email->message($this->load->view('public/email/booking_appointment_approve', $this->data, TRUE));

				// Send email to the user.
				if ($this->email->send())
				{
					$response = $this->appointments_model->update();
					$this->session->set_flashdata('alert', $response['alert']);
					redirect(current_url(), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('alert',
						array('type' => 'danger', 'message' => 'ML505: Appoinment could not been approved.')
					);
					redirect(current_url(), 'refresh');
				}
			}
			if ($this->input->post('cancel')) {
				// Profile Details of the physician booked.
				$this->data['sender'] 	 = $this->users_model->get_details($this->data['user']->id);
				// Profile Details of the person booking.
				$this->data['recipient'] = $this->users_model->get_details($this->input->post('user_id'));
				// Where to take user from email to view booking details.
				$this->data['redirect']  = site_url('appointments/view/'.$y.'/'.$m.'/'.$d);
				
				// Load the email helper.
				$this->load->helper('email');

				$this->email->clear();
				$this->email->from($this->data['app']['email']);
				$this->email->to($this->data['recipient']->email);
				$this->email->subject('['.$this->data['app']['name'].'] A user has requested an appointment');
				$this->email->message($this->load->view('public/email/booking_appointment_cancel', $this->data, TRUE));

				// Send email to the user.
				if ($this->email->send())
				{
					$response = $this->appointments_model->delete();
					$this->session->set_flashdata('alert', $response['alert']);
					redirect(current_url(), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('alert',
						array('type' => 'danger', 'message' => 'ML505: Appoinment could not been cancelled.')
					);
					redirect(current_url(), 'refresh');
				}
			}
			if ($this->input->post('delete')) {
				$response = $this->appointments_model->delete();
				$this->session->set_flashdata('alert', $response['alert']);

				if ( ! $response['error']) {
					// Profile Details of the physician booked.
					$this->data['sender'] 	 = $this->users_model->get_details($this->data['user']->id);
					// Profile Details of the person booking.
					$this->data['recipient'] = $this->users_model->get_details($this->input->post('user_id'));
					// Where to take user from email to view booking details.
					$this->data['redirect']  = site_url('appointments/view/'.$y.'/'.$m.'/'.$d);

					// Load the email helper.
					$this->load->helper('email');

					$this->email->clear();
					$this->email->from($this->data['app']['email']);
					$this->email->to($this->data['recipient']->email);
					$this->email->subject('['.$this->data['app']['name'].'] A user has requested an appointment');
					$this->email->message($this->load->view('public/email/booking_appointment_cancel', $this->data, TRUE));
				}
			}
			$this->data['day_title'] = date('D, d M Y', $now);
			$this->data['events'] = $this->appointments_model->get_appointments($year, $month, $d);
			$this->load->view('public/appointment_view', $this->data);
		} else {
			$data = $this->appointments_model->all([
				'user' => $user_id,
				'date' => strtotime($now)
			]);

			$this->data['appointments'] = $data;
			$this->data['unread'] = $this->appointments_model->get_pending($user_id);

			$this->load->view('public/appointments_view', $this->data);
		}
	}


	private function _approve_event($id, $date = null)
	{
		$user_id = $_SESSION['user_id'];

		$this->load->model('hospitals/physicians_model');

		// Profile Details of the physician booked.
		$this->data['sender'] = $this->physicians_model->details($user_id, true);
		// Profile Details of the person booking.
		$this->data['recipient'] = $this->ion_auth->user($this->input->post('user_id'))->row();
		// Where to take user from email to view booking details.
		$this->data['redirect']  = site_url('appointments');

		$data['approved'] = 1;
		if($date) $data['date'] = $date;

		if ($this->appointments_model->update($id, $data)) {
			// Define email parameters
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);

			$this->email->to($this->data['recipient']->email);
			$this->email->from($this->app->no_reply);
			$this->email->subject('['.$this->app->name.'] Appointment approved');
			$this->email->message($this->load->view('public/email/appointment_approve.mail.php', $this->data, TRUE));
	
			// Send email to the user.
			$this->email->send();
		
			$this->app->setAlert('Appointment has been approved');
		} else {
			$this->app->setAlert('Appoinment could not been approved.', 'error');
		}

		redirect(current_url(), 'refresh');
	}

	private function _delete_event()
	{
		$user_id = $_SESSION['user_id'];

		$this->load->model([
			'hospitals/physicians_model',
			'users/user',
		]);

		// Profile Details of the physician booked.
		$this->data['sender'] = $this->physicians_model->details($user_id, true);
		// Profile Details of the person booking.
		$this->data['recipient'] = $this->ion_auth->user($this->input->post('user_id'))->row();
		// Where to take user from email to view booking details.
		$this->data['redirect']  = site_url('appointments');

		if ($this->appointments_model->delete($this->input->post('id'))) {
			// Profile Details of the physician booked.
			$this->data['sender'] 	 = $this->physicians_model->details($user_id);
			// Profile Details of the person booking.
			$this->data['recipient'] = $this->user->rowData($this->input->post('user_id'), ['username','email']);

			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);

			$this->email->clear();
			$this->email->to($this->data['recipient']['email']);
			$this->email->from($this->app->no_reply);
			$this->email->subject('['.$this->app->name.'] Appointment cancelled');
			$this->email->message($this->load->view('public/email/appointment_cancel.mail.php', $this->data, TRUE));
			
			$this->app->setAlert('Appointment has been cancelled');
		} else {
			$this->app->setAlert('Appoinment could not been cancelled.', 'error');
		}

		redirect(current_url(), 'refresh');
	}
}