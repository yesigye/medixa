<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();

		$this->data  = null;
		$this->data['app'] = $this->config->item('app');
		$this->data['user'] = $this->ion_auth->user()->row();
	}

	public function appointments()
	{
		if ($this->ion_auth->in_group('doctors'))
		{
			// For doctors, count unapproved appointments.
			$this->db->where('approved', 0);
			$this->db->where('doctor_id', $this->data['user']->id);

			$message  = 'unapproved appointment';
			$redirect = 'appointments/unapproved';
		}
		else
		{
			// For general users, count unread appointments.
			$this->db->where('viewed', 0);
			$this->db->where('approved', 1);
			$this->db->where('user_id', $this->data['user']->id);

			$message  = 'unread appointment';
			$redirect = 'appointments/unread';
		}

		$count = $this->db->count_all_results('appointments');

		if ($count > 0)
		{
			return array(
				'redirect' => $redirect,
				'message'  => ($count > 1) ? 'You have '.$count.' '.$message.'s' : 'You have '.$count.' '.$message,
			);
		}
		else
		{
			return NULL;
		}
	}

	public function clear_appointments($user_id, $status)
	{
		$this->db->where('user_id', $user_id);

		$update = array();

		if ($status === 'unread')
		{
			$update ['viewed'] = 1;
		}
		elseif ($status === 'unapproved')
		{
			$update ['viewed'] = 1;
		}
		
		$this->db->update('appointments', $update);
	}
}