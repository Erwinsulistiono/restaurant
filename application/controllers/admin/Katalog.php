<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Katalog extends MY_Controller
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
    $this->load->library('upload');
  }


  /*----------------- MODUL KATEGORI ---------------------*/
  function kategori_menu()
  {
    $data['data'] = $this->M_crud->read('tbl_kategori');
    $this->render('admin/katalog/v_kategori_menu', $data);
  }

  function simpan_kategori_menu()
  {
    $kategori_id = $this->input->post('kategori_id');

    $this->form_validation->set_rules('kategori_nama', 'Kategori', 'is_unique[tbl_kategori.kategori_nama]');
    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b></b>Nama Kategori ini sudah ada !</div>');
      redirect('admin/katalog/kategori_menu');
    }
    $data['kategori_nama'] = $this->input->post('kategori_nama');
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$kategori_id) {
      $this->M_crud->insert('tbl_kategori', $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'KATEGORI', null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Kategori <b>' . $data['kategori_nama'] . '</b> Berhasil disimpan ke database.</div>');
      redirect('admin/katalog/kategori_menu');
    }
    $data_old = $this->M_crud->select('tbl_kategori', 'kategori_id', $kategori_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_crud->update('tbl_kategori', $data, 'kategori_id', $kategori_id);
    $this->M_log->simpan_log($kategori_id, 'KATEGORI', $log_oldval, $log_newval);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Kategori <b>' . $data['kategori_nama'] . '</b> Berhasil disimpan ke database.</div>');
    redirect('admin/katalog/kategori_menu');
  }

  function hapus_kategori_menu($kategori_id)
  {
    $data_old = $this->M_crud->select('tbl_kategori', 'kategori_id', $kategori_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
    $outlet = $this->M_crud->read('tbl_outlet');

    $this->M_log->simpan_log($kategori_id, 'KATEGORI', $log_oldval);
    $this->M_crud->delete('tbl_kategori', 'kategori_id', $kategori_id);
    $this->M_crud->delete('tbl_menu_kat', 'kategori_id', $kategori_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>kategori <b>' . $this->input->post('kategori_nama') . '</b> Berhasil dihapus dari database.</div>');
    redirect('admin/katalog/kategori_menu');
  }


  /*----------------- MODUL VOUCHER ---------------------*/
  function voucher()
  {
    $data['data'] = $this->M_crud->read('tbl_voucher');
    $this->render('admin/katalog/v_voucher', $data);
  }

  function simpan_voucher()
  {
    $voucher_id = $this->input->post('voucher_id');
    $jenis_diskon = $this->input->post('jenis_diskon');
    ($jenis_diskon == 'discount') ? $discount = $this->input->post('voucher_diskon') : $discount = 0;
    ($jenis_diskon == 'nominal') ? $nominal = $this->input->post('voucher_diskon') : $nominal = 0;

    $data = [
      'voucher_kode' => $this->input->post('voucher_kode'),
      'voucher_nama' => $this->input->post('voucher_nama'),
      'voucher_nominal' => $nominal,
      'voucher_discount' => $discount,
      'voucher_periode_awal' => $this->input->post('voucher_periode_awal'),
      'voucher_periode_akhir' => $this->input->post('voucher_periode_akhir'),
      'voucher_limit' => $this->input->post('voucher_limit'),
      'voucher_tandc' => $this->input->post('voucher_tandc'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$voucher_id) {
      $this->M_crud->insert('tbl_voucher', $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'VOUCHER', null,  $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>voucher <b>' . $data['voucher_nama'] . '</b> Berhasil disimpan ke database.</div>');
      redirect('admin/katalog/voucher');
    }
    $data_old = $this->M_crud->select('tbl_voucher', 'voucher_id', $voucher_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_crud->update('tbl_voucher', $data, 'voucher_id', $this->input->post('voucher_id'));
    $this->M_log->simpan_log($voucher_id, 'VOUCHER', $log_oldval, $log_newval);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>voucher <b>' . $data['voucher_nama'] . '</b> Berhasil disimpan ke database.</div>');
    redirect('admin/katalog/voucher');
  }

  function hapus_voucher($voucher_id)
  {
    $data_old = $this->M_crud->select('tbl_voucher', 'voucher_id', $voucher_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($voucher_id, 'VOUCHER', $log_oldval);
    $this->M_crud->delete('tbl_voucher', 'voucher_id', $voucher_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>voucher <b>' . $data_old['voucher_nama'] . '</b> Berhasil dihapus dari database.</div>');
    redirect('admin/katalog/voucher');
  }


  /*----------------- MODUL GALLERY ---------------------*/
  function gallery()
  {
    $data['data'] = $this->M_crud->read('tbl_galeri');
    $this->render('admin/katalog/v_gallery', $data);
  }

  function simpan_gallery()
  {
    $galeri_id = $this->input->post('galeri_id');
    $nmfile = str_replace(' ', '_', $_FILES['filefoto']['name']);
    $config['upload_path'] = './assets/galeries'; //path folder
    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
    $config['max_size'] = '2024';
    $config['file_name'] = $nmfile;

    if ($nmfile) {
      $this->upload->initialize($config);
      $gbr = $this->upload->data();
      $this->load->library('upload', $config);

      if ($this->upload->do_upload('filefoto')) {
        $data['filefoto'] = $nmfile;
      }
    }

    if (empty($nmfile)) {
      $nmfile = $this->M_crud->select('tbl_galeri', 'galeri_id', $galeri_id)['galeri_gambar'];
      $data['galeri_gambar'] = $nmfile;
    } else {
      $data['galeri_gambar'] = $nmfile;
    }

    $data = [
      'galeri_gambar' => $nmfile,
      'galeri_judul' => $this->input->post('galeri_judul'),
      'galeri_deskripsi' => $this->input->post('galeri_deskripsi'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$galeri_id) {
      $this->M_crud->insert('tbl_galeri', $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'GALLERY', null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Gallery <b>' . $data['galeri_judul'] . '</b> Berhasil disimpan ke database.</div>');
      redirect('admin/katalog/gallery');
    }
    $data_old = $this->M_crud->select('tbl_galeri', 'galeri_id', $galeri_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_crud->update('tbl_galeri', $data, 'galeri_id', $galeri_id);
    $this->M_log->simpan_log($galeri_id, 'GALLERY', $log_oldval, $log_newval);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Gallery <b>' . $data['galeri_judul'] . '</b> Berhasil disimpan ke database.</div>');
    redirect('admin/katalog/gallery');
  }

  function hapus_gallery($galeri_id)
  {
    $data_old = $this->M_crud->select('tbl_galeri', 'galeri_id', $galeri_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($galeri_id, 'GALLERY', $log_oldval);
    $this->M_crud->delete('tbl_galeri', 'galeri_id', $galeri_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Gallery Berhasil dihapus dari database.</div>');
    redirect('admin/katalog/gallery');
  }
}
