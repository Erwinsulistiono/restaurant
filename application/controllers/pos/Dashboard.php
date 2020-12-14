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
		$outlet = $this->session->userdata('pengguna_outlet');
		$data['user'] = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $id);
		$data['title'] = 'Home';

		$data['penjualan_tot'] = $this->M_dashboard->get_total_penjualan($outlet);
		$data['penjualan_now'] = $this->M_dashboard->get_total_penjualan_bulan_ini($outlet);
		$data['porsi_tot'] = $this->M_dashboard->get_total_porsi($outlet);
		$data['porsi_now'] = $this->M_dashboard->get_total_porsi_bulan_ini($outlet);

		$this->render('pos/v_dashboard', $data);
	}
}