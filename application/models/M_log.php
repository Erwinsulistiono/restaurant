<?php
class M_log extends CI_Model
{
	public function simpan_log($reff_id, $menu, $log_oldval = null, $log_newval = null)
	{
		$log_type = 'UNDFND';
		if ($log_oldval !== null && $log_newval == null) {
			$log_type = 'DELETE';
		}
		if ($log_oldval == null && $log_newval !== null) {
			$log_type = 'INSERT';
		}
		if ($log_oldval !== null && $log_newval !== null) {
			$log_type = 'UPDATE';
		}

		$data = [
			'log_type' => $log_type,
			'log_oldval' => $log_oldval,
			'log_newval' => $log_newval,
			'log_nama' => $this->session->userdata('user_nama'),
			'log_tgl' => date('Y-m-d H:i:s'),
			'log_reffid' => $reff_id,
			'log_menu' => $menu,
		];

		$this->db->insert('tbl_log', $data);
	}
}
