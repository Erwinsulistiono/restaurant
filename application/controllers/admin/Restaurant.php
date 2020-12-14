<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Restaurant extends MY_Controller
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


  /*----------------- MODUL SETING AREA ---------------------*/
  function area()
  {
    $data['data'] = $this->M_crud->read('tbl_area');
    $this->render('admin/pos/restaurant_mode/v_restaurant_area', $data);
  }

  public function simpan_area()
  {
    $area_id = $this->input->post('area_id');
    $data = [
      'area_nama' => $this->input->post('area_nama'),
      'area_level' => $this->input->post('area_level')
    ];
    if (!$area_id) {
      $this->M_crud->insert('tbl_area', $data);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['area_nama'] . '</b> Berhasil ditambah/diupdate.</div>');
      $this->area();
    }
    $this->M_crud->update('tbl_area', $data, 'area_id', $this->input->post('area_id'));
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['area_nama'] . '</b> Berhasil ditambah/diupdate.</div>');
    $this->area();
  }

  public function hapus_area($area_id)
  {
    $this->M_crud->delete('tbl_area', 'area_id', $area_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Area Berhasil dihapus.</div>');
    $this->area();
  }


  /*----------------- MODUL SETING MEJA ---------------------*/
  public function pilih_meja()
  {
    $data['outlet'] = $this->M_crud->read('tbl_outlet');
    $this->render('admin/pos/restaurant_mode/v_pilih_meja', $data);
  }

  public function meja($outlet = null)
  {
    is_null($outlet) ? $outlet_id = $this->input->post('outlet_id') : $outlet_id = $outlet;
    $data = [
      'outlet_id' => $outlet_id,
      'data' => $this->M_crud->left_join("tbl_meja_${outlet_id}", 'tbl_area', "tbl_meja_${outlet_id}.meja_lokasi=tbl_area.area_id"),
      'area' => $this->M_crud->read('tbl_area'),
    ];
    $this->render('admin/pos/restaurant_mode/v_restaurant_meja', $data);
  }

  function simpan_meja($outlet)
  {
    $meja_id = $this->input->post('meja_id');
    $data = [
      'meja_nama' => $this->input->post('meja_nama'),
      'meja_lokasi' => $this->input->post('meja_lokasi'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$meja_id) {
      $this->M_crud->insert("tbl_meja_$outlet", $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, "MEJA OUT ${outlet}", null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['meja_nama'] . '</b> Berhasil disimpan ke database.</div>');
      redirect('admin/restaurant/meja/' . $outlet);
    }
    $data_old = $this->M_crud->select("tbl_meja_${outlet}", 'meja_id', $meja_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($meja_id, "MEJA OUT $outlet", $log_oldval, $log_newval);
    $this->M_crud->update("tbl_meja_$outlet", $data, 'meja_id', $meja_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['meja_nama'] . '</b> Berhasil disimpan ke database.</div>');
    redirect('admin/restaurant/meja/' . $outlet);
  }

  public function hapus_meja($outlet, $meja_id)
  {
    $data_old = $this->M_crud->select("tbl_meja_${outlet}", 'meja_id', $meja_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($meja_id, 'MEJA OUT ' . $outlet, $log_oldval);
    $this->M_crud->delete("tbl_meja_${outlet}", 'meja_id', $meja_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Meja Berhasil dihapus dari database.</div>');
    redirect('admin/restaurant/meja/' . $outlet);
  }
}