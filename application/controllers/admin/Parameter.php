<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parameter extends MY_Controller
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
    $this->load->model('M_outlet');
  }


  /*----------------- MODUL COMPANY PROFILE ---------------------*/
  function profile_company()
  {
    $data['data'] = $this->M_crud->read('tbl_pt')[0];
    $this->render('admin/parameter/v_profile', $data);
  }

  function simpan_profile_company()
  {
    $pt_id = $this->input->post('pt_id');
    $this->form_validation->set_rules('out_email', 'Email', 'required|valid_email');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b>Email tidak valid</b> Data tidak dapat disimpan</div>');
      redirect('admin/parameter/profile_company');
    } else {
      $data = [
        'pt_nama' => $this->input->post('pt_nama'),
        'pt_npwp' => $this->input->post('pt_npwp'),
        'pt_alamat' => $this->input->post('pt_alamat'),
        'pt_negara' => $this->input->post('pt_negara'),
        'pt_nama_pic' => $this->input->post('pt_nama_pic'),
        'pt_telp_pic' => $this->input->post('pt_telp_pic'),
        'pt_email' => $this->input->post('pt_email'),
        'pt_website' => $this->input->post('pt_website'),
      ];
      $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));
      $data_old = $this->M_crud->select('tbl_pt', 'pt_id', $pt_id);
      $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

      $this->M_crud->update('tbl_pt', $data, 'pt_id', $this->input->post('pt_id'));
      $this->M_log->simpan_log($pt_id, 'COMPANY PROFILE', $log_oldval, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['pt_nama'] . '</b> Berhasil diupdate.</div>');
      redirect('admin/parameter/profile_company');
    }
  }


  /*----------------- MODUL WEWENANG MENU ADMIN ---------------------*/
  function wewenang_admin()
  {
    $data['data'] = $this->M_crud->read('tbl_level_admin');
    $this->render('admin/parameter/v_wewenang_admin', $data);
  }

  function reset_wewenang()
  {
    $level_id = $this->uri->segment(4);
    $wewenang = $this->input->post('wewenang');
    if (!$this->input->post('wewenang')) {
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b></b> Tidak ada data di pass</div>');
      redirect('admin/parameter/wewenang_admin');
    }

    $this->form_validation->set_rules('level_desc', 'Deskripsi Jabatan', 'is_unique[tbl_level_admin.level_desc]');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b>Deskripsi Jabatan sudah ada</b> Data tidak dapat disimpan</div>');
      redirect('admin/parameter/wewenang_admin');
    } else {

      $data = [
        'level_desc' => $this->input->post('level_desc'),
        'parameter' => ((array_search('1', $wewenang) ? "Y" : "N")),
        'katalog' => ((array_search('2', $wewenang) ? "Y" : "N")),
        'pos' => ((array_search('3', $wewenang) ? "Y" : "N")),
        'laporan' => ((array_search('4', $wewenang) ? "Y" : "N")),
        'sistem' => ((array_search('5', $wewenang) ? "Y" : "N")),
        'user' => ((array_search('6', $wewenang) ? "Y" : "N")),
      ];
      $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

      if (!$level_id) {
        $this->M_crud->insert('tbl_level_admin', $data);
        $reff_id = $this->db->insert_id();

        $this->M_log->simpan_log($reff_id, 'WEWENANG MENU ADMIN', null, $log_newval);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b> wewenang berhasil di update </div>');
        redirect('admin/parameter/wewenang_admin');
      }

      $data_old = $this->M_crud->select('tbl_level_admin', 'level_id', $level_id);
      $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
      $reff_id = $level_id;

      $this->M_log->simpan_log($reff_id, 'WEWENANG MENU ADMIN', $log_oldval, $log_newval);
      $this->M_crud->update('tbl_level_admin', $data, 'level_id', $level_id);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b> wewenang berhasil di update </div>');
      redirect('admin/parameter/wewenang_admin');
    }
  }

  function hapus_wewenang($level_id)
  {
    $data_old = $this->M_crud->select('tbl_level_admin', 'level_id', $level_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($level_id, 'WEWENANG MENU ADMIN', $log_oldval);
    $this->M_crud->delete('tbl_level_admin', 'level_id', $level_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>wewenang Berhasil dihapus dari database.</div>');
    redirect('admin/parameter/wewenang_admin');
  }


  /*----------------- MODUL WEWENANG MENU POS ---------------------*/
  function wewenang_pos()
  {
    $data['data'] = $this->M_crud->read('tbl_level_pos');
    $this->render('admin/parameter/v_wewenang_pos', $data);
  }

  function reset_wewenang_pos()
  {
    $level_id = $this->uri->segment(4);
    $wewenang = $this->input->post('wewenang');
    if (!$this->input->post('wewenang')) {
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b></b> Tidak ada data di pass</div>');
      redirect('admin/parameter/wewenang_pos');
    }

    $data = [
      'level_desc' => $this->input->post('level_desc'),
      'pos' => ((array_search('1', $wewenang)) ? "Y" : "N"),
      'inventory' => ((array_search('2', $wewenang)) ? "Y" : "N"),
      'transaction' => ((array_search('3', $wewenang)) ? "Y" : "N"),
      'kitchen' => ((array_search('4', $wewenang)) ? "Y" : "N"),
      'waitress' => ((array_search('5', $wewenang)) ? "Y" : "N"),
      'laporan' => ((array_search('6', $wewenang)) ? "Y" : "N"),
      'settings' => ((array_search('7', $wewenang)) ? "Y" : "N"),
      'user' => ((array_search('8', $wewenang)) ? "Y" : "N"),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$level_id) {
      $this->M_crud->insert('tbl_level_pos', $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'WEWENANG MENU POS', null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b> wewenang berhasil di update </div>');
      redirect('admin/parameter/wewenang_pos');
    }
    $this->M_crud->update('tbl_level_pos', $data, 'level_id', $level_id);
    $data_old = $this->M_crud->select('tbl_level_pos', 'level_id', $level_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
    $reff_id = $level_id;

    $this->M_log->simpan_log($reff_id, 'WEWENANG MENU POS', $log_oldval, $log_newval);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b> wewenang berhasil di update </div>');
    redirect('admin/parameter/wewenang_pos');
  }

  function hapus_wewenang_pos($level_id)
  {
    $data_old = $this->M_crud->select('tbl_level_pos', 'level_id', $level_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($level_id, 'WEWENANG MENU POS', $log_oldval);
    $this->M_crud->delete('tbl_level_pos', 'level_id', $level_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>wewenang Berhasil dihapus dari database.</div>');
    redirect('admin/parameter/wewenang_pos');
  }


  /*----------------- MODUL OUTLET ---------------------*/
  function outlet()
  {
    $data['data'] = $this->M_crud->read('tbl_outlet');
    $this->render('admin/parameter/v_outlet', $data);
  }

  function simpan_outlet()
  {
    $out_id = $this->input->post('out_id');
    $this->form_validation->set_rules('out_email', 'Email', 'required|valid_email');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b>Email tidak valid</b> Data tidak dapat disimpan</div>');
      redirect('admin/parameter/outlet');
    } else {
      $data =  [
        'out_kode' => $this->input->post('out_kode'),
        'out_nama' => $this->input->post('out_nama'),
        'out_alamat' => $this->input->post('out_alamat'),
        'out_telp' => $this->input->post('out_telp'),
        'out_email' => $this->input->post('out_email'),
        'out_opening_hours' => $this->input->post('out_opening_hours'),
        'out_closing_hours' => $this->input->post('out_closing_hours'),
        'out_nm_pic' => $this->input->post('out_nm_pic'),
        'notes_receipt' => $this->input->post('out_notes'),
      ];
      $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

      if (!$out_id) {
        //create new outlet
        $this->M_crud->insert('tbl_outlet', $data);
        $reff_id = $this->db->insert_id();
        $this->M_outlet->create_data_table_outlet($reff_id);

        $this->M_log->simpan_log($reff_id, 'OUTLET', null, $log_newval);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['out_nama'] . '</b> Berhasil ditambah/diupdate.</div>');
        redirect('admin/parameter/outlet');
      }
      //update outlet
      $data_old = $this->M_crud->select('tbl_outlet', 'out_id', $out_id);
      $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
      $reff_id = $out_id;

      $this->M_crud->update('tbl_outlet', $data, 'out_id', $this->input->post('out_id'));
      $this->M_log->simpan_log($reff_id, 'OUTLET', $log_oldval, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['out_nama'] . '</b> Berhasil ditambah/diupdate.</div>');
      redirect('admin/parameter/outlet');
    }
  }

  function hapus_outlet($out_id)
  {
    $data_old = $this->M_crud->select('tbl_outlet', 'out_id', $out_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_outlet->delete_data_table_outlet($out_id);
    $this->M_log->simpan_log($out_id, 'OUTLET', $log_oldval);
    $this->M_crud->delete('tbl_outlet', 'out_id', $out_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Outlet Berhasil dihapus dari database.</div>');
    redirect('admin/parameter/outlet');
  }


  /*----------------- MODUL PELANGGAN ---------------------*/
  function pelanggan()
  {
    $data['data'] = $this->M_crud->read('tbl_pelanggan');
    $this->render('admin/parameter/v_pelanggan', $data);
  }

  function simpan_pelanggan()
  {
    if ($this->input->post('plg_password') !== $this->input->post('plg_password2')) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Password dan Ulangi Password yang Anda masukan tidak sama.</div>');
      redirect('admin/parameter/pelanggan');
    }

    $plg_id = $this->input->post('plg_id');
    $this->form_validation->set_rules('plg_email', 'Email', 'required|valid_email');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b>Email tidak valid</b> Data tidak dapat disimpan</div>');
      redirect('admin/parameter/pelangan');
    } else {

      $data =  [
        'plg_nama' => $this->input->post('plg_nama'),
        'plg_alamat' => $this->input->post('plg_alamat'),
        'plg_jenkel' => $this->input->post('plg_jenkel'),
        'plg_notelp' => $this->input->post('plg_notelp'),
        'plg_email' => $this->input->post('plg_email'),
        'plg_whatsapp' => $this->input->post('plg_whatsapp'),
        'plg_password' => md5($this->input->post('plg_password')),
      ];
      $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

      if (!$plg_id) {
        $this->M_crud->insert('tbl_pelanggan', $data);
        $reff_id = $this->db->insert_id();
        $this->M_log->simpan_log($reff_id, 'PELANGGAN', null, $log_newval);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['plg_nama'] . '</b> Berhasil ditambah/diupdate.</div>');
        redirect('admin/parameter/pelanggan');
      }
      $data_old = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
      $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
      $reff_id = $plg_id;

      $this->M_crud->update('tbl_pelanggan', $data, 'plg_id', $plg_id);
      $this->M_log->simpan_log($reff_id, 'PELANGGAN', $log_oldval, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['plg_nama'] . '</b> Berhasil ditambah/diupdate.</div>');
      redirect('admin/parameter/pelanggan');
    }
  }

  function hapus_pelanggan($plg_id)
  {
    $data_old = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($plg_id, 'PELANGGAN', $log_oldval);
    $this->M_crud->delete('tbl_pelanggan', 'plg_id', $plg_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>pelanggan Berhasil dihapus dari database.</div>');
    redirect('admin/parameter/pelanggan');
  }


  /*----------------- MODUL TAX ---------------------*/
  public function tax()
  {
    $data['data'] = $this->M_crud->read('tbl_tax');
    $this->render('admin/parameter/v_tax', $data);
  }

  public function simpan_tax()
  {
    $tax_id = $this->input->post('tax_id');

    $this->form_validation->set_rules('tax_nm', 'Nama Tax', 'is_unique[tbl_tax.tax_nm]');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b></b>Nama Tax ini sudah ada !</div>');
      redirect('admin/parameter/tax');
    } else {

      $data = [
        'tax_nm' => $this->input->post('tax_nm'),
        'tax_persen' => $this->input->post('tax_persen'),
      ];
      $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

      if (!$tax_id) {
        $this->M_crud->insert('tbl_tax', $data);
        $reff_id = $this->db->insert_id();

        $this->M_log->simpan_log($reff_id, 'TAX', null, $log_newval);
        $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['tax_nm'] . '</b> Berhasil ditambah/diupdate.</div>');
        redirect('admin/parameter/tax');
      }
      $data_old = $this->M_crud->select('tbl_tax', 'tax_id', $tax_id);
      $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
      $reff_id = $tax_id;

      $this->M_log->simpan_log($reff_id, 'TAX', $log_oldval, $log_newval);
      $this->M_crud->update('tbl_tax', $data, 'tax_id', $tax_id);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data['tax_nm'] . '</b> Berhasil ditambah/diupdate.</div>');
      redirect('admin/parameter/tax');
    }
  }

  public function hapus_tax($tax_id)
  {
    $data_old = $this->M_crud->select('tbl_tax', 'tax_id', $tax_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($tax_id, 'TAX', $log_oldval);
    $this->M_crud->delete('tbl_tax', 'tax_id', $tax_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>' . $data_old['tax_nm'] . '</b> Berhasil dihapus.</div>');
    redirect('admin/parameter/tax');
  }
}
