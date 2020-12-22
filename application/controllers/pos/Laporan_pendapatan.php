<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pendapatan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_laporan_pendapatan');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function index()
	{
		$data['tipe_pembayaran'] = $this->M_crud->read('tbl_payment');
		$this->render('pos/laporan_pendapatan/v_index', $data);
	}

	public function laporan($kasir_id = null, $outlet_id = null)
	{
		$data_input = [
			'tgl_awal' => $this->input->post('tgl_awal'),
			'tgl_akhir' => $this->input->post('tgl_akhir'),
			'outlet' => $this->outlet,
			'tipe_pembayaran' => $this->input->post('payment'),
			'periode' => $this->input->post('periode'),
		];

		switch ($data_input['periode']) {
			case "all":
				$return_data['data'] = $this->query_groupby_all($data_input);
				$this->render('pos/laporan_pendapatan/v_laporan', $return_data);
				break;
			case "daily":
				$return_data['data'] = $this->query_groupby_harian($data_input);
				$this->render('pos/laporan_pendapatan/v_laporan', $return_data);
				break;
			case "weekly":
				$return_data['data'] = $this->query_groupby_mingguan($data_input);
				$this->render('pos/laporan_pendapatan/v_laporan', $return_data);
				break;
			case "monthly":
				$return_data['data'] = $this->query_groupby_bulanan($data_input);
				$this->render('pos/laporan_pendapatan/v_laporan', $return_data);
				break;
			default:
				$this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Unknown Error.</div>');
				$this->index();
		}
	}

	public function query_groupby_all($data_input)
	{
		$return_data = $this->M_laporan_pendapatan->get_laporan_all($data_input);
		return $return_data;
	}

	public function query_groupby_harian($data_input)
	{
		$return_data = $this->M_laporan_pendapatan->get_laporan_harian($data_input);
		return $return_data;
	}

	public function query_groupby_mingguan($data_input)
	{
		$return_data = $this->M_laporan_pendapatan->get_laporan_mingguan($data_input);
		return $return_data;
	}

	public function query_groupby_bulanan($data_input)
	{
		$return_data = $this->M_laporan_pendapatan->get_laporan_bulanan($data_input);
		return $return_data;
	}
}
