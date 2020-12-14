<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends MY_Controller
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
		$this->load->model('M_pengguna');
		$this->load->library('upload');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}


	/*----------------- MODUL PENGGUNA ---------------------*/
	function index()
	{
		$data = [
			'level' => $this->M_crud->read('tbl_level_admin'),
			'level_pos' => $this->M_crud->read('tbl_level_pos'),
			'data' => $this->M_pengguna->get_pengguna_outlet($this->outlet),
		];
		$this->render('pos/user/v_pengguna', $data);
	}

	function simpan_pengguna()
	{
		$pengguna_id = $this->input->post('pengguna_id');
		$password = $this->input->post('pengguna_password');
		$password2 = $this->input->post('pengguna_password2');
		if ($password !== $password2) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>password tidak match.</div>');
			redirect('pos/pengguna');
		}
		$nmfile = "file_" . time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path'] = './assets/images/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '1024'; //maksimum besar file 1M
		$config['max_width']  = '900'; //lebar maksimum 1288 px
		$config['max_height']  = '800'; //tinggi maksimu 1000 px
		$config['file_name'] = $nmfile; //nama yang terupload nantinya
		$this->upload->initialize($config);
		$gbr = $this->upload->data();

		if (empty($password)) {
			$password = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id)['pengguna_password'];
		}
		$data = [
			'pengguna_nama' => $this->input->post('pengguna_nama'),
			'pengguna_jenkel' => $this->input->post('pengguna_jenkel'),
			'pengguna_username' => $this->input->post('pengguna_username'),
			'pengguna_password' => md5($password),
			'pengguna_email' => $this->input->post('pengguna_email'),
			'pengguna_nohp' => $this->input->post('pengguna_nohp'),
			'pengguna_level' => $this->input->post('pengguna_level'),
			'pengguna_photo' => $gbr['file_name'],
		];
		$log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

		if (!$pengguna_id) {
			$this->M_crud->insert('tbl_pengguna', $data);
			$reff_id = $this->db->insert_id();

			$this->M_log->simpan_log($reff_id, 'USER', null, $log_newval);
			$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>pengguna <b>' . $data['pengguna_nama'] . '</b> Berhasil disimpan ke database.</div>');
			redirect('pos/pengguna');
		}
		$data_old = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($pengguna_id, 'USER', $log_oldval, $log_newval);
		$this->M_crud->update('tbl_pengguna', $data, 'pengguna_id', $pengguna_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>pengguna <b>' . $data['pengguna_nama'] . '</b> Berhasil disimpan ke database.</div>');
		redirect('pos/pengguna');
	}

	function hapus_pengguna($pengguna_id)
	{
		$data_old = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($pengguna_id, 'USER', $log_oldval);
		$this->M_crud->delete('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pengguna Berhasil dihapus dari database.</div>');
		redirect('pos/pengguna');
	}

	function reset_password($pengguna_id)
	{
		$pengguna = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$log_oldval = 'pengguna_password : ' . $pengguna['pengguna_password'];
		$pass = rand(123456, 999999);
		$data['pengguna_password'] = md5($pass);
		$log_newval = 'pengguna_password : ' . $data['pengguna_password'];;

		$this->M_log->simpan_log($pengguna_id, 'PENGGUNA RESET PASS', $log_oldval, $log_newval);
		$this->M_crud->update('tbl_pengguna', $data, 'pengguna_id', $pengguna_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Username : <b>' . $pengguna['pengguna_username'] . '</b> <br/> Password baru : <b>' . $pass . '</b></div>');
		redirect('pos/pengguna');
	}
}
