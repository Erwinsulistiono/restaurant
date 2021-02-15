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
		$this->load->model('M_log');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function index()
	{
		$data = [
			'pending' => $this->M_crud->read("tmp_stock_$this->outlet"),
			'data' => $this->M_crud->read("tbl_stock_$this->outlet"),
		];
		$this->render('pos/inventory/v_inventory', $data);
	}

	public function reset_stock($stock_id)
	{
		$this->M_crud->update("tbl_stock_$this->outlet", ['stock_qty' => 0], 'stock_id', $stock_id);
	}

	public function approval_inventory($stock_id)
	{
		$source_data = $this->M_crud->select("tmp_stock_$this->outlet", 'stock_id', $stock_id);
		$target_data = $this->M_crud->select("tbl_stock_$this->outlet", 'stock_reffid', $source_data['stock_reffid']);

		if ($this->input->post('stock_qty')) {
			((int)$source_data['stock_qty'] < (int)$this->input->post('stock_qty')) &&
				$this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Qty approval tidak boleh lebih besar dari qty pengiriman.</div>');

			((int)$source_data['stock_qty'] < (int)$this->input->post('stock_qty')) &&
				redirect("pos/inventory/");

			$add_stock = $this->input->post('stock_qty');
		} else {
			$add_stock = $source_data['stock_qty'];
		}


		if (!$target_data) {
			$log_oldval = 0;
			$source_data['stock_reffid'] = $source_data['stock_id'];
			unset($source_data['stock_id']);
			unset($source_data['stock_trf_date']);
			$source_data['stock_qty'] = $add_stock;
			$this->M_crud->insert("tbl_stock_$this->outlet", $source_data);
			$reff_id = $this->db->insert_id();
		} else {
			$log_oldval = strtr(json_encode($target_data), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
			$qty_new['stock_qty'] = $target_data['stock_qty'] + $add_stock;
			$reff_id = $target_data['stock_id'];
			$this->M_crud->update("tbl_stock_$this->outlet", $qty_new, 'stock_reffid', $source_data['stock_reffid']);
		}
		$log_newval = strtr(json_encode($this->M_crud->select("tbl_stock_$this->outlet", 'stock_reffid', $stock_id)), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($reff_id, 'INVENTORY TRANSFER STOCK', $log_oldval, $log_newval);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Berhasil di transfer.</div>');

		if ($this->input->post('stock_qty')) {
			$update['stock_qty'] = $source_data['stock_qty'] - $this->input->post('stock_qty');
			$this->M_crud->update("tmp_stock_$this->outlet", $update, 'stock_id', $stock_id);
			redirect("pos/inventory/");
		}
		$this->M_crud->delete("tmp_stock_$this->outlet", 'stock_id', $stock_id);
		redirect("pos/inventory/");
	}
}
