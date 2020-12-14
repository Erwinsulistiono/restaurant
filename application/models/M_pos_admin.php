<?php
class M_pos_admin extends CI_Model
{
	public function get_saldo_harian_all($outlet, $tgl_awal, $tgl_akhir)
	{
		$query = $this->db->query("SELECT * , 
								'$outlet[out_id]' AS out_id , 
								'$outlet[out_kode]' AS out_kode , 
								'$outlet[out_nama]' AS out_nama 
								FROM tbl_kas_harian_$outlet[out_id]
								LEFT JOIN tbl_pengguna ON tbl_kas_harian_$outlet[out_id].kas_nm_kasir=tbl_pengguna.pengguna_id
								WHERE DATE(`tbl_kas_harian_$outlet[out_id]`.`kas_tgl`) >= '$tgl_awal' AND 
								DATE(`tbl_kas_harian_$outlet[out_id]`.`kas_tgl`) <= '$tgl_akhir' 
								ORDER BY `tbl_kas_harian_$outlet[out_id]`.`kas_tgl` DESC");
		return $query->result_array();
	}
}
