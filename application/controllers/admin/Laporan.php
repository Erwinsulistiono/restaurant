<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url('login');
      redirect($url);
    };
    $this->load->model('M_crud');
    $this->load->model('M_laporan');
    $this->all_outlet = $this->M_crud->read('tbl_outlet');
  }

  function index()
  {
    $data['outlet'] = $this->M_crud->read('tbl_outlet');
    $this->render('admin/laporan/v_index', $data);
  }

  public function laporan()
  {
    $data = [
      'tgl_awal' => $this->input->post('tgl_awal'),
      'tgl_akhir' => $this->input->post('tgl_akhir'),
      'outlet' => $this->input->post('outlet'),
      'group' => $this->input->post('group'),
      'data' => [],
      'rinci' => [],
    ];

    if ($data['group'] == 'order') {
      $data = $this->groupByOrder($data);
      $this->render('admin/laporan/v_order', $data);
    } elseif ($data['group'] == 'plg') {
      $data = $this->groupByPlg($data);
      $this->render('admin/laporan/v_pelanggan', $data);
    } elseif ($data['group'] == 'trx') {
      $data = $this->groupByTrx($data);
      $this->render('admin/laporan/v_transaksi', $data);
    } elseif ($data['group'] == 'menu') {
      $data = $this->groupByMenu($data);
      $this->render('admin/laporan/v_menu', $data);
    } else {
      $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>pilih group.</div>');
      redirect('admin/laporan/index');
    }
  }

  public function pdf($tgl_awal, $tgl_akhir, $outlet, $group)
  {
    $data = [
      'tgl_awal' => $tgl_awal,
      'tgl_akhir' => $tgl_akhir,
      'outlet' => $outlet,
      'group' => $group,
      'pt' => $this->M_crud->select('tbl_pt', 'pt_id' , 1),
      'data' => [],
      'rinci' => [],
    ];

    if ($data['group'] == 'order') {
      $data = $this->groupByOrder($data);
      $this->render('admin/laporan/pdf/v_order', $data);
    } elseif ($data['group'] == 'plg') {
      $data = $this->groupByPlg($data);
      $this->render('admin/laporan/pdf/v_pelanggan', $data);
    } elseif ($data['group'] == 'trx') {
      $data = $this->groupByTrx($data);
      $this->render('admin/laporan/pdf/v_transaksi', $data);
    } elseif ($data['group'] == 'menu') {
      $data = $this->groupByMenu($data);
      $this->render('admin/laporan/pdf/v_menu', $data);
    } 
  }

  public function excel($tgl_awal, $tgl_akhir, $outlet, $group)
  {
    $data = [
      'tgl_awal' => $tgl_awal,
      'tgl_akhir' => $tgl_akhir,
      'outlet' => $outlet,
      'group' => $group,
      'pt' => $this->M_crud->select('tbl_pt', 'pt_id' , 1),
      'data' => [],
      'rinci' => [],
    ];

    if ($data['group'] == 'order') {
      $data = $this->groupByOrder($data);
      $this->render('admin/laporan/excel/v_order', $data);
    } elseif ($data['group'] == 'plg') {
      $data = $this->groupByPlg($data);
      $this->render('admin/laporan/excel/v_pelanggan', $data);
    } elseif ($data['group'] == 'trx') {
      $data = $this->groupByTrx($data);
      $this->render('admin/laporan/excel/v_transaksi', $data);
    } elseif ($data['group'] == 'menu') {
      $data = $this->groupByMenu($data);
      $this->render('admin/laporan/excel/v_menu', $data);
    }
  }

  public function groupByOrder($data)
  {
    if ($data['outlet'] != 'all'){
      $data['data'] = $this->M_laporan->getLaporanOrder($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o){
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->getLaporanOrder($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }

  public function groupByMenu($data)
  {
    if ($data['outlet'] != 'all'){
      $data['data'] = $this->M_laporan->getLaporanMenu($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o){
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->getLaporanMenu($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }

  public function groupByPlg($data)
  {
    if($data['outlet'] != 'all'){
      $data['data'] = $this->M_laporan->getLaporanPlg($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o){
      $data['outlet'] = $o['out_id']; 
      $data['data'] += $this->M_laporan->getLaporanPlg($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }

  public function groupByTrx($data)
  {
    if ($data['outlet'] != 'all'){
      $data['data'] = $this->M_laporan->getLaporan($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o){
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->getLaporan($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }
}