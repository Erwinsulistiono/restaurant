<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_laporan');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function index()
	{
		$this->render('pos/laporan/index');
	}

	public function filter()
	{
		$dataFilter = [
			'tgl_awal' => $this->input->post('tgl_awal'),
			'tgl_akhir' => $this->input->post('tgl_akhir'),
			'outlet' => $this->outlet,
		];
		$data = [
			'data' => $this->M_laporan->get_laporan($dataFilter),
			'pesanan' => $this->M_crud->left_join("tbl_lap_trx_$this->outlet", 'tbl_lap_order_' . $this->outlet, "tbl_lap_trx_$this->outlet.trx_id=tbl_lap_order_$this->outlet.order_trx_reff"),
		];
		$this->render('pos/laporan/v_laporan', $data);
	}
}
