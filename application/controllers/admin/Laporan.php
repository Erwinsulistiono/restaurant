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
        $return_data = $this->group_by_order($input_data);
        $this->render('admin/laporan/v_order', $return_data);
        break;
      case "plg":
        $return_data = $this->group_by_pelanggan($input_data);
        $this->render('admin/laporan/v_pelanggan', $return_data);
        break;
      case "trx":
        $return_data = $this->group_by_transaksi($input_data);
        $this->render('admin/laporan/v_transaksi', $return_data);
        break;
      case "menu":
        $return_data = $this->group_by_menu($input_data);
        $this->render('admin/laporan/v_menu', $return_data);
        break;
      default:
        $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>pilih group.</div>');
        redirect('admin/laporan');
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
        $return_data = $this->group_by_order($data_input);
        $this->load->view('admin/laporan/pdf/v_order', $return_data);
        break;
      case "plg":
        $return_data = $this->group_by_pelanggan($data_input);
        $this->load->view('admin/laporan/pdf/v_pelanggan', $return_data);
        break;
      case "trx":
        $return_data = $this->group_by_transaksi($data_input);
        $this->load->view('admin/laporan/pdf/v_transaksi', $return_data);
        break;
      case "menu":
        $return_data = $this->group_by_menu($data_input);
        $this->load->view('admin/laporan/pdf/v_menu', $return_data);
        break;
      default:
        $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Unknown Error.</div>');
        redirect('admin/laporan');
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
        $return_data = $this->group_by_order($data_input);
        $this->load->view('admin/laporan/excel/v_order', $return_data);
        break;
      case "plg":
        $return_data = $this->group_by_pelanggan($data_input);
        $this->load->view('admin/laporan/excel/v_pelanggan', $return_data);
        break;
      case "trx":
        $return_data = $this->group_by_transaksi($data_input);
        $this->load->view('admin/laporan/excel/v_transaksi', $return_data);
        break;
      case "menu":
        $return_data = $this->group_by_menu($data_input);
        $this->load->view('admin/laporan/excel/v_menu', $return_data);
        break;
      default:
        $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Unknown Error.</div>');
        redirect('admin/laporan');
    }
  }

  public function group_by_order($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->get_laporan_order($data);
      $data['rinci'] = $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->get_laporan_order($data);
      $data['rinci'] += $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }
  }

  public function group_by_menu($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->get_laporan_menu($data);
      $data['rinci'] = $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->get_laporan_menu($data);
      $data['rinci'] += $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }
  }

  public function group_by_pelanggan($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->get_laporan_pelanggan($data);
      $data['rinci'] = $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->get_laporan_pelanggan($data);
      $data['rinci'] += $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }
  }

  public function group_by_transaksi($data)
  {
    if ($data['outlet'] != 'all') {
      $data['data'] = $this->M_laporan->get_laporan($data);
      $data['rinci'] = $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }

    foreach ($this->all_outlet as $o) {
      $data['outlet'] = $o['out_id'];
      $data['data'] += $this->M_laporan->get_laporan($data);
      $data['rinci'] += $this->M_laporan->get_laporan_transaksi($data);
      return $data;
    }
  }
}
