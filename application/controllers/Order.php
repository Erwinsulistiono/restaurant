<?php
class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_login');
        $this->load->model('M_crud');
        $this->load->model('M_pos');
    }

    public function index()
    {
        $data['outlet'] = $this->M_crud->read('tbl_outlet');
        $this->load->view('v_mobile', $data);
    }

    public function outlet($outlet)
    {
        $data['outlet'] = $outlet;
        $data['galeri'] = $this->M_crud->read('tbl_galeri');
        $this->load->view('mobile/v_index', $data);
    }
}
