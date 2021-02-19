<?php
class Order extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_crud');
    }

    public function index()
    {
        $data['galeri'] = $this->M_crud->read('tbl_galeri');
        $this->render_mobile('v_dashboard', $data);
    }

    public function outlet()
    {
        $data['outlet'] = $this->M_crud->read('tbl_outlet');
        $this->render_mobile('mobile/v_pilih_outlet', $data);
    }
}
