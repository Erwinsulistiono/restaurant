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
        $this->load->view('layouts/v_head');
        $this->load->view('v_mobile', $data);
        $this->load->view('layouts/v_footer');
    }

    public function register($outlet)
    {
        $data['data'] = $this->M_crud->left_join('tbl_meja_' . $outlet, 'tbl_area', 'tbl_meja_' . $outlet . '.meja_lokasi=tbl_area.area_id');
        $data['outlet'] = $outlet;
        $data['method_of_order'] = $this->M_crud->read('tbl_tipe_transaksi');
        $this->load->view('layouts/v_head');
        $this->load->view('mobile/v_register', $data);
        $this->load->view('layouts/v_footer');
    }

    public function auth($outlet)
    {
        $meja = $this->input->post('meja_pelanggan');
        $dataPelanggan = [
            'plg_nama' => strip_tags(str_replace("'", "", $this->input->post('plg_nama'))),
            'plg_notelp' => $this->input->post('plg_notelp'),
            'plg_whatsapp' => $this->input->post('plg_notelp'),
            'plg_email' => $this->input->post('plg_email'),
            'plg_platno' => $this->input->post('plg_platno'),
            'plg_alamat' => $this->input->post('plg_alamat'),
            'plg_login_flg' => 'Y',
        ];
        $this->M_crud->insert('tbl_pelanggan', $dataPelanggan);
        $plg_id = $this->db->insert_id();
        $cadmin = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
        if ($cadmin) {
            $sesdata = array(
                'masuk' => true,
                'idadmin' => $cadmin['plg_id'],
                'user_nama' => $cadmin['plg_nama'],
                'pelanggan_username' => $cadmin['plg_nama'],
                'pelanggan_nohp' => $cadmin['plg_notelp'],
                'pelanggan_email' => $cadmin['plg_email'],
                'tipe_transaksi' => $this->input->post('tipe_transaksi'),
                'plg_meja' => $meja,
                'pelanggan_outlet' => $outlet,
            );
            $this->session->set_userdata($sesdata);
            redirect('mobile/pos/pilih_meja/' . $meja . '/' . $cadmin['plg_id'] . '/' . md5($cadmin['user_nama']) . '/' . $cadmin['plg_id']);
        }
    }
}
