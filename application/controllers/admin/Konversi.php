<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konversi extends MY_Controller
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
    $this->load->model('M_konversi');
  }

  public function index()
  {
    $data['data'] = $this->M_konversi->read();
    $this->render('admin/parameter/v_konversi', $data);
  }

  function simpan_konversi()
  {
    $satuan_id = $this->input->post('satuan_id');
    $this->form_validation->set_rules('satuan_kode', 'Satuan Kode', 'is_unique[tbl_satuan.satuan_kode]');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b></b>Nama Satuan Kode ini sudah ada !</div>');
      redirect('admin/konversi');
    }
    $data = [
      'satuan_kode' => $this->input->post('satuan_kode'),
      'satuan_reff' => $this->input->post('satuan_reff'),
      'satuan_val' => $this->input->post('satuan_val'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$satuan_id) {
      $this->M_crud->insert('tbl_satuan', $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'KONVERSI SATUAN', null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Satuan <b>' . $data['satuan_kode'] . '</b> Berhasil disimpan ke database.</div>');
      redirect('admin/konversi');
    }
    $data_old = $this->M_crud->select('tbl_satuan', 'satuan_id', $satuan_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($satuan_id, 'KONVERSI SATUAN', $log_oldval, $log_newval);
    $this->M_crud->update('tbl_satuan', $data, 'satuan_id', $satuan_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Satuan <b>' . $data['satuan_kode'] . '</b> Berhasil disimpan ke database.</div>');
    redirect('admin/konversi');
  }

  function hapus_konversi($satuan_id)
  {
    $data_old = $this->M_crud->select('tbl_satuan', 'satuan_id', $satuan_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($satuan_id, 'KONVERSI SATUAN', $log_oldval);
    $this->M_crud->delete('tbl_satuan', 'satuan_id', $satuan_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Satuan <b>' . $data_old['satuan_kode'] . '</b> Berhasil dihapus dari database.</div>');
    redirect('admin/konversi');
  }
}
