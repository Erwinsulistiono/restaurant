<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Waitress extends MY_Controller
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
    $this->load->model('M_waitress');
    $this->load->model('M_stock');
    $this->outlet = $this->session->userdata('pengguna_outlet');
  }

  public function index()
  {
    $tbl_order = "tbl_order_$this->outlet";
    $tbl_trx = "tbl_trx_$this->outlet";
    $tbl_menu = "tbl_menu_$this->outlet";
    $data = [
      'order' => $this->M_crud->left_join($tbl_order, $tbl_menu, "$tbl_order.order_menu=$tbl_menu.menu_id"),
      'menu' => $this->M_crud->read("tbl_menu_$this->outlet"),
    ];
    $this->render('pos/waitress/v_waitress', $data);
  }

  public function end_proses_waitress()
  {
    $order_id = $this->input->post('orderId');
    $this->M_crud->update("tbl_order_$this->outlet", ['order_waitress_flg' => 'Y'], 'order_id', $order_id);

    $trxId = $this->M_crud->select("tbl_order_$this->outlet", 'order_id', $order_id)['order_trx_reff'];
    $count_order_in_kitchen = $this->M_waitress->get_all_order_by_id($trxId, $this->outlet);

    ($count_order_in_kitchen == 0) && $this->M_crud->update("tbl_trx_pos_$this->outlet", ['trx_waitress_flg' => 'Y'], 'trx_id', $trxId);
  }

  public function return_order()
  {
    $return_order = $this->input->post('order_id');
    $return_qty = $this->input->post('qty_potong');
    $potong_stock = $this->input->post('potong_stock');

    if (isset($potong_stock) && isset($return_qty)) {
      $stock_inv['stock_qty'] = $this->M_stock->get_qty_diff($potong_stock, $return_qty, $this->outlet)[0]['stock_qty'];
      $this->M_crud->update("tbl_stock_$this->outlet", $stock_inv, 'stock_id', $potong_stock);
    }

    $update_flg['order_kitchen_flg'] = 'N';
    $this->M_crud->update("tbl_order_$this->outlet", $update_flg, 'order_id', $return_order);
    $this->index();
  }

  public function return_order_after_cancelation()
  {
    $trx_id = $this->input->post('trxId');
    $this->M_waitress->clear_order_after_cancelation($this->outlet, $trx_id);

    redirect("pos/pesanan/clear_transaksi/$trx_id");
  }
}
