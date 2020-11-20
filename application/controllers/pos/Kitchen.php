<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kitchen extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
		$this->load->model('M_kitchen');
		$this->outlet = $this->session->userdata('pengguna_outlet');
	}

	public function getDataTrx()
	{
		$data = [
			'table' => $this->M_kitchen->getOrder($this->outlet),
			'order' => $this->M_crud->read('tbl_order_' . $this->outlet),
		];
		echo json_encode($data);
	}

	public function index()
	{
		echo json_encode($this->load->view('pos/kitchen/v_kitchen','',TRUE));
	}

	public function end_proses_kitchen()
	{
		$groupOrder = $this->input->post('groupOrder');
		$groupId = $this->input->post('groupId');
		$this->M_kitchen->updateFlgKitchen($this->outlet, $groupOrder, $groupId);
	}
}