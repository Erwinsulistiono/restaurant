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


        $data['data'] = $this->M_crud->left_join('tbl_meja_' . $outlet, 'tbl_area', 'tbl_meja_' . $outlet . '.meja_lokasi=tbl_area.area_id');
        $data['outlet'] = $this->M_crud->select('tbl_outlet', 'out_id', $outlet);
        $data['method_of_order'] = $this->M_crud->read('tbl_tipe_transaksi');
        $this->load->view('mobile/v_register', $data);
    }

    public function view_order($outlet, $dataPost = null, $plg_id = null)
    {
        $authPelanggan = md5($plg_id . '-' . $outlet);
        if ($authPelanggan == $dataPost) {
            $this->order_detail($outlet, $plg_id);
        } else {
            $data['data'] = $this->M_crud->left_join('tbl_meja_' . $outlet, 'tbl_area', 'tbl_meja_' . $outlet . '.meja_lokasi=tbl_area.area_id');
            $data['outlet'] = $outlet;
            $data['authPelanggan'] = $authPelanggan;
            $data['dataPost'] = $dataPost;
            $data['method_of_order'] = $this->M_crud->read('tbl_tipe_transaksi');
            $this->load->view('mobile/v_cek_order', $data);
        }
    }

    public function order_detail($outlet = null, $plg_id = null)
    {
        ($plg_id) && $data['pending_payment'] = $this->M_mobile->cek_status_pending($outlet, $plg_id);
        if ($plg_id) {
            return ($this->load->view('mobile/v_order_detail', $data));
        }
        $data['tipe_transaksi'] = $this->input->post('tipe_transaksi');
        $data['plg_notelp'] = $this->input->post('plg_notelp');
        $data['plg_platno'] = $this->input->post('plg_platno');
        $data['plg_meja'] = $this->input->post('meja_pelanggan');
        $data['plg_nama'] = $this->input->post('plg_nama');

        $plg_id = $this->getCustIdFromTableUser($data, $outlet);
        if (!$plg_id) {
            return ($this->load->view('mobile/v_belum_order'));
        }

        $data['order_pelanggan'] = $this->getDataOrderByCustId($outlet, $plg_id);
        if (!$data['order_pelanggan']) {
            return ($this->load->view('mobile/v_belum_order'));
        }

        $this->load->view('mobile/v_order_detail', $data);
    }

    public function is_user_session_valid()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userSessionExist = $this->M_mobile->checkPelangganSession($data['plg_id']);
        echo json_encode(($userSessionExist) ? true : false);
    }


    //METHOD HELPER DARI EXTRACTION DAN REFACTORING
    public function getDataOrderByCustId($outlet, $plg_id)
    {
        $order = $this->M_mobile->cek_status_pending($outlet, $plg_id);
        if ($order) {
            return $order;
        }

        $order = $this->M_mobile->cek_status_approved($outlet, $plg_id);
        if ($order) {
            return $order;
        }

        return false;
    }

    public function getCustIdFromTableUser($data)
    {
        if ($data['tipe_transaksi'] == '1') {
            $plg_id = $this->M_mobile->getIdPelangganFromTableOrName($data['plg_nama'], $data['plg_meja']);
            return (($plg_id) ? ($plg_id)['plg_id'] : false);
        }
        if ($data['tipe_transaksi'] == '2') {
            $plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_notelp', $data['plg_notelp']);
            return (($plg_id) ? ($plg_id)['plg_id'] : false);
        }
        if ($data['tipe_transaksi'] == '3') {
            $plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_platno', $data['plg_platno']);
            return (($plg_id) ? ($plg_id)['plg_id'] : false);
        }
        if ($data['tipe_transaksi'] == '4') {
            $plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_notelp', $data['plg_notelp']);
            return (($plg_id) ? ($plg_id)['plg_id'] : false);
        }
        return false;
    }
}
