<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointments_model extends CI_Model
{
	/**
	 * error message
	 *
	 * error message a function may return.
	 *
	 * @var string
	 **/
	public $error_message = '';

	/**
	 * number of result objects
	 *
	 * some functions like all() set this variable and
	 * it should be called after such functions execute.
	 *
	 * @var int
	 **/
	public $count = 0;

	/**
	 * id of user object
	 *
	 * some functions like add() set this variable and
	 * it should be called after such functions execute.
	 *
	 * @var int
	 **/
	public $id = 0;

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * Set any error that occurs
	 *
	 * @var	string $message error meassage to be set
	 **/
	public function set_error_message($message = '')
	{
		$this->error_message = $message;
	}

	/**
	 * Return error message
	 *
	 * @return string
	 **/
	public function error_message()
	{
		return $this->error_message;
	}

	/**
	 * Return all appointments.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter results 
	 * @return	array
	 */
	public function all($options = array())
	{
		// Set default options
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('appointments');
		// Data to harvest.
		$this->db->select('appointments.id');
		$this->db->select('appointments.title');
		$this->db->select('appointments.user_id');
		$this->db->select('appointments.doctor_id');
		$this->db->select('appointments.approved');
		$this->db->select('appointments.start_date');
		$this->db->select('appointments.end_date');
		$this->db->select('appointments.message');
		$this->db->select('userDetails.username user');
		$this->db->select('doctorUsers.username doctor');
		
		$this->db->select('userDetails.username user');
		$this->db->select('userDetails.id user_id');
		$this->db->select('doctorUsers.username doctor');
		$this->db->select('doctorUsers.id dictor_id');
		
		$this->db->join('users userDetails', 'userDetails.id = appointments.user_id', 'left');
		$this->db->join('users doctorUsers', 'doctorUsers.id = appointments.doctor_id', 'left');
		
		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->like('appointments.title', $options['search']);
			$this->db->or_like('appointments.message', $options['search']);
		}
		
		if (isset($options['user']) AND $id = $options['user']) {
			$this->db->where("(appointments.doctor_id = $id OR appointments.user_id = $id)", null, true);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		if (isset($options['count'])) {
			$this->db->stop_cache()->flush_cache();
			return $this->count;
		}

		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			if ($options['order']['column'] == 'facilities') {
				$this->db->order_by('facilites.count', $options['order']['dir']);
			} else {
				$this->db->order_by('appointments.'.$options['order']['column'], $options['order']['dir']);
			}
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache()->flush_cache();

		return $result;
	}

	public function add($data = array())
	{
		$datestring = '%Y-%m-%d %h:%i:%s';
		$datetime   = strtotime($data['date']);

		$insert['start_date'] = mdate($datestring, $datetime);
		$insert['user_id'] = $data['user_id'];
		$insert['doctor_id'] = $data['doctor_id'];
		$this->db->where($insert);
		$similar = $this->db->count_all_results('appointments');

		if ($similar == 0) {
			$insert['message'] = $data['message'];

			// Record in to database if email is sent.
			$this->db->insert('appointments', $insert);

			if ($this->db->affected_rows()) {
				return true;
			} else {
				$this->set_error_message('Appointment could not be made.');
				return false;
			}
		} else {
			$this->set_error_message('This appointment is already pending.');
			return false;
		}
	}

	public function update($id, $data = [])
	{
		if (isset($data['date'])) {
			$datestring = '%Y-%m-%d %h:%i:%s';
			$datetime   = strtotime($data['date']);
			$data['date'] = mdate($datestring, $datetime);
		}
		$data['viewed'] = 1; // mark event as read

		// Update record in the database.
		$this->db->where('id', $id);
		$this->db->update('appointments', $data);

		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		// Delete record in the database.
		$this->db->where('id', $id);
		$this->db->delete('appointments');

		return $this->db->affected_rows();
	}

	public function user($id, $options = [])
	{
		$this->db->select('id');
		$this->db->select('title');
		$this->db->select('message');
		$this->db->select('date');
		$this->db->select('user_id');
		$this->db->select('doctor_id');
		$this->db->select('approved');
		$this->db->select('viewed');
		
		$this->db->from('appointments');

		if (isset($options['user'])) {
			if ($options['user'] == 'doctor') {
				$this->db->where('(doctor_id = '.$id.' OR user_id = '.$id.')', null, false);
			} else {
				$this->db->where('user_id', $id);
			}
		}
		
		if (isset($options['view'])) {
			if ($options['view'] == 'unread') {
				$this->db->where('viewed', 0);
			} elseif ($options['view'] == 'read') {
				$this->db->where('viewed', 1);
			}
		}
		
		if (isset($options['pending'])) {
			$this->db->where('date >=', date('Y-m-d'));
		}
		
		if (isset($options['start']) && isset($options['end'])) {
			// $this->db->where('YEAR(date)', date('Y', $options['start']), false);
			// $this->db->where('MONTH(date)', date('m', $options['end']), false);
			$this->db->where('(date <= '.$options['start'].' OR date >= '.$options['end'].')', null, false);
		}
		
		if (isset($options['count'])) {
			return $this->db->count_all_results();
		}

		return $this->db->get()->result();
	}

	public function get_appointments($y, $m, $d = FALSE)
	{
		if ($d)
		{
			if ($this->ion_auth->in_group('doctors'))
			{
				$this->db->where('doctor_id', $this->data['user']->id);
			}
			else
			{
				$this->db->where('user_id', $this->data['user']->id);
			}
			$this->db->like('date', $y.'-'.$m.'-'.$d);
			$result = $this->db->get('appointments')->result();
			
			$appointments = array();
			
			foreach ($result as $key => $row)
			{
				$options = array();
				$options['id'] = $row->user_id;

				if ($this->ion_auth->in_group('doctors'))
				{
					$recipient = $this->users_model->get_details($row->user_id);
				}
				else
				{
					$recipient = $this->users_model->get_doctor(array('id' => $row->doctor_id));
				}

				array_push($appointments, array(
					'id' => $row->id,
					'time' => nice_date($row->date, 'h:i a'),
					'date' => nice_date($row->date, 'Y-m-d h:i:s'),
					'user' => $recipient,
					'message' => $row->message,
					'approved' => $row->approved,
				));
			}
		}
		else
		{
			if ($this->ion_auth->in_group('doctors'))
			{
				$this->db->where('doctor_id', $this->data['user']->id);
			}
			else
			{
				$this->db->where('user_id', $this->data['user']->id);
			}
			$this->db->like('date', $y.'-'.$m);
			$result = $this->db->get('appointments')->result();
			
			$appointments = array();
			
			foreach ($result as $key => $row)
			{
				$row->date = nice_date($row->date, 'd');

				$key = intval($row->date);
				$val = site_url('appointments/view/'.$y.'/'.$m.'/'.$row->date);

				$appointments[$key] = $val;
			}
		}

		return $appointments;
	}

	public function get_monthly_data($year, $months)
	{
		$this->db->reset_query();

		$result = array();

		for ($i=0; $i < 12; $i++) {

			$diff = $months - $i;

			if ($diff > 0) {

				if ($diff < 10) {
					$date 	= $year.'-0'.$diff;
				}else {
					$date 	= $year.'-'.$diff;
				}

				$this->db->select('date AS month');
				$this->db->select('IFNULL(SUM(appointments.approved), 0) AS sales');
				$this->db->like('date', $date);
				$data = $this->db->get('appointments')->result_array();

				if(!empty($data[0]['month'])) {
					array_push($result, $data[0]);
				} else {
					array_push($result, array(
						'month' => $date,
						'sales' => 0.00,
						));
				}
			}
		}
		krsort($result);
		return array_values($result);
	}

	public function get_approved($id)
	{
		$this->db->where('doctor_id', $id);
		$this->db->where('approved', 1);
		$result = $this->db->get('appointments')->result();
		
		$appointments = array();
		
		foreach ($result as $key => $row)
		{
			$options = array();
			$options['id'] = $row->user_id;

			$recipient = $this->users_model->get_details($row->user_id);

			array_push($appointments, array(
				'id' => $row->id,
				'time' => nice_date($row->date, 'h:i a'),
				'date' => nice_date($row->date, 'Y-m-d h:i:s'),
				'user' => $recipient,
				'message' => $row->message,
				'approved' => $row->approved,
			));
		}

		return $appointments;
	}

	public function get_pending($id)
	{
		$now = date('Y-m-d');
		
		$this->db->select('appointments.id');
		$this->db->select('appointments.title');
		$this->db->select('appointments.message');
		// $this->db->select('from_unixtime(appointments.date, "%D %M %Y") AS date');
		$this->db->select('appointments.start_date');
		$this->db->select('appointments.approved');
		$this->db->select('users.username');
		$this->db->select('users.avatar');
		$this->db->select('doctors.username doc_username');
		$this->db->select('doctors.avatar doc_avatar');
		
		$this->db->limit(10);
		
		$this->db->from('appointments');
		
		// current and future
		$this->db->where('start_date >', $now);
		$this->db->order_by('start_date', "ASC");

		$this->db->where("(appointments.doctor_id = $id OR appointments.user_id = $id)", null, true);

		$this->db->join('users', 'users.id = appointments.user_id', 'left');
		$this->db->join('users doctors', 'doctors.id = appointments.doctor_id', 'left');
		
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function get_unread($id)
	{
		$this->db->where('user_id', $id);
		$this->db->where('approved', 1);
		$result = $this->db->get('appointments')->result();
		
		$appointments = array();
		
		foreach ($result as $key => $row)
		{
			$options = array();
			$options['id'] = $row->user_id;

			$recipient = $this->users_model->get_details($row->doctor_id);

			array_push($appointments, array(
				'id' => $row->id,
				'time' => nice_date($row->date, 'h:i a'),
				'date' => nice_date($row->date, 'Y-m-d h:i:s'),
				'user' => $recipient,
				'message' => $row->message,
				'approved' => $row->approved,
			));
		}

		return $appointments;
	}


	/**
	 * Return an appointment object.
	 *
	 * @param	array $id id of appointment
	 *  
	 * @return	array
	 */
	public function details($id)
	{
		// Data to harvest.
		$this->db->select('appointments.id');
		$this->db->select('appointments.title');
		$this->db->select('appointments.message');
		$this->db->select('appointments.user_id');
		$this->db->select('appointments.doctor_id');
		$this->db->select('appointments.approved');
		$this->db->select('appointments.start_date');
		$this->db->select('appointments.end_date');
		$this->db->select('appointments.created_on');
		
		$this->db->select('userDetails.username');
		$this->db->select('userDetails.avatar user_avatar');
		$this->db->select('doctorUsers.username doctor_username');
		$this->db->select('doctorUsers.avatar doctor_avatar');
		$this->db->select('doctorUsers.id doctor_id');
		$this->db->select('doctor_specialities.name doctor_speciality');
		
		$this->db->join('users userDetails', 'userDetails.id = appointments.user_id', 'left');
		$this->db->join('users doctorUsers', 'doctorUsers.id = appointments.doctor_id', 'left');

		$this->db->join('doctors_profiles', 'doctors_profiles.user_id = doctorUsers.id', 'left');
		$this->db->join('doctor_specialities', 'doctor_specialities.id = doctors_profiles.speciality_id', 'left');
		
		$result = $this->db->where('appointments.id', $id)->get('appointments')->result_array();

		return (empty($result)) ? $result : $result[0];
	}
}
