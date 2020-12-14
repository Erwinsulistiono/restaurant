<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		}
		$this->load->model('M_dashboard');
		$this->load->model('M_crud');
	}

	public function index()
	{
		$id = $this->session->userdata('pengguna_id');
		$data['user'] = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $id);
		$penjualan_tot = 0;
		$penjualan_now = 0;
		$porsi_tot = 0;
		$porsi_now = 0;


		$out_id = $this->M_crud->read('tbl_outlet');
		foreach ($out_id as $id) {
			$penjualan_tot += (int)($this->M_dashboard->get_total_penjualan($id['out_id']));
			$penjualan_now += (int)($this->M_dashboard->get_total_penjualan_bulan_ini($id['out_id']));
			$porsi_tot += (int)($this->M_dashboard->get_total_porsi($id['out_id']));
			$porsi_now += (int)($this->M_dashboard->get_total_porsi_bulan_ini($id['out_id']));
		}
		$data['penjualan_tot'] = $penjualan_tot;
		$data['penjualan_now'] = $penjualan_now;
		$data['porsi_tot'] = $porsi_tot;
		$data['porsi_now'] = $porsi_now;

		$this->render('admin/v_dashboard', $data);
	}
}