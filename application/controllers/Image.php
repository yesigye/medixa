<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Controller {

	public function _remap()
	{
		// Load the upload config file to get upload path.
		$this->load->config('upload');
		$upload_path = $this->config->item('upload')['file_path'];
		// Get requested filename from URI.
		$filepath = $upload_path.$this->uri->segment(2);

		$this->load->helper('file');
		
		if ($image = read_file($filepath)) {
			header('Content-Type: image/jpeg');
			echo $image;
		} else {
			header("HTTP/1.0 404 Not Found");
			echo "404 Not Found";
		}
	}
}

/* End of file Image.php */
/* Location: ./application/controllers/Image.php */