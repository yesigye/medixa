<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Specialities_model extends CI_Model
{
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

	// count types.
	public function count()
	{
		return $this->db->from('doctor_specialities')->count_all_results();
	}

	/**
	 * Return all specialities objects.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter results 
	 * @return	array
	 */
	public function get_specialists($options = array())
	{
		// Set default options
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('doctor_specialities');
		
		// Data to harvest.
		$this->db->select('doctor_specialities.id');
		$this->db->select('doctor_specialities.code');
		$this->db->select('doctor_specialities.name');
		$this->db->select('doctor_specialities.description');
			
		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->like('doctor_specialities.name', $options['search']);
			$this->db->or_like('doctor_specialities.description', $options['search']);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			$this->db->order_by('doctor_specialities.'.$options['order']['column'], $options['order']['dir']);
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	
	public function add_specialities()
	{
		$this->load->helper('text');

		$before = $this->db->count_all('doctor_specialities');

		$insertData = $this->input->post('insert');

		$this->load->library('form_validation');

		// Set validation rules.
		$i = 1; // Identify rows using standard counting starting from 1 rather than 0.
		foreach($insertData as $id => $row) {
			$this->form_validation->set_rules('insert['.$id.'][name]', ' ', 'required|is_unique[doctor_specialities.name]');
			$i++;
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {
			
			foreach ($insertData as $key => $tier) {
				$data = [
					'name' => $tier['name'],
					'code' => convert_accented_characters(url_title(strtolower($tier['name']))),
				];
				$count = $this->db->where($data)->count_all_results('doctor_specialities');
				
				if ($count == 0) {
					// Only add specialities that don't already exist.
					$data['description'] = $tier['description'];
					$data['created_on'] = time();
					$this->db->insert('doctor_specialities', $data);
				}
			}
		}
		
		$after = $this->db->count_all('doctor_specialities');
		
		return $after - $before;
	}

	public function update_specialities()
	{
		$this->load->library(array('app','form_validation'));

		$batchData = array();
		$updateData = $this->input->post('update');
		// Set validation rules.
		foreach($updateData as $id => $row) {
			$this->form_validation->set_rules('update['.$id.'][name]', ' ', 'required');
			array_push($batchData, array(
				'id' => $id,
				'name' => $row['name'],
				'code' => url_title($row['name']),
				'description' => $row['description'],
			));
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {

			$this->db->update_batch('doctor_specialities', $batchData, 'id');

			return $this->db->affected_rows();
		}
	}

	public function delete_specialities($ids)
	{
		$before = $this->db->count_all('doctor_specialities');
		
		foreach ($ids as $key => $id) {
			$this->db->where('id', $id);
			$this->db->delete('doctor_specialities');
			
		}
		
		return ($before - $this->db->count_all('doctor_specialities'));
	}
}