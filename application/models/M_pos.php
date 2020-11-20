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
		$query = $this->db->query('SELECT * FROM tbl_order_' . $outlet . ' WHERE order_trx_reff = ' . $id);
		return $query->result_array();
	}

	public function getAllOrderFromMobilePos($id, $outlet)
	{
		$query = $this->db->query('SELECT * FROM cust_order_' . $outlet . ' WHERE order_userid = ' . $id);
		return $query->result_array();
	}

	public function get_qty_diff($id, $qty, $outlet)
	{
		$query = $this->db->query('SELECT a.stock_id, a.stock_nama, a.stock_qty - (b.ing_qty * c.satuan_val * ' . $qty . ') as stock_qty FROM tbl_stock_' . $outlet . ' a
		INNER JOIN tbl_ingredient b ON a.stock_id=b.ing_inv_id
		INNER JOIN tbl_satuan c ON b.ing_satuan_id=c.satuan_id 
		WHERE b.ing_menu_id = ' . $id);
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
	}

	public function getById($tgl, $user, $outlet)
	{
		$query = $this->db->query("SELECT * FROM tbl_kas_harian WHERE kas_tgl = '$tgl' AND kas_nm_kasir = '$user' AND kas_kd_outlet = '$outlet'");
		return $query->row()->kas_id;
	}

	public function getAllOrderPrint($id, $outlet)
	{
		$query = $this->db->query('SELECT * FROM tbl_lap_order_' . $outlet . ' WHERE order_trx_reff = ' . $id);
		return $query->result_array();
	}

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

	public function getIngredientAll($outlet)
	{
		$query = $this->db->query("SELECT ing_id, ing_menu_id, ing_inv_id, ing_qty, satuan_val, stock_qty, b.*
									FROM tbl_ingredient AS a
									LEFT JOIN tbl_menu_$outlet AS b ON a.ing_menu_id=b.menu_id
									LEFT JOIN tbl_stock_$outlet AS c ON a.`ing_inv_id` = c.`stock_id`
									LEFT JOIN tbl_satuan AS d ON a.`ing_satuan_id`=d.`satuan_id`");
		return $query->result_array();
	}

	public function updateStock($outlet, $id, $qty)
	{
		$this->db->query("UPDATE restaurant.tbl_stock_$outlet SET stock_qty = stock_qty - $qty WHERE stock_id = $id");
	}

	function insertBulkOrder($data, $outlet)
	{
		$this->db->insert_batch('tbl_order_' . $outlet, $data);
		// return $this->db->affected_rows() > 0;
	}

	public function customerHadOrder()
	{
		$this->db->select('plg_id, plg_nama, plg_meja, plg_alamat, plg_notelp, plg_platno, plg_order');
		$this->db->from('tbl_pelanggan');
		$this->db->where('plg_order > ', 0);
		$query = $this->db->get();
		return $query->result_array();
	}
}
