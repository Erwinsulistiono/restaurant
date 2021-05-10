<?php
class M_pos_admin extends CI_Model
{
	public function get_saldo_harian_all($outlet, $tgl_awal, $tgl_akhir)
	{
		$outlet_id = $outlet['out_id'];
		$query = $this->db->select("*, '$outlet_id' AS out_id, '$outlet[out_kode]' AS out_kode, '$outlet[out_nama]' AS out_nama")
			->from("tbl_kas_harian_$outlet_id AS tbl1")
			->join('tbl_pengguna AS tbl2', "tbl1.kas_nm_kasir=tbl2.pengguna_id", 'LEFT')
			->where('DATE(kas_tgl) >=', $tgl_awal)
			->where('DATE(kas_tgl) <=', $tgl_akhir)
			->order_by('kas_tgl', 'DESC')
			->get();

		return $query->result_array();
	}
}
