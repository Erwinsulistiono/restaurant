<?php
class M_pos extends CI_Model
{

	public function search_voucher($title)
	{
		$date = date('Y-m-d');
		$this->db->where('voucher_periode_akhir > ', $date);
		$this->db->where('voucher_periode_awal < ', $date);
		$this->db->where('voucher_limit != ', '0');
		$this->db->like('voucher_kode', $title, 'none');
		$this->db->limit(1);
		$query =  $this->db->get('tbl_voucher');
		return $query->result_array();
	}

	public function potongQtyVoucher($id)
	{
		$this->db->query("UPDATE `tbl_voucher` SET `voucher_limit` = `voucher_limit` - 1 WHERE voucher_id = " . $id);
	}

	public function getAllOrderPos($id, $outlet)
	{
		$this->db->select('*');
		$this->db->from("tbl_order_$outlet as tbl1");
		$this->db->where("order_trx_reff = $id");
		$this->db->join("tbl_menu_$outlet as tbl2", "tbl1.order_menu=tbl2.menu_id", "left");
		$query = $this->db->get();
		// $query = $this->db->query('SELECT * FROM tbl_order_' . $outlet . ' WHERE order_trx_reff = ' . $id);
		return $query->result_array();
	}

	public function getAllOrderFromMobilePos($id, $outlet)
	{
		$this->db->select('*');
		$this->db->from("cust_order_$outlet AS tbl1");
		$this->db->join("tbl_menu_$outlet AS tbl2", "tbl1.order_menu=tbl2.menu_id", "left");
		$this->db->where("order_userid = $id");
		$query = $this->db->get();

		return $query->result_array();
	}

	public function getDataCashInSaldo($tgl, $user, $outlet)
	{
		$query = $this->db->get_where('tbl_kas_harian_' . $outlet, ['kas_tgl > ' => $tgl, 'kas_nm_kasir' => $user, 'kas_saldo_akhir' => 0]);
		return $query->row_array();
	}

	public function getLatestDateSaldo($outlet)
	{
		$query = $this->db->query("SELECT DATE(kas_tgl) AS kas_tgl FROM tbl_kas_harian_$outlet WHERE kas_id IN (
									SELECT MAX(kas_id) FROM tbl_kas_harian_$outlet
									);");
		return $query->row()->kas_tgl;
	}

	public function resetNomorTransaksiHarian($outlet)
	{
		$this->db->query("TRUNCATE tbl_trx_pos_$outlet");
		$this->db->query("TRUNCATE tbl_order_$outlet");
		$this->db->query("UPDATE tbl_meja_$outlet SET meja_pelanggan = 0;");
		$this->db->query("UPDATE tbl_pelanggan SET plg_order = 0;");
		$this->db->query("UPDATE tbl_pelanggan SET plg_login_flg = 'N';");
		$this->db->query("UPDATE tbl_pelanggan SET plg_meja = '';");
	}

	public function getById($tgl, $user, $outlet)
	{
		$query = $this->db->query("SELECT * FROM tbl_kas_harian WHERE kas_tgl = '$tgl' AND kas_nm_kasir = '$user' AND kas_kd_outlet = '$outlet'");
		return $query->row()->kas_id;
	}

	// public function getAllOrderPrint($id, $outlet)
	// {
	// 	$query = $this->db->query('SELECT * FROM tbl_lap_order_' . $outlet . ' WHERE order_trx_reff = ' . $id);
	// 	return $query->result_array();
	// }

	public function getLastAutoIncrementId($outlet)
	{
		$db = $this->db->database;
		$query = $this->db->query("SELECT `AUTO_INCREMENT`
									FROM  INFORMATION_SCHEMA.TABLES
									WHERE TABLE_SCHEMA = '$db'
									AND   TABLE_NAME   = 'tbl_trx_pos_$outlet';");
		return $query->row()->AUTO_INCREMENT;
	}

	public function getMobileTrx($outlet)
	{
		$query = $this->db->query("SELECT a.*, b.`plg_nama` AS order_username , 
												b.`plg_alamat` AS order_alamat, 
												b.`plg_platno` AS order_platno, 
												b.`plg_notelp` AS order_telp, c.* , d.* , e.*
									FROM cust_order_$outlet AS a LEFT JOIN tbl_pelanggan AS b ON a.`order_userid`=b.`plg_id`
															LEFT JOIN tbl_meja_$outlet AS c ON c.`meja_id`=a.`order_table`
															LEFT JOIN tbl_area AS d ON c.`meja_lokasi`=d.`area_id`
															LEFT JOIN tbl_voucher AS e ON a.`order_voucher_id`=e.`voucher_id`
									GROUP BY order_userid;");
		return $query->result_array();
	}

	public function joinMobileOrderPelangganMeja($outlet)
	{
		$this->db->select('*');
		$this->db->from('cust_order_' . $outlet);
		$this->db->join('tbl_pelanggan', 'tbl_pelanggan.plg_id = cust_order_' . $outlet . '.order_userid', 'left');
		$this->db->join('tbl_meja_' . $outlet, 'tbl_meja_' . $outlet . '.meja_id = tbl_pelanggan.plg_meja', 'left');
		$this->db->join('tbl_area', 'tbl_area.area_id = tbl_meja_' . $outlet . '.meja_lokasi', 'left');
		$this->db->group_by("order_userid");
		$query = $this->db->get();
		return $query->result_array();
	}
}
