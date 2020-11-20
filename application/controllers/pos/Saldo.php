<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldo extends CI_Controller
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
    $this->user = $this->session->userdata('idadmin');
    $this->outlet = $this->session->userdata('pengguna_outlet');
  }

  public function index()
  {
    $tgl = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $this->user)['pengguna_last_login'];
    $cek_saldo = $this->M_pos->getDataCashInSaldo($tgl, $this->user, $this->outlet);
    if ($cek_saldo) {
      redirect(base_url('pos/pos'));
    }
    echo json_encode($this->load->view('pos/pos/v_saldo_awal', '', TRUE));
  }

  public function simpan_saldo_outlet()
  {
    $kas_saldo_awal = $this->input->post('kas_saldo_awal');
    $date_last_insert_saldo = $this->M_pos->getLatestDateSaldo($this->outlet);
    $data = [
      'kas_tgl' => date("Y-m-d H:i:s"),
      'kas_nm_kasir' => $this->user,
      'kas_saldo_awal' => preg_replace('/[^0-9]/', '', $kas_saldo_awal),
      'kas_saldo_akhir' => 0
    ];
    $this->M_crud->insert('tbl_kas_harian_' . $this->outlet, $data);

    if (($date_last_insert_saldo + 1) != $data['kas_tgl']) {
      $this->M_pos->resetNomorTransaksiHarian($this->outlet);
    }
    redirect(base_url('pos/pos'));
  }
}
