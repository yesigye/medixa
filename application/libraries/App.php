<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  App
*
* Author: Ignatius Yesigye
*		  ignatiusyesigye@gmail.com
*/

class App
{
	public $name = '';
	public $logo = '';
	public $pageLimit = '24';
	public $no_reply = '';
	public $language = 'english';

	/**
	 * Define app basic data
	 */
	public function __construct()
	{
		if ($this->uri->segment(1) !== 'migrate' && $this->uri->segment(2) !== 'migrate') {
			$this->load->database();

			$this->load->library('session');
			
			$this->db->select('site_logo');
			$this->db->select('site_name');
			$this->db->select('pagination_limit');
			$this->db->select('site_language');
			$this->db->select('no_reply');
			$this->db->from('settings');
			$this->db->limit(1);
			$info = $this->db->get()->result();
			
			if(!empty($info)) {
				$this->name = $info[0]->site_name;
				$this->logo = $info[0]->site_logo;
				$this->pageLimit = $info[0]->pagination_limit;
				$this->no_reply = $info[0]->no_reply;
				$this->language = $info[0]->site_language;
			}

			// Set language files for system
			$this->config->set_item('language', $this->language);
			// Load language files for view
			$this->lang->load('app.menus', $this->language);
			// $this->lang->load('app.forms', $this->language);
			// $this->lang->load('app.titles', $this->language);
			// $this->lang->load('app.alerts', $this->language);
			// $this->lang->load('app.buttons', $this->language);
			$this->lang->load('ion_auth', $this->language);
		}
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	/**
	 * Set user message
	 *
	 * @param string $message error message
	 * @param string $message_type type of alert message
	 **/
	function setAlert($message, $message_type = 'success')
	{
		switch ($message_type) {
			case 'error':
				$type = 'danger';
				$this->error_message = $message;
				break;
			
			case 'warn':
				$type = 'warning';
				$this->status_message = $message;
				break;
			
			case 'info':
				$type = 'info';
				$this->status_message = $message;
				break;
			
			default:
				$type = 'success';
				$this->status_message = $message;
				break;
		}

		// Save message in session
		$this->session->set_flashdata('alert', array(
			'type' => $type,
			'message' => $message
		));
	}

	/**
	 * Get alert message flashdata
	 *
	 * @return string str error message
	 **/
	function getAlert($message_type = 'success')
	{
		return $this->session->flashdata('alert');
	}

	/**
	 * Return settings configuration
	 *
	 * @param array $params  list of specific configuration values
	 *
	 * @return array
	 **/
	public function config($params = array())
	{
		$this->load->model('admin/settings_model', 'settings');
		return $this->settings->values($params);
	}

	/**
	 * Return current user
	 *
	 * @param array $column value to return
	 *
	 * @return array
	 **/
	public function user($column = '')
	{
		$this->load->library('users/ion_auth');
		$this->load->model('users/user', 'user_model');
		
		return $this->user_model->current($column);
	}

	/**
	 * Generate slug value
	 *
	 * @param string $string  value to generate a slug for
	 * @param int $id  id to insert into the slug
	 * @param int $length  number of character for the slug
	 *
	 * @return string
	 **/
	public function gen_sku($string, $id = null, $length = 3)
	{
		$string = str_replace('_', '', $string);
		$string = str_replace('-', '', $string);
		$result = ''; // empty string
		$vowels = array('a', 'e', 'i', 'o', 'u', 'y'); // vowels

		// Match every word that begins with a capital letter,
		// add ucfirst() in case there is no uppercase letter
		preg_match_all('/[A-Z][a-z]*/', ucfirst($string), $m);

		foreach($m[0] as $substring)
		{
			// String to lower case and remove all vowels
			$substring = str_replace($vowels, '', strtolower($substring));
			$result   .= preg_replace('/([a-z]{'.$length.'})(.*)/', '$1', $substring); // Extract the first 'N' letters.
			$result    = strtoupper($result);
		}
		
		if ($id) $result .= '-'. str_pad($id, 4, 0, STR_PAD_LEFT); // Add the ID

		return $result;
	}

	/**
	 * Arrary to store hierrachy of lineage
	 *
	 * @var string
	 **/
	private $lineage = array();
	/**
	 * Generate a hierrachy of relational inheritance
	 * for table with foreign keys of themselves
	 *
	 * @param string $table  table's name
	 * @param int $id  table's unique key
	 * @param array $select colums to select.
	 *
	 * @return array.
	 **/
	public function lineage($table, $id, $select)
	{
		// Get the category meta data.
		$this->db->from($table);
		$this->db->where('id', $id);
		$this->db->select($select);
		$this->db->select('parent_id');
		$tier = $this->db->get()->result_array();
			
		// If this category has data (exists).
		if ( ! empty($tier)) {
			// Add category to lineage array.
			array_push($this->lineage, $tier[0]);
			// Repeat this process.
			$this->lineage($table, $tier[0]['parent_id'], $select);
		}

		// Reverse the lineage to get proper hierrachy.
		return array_reverse($this->lineage);
	}
}