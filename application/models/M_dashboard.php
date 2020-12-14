<?php
class M_dashboard extends CI_Model
{


	public function getTotalPenjualan($outlet)
	{
		$query = $this->db->query("SELECT SUM(trx_grand_total) AS total FROM tbl_lap_trx_$outlet");
		return $query->row()->total;
	}

	public function getTotalPenjualanThisMonth($outlet)
	{
		$query = $this->db->query("SELECT SUM(trx_grand_total) AS total FROM tbl_lap_trx_$outlet WHERE MONTH(trx_date)=MONTH(CURDATE())");
		return $query->row()->total;
	}

	public function getTotalPorsi($outlet)
	{
		$query = $this->db->query("SELECT SUM(order_qty) AS total FROM tbl_lap_order_$outlet");
		return $query->row()->total;
	}

	public function getTotalPorsiThisMonth($outlet)
	{
		$query = $this->db->query("SELECT SUM(order_qty) AS total FROM tbl_lap_order_$outlet WHERE MONTH(order_date)=MONTH(CURDATE())");
		return $query->row()->total;
	}
}