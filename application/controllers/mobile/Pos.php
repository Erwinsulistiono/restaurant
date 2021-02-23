<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_pos');
		$this->load->model('M_crud');
		$this->load->model('M_stock');
		$this->load->model('M_mobile');
	}


	public function display_pos($outlet)
	{
		$data = [
			'kategori' => $this->M_crud->read('tbl_kategori'),
			'kategori_makanan' => $this->M_crud->left_join('tbl_menu_kat', "tbl_menu_$outlet", "tbl_menu_kat.menu_id=tbl_menu_$outlet.menu_id"),
			'data' => $this->M_crud->read("tbl_menu_$outlet"),
			'inventory' => $this->M_crud->read("tbl_stock_$outlet"),
			'ingredient' => $this->M_stock->getIngredientAll($outlet),
		];
		$this->render_mobile('mobile/v_pos', $data);
	}


	public function display_table_cart()
	{
		$data = [
			'payment' => $this->M_crud->read('tbl_payment'),
			'customer' => $this->M_crud->read('tbl_pelanggan'),
			'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
			'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
		];
		$this->render_mobile('mobile/v_cart', $data);
	}


	public function confirm_order()
	{
		$data_post = json_decode(file_get_contents('php://input'), true);
		$data_pelanggan = $this->proses_pelanggan($data_post);

		$this->prosesPesanan($data_post, $data_pelanggan['plg_id']);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Terimakasih Sudah Memesan di resto kami.</div>');
		$data_pelanggan['hashed'] = md5($data_pelanggan['plg_id'] . '-' . $data_post['db']);
		echo json_encode($data_pelanggan);
	}

	public function paid_order()
	{
		$data_post = json_decode(file_get_contents('php://input'), true);
		$outlet_id = $data_post['db'];
		$trx_id = $this->M_crud->select('tbl_pelanggan', 'plg_id', $data_post['customerId'])['plg_order'];

		$data = [
			'trx_payment' => $data_post['payment_nama'],
			'trx_nomor' => 'INV' . str_pad(($trx_id), 3, "0", STR_PAD_LEFT),
			'trx_cardno' => $data_post['nomor_kartu'],
			'trx_payreff' => $data_post['nomor_reff'],
		];

		$this->M_crud->update("tbl_trx_pos_$outlet_id", $data, 'trx_id', $trx_id);
		echo json_encode('true');
		// echo json_encode($is_updated);
	}


	function prosesPesanan($data_post, $plg_id)
	{
		$tipeTransaksi = $data_post['tipe_transaksi'];
		foreach ($data_post['cart'] as $cart) {
			$data[] = array(
				'order_menu' => $cart['id'],
				'order_qty' => $cart['count'],
				'order_harga' => $cart['price'] / $cart['count'],
				'order_subtotal' => $cart['price'],
				'order_notes' => $cart['notes'],
				'order_date' => date('Y-m-d H:i:s'),
				'order_userid' => $plg_id,
				'order_trx_tipe' => $tipeTransaksi,
				'order_cust_table' => $data_post['cust_meja'],
				'order_cust_address' => $data_post['cust_alamat'],
				'order_cust_notes' => $data_post['cust_notes'],
				'order_cust_platno' => $data_post['cust_platno'],
				'order_cust_phone' => $data_post['cust_telp'],
				'order_payment_id' => $data_post['payment_id'],
				'order_payment_nama' => $data_post['payment_nama'],
				'order_nomor_kartu' => $data_post['nomor_kartu'],
				'order_nomor_reff' => $data_post['nomor_reff'],
				'order_voucher_id' => $data_post['voucher_id'],
			);
		}
		$this->M_mobile->insert_bulk_order($data, $data_post['db']);
	}


	function proses_pelanggan($data)
	{
		if ($data['customerId'] == 0) {
			$data_pelanggan = [
				'plg_nama' => strip_tags(str_replace("'", "", $data['cust_nama'])),
				'plg_notelp' => $data['cust_telp'],
				'plg_platno' => $data['cust_platno'],
				'plg_alamat' => $data['cust_alamat'],
				'plg_login_flg' => 'Y',
				'plg_meja' => $data['cust_meja'],
				'plg_socmed' => $data['cust_meja'] ? $data['cust_meja'] : '',
				'plg_status' => $data['cust_meja'] ? 'member' : 'pelanggan',
			];

			$this->M_crud->insert('tbl_pelanggan', $data_pelanggan);
			$data_pelanggan['plg_id'] = $this->db->insert_id();
			return $data_pelanggan;
		} else {
			$data_table = $this->M_crud->select('tbl_pelanggan', 'plg_id', $data['customerId']);
			$data_pelanggan = [
				'plg_id' => $data['customerId'],
				'plg_nama' => strip_tags(str_replace("'", "", $data['cust_nama'])),
				'plg_notelp' => $data_table['plg_notelp'],
				'plg_platno' => $data['cust_platno'],
				'plg_alamat' => $data['cust_alamat'],
				'plg_login_flg' => 'Y',
				'plg_meja' => $data['cust_meja'],
				'plg_socmed' => $data_table['plg_socmed'],
				'plg_status' => $data_table['plg_status'],
			];

			$this->M_crud->update('tbl_pelanggan', $data_pelanggan, 'plg_id', $data['customerId']);
			return $data_pelanggan;
		}
	}


	public function voucher_tandc($kodeDiskon)
	{
		$data = $this->M_pos->search_voucher($kodeDiskon);
		echo json_encode($data);
	}
}
