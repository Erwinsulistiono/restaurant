<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('order/outlet/');
			redirect($url);
		};
		$this->load->model('M_pos');
		$this->load->model('M_crud');
		$this->outlet = $this->session->userdata('pelanggan_outlet');
	}

	public function pilih_meja($meja, $plg_id)
	{
		$table = $this->M_crud->select('tbl_meja_' . $this->outlet, 'meja_id', $meja);
		$this->display_pos($table);
	}

	public function display_pos($table = null, $trx = null)
	{
		($trx === null) ? $trx = '' : $trx = $trx;
		$data = [
			'table' => $table,
			'cart' => $this->cart->contents(),
			'kategori' => $this->M_crud->read('tbl_kategori'),
			'kategori_makanan' => $this->M_crud->left_join('tbl_menu_kat', 'tbl_menu_' . $this->outlet, 'tbl_menu_kat.menu_id=tbl_menu_' . $this->outlet . '.menu_id'),
			'data' => $this->M_crud->read('tbl_menu_' . $this->outlet),
			'inventory' => $this->M_crud->read('tbl_stock_' . $this->outlet),
			'ingredient' => $this->M_pos->getIngredientAll($this->outlet),
		];
		$this->render('mobile/v_pos', $data);
	}

	public function display_table_cart()
	{
		$table = '';
		$this->session->userdata('plg_meja') &&
			$table = $this->M_crud->select('tbl_meja_' . $this->outlet, 'meja_id', $this->session->userdata('plg_meja'));
		$data = [
			'ip' => $_SERVER['HTTP_HOST'],
			'table' => $table,
			'cart' => $this->cart->contents(),
			'payment' => $this->M_crud->read('tbl_payment'),
			'customer' => $this->M_crud->read('tbl_pelanggan'),
			'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
			'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
		];
		$this->render('mobile/v_order', $data);
	}


	public function check_stock()
	{
		$id = $this->input->post('item_id');
		$qty = $this->input->post('item_qty');
		$stock = $this->M_pos->get_qty_diff($id, $qty, $this->outlet);
		//cek sudah buat resep/belum
		if (empty($stock)) {
			$output = json_encode(array('type' => 'error', 'message' => 'Belum Buat Resep'));
			die($output);
		}
		//cek apa stock ada
		foreach ($stock as $s) {
			if ($s['stock_qty'] <= 0 || ($s['stock_qty'] == "")) {
				$output = json_encode(array('type' => 'error', 'message' => 'Stock ' . $s['stock_nama'] .  ' Habis'));
				die($output);
			}
		}
		$this->add_to_cart($id);
	}

	public function add_to_cart($id)
	{
		$data = array(
			'id' => $id,
			'name' => $this->input->post('item_nama'),
			'price' => $this->input->post('item_harga'),
			'qty' => $this->input->post('item_qty'),
			'options' => array('notes' => $this->input->post('item_notes'))
		);
		$this->cart->insert($data);
		$this->show_cart();
	}

	public function show_cart()
	{
		$data = [
			'cart' => $this->cart->contents(),
			'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
			'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
		];
		echo json_encode($data);
	}


	public function confirm_order()
	{
		$plg_id = $this->session->userdata('idadmin');
		$cart = $this->input->post('cart');
		$this->update_cart($cart);
		$tbl_pelanggan = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
		$tipe_trx_nama = '';
		($this->session->userdata('plg_meja')) && $tipe_trx_nama = $this->session->userdata('plg_meja');
		(($tipe_trx_nama == '') && ($tbl_pelanggan['plg_platno'])) && $tipe_trx_nama = $tbl_pelanggan['plg_platno'];
		(($tipe_trx_nama == '') && ($tbl_pelanggan['plg_alamat'])) && $tipe_trx_nama = $tbl_pelanggan['plg_alamat'];

		foreach ($this->cart->contents() as $items) {
			if (empty($items['options']['plg_reffid'])) {
				$data2 = array(
					'order_menu' => $items['name'],
					'order_qty' => $items['qty'],
					'order_harga' => $items['price'],
					'order_subtotal' => $items['subtotal'],
					'order_notes' => $items['options']['notes'],
					'order_date' => date('Y-m-d H:i:s'),
					'order_userid' => $plg_id,
					'order_table' => $tipe_trx_nama,
					'order_trx_tipe' => $this->session->userdata('tipe_transaksi'),
					'order_payment_id' => $this->input->post('payment_id'),
					'order_payment_nama' => $this->input->post('payment_nama'),
					'order_nomor_kartu' => $this->input->post('nomor_kartu'),
					'order_nomor_reff' => $this->input->post('nomor_reff'),
					'order_voucher_id' => $this->input->post('voucher_id'),
				);
				$this->M_crud->insert('cust_order_' . $this->outlet, $data2);
			}
		}
		$this->cart->destroy();
		echo json_encode($this->outlet);
	}


	public function update_cart($cart = null)
	{
		($cart) ? $newCart = $cart : $newCart = $this->input->post('cart');
		$this->cart->destroy();
		foreach ($newCart as $c) {
			$data = array(
				'id' => $c['id'],
				'name' => $c['name'],
				'price' => $c['price'],
				'qty' => $c['qty'],
				'options' => array('notes' => $c['options']['notes'])
			);
			$this->cart->insert($data);
		}
	}


	public function voucher()
	{
		$id = $this->input->post('id');
		$data = $this->M_crud->select('tbl_voucher', 'voucher_id', $id);
		echo json_encode($data);
	}


	public function voucher_tandc()
	{
		$title = $this->input->post('kodeDiskon');
		$data = $this->M_pos->search_voucher($title);
		echo json_encode($data);
	}

	public function print($order_trx_reff)
	{
		$data = [
			'trx' => $this->M_crud->select('tbl_lap_trx_' . $this->outlet, 'trx_id', $order_trx_reff),
			'order' => $this->M_pos->getAllOrderPrint($order_trx_reff, $this->outlet),
			'outlet' => $this->M_crud->select('tbl_outlet', 'out_id', $this->outlet),
			'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
		];
		$this->load->view('pos/pos/v_print_struk', $data);
	}
}
