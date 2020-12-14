<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->library('upload');
	}

	function index()
	{
		$this->render('admin/profile/v_profile');
	}

	function update()
	{
		if ($this->input->post('password') !== $this->input->post('password2')) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Password dan Ulangi Password yang Anda masukan tidak sama.</div>');
			redirect('admin/profile');
		}
		$data = [
			'pengguna_username' => $this->input->post('username'),
			'pengguna_password' => md5($this->input->post('password')),
			'pengguna_email' => $this->input->post('email'),
			'pengguna_nohp' => $this->input->post('kontak'),
		];
		$this->M_crud->update('tbl_pengguna', $data, 'pengguna_id', $this->session->userdata('idadmin'));
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pengguna <b>' . $this->session->userdata('nama') . '</b> Berhasil diupdate.</div>');
		redirect('login/logout');
	}
}