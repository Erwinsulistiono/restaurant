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
    $this->render('admin/point_of_sale/restaurant_mode/v_restaurant_area', $data);
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
      redirect('admin/restaurant/area');
    }
    $this->M_crud->update('tbl_area', $data, 'area_id', $this->input->post('area_id'));
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['area_nama'] . '</b> Berhasil ditambah/diupdate.</div>');
    redirect('admin/restaurant/area');
  }

  public function hapus_area($area_id)
  {
    $this->M_crud->delete('tbl_area', 'area_id', $area_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Area Berhasil dihapus.</div>');
    redirect('admin/restaurant/area');
  }


  /*----------------- MODUL SETING MEJA ---------------------*/
  public function pilih_meja()
  {
    $data['outlet'] = $this->M_crud->read('tbl_outlet');
    $this->render('admin/point_of_sale/restaurant_mode/v_pilih_meja', $data);
  }

  public function meja($dataBase = null)
  {
    is_null($dataBase) ? $db = $this->input->post('selectDb') : $db = $dataBase;
    $data = [
      'dataBase' => $db,
      'data' => $this->M_crud->left_join('tbl_meja_' . $db, 'tbl_area', 'tbl_meja_'.$db.'.meja_lokasi = tbl_area.area_id'),
      'area' => $this->M_crud->read('tbl_area'),
    ];
    $this->render('admin/point_of_sale/restaurant_mode/v_restaurant_meja', $data);
  }

  function simpan_meja($dataBase)
  {
    $meja_id = $this->input->post('meja_id');
    $data = [
      'meja_nama' => $this->input->post('meja_nama'),
      'meja_lokasi' => $this->input->post('meja_lokasi'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$meja_id) {
      $this->M_crud->insert('tbl_meja_' . $dataBase, $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'MEJA OUT '. $dataBase, null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['meja_nama'] . '</b> Berhasil disimpan ke database.</div>');
      redirect('admin/restaurant/meja/' . $dataBase);
    }
    $data_old = $this->M_crud->select('tbl_meja_' . $dataBase, 'meja_id', $meja_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($meja_id, 'MEJA OUT ' . $dataBase, $log_oldval, $log_newval);
    $this->M_crud->update('tbl_meja_' . $dataBase, $data, 'meja_id', $meja_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['meja_nama'] . '</b> Berhasil disimpan ke database.</div>');
    redirect('admin/restaurant/meja/' . $dataBase);
  }

  public function hapus_meja($dataBase, $meja_id)
  {
    $data_old = $this->M_crud->select('tbl_meja_' . $dataBase, 'meja_id', $meja_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($meja_id, 'MEJA OUT '.$dataBase, $log_oldval);
    $this->M_crud->delete('tbl_meja_' . $dataBase, 'meja_id', $meja_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Meja Berhasil dihapus dari database.</div>');
    redirect('admin/restaurant/meja/' . $dataBase);
  }
}