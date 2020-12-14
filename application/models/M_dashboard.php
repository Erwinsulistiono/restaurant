<?php
class M_dashboard extends CI_Model
{


	public function get_total_penjualan($outlet)
	{
		$query = $this->db->query("SELECT SUM(trx_grand_total) AS total FROM tbl_lap_trx_$outlet");
		return $query->row()->total;
	}

	public function get_total_penjualan_bulan_ini($outlet)
	{
		$query = $this->db->query("SELECT SUM(trx_grand_total) AS total FROM tbl_lap_trx_$outlet WHERE MONTH(trx_date)=MONTH(CURDATE())");
		return $query->row()->total;
	}

	public function get_total_porsi($outlet)
	{
		$query = $this->db->query("SELECT SUM(order_qty) AS total FROM tbl_lap_order_$outlet");
		return $query->row()->total;
	}

	public function get_total_porsi_bulan_ini($outlet)
	{
		$query = $this->db->query("SELECT SUM(order_qty) AS total FROM tbl_lap_order_$outlet WHERE MONTH(order_date)=MONTH(CURDATE())");
		return $query->row()->total;
	}
}