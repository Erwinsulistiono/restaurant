<?php
class M_dashboard extends CI_Model
{

	public function get_total_penjualan($outlet)
	{
		$query = $this->db->select('SUM(trx_grand_total) AS total')
			->from("tbl_lap_trx_$outlet")
			->get();

		return $query->row()->total;
	}

	public function get_total_penjualan_bulan_ini($outlet)
	{
		$query = $this->db->select('SUM(trx_grand_total) AS total')
			->from("tbl_lap_trx_$outlet")
			->where('MONTH(trx_date) = MONTH(CURDATE())')
			->get();

		return $query->row()->total;
	}

	public function get_total_porsi($outlet)
	{
		$query = $this->db->select('SUM(order_qty) AS total')
			->from("tbl_lap_order_$outlet")
			->get();

		return $query->row()->total;
	}

	public function get_total_porsi_bulan_ini($outlet)
	{
		$query = $this->db->select('SUM(order_qty) AS total')
			->from("tbl_lap_order_$outlet")
			->where('MONTH(order_date) = MONTH(CURDATE())')
			->get();

		return $query->row()->total;
	}
}
