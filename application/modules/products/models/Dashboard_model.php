<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_orders_total()
	{
		$grandTotal = 0;

		$query = $this->db->query(
			'SELECT IFNULL(SUM(order_summary.ord_total), 0) total
			 FROM order_summary
			 GROUP BY ord_date WITH ROLLUP;'
			);
		$data = $query->result_array();

		if (!empty($data)) {

			// Get the value of the last summation.
			$grandTotal = $data[count($data)-1]['total'];
		}
		return $grandTotal;
	}

	public function get_monthly_revenue($year, $months)
	{
		$this->db->reset_query();

		$result = array();

		for ($i=0; $i < 12; $i++) {

			$diff = $months - $i;

			if ($diff > 0) {

				if ($diff < 10) {
					$date 	= $year.'-0'.$diff;
				}else {
					$date 	= $year.'-'.$diff;
				}

				$this->db->select('ord_date AS month');
				$this->db->select('IFNULL(SUM(order_summary.ord_total), 0) AS sales');
				$this->db->like('ord_date', $date);
				$this->db->group_by('order_summary.ord_order_number');
				$data = $this->db->get('order_summary')->result_array();

				if(!empty($data[0]['month'])) {
					array_push($result, $data[0]);
				} else {
					array_push($result, array(
						'month' => $date,
						'sales' => 0.00,
						));
				}
			}
		}
		krsort($result);
		return array_values($result);
	}

	public function get_monthly($year, $month)
	{
		$this->db->reset_query();

		$result = array();

		for ($i=0; $i < 12; $i++) {

			$diff = $month - $i;

			if ($diff > 0) {

				if ($diff < 10) {
					$date 	= $year.'-0'.$diff;
				}else {
					$date 	= $year.'-'.$diff;
				}

				$this->db->select('ord_date AS month');
				$this->db->select('IFNULL(SUM(order_summary.ord_total), 0) AS sales');
				$this->db->like('ord_date', $date);
				$data = $this->db->get('order_summary')->result_array();

				if(!empty($data[0]['month'])) {
					array_push($result, $data[0]);
				} else {
					array_push($result, array(
						'month' => $date,
						'sales' => 0.00,
						));
				}
			}
		}
		krsort($result);
		return array_values($result);
	}
}