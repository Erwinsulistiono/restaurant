<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_pos');
		$this->load->model('M_laporan');
		$this->load->model('M_laporan_harian');
		$this->user = $this->session->userdata('idadmin');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function close_kasir()
	{
		$tgl_awal = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $this->user)['pengguna_last_login'];
		$tgl_akhir = date("Y-m-d H:i:s");
		$tot_saldo = $this->M_laporan->get_laporan_cash_in_out($tgl_awal, $tgl_akhir, $this->outlet, $this->session->userdata('pengguna_username'));
		$tot = 0;
		foreach ($tot_saldo as $t) {
			$tot += $t['trx_grand_total'];
		}
		$data = [
			'tot_saldo' => $tot,
			'cek_saldo' => $this->M_pos->get_saldo_cash_in($tgl_awal, $this->user, $this->outlet),
		];
		$this->render('pos/settings/v_closing_kasir', $data);
	}

	public function simpan_close_kasir()
	{
		$kas_saldo_akhir = $this->input->post('kas_saldo_akhir');
		$data = [
			'kas_saldo_akhir' => preg_replace('/[^0-9]/', '', $kas_saldo_akhir),
		];
		$this->M_crud->update("tbl_kas_harian_$this->outlet", $data, 'kas_id', $this->input->post('kas_id'));
		// $this->send_mail(); Uncomment setelah settings email
		redirect('login/logout');
	}


	public function laporan_harian()
	{
		isset($this->M_laporan_harian->count_total_porsi()['total_porsi']) ? $total_porsi = $this->M_laporan_harian->count_total_porsi()['total_porsi'] : $total_porsi = '';
		$data = [
			'penjualan_per_menu' => $this->M_laporan_harian->get_sales_per_kategori(),
			'summary' => $this->M_laporan_harian->get_laporan_harian(),
			'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
			'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
			'payment_method' => $this->M_crud->read('tbl_payment'),
			'trx' => $this->M_laporan_harian->get_today_trx(),
			'total_order' => $total_porsi,
			'total_trx' => $this->M_laporan_harian->count_total_trx(),
		];
		$this->load->view('pos/settings/v_laporan_harian', $data);
	}


	public function send_mail()
	{
		$input_data = [
			'tgl_awal' => date("Y-m-d"),
			'tgl_akhir' => date("Y-m-d"),
			'tipe_trx' => "all",
			'outlet' => $this->outlet,
		];
		$data['data'] = $this->M_laporan->get_laporan_outlet($input_data);

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'example@gmail.com', // change it to yours
			'smtp_pass' => '', // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'newline' => "\r\n",
			'smtp_timeout' => '7',
			'wordwrap' => TRUE
		);

		$from_email = "";
		$to_email = "";
		$body = $this->load->view('pos/settings/v_email.php', $data, TRUE);

		$this->load->library('email', $config);
		$this->email->from($from_email, 'no-reply');
		$this->email->to($to_email);
		$this->email->subject('Laporan Transaksi - ' . date("d-M-Y"));
		$this->email->message($body);

		if ($this->email->send()) {
			redirect('login/logout');
		} else {
			echo $this->email->print_debugger();
			echo "success";
		}
	}
}
