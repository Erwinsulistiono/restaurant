<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
		$this->load->model('M_crud');
	}

	function index()
	{
		$data['data'] = $this->M_crud->read('tbl_log');
		$this->render('admin/sistem/v_log', $data);
	}
}