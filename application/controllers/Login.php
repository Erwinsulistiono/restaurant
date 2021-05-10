<?php
class Login extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_login');
    $this->load->model('M_crud');
  }

  public function index()
  {
    if ($this->session->userdata('masuk') == true) {
      redirect('login/berhasillogin');
    }
    $title['title'] = "Mi Resto";
    $this->load->view('layouts/v_head', $title);
    $this->load->view('v_login');
    $this->load->view('layouts/v_footer');
  }


  public function auth()
  {
    $username = strip_tags(str_replace("'", "", $this->input->post('username')));
    $password = md5($this->input->post('password'));
    $cadmin = $this->M_login->cekadmin($username, $password);

    if ($cadmin) {
      $sesdata = array(
        'masuk' => true,
        'pengguna_dashboard' => $cadmin['pengguna_dashboard'],
        'pengguna_level' => $cadmin['pengguna_level'],
        'idadmin' => $cadmin['pengguna_id'],
        'user_nama' => $cadmin['pengguna_nama'],
        'pengguna_username' => $cadmin['pengguna_username'],
        'pengguna_email' => $cadmin['pengguna_email'],
        'pengguna_nohp' => $cadmin['pengguna_nohp'],
        'pengguna_photo' => $cadmin['pengguna_photo'],
        'pengguna_outlet' => $cadmin['pengguna_outlet'],
      );
      $this->session->set_userdata($sesdata);
    }

    if ($this->session->userdata('masuk') == true) {
      $this->M_crud->update('tbl_pengguna', array('pengguna_last_login' => date("Y-m-d H:i:s")), 'pengguna_id', $cadmin['pengguna_id']);
      redirect('login/berhasillogin');
    }
    redirect('login/gagallogin');
  }

  public function berhasillogin()
  {
    if ($this->session->userdata('pengguna_dashboard') == 1) {
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Welcome <b>' . $this->session->userdata('user_nama') . '</b> Selamat bekerja.</div>');
      redirect('admin/dashboard');
    }
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Welcome <b>' . $this->session->userdata('user_nama') . '</b> Selamat bekerja.</div>');
    redirect('pos/dashboard');
  }

  public function gagallogin()
  {
    $this->session->set_flashdata('msg', 'Username Atau Password Salah');
    redirect('login');
  }

  public function logout()
  {
    $this->M_crud->update('tbl_pengguna', array('pengguna_last_login' => date("Y-m-d H:i:s")), 'pengguna_id', $this->session->userdata('idadmin'));
    $this->session->sess_destroy();
    redirect('login');
  }
}
