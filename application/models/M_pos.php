<?php
class M_pos extends CI_Model
{

  public function get_all_table($outlet_id)
  {
    $query = $this->db->select('tbl1.meja_id, tbl1.meja_nama, tbl2.area_level, tbl2.area_nama, tbl4.trx_id, tbl4.trx_date')
      ->select('tbl1.meja_cptcy, tbl3.plg_nama, tbl3.plg_notelp, tbl3.plg_order, tbl4.trx_kitchen_flg, tbl4.trx_waitress_flg,')
      ->select('tbl4.trx_payment, tbl3.plg_id')
      ->from("tbl_meja_$outlet_id AS tbl1")
      ->join('tbl_area AS tbl2', 'tbl1.meja_lokasi = tbl2.area_id', 'LEFT')
      ->join('tbl_pelanggan AS tbl3', 'tbl1.meja_pelanggan = tbl3.plg_id', 'LEFT')
      ->join("tbl_trx_pos_$outlet_id AS tbl4", 'tbl4.trx_id = tbl3.plg_order', 'LEFT')
      ->get();

    return $query->result_array();
  }


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


  public function select_order($trx_id, $outlet_id)
  {
    $query = $this->db->select()
      ->from("tbl_order_$outlet_id AS tbl1")
      ->where('order_trx_reff', $trx_id)
      ->join("tbl_menu_$outlet_id AS tbl2", "tbl2.menu_id = tbl1.order_menu", "LEFT")
      ->get();

    return $query->result_array();
  }


  public function select_trx($outlet_id)
  {
    $query = $this->db->select()
      ->from("tbl_lap_trx_$outlet_id")
      ->order_by('trx_id')
      ->limit(1)
      ->get();

    return $query->result_array();
  }


  public function get_mobile_customer_order($id, $outlet_id)
  {
    $query = $this->db->select()
      ->from("cust_order_$outlet_id AS tbl1")
      ->join("tbl_menu_$outlet_id AS tbl2", "tbl1.order_menu=tbl2.menu_id", "LEFT")
      ->where('order_userid', $id)
      ->get();

    return $query->result_array();
  }


  public function get_saldo_cash_in($tgl, $user, $outlet_id)
  {
    $query = $this->db->select()
      ->from("tbl_kas_harian_$outlet_id")
      ->where('kas_tgl >=', $tgl)
      ->where('kas_nm_kasir', $user)
      ->where('kas_saldo_akhir', 0)
      ->get();

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


  public function getLastAutoIncrementId($outlet_id)
  {
    $db = $this->db->database;
    $query = $this->db->select('AUTO_INCREMENT')
      ->from('INFORMATION_SCHEMA.TABLES')
      ->where('TABLE_SCHEMA', $db)
      ->where('TABLE_NAME', "tbl_trx_pos_$outlet_id")
      ->get();

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
      ->group_by('order_userid')
      ->get();

    return $query->result_array();
  }


  public function get_customer_order_per_table($outlet_id)
  {
    $query = $this->db->select()
      ->from("cust_order_$outlet_id AS tbl1")
      ->join('tbl_pelanggan AS tbl2', 'tbl2.plg_id = tbl1.order_userid', 'LEFT')
      ->join("tbl_meja_$outlet_id AS tbl3", 'tbl3.meja_id = tbl2.plg_meja', 'LEFT')
      ->join('tbl_area AS tbl4', 'tbl4.area_id = tbl3.meja_lokasi', 'LEFT')
      ->join('tbl_voucher AS tbl5', 'tbl5.voucher_id = tbl1.order_voucher_id', 'LEFT')
      ->group_by("order_userid")
      ->get();

    return $query->result_array();
  }

  public function fetch_all_transaksi_by_tipe($outlet_id, $tipe_trx)
  {
    $query = $this->db->select()
      ->from("tbl_trx_pos_$outlet_id AS tbl1")
      ->join('tbl_pelanggan AS tbl2', 'tbl2.plg_order = tbl1.trx_id', 'LEFT')
      ->where("trx_tipe", $tipe_trx)
      ->get();

    return $query->result();
  }

  public function plg_sudah_order()
  {
    $query = $this->db->select('plg_id, plg_nama, plg_meja, plg_alamat, plg_notelp, plg_platno, plg_order')
      ->from('tbl_pelanggan')
      ->where('plg_order > ', 0)
      ->get();

    return $query->result_array();
  }

  public function get_semua_ingredient($outlet)
  {
    $query = $this->db->select('a.ing_id, a.ing_menu_id, a.ing_inv_id, a.ing_qty, d.satuan_val, c.stock_qty, b.*')
      ->from('tbl_ingredient AS a')
      ->join("tbl_menu_$outlet AS b", 'a.ing_menu_id=b.menu_id', 'LEFT')
      ->join("tbl_stock_$outlet AS c", 'a.ing_inv_id=c.stock_id', 'LEFT')
      ->join('tbl_satuan AS d', 'a.ing_satuan_id=d.satuan_id', 'LEFT')
      ->get();

    return $query->result_array();
  }

  function simpan_order($data, $outlet)
  {
    $this->db->insert_batch("tbl_order_$outlet", $data);
  }

  function simpan_laporan_order($data, $outlet)
  {
    $this->db->insert_batch("tbl_lap_order_$outlet", $data);
  }

  public function updateStock($outlet, $id, $qty)
  {
    $this->db->set('stock_qty', "stock_qty - $qty", FALSE)
      ->where('stock_id', $id)
      ->update("tbl_stock_$outlet");
  }

  public function is_paid($outlet, $no_trx, $trx_cust, $trx_userid)
  {
    $query = $this->db->select('trx_id')
      ->where('trx_nomor', $no_trx)
      ->where('trx_userid', $trx_userid)
      ->where('trx_cust', $trx_cust)
      ->get("tbl_lap_trx_$outlet");

    return $query->row_array();
  }
}
