<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages extends CI_Model
{
	/**
	 * Default Languages
	 *
	 * This is the language others will translate against.
	 *
	 * @var string
	 **/
	public $default_language = 'english';
	
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
	 * Return all languages
	 *
	 * @return array
	 **/
	public function get_languages()
	{
		return $this->db->get('languages')->result_array();
	}

	/**
	 * Return all languages sets
	 *
	 * @return array
	 **/
	public function get_sets()
	{
		return $this->db
		->select('set')
		->group_by('set')
		->get('lang_translations')
		->result_array();
	}

	/**
	 * Return all languages translations
	 * 
	 * @param string $langauge name of the language
	 *
	 * @return array
	 **/
	public function get_translations($langauge)
	{
		// Get translated language texts into a sub query
		$this->db->from('lang_translations trans');
		$this->db->select('trans.id, trans.set, trans.key, trans.text AS translation');
		$this->db->where('languages.language', $langauge);
		$this->db->join('languages', 'languages.id = trans.language_id', 'left');
		$subquery = $this->db->get_compiled_select();
		
		$this->db->reset_query();
		
		// Get default language info.
		$this->db->from('lang_translations lang');
		$this->db->select('lang.set, lang.key, lang.text, trans.id As trans_id, trans.translation');
		$this->db->group_by('lang.set, lang.key, lang.text, trans.id, trans.translation');
		$this->db->where('languages.language', $this->default_language);
		$this->db->join('languages', 'languages.id = lang.language_id', 'left');

		// Join the default language info and the translated texts
		$this->db->join("($subquery) trans", 'trans.set = lang.set AND trans.key = lang.key', 'left', true);

		return $this->db->get()->result_array();
	}

	/**
	 * Add a new language
	 * @param string $name name of the language
	 * @param string $lang name of the language being edited
	 * 
	 * @return array
	 **/
	public function save(String $name, String $lang = '')
	{
		$this->db->set('language', $name);

		if($lang) {
			$this->db->where('language', $lang)->update('languages');
		} else {
			$this->db->insert('languages');
		}
		
		return $this->db->affected_rows();
	}

	/**
	 * Update translations
	 * 
	 * @return array
	 **/
	public function save_translations(String $langauge, Array $translations)
	{
		if($lang_id = $this->getLangId($langauge)) {
			
			foreach ($translations as $key => $row) {
				
				if( ! $row['translation']) continue;

				$this->db->set('set', $row['set']);
				$this->db->set('key', $row['key']);
				$this->db->set('text', $row['translation']);
				$this->db->set('language_id', $lang_id);
				
				if ($row['trans_id']) $this->db->set('id', $row['trans_id']);

				$this->db->replace('lang_translations');
			}
			
			return $this->db->affected_rows();

		} else {
			// This language does not exist.
			$this->set_error_message(lang('alert_modifying_missing_item'));
			
			return false;
		}
	}


	public function delete(String $name)
	{
		// sorry. can't delete the default language.
		if ($name === $default_language) return false;

		if($lang_id = $this->getLangId($name)) {
			$this->db->where('language_id', $lang_id)->delete('lang_translations');
			$this->db->where('language', $name)->delete('languages');
	
			return $this->db->affected_rows();
		} else {
			// This language does not exist.
			$this->set_error_message(lang('alert_modifying_missing_item'));
			return false;
		}
	}

	public function getLangId(String $name)
	{
		$lang = $this->db->select('id')->where('language', $name)->get('languages')->result();

		if(empty($lang)) return null;

		return $lang[0]->id;
	}
}