<?php
defined('BASEPATH') or exit('No direct script access allowed');

use phpDocumentor\Reflection\Types\Null_;

class Menu extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('masuk') != TRUE) {
      $url = base_url('login');
      redirect($url);
    };
    $this->load->model('M_crud');
    $this->load->model('M_menu');
    $this->load->model('M_log');
    $this->load->library('upload');
  }

  public function outlet($outlet = null)
  {
    is_null($outlet) ? $outlet_id = $this->input->post('outlet_id') : $outlet_id = $outlet;
    $data = [
      'outlet_id' => $outlet_id,
      'outlet' => $this->M_crud->read('tbl_outlet'),
      'kategori' => $this->M_crud->read('tbl_kategori'),
      'kategori_makanan' => $this->M_crud->left_join('tbl_menu_kat', 'tbl_kategori', 'tbl_menu_kat.kategori_id=tbl_kategori.kategori_id'),
      'kitchen' => ($outlet_id == 'master') ? '' : $this->M_crud->read("tbl_kitchen_${outlet_id}"),
      'data' => $this->M_crud->read("tbl_menu_${outlet_id}"),
      'inventory' => json_encode($this->M_crud->read("tbl_stock_${outlet_id}")),
      'satuan' => json_encode($this->M_crud->read('tbl_satuan')),
      'ingredient' => json_encode($this->M_menu->get_all_resep($outlet_id)),
    ];
    $this->render('admin/katalog/v_menu_outlet', $data);
  }

  /*----------------- MODUL MENU ---------------------*/
  public function index()
  {
    $data['outlet'] = $this->M_crud->read('tbl_outlet');
    $this->render('admin/katalog/v_menu', $data);
  }

  function simpan_menu($outlet_id)
  {
    $menu_id = $this->input->post('menu_id');
    $nmfile = "file_" . time() . '.jpg'; //nama file saya beri nama langsung dan diikuti fungsi time
    $config['upload_path'] = './assets/gambar/'; //path folder
    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
    $config['max_size'] = '1024'; //maksimum besar file 2M
    $config['max_width']  = '900'; //lebar maksimum 1288 px
    $config['max_height']  = '800'; //tinggi maksimu 1000 px
    $config['file_name'] = $nmfile; //nama yang terupload nantinya

    $this->upload->initialize($config);
    // $gbr = $this->upload->data();
    $this->load->library('upload', $config);

    if (empty($_FILES['filefoto']['name']) && !$menu_id) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu tidak dapat ditambahkan, file gambar yang Anda masukkan terlalu besar.</div>');
      redirect('admin/menu/outlet/' . $outlet_id);
    }
    if ($this->upload->do_upload('filefoto')) {
      $data['menu_gambar'] = $nmfile;
    }

    if (empty($_FILES['filefoto']['name'])) {
      $upload = $this->M_crud->select("tbl_menu_${outlet_id}", 'menu_id', $menu_id);
      $nmfile = $upload['menu_gambar'];
    }


    $data = [
      'menu_gambar' => $nmfile,
      'menu_nama' => $this->input->post('menu_nama'),
      'menu_deskripsi' => $this->input->post('menu_deskripsi'),
      'menu_harga_lama' => $this->input->post('menu_harga_lama'),
      'menu_harga_baru' => $this->input->post('menu_harga_baru'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$menu_id) {
      $this->M_crud->insert("tbl_menu_${outlet_id}", $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'MENU', null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['menu_nama'] . '</b> Berhasil disimpan ke database.</div>');
      $this->simpan_kategori($reff_id, $outlet_id);
      redirect('admin/menu/outlet/' . $outlet_id);
    }

    $data_old = $this->M_crud->select("tbl_menu_${outlet_id}", 'menu_id', $menu_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($menu_id, 'MENU', $log_oldval, $log_newval);
    $this->M_crud->update("tbl_menu_${outlet_id}", $data, 'menu_id', $menu_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['menu_nama'] . '</b> Berhasil disimpan ke database.</div>');
    $this->simpan_kategori($menu_id, $outlet_id);
    redirect('admin/menu/outlet/' . $outlet_id);
  }

  /*-------------------SIMPAN KITCHEN ----------------------------*/
  public function simpan_kitchen($outlet_id)
  {
    $kitchen_id = $this->input->post('menu_id');
    $data = [
      'menu_kitchen' => $this->input->post('menu_kitchen'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    $data_old = $this->M_crud->select("tbl_menu_${outlet_id}", 'menu_id', $kitchen_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));
    $this->M_log->simpan_log($kitchen_id, 'MENU', $log_oldval, $log_newval);

    $this->M_crud->update("tbl_menu_${outlet_id}", $data, 'menu_id', $kitchen_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['menu_nama'] . '</b> Berhasil disimpan ke database.</div>');
    redirect('admin/menu/outlet/' . $outlet_id);
  }


  /*----------------- MODUL KATEGORI TIAP MENU ---------------------*/
  public function simpan_kategori($menu_id, $outlet_id)
  {
    $data_old = $this->M_menu->get_kategori($outlet_id, $menu_id);
    $log_oldval = '';
    if ($data_old) {
      $i = 1;
      foreach ($data_old as $old) {
        $nama_kategori = $old['kategori_nama'];
        $log_oldval .= ("kategori ${i} : ${nama_kategori} | ");
        $i++;
      };
    }

    $this->M_crud->delete('tbl_menu_kat', 'menu_id', $menu_id);
    $kategori_id = array_filter($this->input->post('product'));
    foreach ($kategori_id as $kat) {
      $data = [
        'kategori_id' => $kat,
        'menu_id' => $menu_id,
      ];
      $this->M_crud->insert('tbl_menu_kat', $data);
    }

    $data_new = $this->M_menu->get_kategori($outlet_id, $menu_id);
    if ($data_new) {
      $log_newval = '';
      $i = 1;
      foreach ($data_new as $new) {
        $nama_kategori = $new['kategori_nama'];
        $log_newval .= ("kategori ${i} : ${nama_kategori} | ");
      };
    }
    $this->M_log->simpan_log($menu_id, 'KATEGORI PER MENU', $log_oldval, $log_newval);
  }

  public function hapus_menu($outlet_id, $menu_id)
  {
    $data_old = $this->M_crud->select("tbl_menu_${outlet_id}", 'menu_id', $menu_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($menu_id, 'MENU', $log_oldval);
    $this->M_crud->delete("tbl_menu_${outlet_id}", 'menu_id', $menu_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu Berhasil dihapus dari database.</div>');
    redirect('admin/menu/outlet/' . $outlet_id);
  }


  /*----------------- MODUL RESEP MENU ---------------------*/
  public function simpan_recipe($outlet_id, $menu_id)
  {
    $data_old = $this->M_menu->get_resep($outlet_id, $menu_id);
    $log_oldval = '';

    if ($data_old) {
      foreach ($data_old as $old) {
        $nama_stock = $old['stock_nama'];
        $qty_stock = $old['ing_qty'];
        $kode_satuan = $old['satuan_kode'];
        $log_oldval .= ("ingredient : ${nama_stock} Qty : ${qty_stock} Satuan : ${kode_satuan} | ");
      };
    }

    $this->M_crud->delete('tbl_ingredient', 'ing_menu_id', $menu_id);
    if ($this->input->post('post_inv_id')) {
      $arr =  array_filter($this->input->post('post_inv_id'));
      $i = 0;
      foreach ($arr as $row) {
        $data = [
          'ing_menu_id' => $menu_id,
          'ing_inv_id' => $this->input->post('post_inv_id')[$i],
          'ing_qty' => intval(preg_replace('/[^0-9]/', '', $this->input->post('post_qty')[$i])),
          'ing_satuan_id' => $this->input->post('post_satuan_id')[$i],
        ];
        $i++;
        $this->M_crud->insert('tbl_ingredient', $data);
      };
    }

    $data_new = $this->M_menu->get_resep($outlet_id, $menu_id);
    if ($data_new) {
      $log_newval = '';
      foreach ($data_new as $new) {
        $nama_stock = $new['stock_nama'];
        $qty_stock = $new['ing_qty'];
        $kode_satuan = $new['satuan_kode'];
        $log_newval .= ("ingredient : ${nama_stock} Qty :  ${qty_stock} Satuan : ${kode_satuan} | ");
      };
    }
    $this->M_log->simpan_log($menu_id, 'INGREDIENT MENU', $log_oldval, $log_newval);
    echo json_encode($data_new);
  }


  /*----------------- MODUL TRANSFER MENU KE OUTLET CABANG---------------------*/
  public function transfer_menu($menu_id)
  {
    $out_id = $this->input->post('outlet_tujuan');
    $outlet_tujuan = $this->M_crud->select('tbl_outlet', 'out_id', $out_id);
    $duplicate_menu = $this->M_crud->select("tbl_menu_${out_id}", 'menu_id', $menu_id);
    if ($duplicate_menu) {
      $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $duplicate_menu['menu_nama'] . ' </b>sudah ada di outlet <b>' . $outlet_tujuan['out_nama'] . '</b></div>');
      $this->outlet('master');
    };
    $data = $this->M_crud->select('tbl_menu_master', 'menu_id', $menu_id);
    $nama_menu = $data['menu_nama'];
    $nama_outlet_tujuan = $outlet_tujuan['out_nama'];
    $log = "menu = ${nama_menu} | Outlet tujuan = ${nama_outlet_tujuan} ";
    $data['menu_id'] = $menu_id;

    $this->M_crud->insert("tbl_menu_${out_id}", $data);
    $this->M_log->simpan_log($menu_id, 'TRANSFER MENU', $log, $log);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu ' . $data['menu_nama'] . ' Berhasil ditambah ke outlet tujuan.</div>');
    $this->outlet('master');
  }
}
