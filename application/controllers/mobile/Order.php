<?php
class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_crud');
        $this->load->model('M_mobile');
    }

    public function register($outlet, $tipe_order = null)
    {
        if ($tipe_order == 'meja') {
            $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
            parse_str($query, $params);
            ($params) && $meja_id = $params['id'];
            ($params) && $data['trx_id'] = 1;
            ($params) && $data['meja_id'] = $meja_id;
        } else if ($tipe_order == 'mobil') {
            $data['trx_id'] = 3;
        } else if ($tipe_order == 'take_away') {
            $data['trx_id'] = 2;
        }

        $data['data'] = $this->M_crud->left_join("tbl_meja_$outlet", 'tbl_area', "tbl_meja_$outlet.meja_lokasi=tbl_area.area_id");
        $data['outlet'] = $this->M_crud->select('tbl_outlet', 'out_id', $outlet);
        $data['method_of_order'] = $this->M_crud->read('tbl_tipe_transaksi');
        $this->load->view('mobile/v_daftar', $data);
    }

    public function view_order($outlet, $dataPost = null, $plg_id = null)
    {
        $authPelanggan = md5($plg_id . '-' . $outlet);
        if ($authPelanggan == $dataPost) {
            $this->order_detail($outlet, $plg_id);
        } else {
            $data['data'] = $this->M_crud->left_join("tbl_meja_$outlet", 'tbl_area', "tbl_meja_$outlet.meja_lokasi=tbl_area.area_id");
            $data['outlet'] = $outlet;
            $data['authPelanggan'] = $authPelanggan;
            $data['dataPost'] = $dataPost;
            $data['method_of_order'] = $this->M_crud->read('tbl_tipe_transaksi');
            $this->load->view('mobile/v_cek_order', $data);
        }
    }

    public function order_detail($outlet = null, $plg_id = null)
    {
        if ($plg_id) {
            $trx_id = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id)['plg_order'];
        } else {
            $data['tipe_transaksi'] = $this->input->post('tipe_transaksi');
            $data['plg_notelp'] = $this->input->post('plg_notelp');
            $data['plg_platno'] = $this->input->post('plg_platno');
            $data['plg_meja'] = $this->input->post('meja_pelanggan');
            $data['plg_nama'] = $this->input->post('plg_nama');
            $trx_id = $this->get_existing_customer_id($data, $outlet);
        }

        if (!$trx_id) {
            return ($this->load->view('mobile/v_belum_order'));
        }

        $data['order_pelanggan'] = $this->get_data_order_by_trx_id($outlet, $trx_id);
        $data['trx_pelanggan'] = $this->M_crud->select("tbl_trx_pos_$outlet", "trx_id", $trx_id);

        return ($this->load->view('mobile/v_sudah_order', $data));
    }

    public function is_user_session_valid()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user_session_valid = $this->M_mobile->check_session_pelanggan($data['plg_id']);
        echo json_encode(($user_session_valid) ? true : false);
    }


    //METHOD HELPER DARI EXTRACTION DAN REFACTORING
    public function get_data_order_by_trx_id($outlet, $plg_id)
    {
        $order = $this->M_mobile->get_pelanggan_order($outlet, $plg_id);
        if ($order) {
            return $order;
        }

        return false;
    }

    public function get_existing_customer_id($data)
    {
        switch ($data['tipe_transaksi']) {
            case '1':
                $plg = $this->M_mobile->get_customer_by_name($data['plg_nama'], $data['plg_meja']);
                ($plg) ? $plg_id = ($plg)['plg_order'] : $plg_id = false;
                break;
            case '2':
                $plg = $this->M_crud->select('tbl_pelanggan', 'plg_notelp', $data['plg_notelp']);
                ($plg) ? $plg_id = ($plg)['plg_order'] : $plg_id = false;
                break;
            case '3':
                $plg = $this->M_crud->select('tbl_pelanggan', 'plg_platno', $data['plg_platno']);
                ($plg) ? $plg_id = ($plg)['plg_order'] : $plg_id = false;
                break;
            case '4':
                $plg = $this->M_crud->select('tbl_pelanggan', 'plg_notelp', $data['plg_notelp']);
                ($plg) ? $plg_id = ($plg)['plg_order'] : $plg_id = false;
                break;
            default:
                $plg_id = false;
        }

        return $plg_id;
    }
}
