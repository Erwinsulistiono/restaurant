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
		$start = new DateTime('2020-12-01');
		$end = new DateTime('2020-12-30 23:59');
		$interval = new DateInterval('P1D');
		$dateRange = new DatePeriod($start, $interval, $end);
		$weekNumber = 0;
		// $weeks = array();
		foreach ($dateRange as $date) {
			if ($date == $start || $date->format('d') == $end->format('d') || $date->format('w') == 1 || $date->format('w') == 6) {
				$weeks[$weekNumber][] = $date->format('Y-m-d');
			}
			if ($date->format('w') == 6) {
				$weekNumber++;
			}
		}
		echo '<pre>';
		var_dump($weeks);
		echo '</pre>';


		// if (isset($kasir_id) && $kasir_id != md5($this->session->userdata("pengguna_id")) && $outlet_id != md5($this->outlet)) {
		// 	$this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Uknown Error</div>');
		// 	$this->index();
		// }
		// $input_data = [
		// 	'tgl_awal' => ($kasir_id) ? date("Y-m-d") : $this->input->post('tgl_awal'),
		// 	'tgl_akhir' => ($kasir_id) ? date("Y-m-d") : $this->input->post('tgl_akhir'),
		// 	'payment_id' => ($kasir_id) ? "all" : $this->input->post('payment'),
		// 	'outlet' => $this->outlet,
		// 	'periode' => ($kasir_id) ? "trx" : $this->input->post('periode'),
		// ];

		// $return_data = $this->M_laporan_pendapatan->get_laporan_menu_outlet($input_data);
		// $return_data['payment'] = $this->M_crud->read("tbl_payment");
		// $this->render('pos/laporan_pendapatan/v_menu', $return_data);
	}

	// public function pdf($tgl_awal, $tgl_akhir, $tipe_trx, $group)
	// {
	// 	$data_input = [
	// 		'tgl_awal' => $tgl_awal,
	// 		'tgl_akhir' => $tgl_akhir,
	// 		'tipe_trx' => $tipe_trx,
	// 		'outlet' => $this->outlet,
	// 		'group' => $group,
	// 		'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
	// 	];

	// 	switch ($data_input['payment_id']) {
	// 		case "order":
	// 			$return_data = $this->group_by_order($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/pdf/v_order', $return_data);
	// 			break;
	// 		case "plg":
	// 			$return_data = $this->group_by_pelanggan($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/pdf/v_pelanggan', $return_data);
	// 			break;
	// 		case "trx":
	// 			$return_data = $this->group_by_transaksi($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/pdf/v_transaksi', $return_data);
	// 			break;
	// 		case "menu":
	// 			$return_data = $this->group_by_menu($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/pdf/v_menu', $return_data);
	// 			break;
	// 		default:
	// 			$this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Unknown Error.</div>');
	// 			$this->index();
	// 	}
	// }

	// public function excel($tgl_awal, $tgl_akhir, $tipe_trx, $group)
	// {
	// 	$data_input = [
	// 		'tgl_awal' => $tgl_awal,
	// 		'tgl_akhir' => $tgl_akhir,
	// 		'tipe_trx' => $tipe_trx,
	// 		'outlet' => $this->outlet,
	// 		'group' => $group,
	// 		'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
	// 	];

	// 	switch ($data_input['group']) {
	// 		case "order":
	// 			$return_data = $this->group_by_order($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/excel/v_order', $return_data);
	// 			break;
	// 		case "plg":
	// 			$return_data = $this->group_by_pelanggan($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/excel/v_pelanggan', $return_data);
	// 			break;
	// 		case "trx":
	// 			$return_data = $this->group_by_transaksi($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/excel/v_transaksi', $return_data);
	// 			break;
	// 		case "menu":
	// 			$return_data = $this->group_by_menu($data_input);
	// 			$return_data['payment'] = $this->M_crud->read("tbl_payment");
	// 			$this->load->view('pos/laporan/excel/v_menu', $return_data);
	// 			break;
	// 		default:
	// 			$this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Unknown Error.</div>');
	// 			$this->index();
	// 	}
	// }

	// public function group_by_order($data)
	// {
	// 	$data['data'] = $this->M_laporan->get_laporan_order_outlet($data);
	// 	return $data;
	// }

	// public function group_by_menu($data)
	// {
	// }

	// public function group_by_pelanggan($data)
	// {
	// 	$data['data'] = $this->M_laporan->get_laporan_pelanggan_outlet($data);
	// 	$data['rinci'] = $this->M_laporan->get_laporan_transaksi_outlet($data);
	// 	return $data;
	// }

	// public function group_by_transaksi($data)
	// {
	// 	$data['data'] = $this->M_laporan->get_laporan_outlet($data);
	// 	$data['rinci'] = $this->M_laporan->get_laporan_transaksi_outlet($data);
	// 	return $data;
	// }
}
