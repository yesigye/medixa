<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
    }
    
    public function values($value = '')
    {
        if ($value !== '') $this->db->select($value);

		$this->db->from('settings');
		$this->db->limit(1);
        $config = $this->db->get()->result_array();
        
        if (!empty($config)) {
            $config = $config[0];
            return ($value !== '') ? $config[$value] : $config;
        } else {
            return null;
        }
    }

    public function update($data)
    {
        $this->db->update('settings', $data);

        return $this->db->affected_rows();
    }
}