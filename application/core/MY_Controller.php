<?php
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_crud');
	}

	function render($view, $data = null)
	{
		$title['title'] = 'Mi Resto';
		if ($this->session->userdata('pengguna_dashboard') == 1) {
			$sidebar['data'] = $this->M_crud->select('tbl_level_admin', 'level_id', $this->session->userdata('pengguna_level'));
			$this->load->view('layouts/v_head', $title);
			$this->load->view('layouts/v_header');
			$this->load->view($view, $data);
			$this->load->view('layouts/v_sidebar', $sidebar);
			$this->load->view('layouts/v_footer');
		}
		if ($this->session->userdata('pengguna_dashboard') == 2) {
			$this->load->view($view, $data);
		}
		if (!$this->session->userdata('pengguna_dashboard')) {
			$this->load->view('layouts/v_head', $title);
			$this->load->view($view, $data);
			$this->load->view('layouts/v_footer');
		}
	}
}
