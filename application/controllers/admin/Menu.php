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

  public function outlet($dataBase = null)
  {
    is_null($dataBase) ? $db = $this->input->post('selectDb') : $db = $dataBase;
    $data = [
      'dataBase' => $db,
      'outlet' => $this->M_crud->read('tbl_outlet'),
      'kategori' => $this->M_crud->read('tbl_kategori'),
      'kategori_makanan' => $this->M_crud->left_join('tbl_menu_kat', 'tbl_kategori', 'tbl_menu_kat.kategori_id=tbl_kategori.kategori_id'),
      'data' => $this->M_crud->read('tbl_menu_' . $db),
      'inventory' => json_encode($this->M_crud->read('tbl_stock_' . $db)),
      'satuan' => json_encode($this->M_crud->read('tbl_satuan')),
      'ingredient' => json_encode($this->M_menu->get_all_resep($db)),
    ];
    $this->render('admin/katalog/v_menu_outlet', $data);
  }

  /*----------------- MODUL MENU ---------------------*/
  public function index()
  {
    $data['outlet'] = $this->M_crud->read('tbl_outlet');
    $this->render('admin/katalog/v_menu', $data);
  }

  function simpan_menu($dataBase)
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
    $gbr = $this->upload->data();

    if (empty($_FILES['filefoto']['name']) && !$menu_id) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu tidak dapat ditambahkan, file gambar yang Anda masukkan terlalu besar.</div>');
      redirect('admin/katalog/outlet' . $dataBase);
    }

    if (empty($_FILES['filefoto']['name'])) {
      $upload = $this->M_crud->select('tbl_menu_' . $dataBase, 'menu_id', $menu_id);
      $gbr['file_name'] = $upload['menu_gambar'];
    }

    $data = [
      'menu_gambar' => $gbr['file_name'],
      'menu_nama' => $this->input->post('menu_nama'),
      'menu_deskripsi' => $this->input->post('menu_deskripsi'),
      'menu_harga_lama' => $this->input->post('menu_harga_lama'),
      'menu_harga_baru' => $this->input->post('menu_harga_baru'),
    ];
    $log_newval = strtr(json_encode($data), array(',' => ' | ', '{' => '', '}' => '', '"' => ' '));

    if (!$menu_id) {
      $this->M_crud->insert('tbl_menu_' . $dataBase, $data);
      $reff_id = $this->db->insert_id();

      $this->M_log->simpan_log($reff_id, 'MENU', null, $log_newval);
      $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['menu_nama'] . '</b> Berhasil disimpan ke database.</div>');
      $this->simpan_kategori($reff_id, $dataBase);
      redirect('admin/katalog/menu/' . $dataBase);
    }
    $data_old = $this->M_crud->select('tbl_menu_' . $dataBase, 'menu_id', $menu_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($menu_id, 'MENU', $log_oldval, $log_newval);
    $this->M_crud->update('tbl_menu_' . $dataBase, $data, 'menu_id', $menu_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>' . $data['menu_nama'] . '</b> Berhasil disimpan ke database.</div>');
    $this->simpan_kategori($menu_id, $dataBase);
    redirect('admin/menu/outlet/' . $dataBase);
  }


  /*----------------- MODUL KATEGORI TIAP MENU ---------------------*/
  public function simpan_kategori($menu_id, $dataBase)
  {
    $data_old = $this->M_menu->get_kategori($dataBase, $menu_id);
    $log_oldval = '';
    if ($data_old) {
      $i = 1;
      foreach ($data_old as $old) {
        $log_oldval .= ('kategori' . $i . ' : ' . $old['kategori_nama'] . ' | ');
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
      $this->M_crud->insert('tbl_menu_kat' , $data);
      var_dump($data);
    }

    $data_new = $this->M_menu->get_kategori($dataBase, $menu_id);
    if ($data_new) {
      $log_newval = '';
      $i = 1;
      foreach ($data_new as $new) {
        $log_newval .= ('kategori' . $i . ' : ' . $new['kategori_nama'] . ' | ');
      };
    }
    $this->M_log->simpan_log($menu_id, 'KATEGORI PER MENU', $log_oldval, $log_newval);
  }

  public function hapus_menu($dataBase, $menu_id)
  {
    $data_old = $this->M_crud->select('tbl_menu_' . $dataBase, 'menu_id', $menu_id);
    $log_oldval = strtr(json_encode($data_old), array(',' => ' | ', '{' => '', '}' => '', '"' => ''));

    $this->M_log->simpan_log($menu_id, 'MENU', $log_oldval);
    $this->M_crud->delete('tbl_menu_' . $dataBase, 'menu_id', $menu_id);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu Berhasil dihapus dari database.</div>');
    redirect('admin/menu/outlet/' . $dataBase);
  }


  /*----------------- MODUL RESEP MENU ---------------------*/
  public function simpan_recipe($dataBase, $menu_id)
  {
    $data_old = $this->M_menu->get_resep($dataBase, $menu_id);
    $log_oldval = '';
    
    if ($data_old) {
      foreach ($data_old as $old) {
        $log_oldval .= ('ingredient : ' . $old['stock_nama'] . ' Qty : ' . $old['ing_qty'] . ' Satuan : ' . $old['satuan_kode'] . ' | ');
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

    $data_new = $this->M_menu->get_resep($dataBase, $menu_id);
    if ($data_new) {
      $log_newval = '';
      foreach ($data_new as $new) {
        $log_newval .= ('ingredient : ' . $new['stock_nama'] . ' Qty : ' . $new['ing_qty'] . ' Satuan : ' . $new['satuan_kode'] . ' | ');
      };
    }
    $this->M_log->simpan_log($menu_id, 'INGREDIENT MENU', $log_oldval, $log_newval);
    echo json_encode($data_new);
  }


  /*----------------- MODUL FETCH SATUAN KONVERSI ---------------------*/
  public function check_satuan_konversi()
  {
    $outlet = $this->input->post('dataBase');
    $ing_satuan = $this->M_crud->select('tbl_stock_' . $outlet, 'stock_id', $this->input->post('ing'))['stock_satuan'];
    $data = $this->M_menu->check_satuan_konversi($ing_satuan);
    echo json_encode($data);
  }


  /*----------------- MODUL TRANSFER MENU KE OUTLET CABANG---------------------*/
  public function transfer_menu($menu_id)
  {
    $outlet_tujuan = $this->M_crud->select('tbl_outlet', 'out_id', $this->input->post('outlet_tujuan'));
    $duplicate_menu = $this->M_crud->select('tbl_menu_'.$outlet_tujuan['out_id'] , 'menu_reff_id' , $menu_id);
    if ($duplicate_menu) {
      $this->session->set_flashdata('msg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu <b>'.$duplicate_menu['menu_nama'].' </b>sudah ada di outlet <b>'.$outlet_tujuan['out_nama'].'</b></div>');
      redirect('admin/menu/outlet/master');
    };
    $data = $this->M_crud->select('tbl_menu_master' , 'menu_id' , $menu_id);
    $log = 'menu = '.$data['menu_nama'].' | Outlet tujuan = '.$outlet_tujuan['out_nama'];
    $data['menu_reff_id'] = $menu_id;
    
    $this->M_crud->insert('tbl_menu_'.$outlet_tujuan['out_id'] , $data);
    $this->M_log->simpan_log($menu_id, 'TRANSFER MENU', $log, $log);
    $this->session->set_flashdata('msg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Menu '.$data['menu_nama'].' Berhasil ditambah ke outlet tujuan.</div>');
    redirect('admin/menu/outlet/master');
  }
}