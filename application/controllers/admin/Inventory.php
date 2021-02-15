<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url('login');
      redirect($url);
    };
    $this->load->model('M_crud');
    $this->load->model('M_log');
  }


  public function index()
  {
    $data['outlet'] = $this->M_crud->read('tbl_outlet');
    $this->render('admin/katalog/v_inventory', $data);
  }


  public function outlet($outlet = null)
  {
    ($outlet) ? $outlet_id = $outlet : $outlet_id = $this->input->post('outlet_id');
    $data = [
      'outlet_id' => $outlet_id,
      'outlet' => $this->M_crud->read('tbl_outlet'),
      'kategori' => $this->M_crud->read('tbl_kategori'),
      'data' => $this->M_crud->read("tbl_stock_${outlet_id}" . '  ' . ' ORDER BY ' . '\'stock_kat\''),
    ];
    $this->render('admin/katalog/v_inventory_outlet', $data);
  }


  public function simpan_inventory($outlet_id)
  {
    $stock_id = $this->input->post('stock_id');
    $data = [
      'stock_kode' => $this->input->post('stock_kode'),
      'stock_nama' => $this->input->post('stock_nama'),
      'stock_kat' => $this->input->post('stock_kat'),
      'stock_qty' => $this->input->post('stock_qty'),
      'stock_min_qty' => $this->input->post('stock_min_qty'),
      'stock_satuan' => $this->input->post('stock_satuan'),
      'stock_harga' => $this->input->post('stock_harga'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$stock_id) {
      $this->M_crud->insert("tbl_stock_${outlet_id}", $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'INVENTORY', null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['nm_brg'] . '</b> Berhasil ditambah/diupdate.</div>');
      redirect("admin/inventory/outlet/$outlet_id");
    }
    $data_old = $this->M_crud->select("tbl_stock_${outlet_id}", 'stock_id', $stock_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_crud->update("tbl_stock_${outlet_id}", $data, 'stock_id', $stock_id);
    $this->M_log->simpan_log($stock_id, 'INVENTORY', $log_oldval, $log_newval);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['nm_brg'] . '</b> Berhasil ditambah/diupdate.</div>');
    redirect("admin/inventory/outlet/$outlet_id");
  }


  public function hapus_inventory($outlet_id, $stock_id)
  {
    $data_old = $this->M_crud->select("tbl_stock_${outlet_id}", 'stock_id', $stock_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_menu($stock_id, 'INVENTORY', $log_oldval);
    $this->M_crud->delete("tbl_stock_${outlet_id}", 'stock_id', $stock_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Berhasil di hapus.</div>');
    redirect("admin/inventory/outlet/$outlet_id");
  }


  public function tambah_inventory($outlet_id)
  {
    $stock_id = $this->input->post('stock_id');
    $add_stock = $this->input->post('stock_qty');
    $data_old = $this->M_crud->select("tbl_stock_${outlet_id}", 'stock_id', $stock_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
    $data['stock_qty'] = $data_old['stock_qty'] + $add_stock;
    $this->M_crud->update("tbl_stock_${outlet_id}", $data, 'stock_id', $stock_id);
    $data_new = $this->M_crud->select("tbl_stock_${outlet_id}", 'stock_id', $stock_id);
    $log_newval = strtr(json_encode($data_new), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($stock_id, 'INVENTORY (TAMBAH STOCK)', $log_oldval, $log_newval);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Berhasil di hapus.</div>');
    redirect("admin/inventory/outlet/$outlet_id");
  }


  public function transfer_inventory($outlet_id)
  {
    $stock_id = $this->input->post('stock_id');
    $outlet_id_tujuan = $this->input->post('outlet_id');
    $add_stock = $this->input->post('stock_qty');
    $source_data = $this->M_crud->select("tbl_stock_${outlet_id}", 'stock_id', $stock_id);
    $target_data = $this->M_crud->select("tbl_stock_${outlet_id_tujuan}", 'stock_reffid', $stock_id);
    $qty_old['stock_qty'] = $source_data['stock_qty'] - $add_stock;
    $this->M_crud->update("tbl_stock_${outlet_id}", $qty_old, 'stock_id', $stock_id);

    if (!$target_data) {
      $log_oldval = 0;
      $source_data['stock_reffid'] = $source_data['stock_id'];
      unset($items['stock_id']);
      $source_data['stock_qty'] = $add_stock;
      $this->M_crud->insert("tbl_stock_${outlet_id_tujuan}", $source_data);
      $reff_id = $this->db->insert_id();
    } else {
      $log_oldval = strtr(json_encode($target_data), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
      $qty_new['stock_qty'] = $target_data['stock_qty'] + $add_stock;
      $reff_id = $target_data['stock_id'];
      $this->M_crud->update("tbl_stock_${outlet_id_tujuan}", $qty_new, 'stock_reffid', $stock_id);
    }
    $log_newval = strtr(json_encode($this->M_crud->select("tbl_stock_$outlet_id_tujuan", 'stock_reffid', $stock_id)), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($reff_id, 'INVENTORY TRANSFER STOCK', $log_oldval, $log_newval);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Berhasil di transfer.</div>');
    redirect("admin/inventory/outlet/$outlet_id");
  }
}
