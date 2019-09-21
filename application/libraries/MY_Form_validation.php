<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Custom Validation Callbacks
|--------------------------------------------------------------------------
| Set custom rules to be used for form validation.
|
*/

class MY_Form_validation extends CI_Form_validation
{
    function __construct($rules = array())
    {
        parent::__construct($rules);
    }

	public function __get($var)
	{
		return get_instance()->$var;
    }
    
	/**
	 * Hack to enable custom validations work with HMVC.
	 *
	 * @return object
	 **/
	function run($module = '', $group = '')
	{
		(is_object($module)) AND $this->CI = &$module;
		return parent::run($group);
	}


	/**
	 * Check whether a file was uploaded
	 *
	 * @return boolean
	 **/
	function userfile_check()
	{
		if ($_FILES['avatar']['size'] > 0) {
			return TRUE;
		} else {
			$this->form_validation->set_message('userfile_check', 'The {field} file is required');
			return FALSE;
		}
	}

	/**
	 * Check whether date is current or in the future
	 *
	 * @return boolean
	 **/
	function valid_date($date, $format = 'd-m-Y')
	{
		$test_arr  = explode('/', $date);
		
		if (count($test_arr) == 3) {
			return checkdate($test_arr[0], $test_arr[1], $test_arr[2]);
		}
		return false;
	}

	/**
	 * Check whether date is current or in the future
	 *
	 * @return boolean
	 **/
	function date_not_passed($str)
	{
        $this->load->helper('date');
        
		if (strtotime(date('Y-m-d')) <= strtotime($str))
		{
			return TRUE;
		}
		else
		{
            $this->form_validation->set_message('is_date_valid', 'The {field} must not be in the past');
			return FALSE;
		}
	}

	/**
	 * Check whether a password matches one stored in the database.
	 *
	 * @return boolean
	 **/
	public function password_check($password, $user_id)
	{
		if ($this->ion_auth->hash_password_db($user_id, $password)){
			return TRUE;
		}else{
			$this->form_validation->set_message('password_check', lang('alert_password_incorrect'));
			return FALSE;
		}
	}
}

/* End of file MY_form_validation.php */
/* Location: ./application/libraries/MY_form_validation.php */