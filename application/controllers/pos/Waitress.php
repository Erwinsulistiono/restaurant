<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Waitress extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_kitchen');
		$this->load->model('M_pos');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function getDataTrx()
	{
		$data = [
			'table' => $this->M_kitchen->getOrder($this->outlet),
			'order' => $this->M_crud->read('tbl_order_' . $this->outlet),
		];
		echo json_encode($data);
	}

	public function index()
	{
		$data = [
			'order' => $this->M_crud->read('tbl_order_' . $this->outlet),
			'trx' => $this->M_crud->read('tbl_trx_pos_' . $this->outlet),
			'menu' => $this->M_crud->read('tbl_menu_' . $this->outlet),
		];
		echo json_encode($this->load->view('pos/waitress/v_waitress', $data, true));
	}

	public function end_proses_waitress()
	{
		$groupOrder = $this->input->post('groupOrder');
		$groupId = $this->input->post('groupId');
		$this->M_kitchen->updateFlgWaitress($this->outlet, $groupOrder, $groupId);
		$this->getDataTrx();
	}

	public function return_order()
	{
		$return_order = $this->input->post('return_order');
		$return_qty = $this->input->post('qty_potong');
		$potong_stock = $this->input->post('potong_stock');
		$stock_inv['stock_qty'] = $this->M_pos->get_qty_diff($potong_stock, $return_qty, $this->outlet)[0]['stock_qty'];
		$update_flg['order_kitchen_flg'] = 'N';
		$this->M_crud->update('tbl_stock_' . $this->outlet, $stock_inv, 'stock_id', $potong_stock);
		$this->M_crud->update('tbl_order_' . $this->outlet, $update_flg, 'order_id', $return_order);
		$this->index();
	}
}