<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locations_model extends CI_Model
{
	/**
	 * error message
	 *
	 * An error message generated within any function.
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

	public function tiers($options = [], $table = 'location_types')
	{
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->select("$table.id");
		$this->db->select("$table.parent_id");
		$this->db->select("$table.name");
		$this->db->select("$table.code");
		
		$this->db->select('parentTiers.name AS parent');
		$this->db->join("$table parentTiers", "parentTiers.id = $table.parent_id", 'left');
		
		$this->db->from($table);
		
		// Query by parent
		if (isset($options['parent'])) {
			$this->db->where("$table.parent_id", $options['parent']);
		}
		
		// Query by level
		if (isset($options['level'])) {
			$this->db->where("parentTypes.id", $options['level']);
			$this->db->join("location_types parentTypes", "parentTypes.id = $table.location_type_id", 'left');
		}
		
		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->like("$table.name", $options['search']);
			$this->db->or_like("$table.code", $options['search']);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Limit number of objects in the results.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			$this->db->order_by("$table.".$options['order']['column'], $options['order']['dir']);
		} else {
			$this->db->order_by("$table.id", 'ASC');
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	public function zones($options = [], $table = 'location_zones')
	{
		if (!isset($options['start'])) $options['start'] = 10;
		
		// We cache because we need to remember our filter/where clauses.
		// This allows us to get both the row count and the query objects
		// otherwise the CI query builder would reset after getting the row count.
		$this->db->start_cache();
		
		$this->db->select("$table.id");
		$this->db->select("$table.name");
		$this->db->select("$table.description");
		$this->db->select("$table.status");
		$this->db->from($table);
		
		// Query groups by search
		if (isset($options['search']) && $options['search'] !== '') {
			$this->db->like("$table.name", $options['search']);
			$this->db->or_like("$table.status", $options['search']);
			$this->db->or_like("$table.description", $options['search']);
		}
		
		// Count the items before applying pagination.
		$this->count = $this->db->count_all_results();
		
		// Limit number of objects in the results.
		if (isset($options['limit'])) $this->db->limit($options['limit'], $options['start']);
		
		// Apply ordering
		if (isset($options['order'])) {
			$this->db->order_by("$table.".$options['order']['column'], $options['order']['dir']);
		} else {
			$this->db->order_by("$table.id", 'ASC');
		}
		
		$result = $this->db->get()->result_array();
		
		// Don't forget to stop and clear the cache.
		$this->db->stop_cache();
		$this->db->flush_cache();

		return $result;
	}

	/**
	 * Return count of all objects
	 *
	 * @return int
	 **/
	public function get_total()
	{
		return $this->db->count_all_results('location_types');
	}

	/**
	 * Return count of all zones
	 *
	 * @return int
	 **/
	public function get_Zones_total()
	{
		return $this->db->count_all_results('location_zones');
	}

	/**
	 * Return count of all objects
	 *
	 * @return int
	 **/
	public function get_places_total($tierId)
	{
		return $this->db->where('location_type_id', $tierId)->count_all_results('location_types');
	}

	public function tier($tierId)
	{
		$this->db->select('id, parent_id, name, code');
		$this->db->from('location_types')->where('id', $tierId);
		$result = $this->db->get()->result_array();
		
		return empty($result) ? $result : $result[0];
	}
	
	public function userTiers()
	{
		$this->db->reset_query();
		$this->db->select('location_types.id');
		$this->db->select('location_types.id');
		$this->db->select('location_types.parent_id');
		$this->db->select('location_types.name');
		$this->db->select('location_types.code');
		$this->db->from('location_types');
		$this->db->join('doctors_profiles', 'doctors_profiles.location_id = location.id');
		return $this->db->get()->result_array();
	}

	public function add_tiers()
	{
		$insertData = $this->input->post('insert');

		$this->load->library(array('app', 'form_validation'));

		// Set validation rules.
		$i = 1; // Identify rows using standard counting starting from 1 rather than 0.
		foreach($insertData as $id => $row) {
			$this->form_validation->set_rules('insert['.$id.'][code]', ' ', 'is_unique[location_types.code]');
			$i++;
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {
			
			foreach ($insertData as $key => $tier) {
				$data = [
					'name' => $tier['name'],
					'created_on' => time(),
				];
				if (isset($tier['parent_id'])) {
					$data['parent_id'] = $tier['parent_id'];
				};

				$this->db->insert('location_types', $data);
				// ID of the just-inserted-row
				$id = $this->db->insert_id();
				
				// Update with the slug.
				if (trim($tier['code']) !== '' && $id) {
					$this->db->where('id', $id);
					$this->db->update('location_types', array(
						'code' => $tier['code']
					));
				}
			}

			return $this->db->affected_rows();
		}
	}

	public function add_zones()
	{
		$insertData = $this->input->post('insert');

		$this->load->library(array('app', 'form_validation'));

		// Set validation rules.
		$i = 1; // Identify rows using standard counting starting from 1 rather than 0.
		foreach($insertData as $id => $row) {
			$this->form_validation->set_rules('insert['.$id.'][name]', ' ', 'is_unique[location_zones.name]');
			$i++;
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {
			
			foreach ($insertData as $key => $tier) {
				$data = [
					'name' => $tier['name'],
					'description' => $tier['description'],
				];
				if (isset($tier['status'])) $data['status'] = 1;

				$this->db->insert('location_zones', $data);
			}

			return $this->db->affected_rows();
		}
	}

	public function update_tiers()
	{
		$this->load->library(array('app','form_validation'));

		$batchData = array();
		$updateData = $this->input->post('update');

		// Set validation rules.
		foreach($updateData as $id => $row) {
			$this->form_validation->set_rules('update['.$id.'][name]', ' ', 'required');
			$data = [
				'id' => $id,
				'name' => $row['name'],
				'code' => ($row['code']) ? $row['code'] : $this->app->gen_sku($row['name'], $id),
			];
			
			if (trim($row['parent_id']) !== '') $data['parent_id'] = $row['parent_id'];
			
			array_push($batchData, $data);
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {

			$this->db->update_batch('location_types', $batchData, 'id');

			return $this->db->affected_rows();
		}
	}

	public function update_zones()
	{
		$this->load->library(array('app','form_validation'));

		$batchData = array();
		$updateData = $this->input->post('update');

		// Set validation rules.
		foreach($updateData as $id => $tier) {
			$this->form_validation->set_rules('update['.$id.'][name]', ' ', 'required');
			$data = [
				'id' => $id,
				'name' => $tier['name'],
				'description' => $tier['description'],
			];
			$data['status'] = (isset($tier['status'])) ? 1 : 0;
			
			array_push($batchData, $data);
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {

			$this->db->update_batch('location_zones', $batchData, 'id');

			// returns number of updated rows
			return $this->db->affected_rows();
		}
	}

	public function delete_tiers($ids)
	{
		foreach ($ids as $key => $id) {
			$this->db->where('location_type_id', $id);
			$this->db->delete('locations');

			$this->db->where('parent_id', $id);
			$this->db->delete('location_types');
			
			$this->db->where('id', $id);
			$this->db->delete('location_types');
		}

		return $this->db->affected_rows();
	}

	public function get_location_id($code)
	{
		$this->db->limit(1);
		$this->db->select('id');
		$this->db->from('locations');
		$this->db->where('code', $code);
		$location = $this->db->get()->result();

		return (!empty($location)) ? $location[0]->id : null;
	}

	public function locations($tierId = '', $parentId = '')
	{
		$this->db->select('locations.id');
		$this->db->select('locations.location_type_id');
		$this->db->select('locations.parent_id');
		$this->db->select('locations.name');
		$this->db->select('locations.code');
		$this->db->from('locations');
		if ($tierId) $this->db->where('locations.location_type_id', $tierId);
		if ($parentId) $this->db->where('locations.parent_id', $parentId);
		return $this->db->get()->result_array();
	}
	
	public function getChildren($code = null)
	{
		$locations = [];
		$arrayKey  = '';

		if ($code == null) {
			// Get the very first.
			$this->db->limit(1);
			$this->db->where('parent_id', null);
			$this->db->select('location_types.id');
			$this->db->select('location_types.parent_id');
			$this->db->select('location_types.name');
			$this->db->from('location_types');
			$origin = $this->db->get()->result_array();
			
			if(empty($origin)) {
				// There is no initial location level
				return [];
			} else {
				$type_id = $origin[0]['id'];
				$parent_id = $origin[0]['parent_id'];
				$arrayKey = $origin[0]['name'];
			}
		} else {
			// Get location details
			$this->db->select(['id', 'location_type_id']);
			$this->db->from('locations');
			$this->db->where('code', $code);
			$location = $this->db->get()->result_array();
			// Get the immediate child.
			$this->db->select(['id', 'name']);
			$this->db->from('location_types');
			$this->db->where('location_types.parent_id', $location[0]['location_type_id']);
			$child = $this->db->get()->result_array();
			
			// location has no child. Bye!
			if(empty($child)) return [];

			$type_id = $child[0]['id'];
			$parent_id = $location[0]['id'];
			$arrayKey = $child[0]['name'];
		}
		$this->db->select('locations.id');
		$this->db->select('locations.parent_id');
		$this->db->select('locations.location_type_id');
		$this->db->select('locations.name');
		$this->db->select('locations.code');
		$this->db->from('locations');
			
		$this->db->where('locations.location_type_id', $type_id);
		$this->db->where('locations.parent_id', $parent_id);
		
		$results = $this->db->get()->result_array();

		if (!empty($results)) {
			$locations[$arrayKey] = $results;
		}
		
		return $locations;
	}

	public function add_locations($tierId)
	{
		$insertData = $this->input->post('insert');

		$this->load->library(array('app', 'form_validation'));

		// Set validation rules.
		$i = 1; // Identify rows using standard counting starting from 1 rather than 0.
		foreach($insertData as $id => $row) {
			$this->form_validation->set_rules('insert['.$id.'][code]', ' ', 'is_unique[locations.code]');
			$i++;
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {
			
			foreach ($insertData as $key => $tier) {
				$data = [
					'name' => $tier['name'],
					'created_on' => time(),
					'location_type_id' => $tierId,
				];
				if (isset($tier['parent_id']) AND $tier['parent_id'] !== '') {
					$data['parent_id'] = $tier['parent_id'];
				};
				$this->db->insert('locations', $data);
				$id = $this->db->insert_id(); // ID of the just-inserted-row
				
				// Update with the slug.
				if ($id) {
					$this->db->where('id', $id)->update('locations', array(
						'code' => (trim($tier['code']) !== '') ? $tier['code'] : $this->app->gen_sku($tier['name'], $id)
					));
				}
			}

			return $this->db->affected_rows();
		}
	}

	public function update_locations()
	{
		$this->load->library(array('app','form_validation'));

		$batchData = array();
		$updateData = $this->input->post('update');
		// Set validation rules.
		foreach($updateData as $id => $row) {
			$this->form_validation->set_rules('update['.$id.'][name]', ' ', 'required');
			$data = [
				'id' => $id,
				'name' => $row['name'],
				'code' => ($row['code']) ? $row['code'] : $this->app->gen_sku($row['name'], $id),
			];
			if (trim($row['parent_id']) !== '') {
				$data['parent_id'] = $row['parent_id'];
			};
			array_push($batchData, $data);
		}
		
		// Validate fields.
		if ($this->form_validation->run()) {

			$this->db->update_batch('locations', $batchData, 'id');

			return $this->db->affected_rows();
		}
	}

	public function delete_locations($ids)
	{
		foreach ($ids as $key => $id) {
			$this->db->where('id', $id)->delete('locations');
		}

		return $this->db->affected_rows();
	}
}