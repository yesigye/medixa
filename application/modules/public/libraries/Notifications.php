<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Notifications
*
* Author: Ignatius Yesigye
*		  ignatiusyesigye@gmail.com
*/

class Notifications
{
	/**
	 * __construct
	 */
	public function __construct()
	{
		$this->load->model(array('notification_model'));
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
	 * appointments
	 *
	 * @access	public
	 * @return object
	 **/
	public function appointments()
	{
		$notifications = [];

		$this->load->model(['appointments/appointments_model']);
		
		$aptCount = $this->appointments_model->all([
			'user' => $_SESSION['user_id'],
			'view' => 'unread',
			'pending' => true,
			'count' => true,
		]);

		if ($aptCount > 0) {
			array_push($notifications, [
				'link'=> 'appointments',
				'message'=> $aptCount." new appointment".(($aptCount>1)?'s':''),
			]);
		}

		return $notifications;
	}

	/**
	 * clear_appointments
	 *
	 * @access	public
	 * @return object
	 **/
	public function clear_appointments($id, $status)
	{
		return $this->notification_model->clear_appointments($id, $status);
	}
}
