<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MX_Controller
{
	public function __construct()
	{

        $this->load->library(['unit_test', 'payment']);
        // $this->unit->use_strict(TRUE);
        // $this->output->enable_profiler();
    }
    
	/**
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * @param	$var
     * 
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
    }

    public function index()
    {
        $this->payment->send();
        // $this->unit->run($this->payment->send(), 'is_array', 'Get a user\'s details', '');
		// echo $this->unit->report();
    }

    public function okay(String $var = '')
    {
        $this->payment->done();
    }

    public function fail(String $var = '')
    {
        $token = $this->input->get('token');
        echo 'canceled <hr>';
        var_dump($token);
    }
}