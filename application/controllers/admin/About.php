<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends MY_Controller
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
		$this->render('admin/sistem/v_about');
	}
}