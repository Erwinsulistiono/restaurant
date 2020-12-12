<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_pos_admin');
		$this->load->model('M_log');
		$this->load->library('upload');
		$this->all_outlet = $this->M_crud->read('tbl_outlet');
	}


	/*----------------- MODUL PAYMENT OPTION POS ---------------------*/
	function payment()
	{
		$data['data'] = $this->M_crud->read('tbl_payment');
		$this->render('admin/pos/pos_settings/v_payment', $data);
	}

	function simpan_payment()
	{
		$payment_id = $this->input->post('payment_id');
		$image = $_FILES['payment_qrcode']['name'];

		if ($image) {
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['max_size'] = '2024';
			$config['upload_path'] = './assets/img/';

			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			$this->upload->do_upload('payment_qrcode');
		}

		if ((!$image) && ($payment_id)) {
			$image = $this->input->post('old_payment_qrcode');
		}

		 if($this->upload->do_upload('payment_qrcode')){
      		$data['payment_qrcode'] = $image;
    	}

		$data = [
			'payment_nama' => $this->input->post('payment_nama'),
			'payment_norek' => $this->input->post('payment_norek'),
			'payment_bank' => $this->input->post('payment_bank'),
			'useride' => $this->session->userdata('user_nama'),
			'updatedte' => date('Y-m-d H:i:s'),
			'payment_qrcode' => $image
		];
		$log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

		if (!$payment_id) {
			$this->M_crud->insert('tbl_payment', $data);
			$reff_id = $this->db->insert_id();

			$this->M_log->simpan_log($reff_id, 'PAYMENT POS', null, $log_newval);
			$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Data Payment <b>' . $data['payment_nama'] . '</b> Berhasil disimpan ke database.</div>');
			redirect('admin/pos/payment');
		}
		$data_old = $this->M_crud->select('tbl_payment', 'payment_id', $payment_id);
		$log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($payment_id, 'PAYMENT POS', $log_oldval, $log_newval);
		$this->M_crud->update('tbl_payment', $data, 'payment_id', $payment_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Data Payment <b>' . $data['payment_nama'] . '</b> Berhasil disimpan ke database.</div>');
		redirect('admin/pos/payment');
	}

	function hapus_payment($payment_id)
	{
		$data_old = $this->M_crud->select('tbl_payment', 'payment_id', $payment_id);
		$log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($payment_id, 'PAYMENT POS', $log_oldval);
		$this->M_crud->delete('tbl_payment', 'payment_id', $payment_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Data Payment <b>' . $this->input->post('payment_nama') . '</b> Berhasil dihapus dari database.</div>');
		redirect('admin/pos/payment');
	}


	/*----------------- MODUL PAYMENT SALDO KAS HARIAN ---------------------*/
	function pilih_saldo()
	{
		$data['pengguna'] = $this->M_crud->read('tbl_pengguna');
		$data['outlet'] = $this->M_crud->read('tbl_outlet');
		$this->render('admin/pos/saldo_kas_harian/v_index', $data);
	}
	

	function saldo_kas_harian($pengguna_kasir = null, $tgl_awal = null, $tgl_akhir = null, $outlets = null)
	{

		$data = [			
			'pengguna_kasir' => ($pengguna_kasir) ? $pengguna_kasir : $this->input->post('kas_nm_kasir'),
			'tgl_awal'  => ($tgl_awal) ? $tgl_awal : $this->input->post('tgl_awal'),
			'tgl_akhir' => ($tgl_akhir) ? $tgl_akhir : $this->input->post('tgl_akhir'),
			'outlets' => ($outlets) ? $outlets : $this->input->post('out_id'),
			'data' => [],
		];
		$data['data'] = $this->getAllDataSaldo($data['tgl_awal'] , $data['tgl_akhir']);
		
		if ($data['pengguna_kasir'] != 'all') {
			$data['data'] = $this->filterByPengguna($data);

		}
		if ($data['outlets'] != 'all') {
			$data['data'] = $this->filterByOutlets($data);
		}

		$data['outlet'] = $this->M_crud->read('tbl_outlet');

		$this->render('admin/pos/saldo_kas_harian/v_saldo_kas_harian', $data);
	}


	function simpan_saldo($pengguna_kasir, $tgl_awal, $tgl_akhir, $outlets)
	{
		$kas_id = $this->input->post('kas_id');
		$out_id = $this->input->post('out_id');
		$data = [
			'kas_tgl' => date('Y-m-d'),
			'kas_nm_kasir' => $this->input->post('kas_nm_kasir'),
			'kas_saldo_awal' => intval(preg_replace('/[^0-9]/', '', $this->input->post('kas_saldo_awal'))),
			'kas_saldo_akhir' => intval(preg_replace('/[^0-9]/', '', $this->input->post('kas_saldo_akhir')))
		];
		$log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

		if (!$kas_id) {
			$this->M_crud->insert('tbl_kas_harian_' . $out_id, $data);
			$reff_id = $this->db->insert_id();

			$this->M_log->simpan_log($reff_id, 'SALDO AWAL', null, $log_newval);
			$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>Saldo awal ' . $data['kas_saldo_awal'] . '</b> Berhasil ditambah.</div>');
			redirect('admin/pos/pilih_saldo/'. $pengguna_kasir .'/'. $tgl_awal .'/'. $tgl_akhir .'/'. $outlets);
		}

		$data_old = $this->M_crud->select('tbl_kas_harian_' . $out_id, 'kas_id', $kas_id);
		$log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

		$this->M_log->simpan_log($kas_id, $log_oldval, $log_newval);
		$this->M_crud->update('tbl_kas_harian_' . $out_id, $data, 'kas_id', $kas_id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><b>Saldo akhir ' . $data['kas_saldo_akhir'] . '</b> Berhasil di input.</div>');
		redirect('admin/pos/pilih_saldo/'. $pengguna_kasir .'/'. $tgl_awal .'/'. $tgl_akhir .'/'. $outlets);
	}


	public function pdf($pengguna_kasir, $tgl_awal, $tgl_akhir, $outlets)
	{
		$data['data'] = $this->getAllDataSaldo($tgl_awal , $tgl_akhir);
		if ($pengguna_kasir != 'all') {
			$data['data'] = $this->filterByPengguna($data);
		}
		if ($outlets != 'all') {
			$data['data'] = $this->filterByOutlets($data);
		}
		$this->load->view('admin/pos/saldo_kas_harian/v_pdf_kas_harian', $data);
	}


	public function excel($pengguna_kasir, $tgl_awal, $tgl_akhir, $outlets)
	{
		$data['data'] = $this->getAllDataSaldo($tgl_awal , $tgl_akhir);
		if ($pengguna_kasir != 'all') {
			$data['data'] = $this->filterByPengguna($data);
		}
		if ($outlets != 'all') {
			$data['data'] = $this->filterByOutlets($data);
		}
		$this->load->view('admin/pos/saldo_kas_harian/v_excel_kas_harian', $data);
	}


	public function getAllDataSaldo($tgl_awal, $tgl_akhir)
	{
		$arr = [];
		foreach ($this->all_outlet as $out) {
			$arr += $this->M_pos_admin->getSaldoHarianPerOutlet($out, $tgl_awal , $tgl_akhir);
		}
		return $arr;
	}


	public function filterByPengguna($data)
	{
		$filterBy = $data['pengguna_kasir'];
		$arr = array_filter($data['data'], function ($var) use ($filterBy) {
			return ($var['pengguna_id'] == $filterBy);
		});
		return $arr;
	}


	public function filterByOutlets($data)
	{
		$filterBy = $data['outlets'];
		$arr = array_filter($data['data'], function ($var) use ($filterBy) {
			return ($var['out_id'] == $filterBy);
		});
		return $arr;
	}
}