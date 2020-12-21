<?php
class M_pos extends CI_Model
{

	public function search_voucher($title)
	{
		$date = date('Y-m-d');

		$query = $this->db->where('voucher_periode_akhir > ', $date)
			->where('voucher_periode_awal < ', $date)
			->where('voucher_limit != ', '0')
			->like('voucher_kode', $title, 'none')
			->limit(1)
			->get('tbl_voucher');

		return $query->result_array();
	}

	public function potongQtyVoucher($id)
	{
		$this->db->set('voucher_limit', 'voucher_limit-1', FALSE)
			->where('voucher_id', $id)
			->update('tbl_voucher');
	}

	public function getAllOrderPos($id, $outlet_id)
	{
		$query = $this->db->select()
			->from("tbl_order_$outlet_id AS tbl1")
			->where('order_trx_reff', $id)
			->join("tbl_menu_$outlet_id AS tbl2", "tbl1.order_menu=tbl2.menu_id", "LEFT")
			->get();

		return $query->result_array();
	}

	public function getAllOrderFromMobilePos($id, $outlet_id)
	{
		$query = $this->db->select()
			->from("cust_order_$outlet_id AS tbl1")
			->join("tbl_menu_$outlet_id AS tbl2", "tbl1.order_menu=tbl2.menu_id", "LEFT")
			->where('order_userid', $id)
			->get();

		return $query->result_array();
	}

	public function get_qty_diff($id, $qty, $outlet_id)
	{
		$query = $this->db->select("stock_id, stock_nama, (stock_qty - ing_qty * satuan_val * $qty) AS stock_qty")
			->from("tbl_stock_$outlet_id AS tbl1")
			->join('tbl_ingredient AS tbl2', 'tbl1.stock_id=tbl2.ing_inv_id', 'INNER')
			->join('tbl_satuan AS tbl3', 'tbl2.ing_satuan_id=tbl3.satuan_id', 'INNER')
			->where('ing_menu_id', $id)
			->get();

		return $query->result_array();
	}

	public function get_saldo_cash_in($tgl, $user, $outlet_id)
	{
		$query = $this->db->select("tbl_kas_harian_$outlet_id")
			->where('kas_tgl', $tgl)
			->where('kas_nm_kasir', $user)
			->where('kas_saldo_akhir', 0);

		return $query->row_array();
	}

	public function get_latest_saldo_per_date($outlet_id)
	{
		// Sub Query
		$subQuery = $this->db->select('MAX(kas_id)')
			->from("tbl_kas_harian_$outlet_id")
			->get_compiled_select();

		// Main Query
		$query = $this->db->select('DATE(kas_tgl) AS kas_tgl')
			->from("tbl_kas_harian_$outlet_id")
			->where("kas_id IN ($subQuery)", NULL, FALSE)
			->get()
			->row()->kas_tgl;
		return $query;
	}

	public function reset_nomor_transaksi_harian($outlet_id)
	{
		$this->db->query("TRUNCATE tbl_trx_pos_$outlet_id");
		$this->db->query("TRUNCATE tbl_order_$outlet_id");
	}

	public function getById($tgl, $user, $outlet_id)
	{
		$query = $this->db->select('kas_id')
			->from('tbl_kas_harian')
			->where('kas_tgl', $tgl)
			->where('kas_nm_kasir', $user)
			->where('kas_kd_outlet', $outlet_id)
			->get();

		return $query->row()->kas_id;
	}

	public function getAllOrderPrint($id, $outlet_id)
	{
		$query = $this->db->select()
			->from("tbl_lap_order_$outlet_id")
			->where('order_trx_reff', $id);

		return $query->result_array();
	}

	public function getLastAutoIncrementId($outlet_id)
	{
		$db = $this->db->database;
		$query = $this->db->select('AUTO_INCREMENT')
			->from('INFORMATION_SCHEMA.TABLES')
			->where('TABLE_SCHEMA', $db)
			->where('TABLE_NAME', "tbl_trx_pos_$outlet_id");

		return $query->row()->AUTO_INCREMENT;
	}

	public function getMobileTrx($outlet_id)
	{
		$query = $this->db->select('*, plg_nama AS order_username, plg_alamat AS order_alamat, plg_platno AS order_platno, plg_notelp AS order_telp')
			->from("cust_order_$outlet_id AS tbl1")
			->join('tbl_pelanggan AS tbl2', 'tbl1.order_userid = tbl2.plg_id', 'LEFT')
			->join("tbl_meja_$outlet_id AS tbl3", 'tbl1.order_table = tbl3.meja_id', 'LEFT')
			->join('tbl_area AS tbl4', 'tbl4.area_id = tbl3.meja_lokasi', 'LEFT')
			->join('tbl_voucher AS tbl5', 'tbl5.voucher_id = tbl1.order_voucher_id', 'LEFT')
			->group_by('order_userid');

		return $query->result_array();
	}

	public function getIngredientAll($outlet_id)
	{
		$query = $this->db->select()
			->from('tbl_ingredient AS tbl1')
			->join("tbl_menu_$outlet_id AS tbl2", "tbl2.menu_id = tbl1.ing_menu_id", 'LEFT')
			->join("tbl_stock_$outlet_id AS tbl3", "tbl3.stock_id = tbl1.ing_inv_id", 'LEFT')
			->join('tbl_satuan AS tbl4', 'tbl4.satuan_id = tbl1.ing_satuan_id');

		return $query->result_array();
	}

	public function joinMobileOrderPelangganMeja($outlet_id)
	{
		$query = $this->db->select()
			->from("cust_order_$outlet_id AS tbl1")
			->join('tbl_pelanggan AS tbl2', 'tbl2.plg_id = tbl1.order_userid', 'LEFT')
			->join("tbl_meja_$outlet_id AS tbl3", 'tbl3.meja_id = tbl2.plg_meja', 'LEFT')
			->join('tbl_area AS tbl4', 'tbl4.area_id = tbl3.meja_lokasi', 'LEFT')
			->group_by("order_userid")
			->get();
		return $query->result_array();
	}
}
