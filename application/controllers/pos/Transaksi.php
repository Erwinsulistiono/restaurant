<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends MY_Controller
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
		$outlet = $this->session->userdata('pengguna_outlet');
		$data = [
			'data' => $this->M_crud->read('tbl_trx_pos_' . $outlet . ' WHERE trx_date > CURDATE();'),
			'pesanan' => $this->M_crud->left_join("tbl_trx_pos_$outlet", "tbl_order_$outlet", "tbl_trx_pos_$outlet.trx_id=tbl_order_$outlet.order_trx_reff"),
		];

		$this->render('pos/transaksi/v_transaksi', $data);
	}

	public function hapus($id)
	{
		$outlet = $this->session->userdata('pengguna_outlet');
		$data = $this->M_crud->select("tbl_trx_pos_$outlet", 'trx_id', $id);
		$dataMeja['meja_pelanggan'] = '0';
		$dataPelanggan['plg_order'] = '';
		$this->M_crud->delete("tbl_trx_pos_$outlet", 'trx_id', $id);
		$this->M_crud->delete("tbl_order_$outlet", 'order_trx_reff', $id);
		$this->M_crud->update("tbl_meja_$outlet", $dataMeja, 'meja_pelanggan', $data['trx_table']);
		$this->M_crud->update('tbl_pelanggan', $dataPelanggan, 'plg_order', $id);
		redirect('pos/transaksi');
	}

	public function hapus_order($id)
	{
		$outlet = $this->session->userdata('pengguna_outlet');
		$this->M_crud->delete("tbl_order_$outlet", 'order_id', $id);
		redirect('pos/transaksi');
	}
}
