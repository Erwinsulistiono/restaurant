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
		$this->pengguna_id = $this->session->userdata('idadmin');
	}

	function index()
	{
		$this->render('admin/profile/v_profile');
	}

	function update()
	{
		$password = $this->input->post('password');
		$password_confirmation = $this->input->post('password_confirmation');
		if (empty($password) || $password !== $password_confirmation) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Password dan Ulangi Password yang Anda masukan tidak sama / kosong.</div>');
			redirect('admin/profile');
		}

		$config['upload_path'] = './assets/images'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '1024';

		$this->upload->initialize($config);

		if (!empty($_FILES['filefoto'])) {

			$nmfile = str_replace(' ', '_', $_FILES['filefoto']['name']);
			$config['file_name'] = $nmfile;
			$data['pengguna_photo'] = $nmfile;
		}

		$data['pengguna_username'] = $this->input->post('username');
		$data['pengguna_email'] = $this->input->post('email');
		$data['pengguna_nohp'] = $this->input->post('kontak');
		$data['pengguna_password'] = md5($password);
		echo '<pre>';
		echo ($_FILES['filefoto']['name']);
		var_dump($data);
		echo '</pre>';
		// $this->M_crud->update('tbl_pengguna', $data, 'pengguna_id', $this->pengguna_id);

		// redirect('login/logout');
	}
}
