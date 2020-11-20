<?php
class M_laporan extends CI_Model
{

	public function getLaporan($data)
	{
		$tgl_awal = $data['tgl_awal']; $tgl_akhir = $data['tgl_akhir']; $outlet = $data['outlet'];
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->db->query("SELECT `out_nama` FROM `tbl_outlet` WHERE `out_id` = $outlet ")->row('out_nama');

		$query = $this->db->query("SELECT *,
								'$out_nama'  AS `out_nama` 
								FROM tbl_lap_trx_$outlet 
								WHERE DATE(trx_date) >= '$tgl_awal' AND DATE(trx_date) <= '$tgl_akhir' 
								ORDER BY trx_date DESC");
		return $query->result_array();
	}

	public function getLaporanTrx($data)
	{
		$tgl_awal = $data['tgl_awal']; $tgl_akhir = $data['tgl_akhir']; $outlet = $data['outlet'];
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->db->query("SELECT `out_nama` FROM `tbl_outlet` WHERE `out_id` = $outlet ")->row('out_nama');

		$query = $this->db->query("SELECT *,
								'$out_nama'  AS `out_nama` 
								FROM `tbl_lap_trx_$outlet` 
								LEFT JOIN `tbl_lap_order_$outlet` 
								ON `tbl_lap_trx_$outlet`.`trx_id`=`tbl_lap_order_$outlet`.`order_trx_reff`
								WHERE DATE(trx_date) >= ".$tgl_awal." AND DATE(trx_date) <= ".$tgl_akhir." 
								ORDER BY `tbl_lap_trx_$outlet`.`trx_date` DESC");
		return $query->result_array();
	}

	public function getLaporanOrder($data)
	{
		$tgl_awal = $data['tgl_awal']; $tgl_akhir = $data['tgl_akhir']; $outlet = $data['outlet'];
		
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->db->query("SELECT `out_nama` FROM `tbl_outlet` WHERE `out_id` = $outlet ")->row('out_nama');

		$query = $this->db->query("SELECT *, order_menu, '$out_nama' AS `out_nama` FROM `tbl_lap_order_$outlet` 
			LEFT JOIN `tbl_lap_trx_$outlet` ON `tbl_lap_order_$outlet`.`order_trx_reff` = `tbl_lap_trx_$outlet`.`trx_id`
			WHERE DATE(order_date) >= '$tgl_awal' AND DATE(order_date) <= '$tgl_akhir'
			ORDER BY order_date DESC");	
		return $query->result_array();	
	}

	public function getLaporanPlg($data)
	{
		$tgl_awal = $data['tgl_awal']; $tgl_akhir = $data['tgl_akhir']; $outlet = $data['outlet'];

		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->db->query("SELECT `out_nama` FROM `tbl_outlet` WHERE `out_id` = $outlet ")->row('out_nama');

		$query = $this->db->query("SELECT `trx_cust` , SUM(`tbl_lap_trx_$outlet`.`trx_grand_total`) AS `trx_grand_total` ,
															SUM(`tbl_lap_trx_$outlet`.`trx_subtotal`) AS `trx_subtotal`, 
															SUM(`tbl_lap_trx_$outlet`.`trx_discount`) AS `trx_discount`, 
															SUM(`tbl_lap_trx_$outlet`.`trx_tax_ppn`) AS `trx_tax_ppn`, 
															SUM(`tbl_lap_trx_$outlet`.`trx_tax_service`) AS `trx_tax_service`, 
															MAX(trx_date) AS `last_order` , MIN(trx_date) AS `join_date`,
															'$out_nama'  AS `out_nama`
															FROM `tbl_lap_trx_$outlet` 
															LEFT JOIN `tbl_lap_order_$outlet` 
															ON `tbl_lap_trx_$outlet`.`trx_id`=`tbl_lap_order_$outlet`.`order_trx_reff`
															WHERE DATE(trx_date) >= '$tgl_awal' AND DATE(trx_date) <= '$tgl_akhir' 
															GROUP BY `tbl_lap_trx_$outlet`.`trx_cust`
															ORDER BY trx_date DESC");
		return $query->result_array();
	}

	public function getLaporanMenu($data)
	{
		$tgl_awal = $data['tgl_awal']; $tgl_akhir = $data['tgl_akhir']; $outlet = $data['outlet'];
		
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->db->query("SELECT `out_nama` FROM `tbl_outlet` WHERE `out_id` = $outlet ")->row('out_nama');

		$query = $this->db->query("SELECT * , SUM(`tbl_lap_order_$outlet`.`order_qty`) AS `order_total`,
															'$out_nama'  AS `out_nama`, SUM(`tbl_lap_order_$outlet`.`order_subtotal`) AS `order_revenue`
															FROM `tbl_lap_order_$outlet` LEFT JOIN `tbl_lap_trx_$outlet` 
															ON `tbl_lap_order_$outlet`.`order_trx_reff`=`tbl_lap_trx_$outlet`.`trx_id` 
															WHERE DATE(trx_date) >= '$tgl_awal' AND DATE(trx_date) <= '$tgl_akhir' 
															GROUP BY `tbl_lap_order_$outlet`.`order_menu` 
															ORDER BY trx_date DESC");
		return $query->result_array();
	}

	public function getLaporanCashInOut($tgl_awal = null, $tgl_akhir = null, $outlet, $user)
	{
		($tgl_awal) ? $tgl_awal = $tgl_awal : $tgl_awal = date('Y-m-d');
		($tgl_akhir) ? $tgl_akhir = $tgl_akhir : $tgl_akhir = date('Y-m-d');
		$out_nama = $this->db->query("SELECT `out_nama` FROM `tbl_outlet` WHERE `out_id` = $outlet ")->row('out_nama');

		$query = $this->db->query("SELECT *,
								'$out_nama'  AS `out_nama` 
								FROM tbl_lap_trx_$outlet 
								WHERE trx_date >= '$tgl_awal' AND trx_date <= '$tgl_akhir' AND trx_userid = '$user'
								ORDER BY trx_date DESC");
		return $query->result_array();
	}
}