<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			$url = base_url('login');
			redirect($url);
		};
	}

	function index()
	{
		echo json_encode($this->load->view('admin/sistem/v_about','' , TRUE));
	}
}