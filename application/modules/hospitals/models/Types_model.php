<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Types_model extends CI_Model
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
		$this->db->reset_query();
		return $this->db->count_all('company_types');
	}

	public function details($id)
	{
		$this->db->select('id, name, code');
		$this->db->from('company_types');
		$this->db->where('id', $id);
		$type = $this->db->get()->result_array();
		
		return (empty($type)) ? $type : $type[0];
	}

	/**
	 * Return all types objects.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter results 
	 * @return	array
	 */
	public function get_types($options = array())
	{
		// Set default options
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('company_types');
		// Data to harvest.
		$this->db->select('company_types.id');
		$this->db->select('company_types.parent_id');
		$this->db->select('company_types.name');
		$this->db->select('company_types.code');
		$this->db->select('company_types.description');
		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->like('company_types.name', $options['search']);
			$this->db->or_like('company_types.description', $options['search']);
			$this->db->or_like('facilites.count', $options['search']);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			if ($options['order']['column'] == 'facilities') {
				$this->db->order_by('facilites.count', $options['order']['dir']);
			} else {
				$this->db->order_by('company_types.'.$options['order']['column'], $options['order']['dir']);
			}
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	/**
	 * Return all facilities of a type object.
	 *
	 * options parameter may be used to filter or limited the objects returned.
	 *
	 * @param	array $options an array of options used to filter results 
	 * @return	array
	 */
	public function facilities($options = [], $ids = [])
	{
		// Set default options
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->from('company_facilities');
		
		// Data to harvest.
		$this->db->select('company_facilities.id');
		$this->db->select('company_facilities.code');
		$this->db->select('company_facilities.name');
		$this->db->select('company_facilities.description');
			
		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->like('company_facilities.name', $options['search']);
			$this->db->or_like('company_facilities.description', $options['search']);
			$this->db->or_like('company_types.name', $options['search']);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Limit number of objects in the results.
		// This is primarily for pagination purposes.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			$this->db->order_by('company_facilities.'.$options['order']['column'], $options['order']['dir']);
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	public function inHospitals($hospital_id)
	{
		$this->db->reset_query();

		$this->db->where('companies_types.company_id', $hospital_id);
		$query = $this->db->get('companies_types')->result();

		$ids = array();

		foreach ($query as $row) {
			array_push($ids, $row->company_type_id);
		}

		return $ids;
	}

	public function addTypes()
	{
		$insertData = $this->input->post('insert');

		$this->load->library(array('app', 'form_validation'));

		// Set validation rules.
		$i = 1; // Identify rows using standard counting starting from 1 rather than 0.
		foreach($insertData as $id => $row) {
			$this->form_validation->set_rules('insert['.$id.'][name]', ' ', 'required|is_unique[company_types.name]');
			$i++;
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {
			$before = $this->count();
			
			foreach ($insertData as $key => $tier) {
				$data = [
					'name' => $tier['name'],
					'description' => $tier['description'],
					'created_on' => now()
				];
				if ($tier['parent_id'] !== '') $data['parent_id'] = $tier['parent_id'];
				
				$this->db->insert('company_types', $data);
				// ID of the just-inserted-row
				$this->id = $this->db->insert_id();

				if ($this->db->affected_rows()) {
					// Update with the code.
					$this->db->where('id', $this->id);
					$this->db->update('company_types', array(
						'code' => $this->app->gen_sku($tier['name'], $this->id)
					));
				} else {
					$this->set_error_message('Company type could not added');
				}
				
			}

			$after = $this->count();

			return $after - $before;
		}
	}

	public function updateTypes()
	{
		$this->load->library(array('app','form_validation'));

		$batchData = array();
		$updateData = $this->input->post('update');
		// Set validation rules.
		foreach($updateData as $id => $row) {
			$this->form_validation->set_rules('update['.$id.'][name]', ' ', 'required');
			$data = array(
				'id' => $id,
				'name' => $row['name'],
				'code' => $this->app->gen_sku($row['name'], $id),
				'description' => $row['description'],
			);
			if (isset($row['parent_id']) && $row['parent_id'] !== '') {
				$data['parent_id'] = $row['parent_id'];
			}
			array_push($batchData, $data);
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {

			$this->db->update_batch('company_types', $batchData, 'id');
			$did_update = $this->db->affected_rows();
			
			if ($did_update == false) $this->set_error_message('Types could not be updated.');

			return $did_update;
		}
	}

	public function delete_types($ids)
	{
		foreach ($ids as $key => $id) {
			$this->db->where('company_type_id', $id);
			$this->db->delete('companies_types');
			
			$this->db->where('id', $id);
			$this->db->delete('company_types');
		}

		return $this->db->affected_rows();
	}
	
	public function facilitiesInHospital($id, $count = false)
	{
		$this->db->select('company_facility_id');
		$this->db->from('companies_facilities');
		$this->db->where('company_id', $id);

		if ($count) return $this->db->count_all_results();
		
		$ids = array();

		foreach ($this->db->get()->result() as $row) {
			array_push($ids, $row->company_facility_id);
		}

		return $ids;
	}

	public function addFacilities($type_id = null)
	{
		$insertData = $this->input->post('insert');
		
		$this->load->library(array('app', 'form_validation'));
		
		// Set validation rules.
		$i = 1; // Identify rows using standard counting starting from 1 rather than 0.
		foreach($insertData as $id => $row) {
			$this->form_validation->set_rules('insert['.$id.'][name]', ' ', 'required');
			$i++;
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {
			$before = $this->db->count_all('company_facilities');
			
			foreach ($insertData as $key => $tier) {
				$data = ['name' => $tier['name']];
				if(isset($type_id)) $data['company_type_id'] = $type_id;
				$similar = $this->db->where($data)->count_all_results('company_facilities');
				
				// Skip this row if a similar entry is found
				if ($similar > 0) continue;
				// Added the optional description
				if ($tier['description'] !== '') $data['description'] = $tier['description'];
				// Attempt to Insert data to table.
				$this->db->insert('company_facilities', $data);
				// ID of the just-inserted-row
				$this->id = $this->db->insert_id();

				if ($this->db->affected_rows()) {
					// Update row with unique auto generate code.
					$this->db->where('id', $this->id)->update('company_facilities', array(
						'code' => $this->app->gen_sku($tier['name'], $this->id)
					));
				} else {
					$this->set_error_message('Type facility could not added');
				}
				
			}

			$after = $this->db->count_all('company_facilities');

			return $after - $before;
		}
	}

	public function updateFacilities($type_id = null)
	{
		$this->load->library(array('app','form_validation'));

		$batchData = array();
		$updateData = $this->input->post('update');
		// Set validation rules.
		foreach($updateData as $id => $row) {
			$this->form_validation->set_rules('update['.$id.'][name]', ' ', 'required');
			$data = array(
				'id' => $id,
				'name' => $row['name'],
				'code' => $this->app->gen_sku($row['name'], $id),
				'description' => $row['description'],
			);
			
			if(isset($type_id)) $data['company_type_id'] = $type_id;
			
			array_push($batchData, $data);
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {

			$this->db->update_batch('company_facilities', $batchData, 'id');
			$did_update = $this->db->affected_rows();
			
			if ($did_update == false) $this->set_error_message('Facilities could not be updated.');

			return $did_update;
		}
	}
	
	public function deleteFacilities($ids)
	{
		$before = $this->db->count_all('company_facilities');
		
		foreach ($ids as $key => $id) {
			$this->db->where('company_facility_id', $id);
			$this->db->delete('companies_facilities');
			
			$this->db->where('id', $id);
			$this->db->delete('company_facilities');
		}
		
		return ($before > $this->db->count_all('company_facilities'));
	}
}
/*  */