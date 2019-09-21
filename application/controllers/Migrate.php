<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

	public function index()
	{
		// $this->load->library('migration');

		// if ( ! $this->migration->latest()) {
		// 	show_error($this->migration->error_string());
		// } else {
		// 	redirect('locations/migrate');
		// }
		// // $this->_backup();

		$this->_import();
	}
	
	private function _import(String $file = 'medixa-demo.sql')
	{
		$this->load->database();
		
		if (file_exists($file)) {
			$lines = file($file);
			$statement = '';
			
			foreach ($lines as $line) {
				$statement .= $line;
				
				if (substr(trim($line), -1) === ';') {
					$this->db->simple_query($statement);
					$statement = '';
				}
			}

			echo 'Migrated successfully';
		} else {
			die('File does not exit');
		}
	}
	
	public function _backup(String $file = 'database_demo.sql')
	{
		$this->load->dbutil();
		$this->load->helper(['file', 'download']);
	
		$backup =& $this->dbutil->backup([
			'format' => 'txt',
			'add_insert' => true
		]);
	
		write_file($file, $backup);
		force_download($file, $backup);
	}
}

/* End of file Migrate.php */
/* Location: ./application/controllers/Migrate.php */