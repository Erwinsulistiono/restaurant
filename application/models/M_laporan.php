<?php
class M_laporan extends CI_Model
{

	public function get_laporan($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$query = $this->db->select("*, '$out_nama' AS out_nama")
			->from("tbl_lap_trx_$outlet")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->order_by("trx_date", 'DESC')
			->get();

		return $query->result_array();
	}

	public function get_laporan_kasir($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		$user = $data['trx_userid'];
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$query = $this->db->select("*, '$out_nama' AS out_nama")
			->from("tbl_lap_trx_$outlet AS tbl1")
			->join('tbl_tipe_transaksi AS tbl2', "tbl1.trx_tipe=tbl2.tipe_transaksi_id", "LEFT")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->where("trx_userid", $user)
			->order_by("trx_date", 'DESC')
			->get();

		return $query->result_array();
	}

	public function get_laporan_transaksi($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$query = $this->db->select("*, '$out_nama' AS out_nama, ")
			->from("tbl_lap_trx_$outlet AS tbl1")
			->join("tbl_lap_order_$outlet AS tbl2", "tbl1.trx_id=tbl2.order_trx_reff", "LEFT")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->order_by("trx_date", 'DESC')
			->get();

		return $query->result_array();
	}

	public function get_laporan_order($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$query = $this->db->select("*, '$out_nama' AS out_nama")
			->from("tbl_lap_order_$outlet AS tbl1")
			->join("tbl_lap_trx_$outlet AS tbl2", "tbl1.order_trx_reff=tbl2.trx_id", "LEFT")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->order_by('order_date', 'DESC')
			->get();

		return $query->result_array();
	}

	public function get_laporan_pelanggan($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$query = $this->db->select("trx_cust , SUM(trx_grand_total) AS trx_grand_total")
			->select("SUM(trx_subtotal) AS trx_subtotal")
			->select("SUM(trx_discount) AS trx_discount")
			->select("SUM(trx_tax_ppn) AS trx_tax_ppn")
			->select("SUM(trx_tax_service) AS trx_tax_service")
			->select("MAX(trx_date) AS last_order")
			->select("MIN(trx_date) AS order_date")
			->select("'$out_nama' AS out_nama")
			->from("tbl_lap_trx_$outlet AS tbl1")
			->join("tbl_lap_order_$outlet AS tbl2", "tbl1.trx_id=tbl2.order_trx_reff", "LEFT")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->group_by("trx_cust")
			->order_by('trx_date', 'DESC')
			->get();

		return $query->result_array();
	}

	public function get_laporan_menu($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$query = $this->db->select("order_menu, order_harga, trx_cust, '$out_nama' AS out_nama")
			->select("SUM(order_qty) AS order_total")
			->select("SUM(order_subtotal) AS order_revenue")
			->from("tbl_lap_order_$outlet AS tbl1")
			->join("tbl_lap_trx_$outlet AS tbl2", "tbl1.order_trx_reff=tbl2.trx_id", "LEFT")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->group_by('order_menu')
			->order_by('trx_date', 'DESC')
			->get();

		return $query->result_array();
	}

	public function get_laporan_cash_in_out($tgl_awal = null, $tgl_akhir = null, $outlet, $user)
	{
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$query = $this->db->select("*, '$out_nama' AS out_nama")
			->from("tbl_lap_trx_$outlet")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->where("trx_userid", $user)
			->order_by('trx_date', 'DESC')
			->get();

		return $query->result_array();
	}


	/*------------------ Laporan POS ------------------*/
	public function get_laporan_outlet($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		$tipe_transaksi = (int)$data['tipe_trx'];
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$this->db->select("*, '$out_nama' AS out_nama");
		$this->db->from("tbl_lap_trx_$outlet");
		$this->db->where("DATE(trx_date) >=", $tgl_awal);
		$this->db->where("DATE(trx_date) <=", $tgl_akhir);
		if ($tipe_transaksi != 'all') {
			$this->db->where("trx_tipe", $tipe_transaksi);
		}
		$this->db->order_by('trx_date', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_laporan_order_outlet($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		$tipe_transaksi = $data['tipe_trx'];

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$this->db->select("*, '$out_nama' AS out_nama");
		$this->db->from("tbl_lap_order_$outlet AS tbl1");
		$this->db->join("tbl_lap_trx_$outlet AS tbl2", "tbl1.order_trx_reff=tbl2.trx_id", "LEFT");
		$this->db->where("DATE(trx_date) >=", $tgl_awal);
		$this->db->where("DATE(trx_date) <=", $tgl_akhir);
		if ($tipe_transaksi != 'all') {
			$this->db->where("trx_tipe", $tipe_transaksi);
		}
		$this->db->order_by('order_date', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_laporan_menu_outlet($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$tipe_transaksi = $data['tipe_trx'];
		$outlet = $data['outlet'];

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$this->db->select("order_menu, order_harga, trx_cust, '$out_nama' AS out_nama");
		$this->db->select("SUM(order_qty) AS order_total");
		$this->db->select("SUM(order_subtotal) AS order_revenue");
		$this->db->from("tbl_lap_order_$outlet AS tbl1");
		$this->db->join("tbl_lap_trx_$outlet AS tbl2", "tbl1.order_trx_reff=tbl2.trx_id", "LEFT");
		$this->db->where("DATE(trx_date) >=", $tgl_awal);
		$this->db->where("DATE(trx_date) <=", $tgl_akhir);
		if ($tipe_transaksi != 'all') {
			$this->db->where("trx_tipe", $tipe_transaksi);
		}
		$this->db->group_by("order_menu");
		$this->db->order_by('trx_date', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_laporan_pelanggan_outlet($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$tipe_transaksi = $data['tipe_trx'];
		$outlet = $data['outlet'];

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$this->db->select("trx_cust , SUM(trx_grand_total) AS trx_grand_total");
		$this->db->select("SUM(trx_subtotal) AS trx_subtotal");
		$this->db->select("SUM(trx_discount) AS trx_discount");
		$this->db->select("SUM(trx_tax_ppn) AS trx_tax_ppn");
		$this->db->select("SUM(trx_tax_service) AS trx_tax_service");
		$this->db->select("MAX(trx_date) AS last_order");
		$this->db->select("MIN(trx_date) AS order_date");
		$this->db->select("'$out_nama' AS out_nama");
		$this->db->from("tbl_lap_trx_$outlet AS tbl1");
		$this->db->join("tbl_lap_order_$outlet AS tbl2", "tbl1.trx_id=tbl2.order_trx_reff", "LEFT");
		$this->db->where("DATE(trx_date) >=", $tgl_awal);
		$this->db->where("DATE(trx_date) <=", $tgl_akhir);
		if ($tipe_transaksi != 'all') {
			$this->db->where("trx_tipe", $tipe_transaksi);
		}
		$this->db->group_by("trx_cust");
		$this->db->order_by('trx_date', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_laporan_transaksi_outlet($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$tipe_transaksi = $data['tipe_trx'];
		$outlet = $data['outlet'];
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		$this->db->select("*, '$out_nama' AS out_nama, ");
		$this->db->from("tbl_lap_trx_$outlet");
		$this->db->join("tbl_lap_order_$outlet", "tbl_lap_trx_$outlet.trx_id=tbl_lap_order_$outlet.order_trx_reff", "left");
		$this->db->where("DATE(trx_date) >=", $tgl_awal);
		$this->db->where("DATE(trx_date) <=", $tgl_akhir);
		if ($tipe_transaksi != 'all') {
			$this->db->where("trx_tipe", $tipe_transaksi);
		}
		$this->db->order_by("trx_date", 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_nama_outlet($outlet_id)
	{
		$this->db->select('out_nama');
		$this->db->where('out_id', $outlet_id);
		$query = $this->db->get('tbl_outlet');
		return $query->row('out_nama');
	}
}
