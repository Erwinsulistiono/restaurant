<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_pos');
		$this->load->model('M_crud');
		$this->load->model('M_stock');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}


	public function index()
	{
		$this->cart->destroy();
		$is_order_mobile = ($this->input->post('order_mobile') ? $this->input->post('order_mobile') : '');
		$dataPelanggan = [
			'plg_id' => $this->input->post('plg_id'),
			'plg_nama' => $this->input->post('plg_nama'),
			'plg_alamat' => $this->input->post('plg_alamat'),
			'plg_platno' => $this->input->post('plg_platno'),
			'plg_notelp' => $this->input->post('plg_notelp') ? $this->input->post('plg_notelp') : '',
			'plg_meja' => $this->input->post('plg_meja') ? $this->input->post('plg_meja') : '',
		];

		if ($dataPelanggan['plg_nama'] || $dataPelanggan['plg_id']) {
			$this->prosesPelanggan($dataPelanggan, $is_order_mobile);
		} else {
			$this->display_pos();
		}
	}


	public function prosesPelanggan($dataPelanggan, $is_order_mobile)
	{
		$tbl_pelanggan = $this->check_pelanggan_baru($dataPelanggan);
		if ($is_order_mobile) {
			//ambil order item dari tabel mobile order
			$orderItemMobile = $this->M_pos->getAllOrderFromMobilePos($tbl_pelanggan['plg_id'], $this->outlet);
			foreach ($orderItemMobile as $items) {
				$dataOrder[] = [
					'id' => $items['menu_id'],
					'name' => $items['menu_nama'],
					'price' => $items['order_harga'],
					'qty' => $items['order_qty'],
					'options' => array('notes' => $items['order_notes'])
				];
			}

			(isset($dataOrder)) && $this->cart->insert($dataOrder);
			$activeTransaksi = $orderItemMobile;
			$activeTransaksi['is_mobile'] = 'true';
		} else {
			$orderItem = $this->M_pos->select_order($tbl_pelanggan['plg_order'], $this->outlet);
			foreach ($orderItem as $items) {
				$dataOrder[] = [
					'id' => $items['menu_id'],
					'name' => $items['menu_nama'],
					'price' => $items['order_harga'],
					'qty' => $items['order_qty'],
					'options' => array(
						'is_prev_order' => 'Y',
						'notes' => $items['order_notes'],
						'flg_kitchen' => $items['order_kitchen_flg'],
						'flg_waitress' => $items['order_waitress_flg'],
						'flg_cancel' => $items['order_cancel_flg']
					),
				];
			}

			(isset($dataOrder)) && $this->cart->insert($dataOrder);
			$activeTransaksi = $this->M_crud->select('tbl_trx_pos_' . $this->outlet, 'trx_id', $tbl_pelanggan['plg_order']);
			$activeTransaksi['is_mobile'] = 'false';
		}

		//if customer dine in
		if ($this->input->post('meja_id')) {
			$meja = $this->input->post('meja_id');
			$this->M_crud->update('tbl_meja_' . $this->outlet, array('meja_pelanggan' => $tbl_pelanggan['plg_id']), 'meja_id', $meja);
			$table = $this->M_crud->select('tbl_meja_' . $this->outlet, 'meja_id', $meja);
			$attributTransaksi = [
				'trx_tipe_nama' => $table['meja_nama'],
				'plg_id' => $tbl_pelanggan['plg_id'],
				'trx_tipe' => 'Dine in',
				'trx_tipe_id' => 1
			];
		} else {
			$tbl_pelanggan['plg_alamat'] &&
				$attributTransaksi = [
					'trx_tipe_nama' => $tbl_pelanggan['plg_nama'],
					'plg_id' => $tbl_pelanggan['plg_id'],
					'trx_tipe' => 'Delivery',
					'trx_tipe_id' => 4,
					'plg_telp' => $tbl_pelanggan['plg_notelp'],
				];
			$tbl_pelanggan['plg_platno'] &&
				$attributTransaksi = [
					'trx_tipe_nama' => $tbl_pelanggan['plg_platno'],
					'plg_id' => $tbl_pelanggan['plg_id'],
					'trx_tipe' => 'Car', 'trx_tipe_id' => 3,
					'plg_telp' => $tbl_pelanggan['plg_notelp'],
				];
			(!$tbl_pelanggan['plg_platno'] && !$tbl_pelanggan['plg_alamat']) &&
				$attributTransaksi = [
					'trx_tipe_nama' => $tbl_pelanggan['plg_nama'],
					'plg_id' => $tbl_pelanggan['plg_id'],
					'trx_tipe' => 'Take Away',
					'trx_tipe_id' => 2,
					'plg_telp' => $tbl_pelanggan['plg_notelp'],
				];
		}

		$this->display_pos($attributTransaksi, $activeTransaksi);
	}


	public function check_pelanggan_baru($pelanggan)
	{
		if ($pelanggan['plg_id'] > 0) {
			$data_pelanggan = $this->M_crud->select('tbl_pelanggan', 'plg_id', $pelanggan['plg_id']);
			return $data_pelanggan;
		}

		$this->M_crud->insert('tbl_pelanggan', $pelanggan);
		$plg_id = $this->db->insert_id();
		$data_pelanggan = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
		return $data_pelanggan;
	}


	public function display_pos($tipe_trx = null, $trx = null)
	{
		(($tipe_trx == null) && ($tipe_trx = array('trx_tipe_nama' => '', 'plg_id' => 0, 'trx_tipe' => '', 'trx_tipe_id' => '')));
		(($trx == null) && ($trx = ''));
		$data = [
			'ip' => $_SERVER['HTTP_HOST'],
			'tipe_transaksi' => $this->M_crud->read('tbl_tipe_transaksi'),
			'trx_prop' => $tipe_trx,
			'cart' => $this->cart->contents(),
			'kategori' => $this->M_crud->read('tbl_kategori'),
			'kategori_makanan' => $this->M_crud->left_join('tbl_menu_kat', 'tbl_menu_' . $this->outlet, 'tbl_menu_kat.menu_id=tbl_menu_' . $this->outlet . '.menu_id'),
			'data' => $this->M_crud->read('tbl_menu_' . $this->outlet),
			'alltable' => $this->M_pos->get_all_table($this->outlet),
			'payment' => $this->M_crud->read('tbl_payment'),
			'customer' => $this->M_crud->read('tbl_pelanggan'),
			'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
			'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
			'mobile_app_cust_order' => $this->M_crud->read('cust_order_' . $this->outlet),
			'trx' => $trx,
			'all_trx' => $this->M_crud->read('tbl_trx_pos_' . $this->outlet),
			'all_order' => $this->M_crud->left_join('tbl_order_' . $this->outlet, 'tbl_trx_pos_' . $this->outlet, 'tbl_order_' . $this->outlet . '.order_trx_reff=tbl_trx_pos_' . $this->outlet . '.trx_id'),
			'last_inv_number' => $this->M_pos->getLastAutoIncrementId($this->outlet),
		];
		$this->render('pos/pos/v_pos', $data);
	}


	public function check_stock()
	{
		$id = $this->input->post('items_id');
		$name = $this->input->post('items_nama');
		$price = $this->input->post('items_harga');
		$notes = $this->input->post('items_notes');
		$qty = ($this->cart->get_item($id)) ? $this->cart->get_item($id)['qty'] : 1;
		$stock = $this->M_stock->get_qty_diff($id, $qty, $this->outlet);
		$data = [
			'id' => $id,
			'name' => $name,
			'price' => $price,
			'notes' => $notes
		];
		// cek sudah buat resep/belum
		if (empty($stock)) {
			$output = json_encode(array('type' => 'error', 'message' => 'Belum Buat Resep'));
			die($output);
		}
		//cek apa stock ada
		foreach ($stock as $s) {
			if ($s['stock_qty'] <= $s['stock_min_qty']) {
				$output = json_encode(array('type' => 'error', 'message' => 'Stock ' . $s['stock_nama'] .  'Hampir Habis, Tersisa < ' . round($s['stock_qty'], 0, PHP_ROUND_HALF_DOWN)  . ' (' . $s['stock_satuan'] . ')'));
				die($output);
			} elseif ($s['stock_qty'] <= 0 || ($s['stock_qty'] == "")) {
				$output = json_encode(array('type' => 'error', 'message' => 'Stock ' . $s['stock_nama'] .  'Habis'));
				die($output);
			}
		}
		$this->add_to_cart($data);
	}


	public function add_to_cart($data)
	{
		$data = array(
			'id' => $data['id'],
			'name' => $data['name'],
			'price' => $data['price'],
			'qty' => 1,
			'options' => array('notes' => $data['notes'])
		);
		$this->cart->insert($data);
		$this->show_cart();
	}


	public function show_cart($discount = null)
	{
		$data = [
			'cart' => $this->cart->contents(),
			'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
			'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
		];
		echo json_encode($data);
	}


	public function proses_kitchen($plg_id, $table = null)
	{
		$subtotal = intval(preg_replace('/[^0-9]/', '', $this->input->post('subtotal')));
		$plg_nama = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
		$discount = intval(preg_replace('/[^0-9]/', '', $this->input->post('discount')));
		$dataTrx = array(
			'trx_table' => (($table != null) ? str_replace('%20', ' ', $table) : ''),
			'trx_cust' => $plg_nama['plg_nama'],
			'trx_date' => date('Y-m-d H:i:s'),
			'trx_userid' => $this->session->userdata('pengguna_username'),
			'trx_subtotal' => $subtotal,
			'trx_discount' => (empty($discount) ? 0 : $discount),
			'trx_tax_ppn' => intval(preg_replace('/[^0-9]/', '', $this->input->post('totalpph'))),
			'trx_tax_service' => intval(preg_replace('/[^0-9]/', '', $this->input->post('totalservice'))),
			'trx_grand_total' => intval(preg_replace('/[^0-9]/', '', $this->input->post('grandtotal'))),
			'trx_tipe' => $this->input->post('trx_tipe')
		);
		if (!$plg_nama['plg_order']) {
			$this->M_crud->insert('tbl_trx_pos_' . $this->outlet, $dataTrx);
			$reff_id = $this->db->insert_id();
		} else {
			$reff_id = $plg_nama['plg_order'];
			$this->M_crud->update('tbl_trx_pos_' . $this->outlet, $dataTrx, 'trx_id', $reff_id);
		}

		$this->M_crud->delete("tbl_order_$this->outlet", 'order_trx_reff', $reff_id);
		foreach ($this->cart->contents() as $items) {
			$dataOrder[] = array(
				'order_trx_reff' => $reff_id,
				'order_menu' => $items['id'],
				'order_qty' => $items['qty'],
				'order_harga' => $items['price'],
				'order_subtotal' => $items['subtotal'],
				'order_notes' => $items['options']['notes'],
				'order_date' => date('Y-m-d H:i:s'),
				'order_kitchen_flg' => isset($items['options']['flg_kitchen']) ? $items['options']['flg_kitchen'] : 'N',
				'order_waitress_flg' => isset($items['options']['flg_waitress']) ? $items['options']['flg_waitress'] : 'N',
				'order_cancel_flg' => isset($items['options']['flg_cancel']) ? $items['options']['flg_cancel'] : 'N',
				'order_userid' => $this->session->userdata('pengguna_username'),
			);
			$stock_inv = $this->M_stock->get_qty_diff($items['id'], $items['qty'], $this->outlet);
			foreach ($stock_inv as $potong_stock) {
				$data_stock['stock_qty'] = $potong_stock['stock_qty'];
				$this->M_crud->update('tbl_stock_' . $this->outlet, $data_stock, 'stock_id', $potong_stock['stock_id']);
			}
		}
		$insertBulk = $this->M_crud->insert_bulk("tbl_order_$this->outlet", $dataOrder);
		$plg_order['plg_order'] = $reff_id;
		$this->M_crud->update('tbl_pelanggan', $plg_order, 'plg_id', $plg_id);
		if ($this->input->post('isMobile')) {
			$this->M_crud->delete('cust_order_' . $this->outlet, 'order_userid', $plg_id);
		}

		if (!$this->input->post('pay_first')) {
			redirect('pos/pos');
		}

		echo json_encode($insertBulk);
	}


	public function check_out($trx_id)
	{
		$plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_order', $trx_id)['plg_id'];
		$id_voucher = $this->input->post('voucher_id');
		$discount_nominal = $this->input->post('discount_nominal');
		(($id_voucher) && $this->voucherPotongHargaTransaksi($id_voucher, $trx_id));
		(($discount_nominal && !$id_voucher) && $this->potongHargaTransaksi($discount_nominal, $trx_id));
		$data_trx = $this->M_crud->select('tbl_trx_pos_' . $this->outlet, 'trx_id', $trx_id);

		$data_trx['trx_notes'] = $this->input->post('trx_notes');
		$data_trx['trx_payment'] = $this->input->post('trx_payment');
		$data_trx['trx_paid'] = intval(preg_replace('/[^0-9]/', '', $this->input->post('trx_paid')));
		$data_trx['trx_change'] = intval(preg_replace('/[^0-9]/', '', $this->input->post('trx_change')));
		$data_trx['trx_nomor'] = $this->input->post('trx_nomor');
		$data_trx['trx_cardno'] = $this->input->post('trx_cardno');
		$data_trx['trx_payreff'] = $this->input->post('trx_payreff');
		unset($data_trx['trx_id']);
		unset($data_trx['trx_cancel_flg']);
		unset($data_trx['trx_cancel_waitress_flg']);
		unset($data_trx['trx_cancel_kitchen_flg']);

		$data_tbl['meja_pelanggan'] = '0';
		$data_plg['plg_order'] = '0';

		$data_order = $this->M_pos->select_order($trx_id, $this->outlet);

		//clearing all flag and save transaction data
		$this->M_crud->insert("tbl_lap_trx_$this->outlet", $data_trx);
		$order_trx_reff = $this->db->insert_id();
		$this->M_crud->update("tbl_trx_pos_$this->outlet", $data_trx, 'trx_id', $trx_id);
		foreach ($data_order as $items) {
			(($items['order_waitress_flg'] == 'Y') &&
				$this->M_crud->delete("tbl_order_$this->outlet", 'order_id', $items['order_id']));

			$items['order_trx_reff'] = $order_trx_reff;
			$items['order_menu'] = $items['menu_nama'];
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
		if (!$this->M_crud->select('tbl_order_' . $this->outlet, 'order_trx_reff', $trx_id)) {
			$this->M_crud->delete('tbl_trx_pos_' . $this->outlet, 'trx_id', $trx_id);
			$this->M_crud->update('tbl_meja_' . $this->outlet, array('meja_pelanggan' => 0), 'meja_pelanggan', $plg_id);
			$this->M_crud->update('tbl_pelanggan', ['plg_order' => 0, 'plg_login_flg' => 'N'], 'plg_id', $plg_id);
			if ($this->M_crud->select('cust_order_' . $this->outlet, 'order_userid', $plg_id)) {
				$this->M_crud->delete('cust_order_' . $this->outlet, 'order_userid', $plg_id);
			}
		};
		$this->printPaid($trx_id);
	}


	public function clear_order()
	{
		$trx_id = $this->input->post('trx_id');
		$plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_order', $trx_id)['plg_id'];
		$payment = $this->M_crud->select('tbl_trx_pos_' . $this->outlet, 'trx_id', $trx_id);
		if ($payment['trx_paid']) {
			$this->M_crud->delete('tbl_trx_pos_' . $this->outlet, 'trx_id', $trx_id);
			$this->M_crud->delete('tbl_order_' . $this->outlet, 'order_trx_reff', $trx_id);
			$this->M_crud->update('tbl_meja_' . $this->outlet, array('meja_pelanggan' => 0), 'meja_pelanggan', $plg_id);
			$this->M_crud->update('tbl_pelanggan', ['plg_order' => 0, 'plg_login_flg' => 'N'], 'plg_id', $plg_id);
			echo json_encode(array('type' => 'success', 'message' => 'Pesanan telah selesai'));
		} else {
			echo json_encode(array('type' => 'error', 'message' => 'Belum Melakukan Pembayaran'));
			// die($output);
		}
	}


	public function hapus_cart()
	{
		$id = $this->input->post('row_id');
		$items = $this->cart->get_item($id);
		if ($this->cart->has_options($row_id = $id)) {
			$this->M_crud->delete('tbl_order_' . $this->outlet, 'order_id', $items['id']);
		}
		$this->cart->remove($id);
		echo $this->show_cart();
	}


	public function potongHargaTransaksi($discount_nominal, $trx_id)
	{
		$data_trx = $this->M_crud->select('tbl_trx_pos_' . $this->outlet, 'trx_id', $trx_id);
		$data = [
			'trx_discount' => $discount_nominal,
			'trx_grand_total' => ($data_trx['trx_grand_total']) - $discount_nominal,
		];
		return;
	}


	public function voucherPotongHargaTransaksi($id_voucher, $trx_id)
	{
		$this->M_pos->potongQtyVoucher($id_voucher);
		$voucher = $this->M_crud->select('tbl_voucher', 'voucher_id', $id_voucher);
		$data_trx = $this->M_crud->select('tbl_trx_pos_' . $this->outlet, 'trx_id', $trx_id);
		$nominal = $voucher['voucher_nominal'];
		$percentage = $voucher['voucher_discount'];

		if ($nominal > 0) {
			$discount = $nominal;
		}
		if ($percentage > 0) {
			$discount = ($data_trx['trx_subtotal'] * ($percentage / 100));
		}
		$data = [
			'trx_discount' => $discount,
			'trx_grand_total' => ($data_trx['trx_grand_total']) - $discount,
		];
		$this->M_crud->update('tbl_trx_pos_' . $this->outlet, $data, 'trx_id', $trx_id);
		return;
	}


	public function voucherApplied()
	{
		$id = $this->input->post('id');
		$data = $this->M_crud->select('tbl_voucher', 'voucher_id', $id);
		echo json_encode($data);
	}


	public function voucherTermsAndCondition()
	{
		$title = $this->input->post('kodeDiskon');
		$data = $this->M_pos->search_voucher($title);
		echo json_encode($data);
	}


	public function printPaid($order_trx_reff)
	{
		$data = [
			'trx' => $this->M_crud->select('tbl_trx_pos_' . $this->outlet, 'trx_id', $order_trx_reff),
			'order' => $this->M_pos->select_order($order_trx_reff, $this->outlet),
			'outlet' => $this->M_crud->select('tbl_outlet', 'out_id', $this->outlet),
			'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
		];
		$this->load->view('pos/pos/v_print_struk', $data);
	}

	public function printBill($plg_id, $discount = null)
	{
		$tbl_pelanggan = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
		$orderItem = $this->M_pos->getAllOrderFromMobilePos($tbl_pelanggan['plg_id'], $this->outlet);

		$tbl_pelanggan['plg_alamat'] &&
			$attributTransaksi = array('trx_tipe_nama' => $tbl_pelanggan['plg_nama'], 'plg_id' => $tbl_pelanggan['plg_id'], 'trx_tipe' => 'Delivery', 'trx_tipe_id' => 4);
		$tbl_pelanggan['plg_platno'] &&
			$attributTransaksi = array('trx_tipe_nama' => $tbl_pelanggan['plg_platno'], 'plg_id' => $tbl_pelanggan['plg_id'], 'trx_tipe' => 'Car', 'trx_tipe_id' => 3);
		!($tbl_pelanggan['plg_platno'] && $tbl_pelanggan['plg_platno']) &&
			$attributTransaksi = array('trx_tipe_nama' => $tbl_pelanggan['plg_nama'], 'plg_id' => $tbl_pelanggan['plg_id'], 'trx_tipe' => 'Take Away', 'trx_tipe_id' => 2);
		$attributTransaksi['discount'] = $discount;
		$attributTransaksi['totalPph'] = $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'];
		$attributTransaksi['totalService'] = $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'];

		$data = [
			'trx_prop' => $attributTransaksi,
			'order' => $this->cart->contents(),
			'outlet' => $this->M_crud->select('tbl_outlet', 'out_id', $this->outlet),
			'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
		];
		$this->load->view('pos/pos/v_print_struk', $data);
	}

	public function getTransaksiMobile()
	{
		$data = [
			'mobile_app_order_head' => $this->M_crud->left_join('cust_order_' . $this->outlet, 'tbl_pelanggan', 'cust_order_' . $this->outlet . '.order_userid=tbl_pelanggan.plg_id'),
			'mobile_app_order' => $this->M_crud->read('cust_order_' . $this->outlet),
			'mobile_app_order_header' => $this->M_pos->joinMobileOrderPelangganMeja($this->outlet),
		];
		echo json_encode($data);
	}


	public function getAlerts()
	{
		$data = $this->M_pos->getMobileTrx($this->outlet);
		$notification = 0;
		foreach ($data as $d) {
			$notification++;
		}
		echo json_encode($notification);
	}


	public function batalkan_pemesanan_mobile($mobile_order_user)
	{
		$this->M_crud->delete('cust_order_' . $this->outlet, 'order_userid', $mobile_order_user);
		redirect('pos/pos');
	}


	public function status_order()
	{
		$this->render('pos/pos/v_status');
	}

	public function batalkan_transaksi($id)
	{
		$this->M_crud->update("tbl_trx_pos_$this->outlet", ['trx_cancel_flg' => 'Y'], 'trx_id', $id);
		echo json_encode("success");
	}
}
