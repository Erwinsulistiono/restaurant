<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') != TRUE) {
            redirect(base_url('login'));
        };
        $this->load->model('M_pos');
        $this->load->model('M_crud');
        $this->outlet = $this->session->userdata('pengguna_outlet');
        $this->user = $this->session->userdata('pengguna_username');
    }

    public function index()
    {
        $this->display_pos();
    }

    public function proses_kitchen()
    {
        $inputedData = json_decode(file_get_contents('php://input'), true);
        if (!isset($inputedData)) {
            $this->display_pos();
        }

        $pelanggan = $this->prosesPelanggan($inputedData['cust']); //Proses Pelanggan
        (isset($pelanggan['plg_meja'])) && ($this->tandaiMejaTerpakai($pelanggan)); //Menandai meja dengan ID pelanggan yang duduk
        $trxReffId = $this->createTrxHeader($pelanggan, $inputedData); //Buat Trx Header
        $this->createOrder($trxReffId, $inputedData); //Buat Orderan Baru

        $this->M_crud->update('tbl_pelanggan', ['plg_order' => $trxReffId], 'plg_id', $pelanggan['plg_id']); //Update OrderId Pelanggan
        // $this->M_crud->delete('cust_order_' . $this->outlet, 'order_userid', $pelanggan['plg_id']); //Hapus Pesanan Pelanggan pada temporary order
        $this->display_pos();
    }

    function createOrder($reffId, $input)
    {
        foreach ($input['cart'] as $item) {
            if ($item['isNewOrder'] == 'true') {
                $dataOrder[] = [
                    'order_trx_reff' => $reffId,
                    'order_menu' => $item['name'],
                    'order_qty' => $item['count'],
                    'order_harga' => $item['price'],
                    'order_subtotal' => $item['count'] * $item['price'],
                    'order_notes' => $item['notes'],
                    'order_date' => date('Y-m-d H:i:s'),
                    'order_userid' => $this->user,
                ];
                foreach ($item['recipe'] as $recipe) {
                    $this->M_pos->updateStock($this->outlet, $recipe['id'], $recipe['val']);
                }
            }
        }
        $this->M_pos->insertBulkOrder($dataOrder, $this->outlet);
    }

    function createTrxHeader($pelanggan, $input)
    {
        (isset($pelanggan['plg_notelp'])) ? $trxUniqueIdentifier = $pelanggan['plg_nama'] : '';
        $tipe_trx = $this->M_crud->select('tbl_tipe_transaksi', 'tipe_transaksi_id', $input['cust']['trxTipe']['id']);

        if ($input['cust']['trxTipe']['id'] == 1) {
            $trxUniqueIdentifier = $input['cust']['trxTipeIdentifier']['nama'];
        }
        if ($input['cust']['trxTipe']['id'] == 3) {
            $trxUniqueIdentifier = $pelanggan['plg_platno'];
        }
        if ($input['cust']['trxTipe']['id'] == 4) {
            $trxUniqueIdentifier = $pelanggan['plg_alamat'];
        }
        $trx_nama = $tipe_trx['tipe_transaksi_nama'] . ' - ' . $trxUniqueIdentifier;
        $trx_notes = (isset($input['payment']['trx_notes'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_notes']) : '';
        $trx_cardno = (isset($input['payment']['trx_cardno'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_cardno']) : '';
        $trx_change = (isset($input['payment']['trx_change'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_change']) : '';
        $trx_nomor = (isset($input['payment']['trx_nomor'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_nomor']) : '';
        $trx_paid = (isset($input['payment']['trx_paid'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_paid']) : '';
        $trx_payment = (isset($input['payment']['trx_payment'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_payment']) : '';
        $trx_payreff = (isset($input['payment']['trx_payreff'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_payreff']) : '';

        $dataTrx = array(
            'trx_table' => $trx_nama,
            'trx_cust' => $pelanggan['plg_nama'],
            'trx_date' => date('Y-m-d H:i:s'),
            'trx_userid' => $this->user,
            'trx_subtotal' => $input['subTotal'],
            'trx_discount' => $input['discount']['discount'],
            'trx_tax_ppn' => $input['totalPph'],
            'trx_tax_service' => $input['totalService'],
            'trx_grand_total' => $input['grandTotal'],
            'trx_tipe' => $input['cust']['trxTipe']['id'],
            'trx_notes' => $trx_notes,
            'trx_cardno' => $trx_cardno,
            'trx_change' => $trx_change,
            'trx_nomor' => $trx_nomor,
            'trx_paid' => $trx_paid,
            'trx_payment' => $trx_payment,
            'trx_payreff' => $trx_payreff,
        );

        if ((int)$pelanggan['plg_order'] == 0) {
            $this->M_crud->insert('tbl_trx_pos_' . $this->outlet, $dataTrx);
            $reff_id = $this->db->insert_id();
        } else {
            $reff_id = $pelanggan['plg_order'];
            $this->M_crud->update('tbl_trx_pos_' . $this->outlet, $dataTrx, 'trx_id', $reff_id);
        }

        return $reff_id;
    }

    function prosesPelanggan($data)
    {
        $check_pelanggan = $this->M_crud->select('tbl_pelanggan', 'plg_id', $data['cust']['id']);
        $dataPelanggan = [
            'plg_nama' => (isset($data['cust']['nama'])) ? $data['cust']['nama'] : '',
            'plg_meja' => ($data['trxTipe']['id'] == 1) ? ($data['trxTipeIdentifier']['id']) : '',
            'plg_platno' => ($data['trxTipe']['id'] == 3) ? ($data['trxTipeIdentifier']['platno']) : '',
            'plg_notelp' => (isset($data['trxTipeIdentifier']['notelp'])) ? ($data['trxTipeIdentifier']['notelp']) : '',
            'plg_alamat' => ($data['trxTipe']['id'] == 4) ? ($data['trxTipeIdentifier']['alamat']) : '',
        ];

        if ($check_pelanggan) { //Check Pelanggan Sudah ada di Table
            $this->M_crud->update('tbl_meja_' . $this->outlet, array('meja_pelanggan' => $data['cust']['id']), 'meja_id', $data['trxTipeIdentifier']['id']);
            $this->M_crud->update('tbl_pelanggan', $dataPelanggan, 'plg_id', $data['cust']['id']);
            return $check_pelanggan;
        }
        //Jika Tidak Buat Pelanggan Baru
        $this->M_crud->insert('tbl_pelanggan', $dataPelanggan);
        $plg_id = $this->db->insert_id();
        return $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
    }

    function tandaiMejaTerpakai($pelanggan)
    {
        $updateDataMeja['meja_pelanggan'] = $pelanggan['plg_id'];
        $mejaId = $pelanggan['plg_meja'];
        $this->M_crud->update('tbl_meja_' . $this->outlet, $updateDataMeja, 'meja_id', $mejaId);
    }

    function display_pos()
    {
        $data = [
            'tipe_transaksi' => $this->M_crud->read('tbl_tipe_transaksi'),
            'kategori_all' => $this->M_crud->read('tbl_kategori'),
            'kategori_makanan' => $this->M_crud->left_join('tbl_menu_kat', 'tbl_menu_' . $this->outlet, 'tbl_menu_kat.menu_id=tbl_menu_' . $this->outlet . '.menu_id'),
            'makanan' => $this->M_crud->read('tbl_menu_' . $this->outlet),
            'table_all' => $this->M_crud->left_join('tbl_meja_' . $this->outlet, 'tbl_area', 'tbl_meja_' . $this->outlet . '.meja_lokasi=tbl_area.area_id'),
            'payment' => $this->M_crud->read('tbl_payment'),
            'customer' => $this->M_crud->read('tbl_pelanggan'),
            'customerHadOrder' => $this->M_pos->customerHadOrder(),
            'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
            'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
            'mobile_order' => $this->M_crud->read('cust_order_' . $this->outlet),
            'trx_all' => $this->M_crud->read('tbl_trx_pos_' . $this->outlet),
            'order_all' => $this->M_crud->left_join('tbl_order_' . $this->outlet, 'tbl_trx_pos_' . $this->outlet, 'tbl_order_' . $this->outlet . '.order_trx_reff=tbl_trx_pos_' . $this->outlet . '.trx_id'),
            'last_inv_number' => $this->M_pos->getLastAutoIncrementId($this->outlet),
            'inventory' => $this->M_crud->read('tbl_stock_' . $this->outlet),
            'ingredient' => $this->M_pos->getIngredientAll($this->outlet),
        ];
        echo json_encode($this->load->view('pos/pos/v_pos', $data, TRUE));
    }
}
