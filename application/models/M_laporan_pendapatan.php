<?php
class M_laporan_pendapatan extends CI_Model
{

	public function get_laporan_mingguan($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		$tipe_pembayaran = $this->db->get_where('tbl_payment', ['payment_id' => $data['tipe_pembayaran']]);

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		if ($data['tipe_pembayaran'] != 'all') {
			$this->db->where("trx_payment", $tipe_pembayaran->row('payment_nama'));
		}

		$this->db->select('SUM(trx_subtotal) AS trx_subtotal, SUM(trx_discount) AS trx_discount')
			->select('SUM(trx_tax_ppn) AS trx_tax_ppn, SUM(trx_tax_service) AS trx_tax_service')
			->select('SUM(trx_grand_total) AS trx_grand_total')
			->select("trx_date, '$out_nama' AS out_nama, WEEK(trx_date) AS number_of_week")
			->select("CONCAT(MAKEDATE(YEAR(trx_date), DAYOFYEAR(trx_date) - (WEEKDAY(trx_date) + 1)) , ' - ', MAKEDATE(YEAR(trx_date), DAYOFYEAR(trx_date) - (WEEKDAY(trx_date) - 5))) AS periode")
			->from("tbl_lap_trx_$outlet")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->order_by('trx_date', 'DESC')
			->group_by('WEEK(trx_date)');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_laporan_harian($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		$tipe_pembayaran = $this->db->get_where('tbl_payment', ['payment_id' => $data['tipe_pembayaran']]);

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		if ($data['tipe_pembayaran'] != 'all') {
			$this->db->where("trx_payment", $tipe_pembayaran->row('payment_nama'));
		}

		$this->db->select('SUM(trx_subtotal) AS trx_subtotal, SUM(trx_discount) AS trx_discount')
			->select('SUM(trx_tax_ppn) AS trx_tax_ppn, SUM(trx_tax_service) AS trx_tax_service')
			->select('SUM(trx_grand_total) AS trx_grand_total')
			->select("trx_date, '$out_nama' AS out_nama, DATE(trx_date) AS periode")
			->from("tbl_lap_trx_$outlet")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->order_by('trx_date', 'DESC')
			->group_by('DATE(trx_date)');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_laporan_bulanan($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		$tipe_pembayaran = $this->db->get_where('tbl_payment', ['payment_id' => $data['tipe_pembayaran']]);

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		if ($data['tipe_pembayaran'] != 'all') {
			$this->db->where("trx_payment", $tipe_pembayaran->row('payment_nama'));
		}

		$this->db->select('SUM(trx_subtotal) AS trx_subtotal, SUM(trx_discount) AS trx_discount')
			->select('SUM(trx_tax_ppn) AS trx_tax_ppn, SUM(trx_tax_service) AS trx_tax_service')
			->select('SUM(trx_grand_total) AS trx_grand_total')
			->select("trx_date, '$out_nama' AS out_nama")
			->select("(CONCAT(MONTHNAME(trx_date), ' - ', YEAR(trx_date))) AS periode")
			->from("tbl_lap_trx_$outlet")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->order_by('trx_date', 'DESC')
			->group_by('MONTH(trx_date)');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_laporan_all($data)
	{
		$tgl_awal = $data['tgl_awal'];
		$tgl_akhir = $data['tgl_akhir'];
		$outlet = $data['outlet'];
		$tipe_pembayaran = $this->db->get_where('tbl_payment', ['payment_id' => $data['tipe_pembayaran']]);

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->get_nama_outlet($outlet);

		if ($data['tipe_pembayaran'] != 'all') {
			$this->db->where("trx_payment", $tipe_pembayaran->row('payment_nama'));
		}

		$this->db->select('SUM(trx_subtotal) AS trx_subtotal, SUM(trx_discount) AS trx_discount')
			->select('SUM(trx_tax_ppn) AS trx_tax_ppn, SUM(trx_tax_service) AS trx_tax_service')
			->select('SUM(trx_grand_total) AS trx_grand_total')
			->select("trx_date, '$out_nama' AS out_nama, DATE(trx_date) AS periode")
			->from("tbl_lap_trx_$outlet")
			->where("DATE(trx_date) >=", $tgl_awal)
			->where("DATE(trx_date) <=", $tgl_akhir)
			->order_by('trx_date', 'DESC');

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
