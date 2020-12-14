<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_pos');
		$this->load->model('M_laporan');
		$this->user = $this->session->userdata('idadmin');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function close_kasir()
	{
		$tgl_awal = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $this->user)['pengguna_last_login'];
		$tgl_akhir = date("Y-m-d H:i:s");
		$tot_saldo = $this->M_laporan->get_laporan_cash_in_out($tgl_awal, $tgl_akhir, $this->outlet, $this->session->userdata('pengguna_username'));
		$tot = 0;
		foreach ($tot_saldo as $t) {
			$tot += $t['trx_grand_total'];
		}
		$data = [
			'tot_saldo' => $tot,
			'cek_saldo' => $this->M_pos->get_saldo_cash_in($tgl_awal, $this->user, $this->outlet),
		];
		$this->render('pos/settings/v_closing_kasir', $data);
	}

	public function simpan_close_kasir()
	{
		$tgl = date("Y-m-d H:i:s");
		$kas_saldo_akhir = $this->input->post('kas_saldo_akhir');
		$data = [
			'kas_saldo_akhir' => preg_replace('/[^0-9]/', '', $kas_saldo_akhir),
		];
		$this->M_crud->update("tbl_kas_harian_$this->outlet", $data, 'kas_id', $this->input->post('kas_id'));
		redirect('pos/dashboard');
	}
}
