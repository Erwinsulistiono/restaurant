<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();

        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url('login');
            redirect($url);
        }
        $this->load->model('M_dashboard');
        $this->load->model('M_crud');
    }

    public function index()
    {
        $id = $this->session->userdata('pengguna_id');
        $outlet = $this->session->userdata('pengguna_outlet');
        $data['user'] = $this->M_crud->select('tbl_pengguna', 'pengguna_id', $id);
        $data['title'] = 'Home';

        $data['penjualan_tot'] = $this->M_dashboard->getTotalPenjualan($outlet);
        $data['penjualan_now'] = $this->M_dashboard->getTotalPenjualanThisMonth($outlet);
        $data['porsi_tot'] = $this->M_dashboard->getTotalPorsi($outlet);
        $data['porsi_now'] = $this->M_dashboard->getTotalPorsiThisMonth($outlet);
        $data['sidebar'] = $this->M_crud->select('tbl_level_pos', 'level_id', $this->session->userdata('pengguna_level'));
        $data['landing_page'] = 'pos/v_dashboard';

        $this->render('layouts/v_main_pos', $data);
    }
}
