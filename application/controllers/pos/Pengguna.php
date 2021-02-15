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
			'outlet_id' => $this->outlet,
			'level' => $this->M_crud->read('tbl_level_admin'),
			'level_pos' => $this->M_crud->read('tbl_level_pos'),
			'data' => $this->M_pengguna->get_pengguna($this->outlet),
		];
		$this->render('pos/user/v_pengguna', $data);
	}

	function simpan_pengguna($outlet_id)
	{
		$pengguna_id = $this->input->post('pengguna_id');
		$password = $this->input->post('pengguna_password');
		$password_confirmation = $this->input->post('pengguna_password_confirmation');
		if ($password !== $password_confirmation) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>password tidak match.</div>');
			redirect("pos/pengguna/pengguna/$outlet_id");
		}
		$nmfile = str_replace(' ', '_', $_FILES['filefoto']['name']);
		$config['upload_path'] = './assets/images/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '1024';
		$config['file_name'] = $nmfile;
		if ($nmfile) {
			$this->upload->initialize($config);
			$gbr = $this->upload->data();
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('filefoto')) {
				$data['pengguna_photo'] = $nmfile;
			}
		}
		if ($pengguna_id) {
			if (empty($nmfile)) {
				$nmfile = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id)['pengguna_photo'];
				$data['pengguna_photo'] = $nmfile;
			} else {
				$data['pengguna_photo'] = $nmfile;
			}
		}
		if (empty($password)) {
			$pass = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id)['pengguna_password'];
			$passcode = $pass;
		} else {
			$passcode = md5($password);
		}

		$data = [
			'pengguna_nama' => $this->input->post('pengguna_nama'),
			'pengguna_jenkel' => $this->input->post('pengguna_jenkel'),
			'pengguna_username' => $this->input->post('pengguna_username'),
			'pengguna_password' => $passcode,
			'pengguna_email' => $this->input->post('pengguna_email'),
			'pengguna_nohp' => $this->input->post('pengguna_nohp'),
			'pengguna_dashboard' => $this->input->post('pengguna_dashboard'),
			'pengguna_outlet' => $outlet_id,
			'pengguna_level' => $this->input->post('pengguna_level'),
			'pengguna_photo' => $nmfile,
		];
		$log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

		if (!$pengguna_id) {
			$this->M_crud->insert('tbl_pengguna', $data);
			$reff_id = $this->db->insert_id();

			$this->M_log->simpan_log($reff_id, 'USER', null, $log_newval);
			$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>pengguna <b>' . $data['pengguna_nama'] . '</b> Berhasil disimpan ke database.</div>');
			redirect("pos/pengguna/pengguna/$outlet_id");
		}
		$data_old = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($pengguna_id, 'USER', $log_oldval, $log_newval);
		$this->M_crud->update('tbl_pengguna', $data, 'pengguna_id', $pengguna_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>pengguna <b>' . $data['pengguna_nama'] . '</b> Berhasil disimpan ke database.</div>');
		redirect("pos/pengguna/pengguna/$outlet_id");
	}

	function hapus_pengguna($pengguna_id, $outlet_id)
	{
		$data_old = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($pengguna_id, 'USER', $log_oldval);
		$this->M_crud->delete('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pengguna Berhasil dihapus dari database.</div>');
		redirect("pos/pengguna/pengguna/$outlet_id");
	}

	function reset_password($pengguna_id, $outlet_id)
	{
		$pengguna = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $pengguna_id);
		$pengguna_password = $pengguna['pengguna_password'];
		$log_oldval = "pengguna_password : $pengguna_password";
		$pass = 123456;
		$data['pengguna_password'] = md5($pass);
		$pengguna_password = $data['pengguna_password'];
		$log_newval = "pengguna_password : $pengguna_password";

		$this->M_log->simpan_log($pengguna_id, 'PENGGUNA RESET PASS', $log_oldval, $log_newval);
		$this->M_crud->update('tbl_pengguna', $data, 'pengguna_id', $pengguna_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Username : <b>' . $pengguna['pengguna_username'] . '</b> <br/> Password baru : <b>' . $pass . '</b></div>');
		redirect("pos/pengguna/pengguna/$outlet_id");
	}
}
