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
		$this->load->view('mobile/v_pos', $data);
	}


	public function display_table_cart()
	{
		$data = [
			'payment' => $this->M_crud->read('tbl_payment'),
			'customer' => $this->M_crud->read('tbl_pelanggan'),
			'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
			'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
		];
		$this->load->view('mobile/v_order', $data);
	}


	public function confirm_order()
	{
		$dataPost = json_decode(file_get_contents('php://input'), true);
		$dataPelanggan = $this->prosesPelanggan($dataPost);
		$this->prosesPesanan($dataPost, $dataPelanggan['plg_id']);

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Terimakasih Sudah Memesan di resto kami.</div>');
		$dataPelanggan['hashed'] = md5($dataPelanggan['plg_id'] . '-' . $dataPost['db']);
		echo json_encode($dataPelanggan);
	}


	function prosesPesanan($dataPost, $plg_id)
	{
		$tipeTransaksi = $dataPost['tipe_transaksi'];
		foreach ($dataPost['cart'] as $cart) {
			$data[] = array(
				'order_menu' => $cart['id'],
				'order_qty' => $cart['count'],
				'order_harga' => $cart['price'] / $cart['count'],
				'order_subtotal' => $cart['price'],
				'order_notes' => $cart['notes'],
				'order_date' => date('Y-m-d H:i:s'),
				'order_userid' => $plg_id,
				'order_trx_tipe' => $tipeTransaksi,
				'order_cust_table' => $dataPost['cust_meja'],
				'order_cust_address' => $dataPost['cust_alamat'],
				'order_cust_notes' => $dataPost['cust_notes'],
				'order_cust_platno' => $dataPost['cust_platno'],
				'order_cust_phone' => $dataPost['cust_telp'],
				'order_payment_id' => $dataPost['payment_id'],
				'order_payment_nama' => $dataPost['payment_nama'],
				'order_nomor_kartu' => $dataPost['nomor_kartu'],
				'order_nomor_reff' => $dataPost['nomor_reff'],
				'order_voucher_id' => $dataPost['voucher_id'],
			);
		}
		$insertBatch = $this->M_mobile->insert_bulk_order($data, $dataPost['db']);
	}


	function prosesPelanggan($data)
	{
		$dataPelanggan = [
			'plg_nama' => strip_tags(str_replace("'", "", $data['cust_nama'])),
			'plg_notelp' => $data['cust_telp'],
			'plg_whatsapp' => $data['cust_telp'],
			'plg_email' => '',
			'plg_platno' => $data['cust_platno'],
			'plg_alamat' => $data['cust_alamat'],
			'plg_login_flg' => 'Y',
			'plg_meja' => $data['cust_meja'],
		];
		if ($data['customerId'] == 0) {
			$this->M_crud->insert('tbl_pelanggan', $dataPelanggan);
			$dataPelanggan['plg_id'] = $this->db->insert_id();
			return $dataPelanggan;
		}
		$this->M_crud->update('tbl_pelanggan', $dataPelanggan, 'plg_id', $data['customerId']);
		$dataPelanggan['plg_id'] = $data['customerId'];
		return $dataPelanggan;
	}


	public function voucher()
	{
		$id = $this->input->post('id');
		$data = $this->M_crud->select('tbl_voucher', 'voucher_id', $id);
		echo json_encode($data);
	}


	public function voucher_tandc($kodeDiskon)
	{
		$data = $this->M_pos->search_voucher($kodeDiskon);
		echo json_encode($data);
	}
}
