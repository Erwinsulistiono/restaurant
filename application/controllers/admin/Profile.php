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
		$pengguna_id = $this->input->post('pengguna_id');
		$password = $this->input->post('password');
		$password_confirmation = $this->input->post('password_confirmation');
		if (empty($password) || $password !== $password_confirmation) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Password dan Ulangi Password yang Anda masukan tidak sama / kosong.</div>');
			redirect('admin/profile');
		}

		$nmfile = str_replace(' ', '_', $_FILES['filefoto']['name']);
		$config['upload_path'] = './assets/images'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '1024';
		$config['file_name'] = $nmfile;
		if ($nmfile) {
			$this->upload->initialize($config);
			$gbr = $this->upload->data();
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('filefoto')) {
				$data['filefoto'] = $nmfile;
			}


			if (empty($nmfile)) {
				$nmfile = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id)['pengguna_photo'];
				$data['pengguna_photo'] = $nmfile;
			} else {
				$data['pengguna_photo'] = $nmfile;
			}
		}

		if (empty($password)) {
			$passcode = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id)['pengguna_password'];
			$pass = $passcode;
		} else {
			$pass = md5($password);
		}
		$data = [
			'pengguna_username' => $this->input->post('username'),
			'pengguna_email' => $this->input->post('email'),
			'pengguna_nohp' => $this->input->post('kontak'),
			'pengguna_password' => $pass,
			'pengguna_photo' => $nmfile,
		];
		$this->M_crud->update('tbl_pengguna', $data, 'pengguna_id', $this->session->userdata('idadmin'));
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pengguna <b>' . $this->session->userdata('nama') . '</b> Berhasil diupdate.</div>');
		redirect('login/logout');
	}
}
