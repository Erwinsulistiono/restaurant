<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kitchen extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_stock');
		$this->load->model('M_kitchen');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function index()
	{
		$data['kitchen'] = $this->M_crud->read("tbl_kitchen_$this->outlet");
		$this->render('pos/kitchen/v_index', $data);
	}

	public function view_kitchen($kitchen_id)
	{
		$data['kitchen'] = $this->M_crud->select("tbl_kitchen_$this->outlet", 'kitchen_id', $kitchen_id);
		$this->render('pos/kitchen/v_kitchen', $data);
	}

	public function return_order()
	{
		$data_post = json_decode(file_get_contents('php://input'), true);

		$this->M_crud->update("tbl_order_$this->outlet", ['order_cancel_flg' => 'Y'], 'order_id', $data_post['orderId']);
		$this->M_kitchen->tambah_notes_pengembalian($this->outlet, $data_post['orderId'], $data_post['notes']);

		echo json_encode($data_post);
	}

	public function return_order_after_cancelation()
	{
		$order_id = $this->input->post('orderId');
		$trx_id = $this->input->post('trxId');
		$qty = $this->input->post('qty');
		$menu_id = $this->input->post('menuId');
		$this->M_crud->update("tbl_order_$this->outlet", ['order_cancel_flg' => 'Y'], 'order_id', $order_id);

		$ingredient = $this->M_stock->get_qty_added($menu_id, $qty, $this->outlet);
		foreach ($ingredient as $items) {
			$this->M_crud->update("tbl_stock_$this->outlet", ["stock_qty" => $items["stock_qty"]], "stock_id",  $items["stock_id"]);
		}
		redirect('pos/pesanan/clear_transaksi/' . $trx_id);
	}

	public function end_proses_kitchen()
	{
		$order_id = $this->input->post('orderId');
		$this->M_crud->update("tbl_order_$this->outlet", ['order_kitchen_flg' => 'Y'], 'order_id', $order_id);
	}
}
