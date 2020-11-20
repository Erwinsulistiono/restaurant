<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
	}

	public function index()
	{
		$database = $this->session->userdata('pengguna_outlet');
		$data = [
			'data' => $this->M_crud->read('tbl_stock_' . $database),
		];
		echo json_encode($this->load->view('pos/inventory/v_inventory', $data, TRUE));
	}
}