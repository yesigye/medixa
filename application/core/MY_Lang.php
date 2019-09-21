<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Lang extends MX_Lang
{
    /**
	 * Refactor: base language provided inside system/language
	 * 
	 * @var string
	 */
	public $base_language = 'english';
	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
    /**
     * Fetch a single line of text from the language array
     * Replace argument placeholders with values
     *
     * Usage:
     * # this msg is in your language file
     * $lang['hello_key'] = "Hello %s, you are visitor number %d";
     * ...
     * $this->lang->load('hello_language_file_name','english');
     * $msgvalues = array("Peter",21);
     * $msg = $this->lang->line('hello_key', $msgvalues);     
     *
     * @access    public
     * @param    string    the language line key
     * @param    mixed    argument or array of arguments
     * @return    string
     */

    function line($line = '', $swap = null) {
        $loaded_line    = parent::line($line);
        // If swap if not given, just return the line from the language file (default codeigniter functionality.)
        if(!$swap) return $loaded_line;

        // If an array is given
        if (is_array($swap)) {
            // Explode on '%s'
            $exploded_line = explode('%s', $loaded_line);

            // Loop through each exploded line
            foreach ($exploded_line as $key => $value) {
                // Check if the $swap is set
                if(isset($swap[$key])) {
                    // Append the swap variables
                    $exploded_line[$key] .= $swap[$key];
                }
            }
            // Return the implode of $exploded_line with appended swap variables
            return implode('', $exploded_line);
        }
        // A string is given, just do a simple str_replace on the loaded line
        else {
            return str_replace('%s', $swap, $loaded_line);
        }
    }

    /**
     * Load a language file
     *
     * @access    public
     * @param    mixed    the name of the language file to be loaded. Can be an array
     * @param    string    the language (english, etc.)
     * @return    mixed
     */
    function load($langfile = '', $idiom = '', $return = false, $add_suffix = TRUE, $alt_path = '', $_module = '')
    {
        // Calling early before CI reformats them
        $this->set = $langfile;
        $this->idiom = $idiom;
        $langfile = str_replace('.php', '', str_replace('_lang.', '', $langfile)) . '_lang' . '.php';
        if (in_array($langfile, $this->is_loaded, true)) {
            return;
        }
        if ($idiom == '') {
            $CI =& get_instance();
            $deft_lang = $CI->config->item('language');
            $idiom = ($deft_lang == '') ? 'english' : $deft_lang;
            $this->idiom = $idiom;
        }
        // Determine where the language file is and load it
        if (file_exists(APPPATH . 'language/' . $idiom . '/' . $langfile)) {
            include(APPPATH . 'language/' . $idiom . '/' . $langfile);
        } else {
            if (file_exists(BASEPATH . 'language/' . $idiom . '/' . $langfile)) {
                include(BASEPATH . 'language/' . $idiom . '/' . $langfile);
            } else {
                $database_lang = $this->_get_from_db();
                if ( ! empty($database_lang)) {
                    $lang = $database_lang;
                } else {
                    show_error('Unable to load the requested language file: language/' . $langfile);
                }
            }
        }
        if (!isset($lang)) {
            log_message('error', 'Language file contains no data: language/' . $idiom . '/' . $langfile);
            return;
        }
        if ($return == true) {
            return $lang;
        }
        $this->is_loaded[] = $langfile;
        $this->language = array_merge($this->language, $lang);
        unset($lang);
        log_message('debug', 'Language file loaded: language/' . $idiom . '/' . $langfile);
        return true;
    }
    /**
     * Load a language from database
     *
     * @access    private
     * @return    array
     */
    private function _get_from_db()
    {
        $CI =& get_instance();

        if(! $CI->db->table_exists('languages')) return;
        
        $languages = [];
        $CI->load->model('admin/languages');
        $query = $CI->languages->get_translations($this->idiom);
        
        foreach ($query as $row) {
            $languages[$row['key']] = $row[($this->idiom === $CI->languages->default_language  ? 'text' : 'translation')];
        }
        
        unset($CI, $query);

        return $languages;
    }
}