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
    $input_data = [
      'tgl_awal' => $this->input->post('tgl_awal'),
      'tgl_akhir' => $this->input->post('tgl_akhir'),
      'outlet' => $this->input->post('outlet'),
      'group' => $this->input->post('group'),
      'data' => [],
      'rinci' => [],
    ];

    switch ($input_data["group"]) {
      case "order":
        $return_data = $this->groupByOrder($input_data);
        $this->render('admin/laporan/v_order', $return_data);
        break;
      case "plg":
        $return_data = $this->groupByPlg($input_data);
        $this->render('admin/laporan/v_pelanggan', $return_data);
        break;
      case "trx":
        $return_data = $this->groupByTrx($input_data);
        $this->render('admin/laporan/v_transaksi', $return_data);
        break;
      case "menu":
        $return_data = $this->groupByMenu($input_data);
        $this->render('admin/laporan/v_menu', $return_data);
        break;
      default:
        $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>pilih group.</div>');
        $this->index();
    }
  }

  public function pdf($tgl_awal, $tgl_akhir, $outlet, $group)
  {
    $data_input = [
      'tgl_awal' => $tgl_awal,
      'tgl_akhir' => $tgl_akhir,
      'outlet' => $outlet,
      'group' => $group,
      'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
      'data' => [],
      'rinci' => [],
    ];

    switch ($data_input['group']) {
      case "order":
        $return_data = $this->groupByOrder($data_input);
        $this->load->view('admin/laporan/pdf/v_order', $return_data);
        break;
      case "plg":
        $return_data = $this->groupByPlg($data_input);
        $this->load->view('admin/laporan/pdf/v_pelanggan', $return_data);
        break;
      case "trx":
        $return_data = $this->groupByTrx($data_input);
        $this->load->view('admin/laporan/pdf/v_transaksi', $return_data);
        break;
      case "menu":
        $return_data = $this->groupByMenu($data_input);
        $this->load->view('admin/laporan/pdf/v_menu', $return_data);
        break;
      default:
        $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Unknown Error.</div>');
        $this->index();
    }
  }

  public function excel($tgl_awal, $tgl_akhir, $outlet, $group)
  {
    $data_input = [
      'tgl_awal' => $tgl_awal,
      'tgl_akhir' => $tgl_akhir,
      'outlet' => $outlet,
      'group' => $group,
      'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
      'data' => [],
      'rinci' => [],
    ];

    switch ($data_input['group']) {
      case "order":
        $return_data = $this->groupByOrder($data_input);
        $this->load->view('admin/laporan/excel/v_order', $return_data);
        break;
      case "plg":
        $return_data = $this->groupByPlg($data_input);
        $this->load->view('admin/laporan/excel/v_pelanggan', $return_data);
        break;
      case "trx":
        $return_data = $this->groupByTrx($data_input);
        $this->load->view('admin/laporan/excel/v_transaksi', $return_data);
        break;
      case "menu":
        $return_data = $this->groupByMenu($data_input);
        $this->load->view('admin/laporan/excel/v_menu', $return_data);
        break;
      default:
        $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Unknown Error.</div>');
        $this->index();
    }
  }

  public function groupByOrder($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->getLaporanOrder($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->getLaporanOrder($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }

  public function groupByMenu($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->getLaporanMenu($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->getLaporanMenu($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }

  public function groupByPlg($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->getLaporanPlg($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->getLaporanPlg($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }

  public function groupByTrx($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->getLaporan($data);
      $data['rinci'] = $this->M_laporan->getLaporanTrx($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->getLaporan($data);
      $data['rinci'] += $this->M_laporan->getLaporanTrx($data);
      return $data;
    }
  }
}
