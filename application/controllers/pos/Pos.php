<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url('login');
      redirect($url);
    };
    $this->load->model('M_pos');
    $this->load->model('M_crud');
    $this->load->model('M_stock');
    $this->load->model('M_kitchen');
    $this->outlet = $this->session->userdata('pengguna_outlet');
    $this->user = $this->session->userdata('pengguna_username');
  }


  public function index()
  {
    $this->display_pos();
  }

  function prosesPelanggan($data)
  {
    if (isset($data['cust']['plg_id'])) {
      $check_pelanggan = $this->M_crud->select('tbl_pelanggan', 'plg_id', $data['cust']['plg_id']);
    }

    $dataPelanggan = [
      'plg_nama' => (isset($data['cust']['nama'])) ? $data['cust']['nama'] : '',
      'plg_meja' => ($data['trxTipe']['id'] == 1) ? ($data['cust']['meja']) : '',
      'plg_platno' => ($data['trxTipe']['id'] == 3) ? ($data['cust']['platno']) : '',
      'plg_notelp' => (isset($data['cust']['telp'])) ? ($data['cust']['telp']) : '',
      'plg_alamat' => ($data['trxTipe']['id'] == 4) ? ($data['trxTipeIdentifier']['alamat']) : '',
    ];

    if (isset($check_pelanggan)) { //Check Pelanggan Sudah ada di Table
      $this->M_crud->update('tbl_meja_' . $this->outlet, array('meja_pelanggan' => $data['cust']['id']), 'meja_id', $data['cust']['meja']);
      $this->M_crud->update('tbl_pelanggan', $dataPelanggan, 'plg_id', $data['cust']['id']);
      return $check_pelanggan;
    }
    //Jika Tidak Buat Pelanggan Baru
    $this->M_crud->insert('tbl_pelanggan', $dataPelanggan);
    $plg_id = $this->db->insert_id();

    return $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);
  }

  function create_lap_order($reffId, $cart)
  {
    foreach ($cart as $item) {
      $orders[] = [
        'order_trx_reff' => $reffId,
        'order_menu' => $item['name'],
        'order_qty' => $item['count'],
        'order_harga' => $item['price'],
        'order_subtotal' => $item['count'] * $item['price'],
        'order_notes' => isset($item['notes']) ? $item['notes'] : '',
        'order_date' => date('Y-m-d H:i:s'),
        'order_userid' => $this->user,
      ];
    }

    $this->M_pos->simpan_laporan_order($orders, $this->outlet);
  }


  function create_order($reffId, $cart)
  {
    foreach ($cart as $item) {
      if ($item['isNewOrder'] == 'true') {
        $orders[] = [
          'order_trx_reff' => $reffId,
          'order_menu' => $item['id'],
          'order_qty' => $item['count'],
          'order_harga' => $item['price'],
          'order_subtotal' => $item['count'] * $item['price'],
          'order_notes' => isset($item['notes']) ? $item['notes'] : '',
          'order_date' => date('Y-m-d H:i:s'),
          'order_userid' => $this->user,
        ];
        foreach ($item['recipe'] as $recipe) {
          $this->M_pos->updateStock($this->outlet, $recipe['id'], $recipe['val']);
        }
      }
    }

    $this->M_pos->simpan_order($orders, $this->outlet);
  }


  function update_stock($cart)
  {
    foreach ($cart as $item) {
      foreach ($item['recipe'] as $recipe) {
        $this->M_pos->updateStock($this->outlet, $recipe['id'], $recipe['val']);
      }
    }
  }


  function createTrxHeader($pelanggan, $input)
  {
    $tipe_trx = $this->M_crud->select('tbl_tipe_transaksi', 'tipe_transaksi_id', $input['cust']['trxTipe']['id']);
    $trx_nama = $tipe_trx['tipe_transaksi_nama'];

    if ($tipe_trx['tipe_transaksi_id'] == '1') {
      $meja = $input['cust']['cust']['meja_text'];
      $trx_nama = "$tipe_trx[tipe_transaksi_nama] - $meja";
    }

    $trx_notes = (isset($input['payment']['trx_notes'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_notes']) : '';
    $trx_cardno = (isset($input['payment']['trx_cardno'])) ? $input['payment']['trx_cardno'] : '';
    $trx_change = (isset($input['payment']['trx_change'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_change']) : '';
    $trx_nomor = (isset($input['payment']['trx_nomor'])) ? $input['payment']['trx_nomor'] : '';
    $trx_paid = (isset($input['payment']['trx_paid'])) ? preg_replace('/[^0-9]/', '', $input['payment']['trx_paid']) : '';
    $trx_payment = (isset($input['payment']['trx_payment'])) ? $input['payment']['trx_payment'] : '';
    $trx_payreff = (isset($input['payment']['trx_payreff'])) ? $input['payment']['trx_payreff'] : '';

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
      'trx_notes' => $trx_notes,
      'trx_payment' => $trx_payment,
      'trx_paid' => $trx_paid,
      'trx_change' => $trx_change,
      'trx_payreff' => $trx_payreff,
      'trx_cardno' => $trx_cardno,
      'trx_nomor' => $trx_nomor,
      'trx_tipe' => $input['cust']['trxTipe']['id'],
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


  function tandaiMejaTerpakai($pelanggan)
  {
    $updateDataMeja['meja_pelanggan'] = $pelanggan['plg_id'];
    $mejaId = $pelanggan['plg_meja'];
    $this->M_crud->update('tbl_meja_' . $this->outlet, $updateDataMeja, 'meja_id', $mejaId);
  }


  public function display_pos()
  {
    $data = [
      'tipe_transaksi' => $this->M_crud->read('tbl_tipe_transaksi'),
      'kategori_all' => $this->M_crud->read('tbl_kategori'),
      'kategori_makanan' => $this->M_crud->left_join('tbl_menu_kat', 'tbl_menu_' . $this->outlet, 'tbl_menu_kat.menu_id=tbl_menu_' . $this->outlet . '.menu_id'),
      'makanan' => $this->M_crud->read('tbl_menu_' . $this->outlet),
      'table_all' => $this->M_crud->left_join("tbl_meja_$this->outlet", 'tbl_area', "tbl_meja_$this->outlet.meja_lokasi=tbl_area.area_id"),
      'payment' => $this->M_crud->read('tbl_payment'),
      'customer' => $this->M_crud->read('tbl_pelanggan'),
      'plg_sudah_order' => $this->M_pos->plg_sudah_order(),
      'taxresto' => $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'],
      'taxservice' => $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'],
      'mobile_order' => $this->M_crud->read("cust_order_$this->outlet"),
      'trx_all' => $this->M_crud->read("tbl_trx_pos_$this->outlet"),
      'order_all' => $this->M_kitchen->get_order($this->outlet),
      'last_inv_number' => $this->M_pos->getLastAutoIncrementId($this->outlet),
      'inventory' => $this->M_crud->read('tbl_stock_' . $this->outlet),
      'ingredient' => $this->M_pos->get_semua_ingredient($this->outlet),
    ];

    $this->render('pos/pos/v_pos', $data, true);
  }

  public function proses_kitchen()
  {
    $inputedData = json_decode(file_get_contents('php://input'), true);
    if (!isset($inputedData)) {
      echo json_encode(["msg" => "tidak Terproses ke Dapur"]);
    }

    $pelanggan = $this->prosesPelanggan($inputedData['cust']); //Proses Pelanggan
    (isset($pelanggan['plg_meja'])) && ($this->tandaiMejaTerpakai($pelanggan)); //Menandai meja dengan ID pelanggan yang duduk
    $trxReffId = $this->createTrxHeader($pelanggan, $inputedData); //Buat Trx Header

    $this->create_order($trxReffId, $inputedData['cart']); //Buat Orderan Baru
    $this->M_crud->update('tbl_pelanggan', ['plg_order' => $trxReffId], 'plg_id', $pelanggan['plg_id']); //Update OrderId Pelanggan

    echo json_encode(["msg" => "Terproses ke Dapur"]);
  }

  public function proses_pembayaran()
  {
    $inputedData = json_decode(file_get_contents('php://input'), true);
    if (!isset($inputedData)) {
      echo json_encode(["msg" => "tidak Terjadi Proses Pembayaran"]);
    }

    $tipe_trx = $this->M_crud->select('tbl_tipe_transaksi', 'tipe_transaksi_id', $inputedData['cust']['trxTipe']['id']);

    $trx_nama = $tipe_trx['tipe_transaksi_nama'];
    $trx_notes = (isset($inputedData['payment']['trx_notes'])) ? $inputedData['payment']['trx_notes'] : '';
    $trx_cardno = (isset($inputedData['payment']['trx_cardno'])) ? $inputedData['payment']['trx_cardno'] : '';
    $trx_change = (isset($inputedData['payment']['trx_change'])) ? preg_replace('/[^0-9]/', '', $inputedData['payment']['trx_change']) : '';
    $trx_nomor = (isset($inputedData['payment']['trx_nomor'])) ? $inputedData['payment']['trx_nomor'] : '';
    $trx_paid = (isset($inputedData['payment']['trx_paid'])) ? preg_replace('/[^0-9]/', '', $inputedData['payment']['trx_paid']) : '';
    $trx_payment = (isset($inputedData['payment']['trx_payment'])) ? $inputedData['payment']['trx_payment'] : '';
    $trx_payreff = (isset($inputedData['payment']['trx_payreff'])) ? $inputedData['payment']['trx_payreff'] : '';

    $dataTrx = array(
      'trx_table' => $trx_nama,
      'trx_cust' => $inputedData['cust']['cust']['nama'],
      'trx_date' => date('Y-m-d H:i:s'),
      'trx_userid' => $this->user,
      'trx_subtotal' => $inputedData['subTotal'],
      'trx_discount' => $inputedData['discount']['discount'],
      'trx_tax_ppn' => $inputedData['totalPph'],
      'trx_tax_service' => $inputedData['totalService'],
      'trx_grand_total' => $inputedData['grandTotal'],
      'trx_notes' => $trx_notes,
      'trx_payment' => $trx_payment,
      'trx_paid' => $trx_paid,
      'trx_change' => $trx_change,
      'trx_payreff' => $trx_payreff,
      'trx_cardno' => $trx_cardno,
      'trx_nomor' => $trx_nomor,
      'trx_tipe' => $inputedData['cust']['trxTipe']['id'],
    );

    $this->M_crud->insert('tbl_lap_trx_' . $this->outlet, $dataTrx);
    $reff_id = $this->db->insert_id();
    $this->create_lap_order($reff_id, $inputedData['cart']);
    echo json_encode(["msg" => "Pembayaran Berhasil"]);
  }


  public function check_out($trx_id)
  {
    $plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_order', $trx_id)['plg_id'];
    $id_voucher = $this->input->post('voucher_id');
    $discount_nominal = $this->input->post('discount_nominal');
    (($id_voucher) && $this->diskon_transaksi_by_voucher($id_voucher, $trx_id));
    (($discount_nominal && !$id_voucher) && $this->diskon_transaksi_by_input($discount_nominal, $trx_id));
    $data_trx = $this->M_crud->select("tbl_trx_pos_$this->outlet", 'trx_id', $trx_id);

    $data_trx['trx_notes'] = $this->input->post('trx_notes');
    $data_trx['trx_payment'] = $this->input->post('trx_payment');
    $data_trx['trx_paid'] = intval(preg_replace('/[^0-9]/', '', $this->input->post('trx_paid')));
    $data_trx['trx_change'] = intval(preg_replace('/[^0-9]/', '', $this->input->post('trx_change')));
    $data_trx['trx_nomor'] = $this->input->post('trx_nomor');
    $data_trx['trx_cardno'] = $this->input->post('trx_cardno');
    $data_trx['trx_payreff'] = $this->input->post('trx_payreff');
    unset($data_trx['trx_id']);
    unset($data_trx['trx_cancel_flg']);
    unset($data_trx['trx_cancel_waitress_flg']);
    unset($data_trx['trx_cancel_kitchen_flg']);
    unset($data_trx['trx_waitress_flg']);
    unset($data_trx['trx_kitchen_flg']);

    $data_tbl['meja_pelanggan'] = '0';
    $data_plg['plg_order'] = '0';

    $data_order = $this->M_pos->select_order($trx_id, $this->outlet);

    //clearing all flag and save transaction data
    $this->M_crud->insert("tbl_lap_trx_$this->outlet", $data_trx);
    $order_trx_reff = $this->db->insert_id();
    $this->M_crud->update("tbl_trx_pos_$this->outlet", $data_trx, 'trx_id', $trx_id);

    $this->printPaid($trx_id);

    foreach ($data_order as $items) {
      (($items['order_waitress_flg'] == 'Y') &&
        $this->M_crud->delete("tbl_order_$this->outlet", 'order_id', $items['order_id']));

      $items['order_trx_reff'] = $order_trx_reff;
      $items['order_menu'] = $items['menu_nama'];
      unset($items['order_kitchen_flg']);
      unset($items['order_waitress_flg']);
      unset($items['order_cancel_flg']);
      unset($items['order_id']);
      unset($items['menu_id']);
      unset($items['menu_reff_id']);
      unset($items['menu_nama']);
      unset($items['menu_deskripsi']);
      unset($items['menu_harga_lama']);
      unset($items['menu_harga_baru']);
      unset($items['menu_gambar']);
      unset($items['menu_kitchen']);
      $this->M_crud->insert("tbl_lap_order_$this->outlet", $items);
    }

    if (is_null($this->M_crud->select("tbl_order_$this->outlet", 'order_trx_reff', $trx_id))) {
      $clear_table['meja_pelanggan'] = 0;
      $clear_pelanggan = [
        'plg_order' => '0',
        'plg_login_flg' => 'N',
      ];
      $this->M_crud->delete("tbl_trx_pos_$this->outlet", 'trx_id', $trx_id);
      $this->M_crud->update("tbl_meja_$this->outlet", $clear_table, 'meja_pelanggan', $plg_id);
      $this->M_crud->update('tbl_pelanggan', $clear_pelanggan, 'plg_id', $plg_id);
      if ($this->M_crud->select("cust_order_$this->outlet", 'order_userid', $plg_id)) {
        $this->M_crud->delete("cust_order_$this->outlet", 'order_userid', $plg_id);
      }
    };
  }


  public function clear_order()
  {
    $trx_id = $this->input->post('trx_id');
    $plg_id = $this->M_crud->select('tbl_pelanggan', 'plg_order', $trx_id)['plg_id'];
    $payment = $this->M_crud->select("tbl_trx_pos_$this->outlet", 'trx_id', $trx_id);
    if ($payment['trx_paid']) {
      $this->M_crud->delete("tbl_trx_pos_$this->outlet", 'trx_id', $trx_id);
      $this->M_crud->delete("tbl_order_$this->outlet", 'order_trx_reff', $trx_id);
      $this->M_crud->update("tbl_meja_$this->outlet", array('meja_pelanggan' => 0), 'meja_pelanggan', $plg_id);
      $this->M_crud->update('tbl_pelanggan', ['plg_order' => 0, 'plg_login_flg' => 'N'], 'plg_id', $plg_id);
      echo json_encode(array('type' => 'success', 'message' => 'Pesanan telah selesai'));
    } else {
      echo json_encode(array('type' => 'error', 'message' => 'Belum Melakukan Pembayaran'));
      // die($output);
    }
  }


  public function diskon_transaksi_by_input($discount_nominal, $trx_id)
  {
    $data_trx = $this->M_crud->select("tbl_trx_pos_$this->outlet", 'trx_id', $trx_id);
    $data = [
      'trx_discount' => $discount_nominal,
      'trx_grand_total' => ($data_trx['trx_grand_total']) - $discount_nominal,
    ];
    $this->M_crud->update("tbl_trx_pos_$this->outlet", $data, 'trx_id', $trx_id);
    return;
  }


  public function diskon_transaksi_by_voucher($id_voucher, $trx_id)
  {
    $this->M_pos->potongQtyVoucher($id_voucher);
    $voucher = $this->M_crud->select('tbl_voucher', 'voucher_id', $id_voucher);
    $data_trx = $this->M_crud->select("tbl_trx_pos_$this->outlet", 'trx_id', $trx_id);
    $nominal = $voucher['voucher_nominal'];
    $percentage = $voucher['voucher_discount'];

    if ($nominal > 0) {
      $discount = $nominal;
    }
    if ($percentage > 0) {
      $discount = ($data_trx['trx_subtotal'] * ($percentage / 100));
    }
    $data = [
      'trx_discount' => $discount,
      'trx_grand_total' => ($data_trx['trx_grand_total']) - $discount,
    ];
    $this->M_crud->update("tbl_trx_pos_$this->outlet", $data, 'trx_id', $trx_id);
    return;
  }


  public function voucherApplied()
  {
    $id = $this->input->post('id');
    $data = $this->M_crud->select('tbl_voucher', 'voucher_id', $id);
    echo json_encode($data);
  }


  public function voucherTermsAndCondition()
  {
    $title = $this->input->post('kodeDiskon');
    $data = $this->M_pos->search_voucher($title);
    echo json_encode($data);
  }

  public function printPaid($order_trx_reff)
  {
    $data = [
      'trx_prop' => $this->M_pos->select_trx($this->outlet),
      'trx' => $this->M_crud->select("tbl_trx_pos_$this->outlet", 'trx_id', $order_trx_reff),
      'order' => $this->M_pos->select_order($order_trx_reff, $this->outlet),
      'outlet' => $this->M_crud->select('tbl_outlet', 'out_id', $this->outlet),
      'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
    ];
    $this->load->view('pos/pos/v_print_struk', $data);
  }

  public function printBill($plg_id, $discount = null)
  {
    $tbl_pelanggan = $this->M_crud->select('tbl_pelanggan', 'plg_id', $plg_id);

    $tbl_pelanggan['plg_alamat'] &&
      $attr_trx = array('trx_tipe_nama' => $tbl_pelanggan['plg_nama'], 'plg_id' => $tbl_pelanggan['plg_id'], 'trx_tipe' => 'Delivery', 'trx_tipe_id' => 4);
    $tbl_pelanggan['plg_platno'] &&
      $attr_trx = array('trx_tipe_nama' => $tbl_pelanggan['plg_platno'], 'plg_id' => $tbl_pelanggan['plg_id'], 'trx_tipe' => 'Car', 'trx_tipe_id' => 3);
    !($tbl_pelanggan['plg_platno'] && $tbl_pelanggan['plg_platno']) &&
      $attr_trx = array('trx_tipe_nama' => $tbl_pelanggan['plg_nama'], 'plg_id' => $tbl_pelanggan['plg_id'], 'trx_tipe' => 'Take Away', 'trx_tipe_id' => 2);
    $attr_trx['discount'] = $discount;
    $attr_trx['totalPph'] = $this->M_crud->select('tbl_tax', 'tax_id', '2')['tax_persen'];
    $attr_trx['totalService'] = $this->M_crud->select('tbl_tax', 'tax_id', '1')['tax_persen'];

    $data = [
      'trx_prop' => $attr_trx,
      'order' => $this->cart->contents(),
      'outlet' => $this->M_crud->select('tbl_outlet', 'out_id', $this->outlet),
      'pt' => $this->M_crud->select('tbl_pt', 'pt_id', 1),
    ];
    $this->load->view('pos/pos/v_print_struk', $data);
  }

  public function getTransaksiMobile()
  {
    $data = [
      'mobile_app_order' => $this->M_crud->read("cust_order_$this->outlet"),
      'mobile_app_order_header' => $this->M_pos->get_customer_order_per_table($this->outlet),
    ];
    echo json_encode($data);
  }


  public function getAlerts()
  {
    $data = $this->M_pos->getMobileTrx($this->outlet);
    $notification = 0;
    foreach ($data as $d) {
      $notification++;
    }
    echo json_encode($notification);
  }


  public function batalkan_pemesanan_mobile($mobile_order_user)
  {
    $this->M_crud->delete("cust_order_$this->outlet", 'order_userid', $mobile_order_user);
    redirect('pos/pos');
  }


  public function status_order()
  {
    $this->render('pos/pos/v_status');
  }

  public function batalkan_transaksi($id)
  {
    $this->M_crud->update("tbl_trx_pos_$this->outlet", ['trx_cancel_flg' => 'Y'], 'trx_id', $id);
    echo json_encode("success");
  }

  public function clear_seat()
  {
    $id = $this->input->post('row_id');
    $this->M_crud->update("tbl_meja_$this->outlet", ['meja_pelanggan' => '0'], 'meja_id', $id);
    echo json_encode("success");
  }

  public function fetch_meja()
  {
    $meja = $this->M_pos->get_all_table($this->outlet);

    echo json_encode($meja);
  }

  public function fetch_all_transaksi_by_tipe($tipe_trx)
  {
    $trx = $this->M_pos->fetch_all_transaksi_by_tipe($this->outlet, $tipe_trx);

    echo json_encode($trx);
  }
}
