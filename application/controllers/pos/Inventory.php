<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function index()
	{
		$data = [
			'data' => $this->M_crud->read("tbl_stock_$this->outlet"),
		];
		$this->render('pos/inventory/v_inventory', $data);
	}

	public function reset_stock($stock_id)
	{
		$this->M_crud->update("tbl_stock_$this->outlet", ['stock_qty' => 0], 'stock_id', $stock_id);
	}
}
