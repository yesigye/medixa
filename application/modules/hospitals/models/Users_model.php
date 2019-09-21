<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
    protected $table = 'companies_users';
	public $error_message = '';
    public $count = 0;

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

	public function count($hospital_id)
	{
        $this->db->where('company_id', $hospital_id);
		return $this->db->count_all_results($this->table);
    }
    
    public function inHospital($hospital_id)
    {
        $ids = [];
        $this->db->where('company_id', $hospital_id);
        $query = $this->db->get_where($this->table, array(
            'company_id' => $hospital->id
        ))->result();
        
        foreach ($query as $row) {
            array_push($ids, $row->doctor_id);
        }

        return $ids;
    }
}