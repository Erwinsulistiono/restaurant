<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends MY_Controller
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
		$this->load->model('M_kitchen');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function index()
	{
		$tbl_order = "tbl_order_$this->outlet";
		$tbl_menu = "tbl_menu_$this->outlet";
		$data = [
			'order' => $this->M_crud->left_join($tbl_order, $tbl_menu, "$tbl_order.order_menu=$tbl_menu.menu_id"),
			'trx' => $this->M_kitchen->getOrder($this->outlet),
			'recipe' => $this->M_kitchen->getOrderRecipe($this->outlet),
		];

		echo json_encode($data);
	}

	public function clear_transaksi($trxId)
	{
		$orders = $this->M_pos->select_order($trxId, $this->outlet);
		$allOrdersAreNotCleared = false;
		foreach ($orders as $order) {
			if ($order['order_cancel_flg'] == 'N') {
				$allOrdersAreNotCleared = true;
			}
		}
		if ($allOrdersAreNotCleared) {
			exit(json_encode("order cleared"));
		}

		$plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_order', $trxId)['plg_id'];
		$data_trx = $this->M_crud->select('tbl_trx_pos_' . $this->outlet, 'trx_id', $trxId);

		$data_trx['trx_notes'] = "Cancel Order By Pelanggan";
		$data_trx['trx_payment'] = "canceled";
		$data_trx['trx_paid'] = "";
		$data_trx['trx_change'] = "";
		$data_trx['trx_nomor'] = "";
		$data_trx['trx_cardno'] = "";
		$data_trx['trx_payreff'] = "";
		unset($data_trx['trx_id']);
		unset($data_trx['trx_cancel_flg']);
		unset($data_trx['trx_cancel_waitress_flg']);
		unset($data_trx['trx_cancel_kitchen_flg']);

		$data_tbl['meja_pelanggan'] = '0';
		$data_plg['plg_order'] = '0';

		$data_order = $this->M_pos->select_order($trxId, $this->outlet);

		//clearing all flag and save transaction data
		$this->M_crud->insert('tbl_lap_trx_' . $this->outlet, $data_trx);
		$order_trx_reff = $this->db->insert_id();
		$this->M_crud->update('tbl_trx_pos_' . $this->outlet, $data_trx, 'trx_id', $trxId);
		foreach ($data_order as $items) {
			$this->M_crud->delete('tbl_order_' . $this->outlet, 'order_id', $items['order_id']);

			$items['order_trx_reff'] = $order_trx_reff;
			unset($items['order_kitchen_flg']);
			unset($items['order_waitress_flg']);
			unset($items['order_cancel_flg']);
			unset($items['order_id']);
			unset($items['menu_id']);
			unset($items['menu_reff_id']);
			unset($items['menu_nama']);
			unset($items['menu_deskripsi']);
			unset($items['menu_harga_lama']);
			unset($items['menu_harga_baru']);
			unset($items['menu_gambar']);
			unset($items['menu_kitchen']);
			$this->M_crud->insert('tbl_lap_order_' . $this->outlet, $items);
		}

		$this->M_crud->delete('tbl_trx_pos_' . $this->outlet, 'trx_id', $trxId);
		$this->M_crud->update('tbl_meja_' . $this->outlet, array('meja_pelanggan' => '0'), 'meja_pelanggan', $plg_id);
		$this->M_crud->update('tbl_pelanggan', ['plg_order' => 0, 'plg_login_flg' => 'N'], 'plg_id', $plg_id);
		if ($this->M_crud->select('cust_order_' . $this->outlet, 'order_userid', $plg_id)) {
			$this->M_crud->delete('cust_order_' . $this->outlet, 'order_userid', $plg_id);
		}

		echo json_encode("transaksi cleared");
	}
}
