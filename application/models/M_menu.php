<?php
class M_menu extends CI_Model
{

    function check_satuan_konversi($ing_satuan)
    {
        $this->db->select('satuan_id, satuan_kode');
        $this->db->from('tbl_satuan');
        $this->db->where('satuan_reff', $ing_satuan);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_resep($outlet, $id)
    {
        $this->db->select('*');
        $this->db->from('tbl_ingredient');
        $this->db->join('tbl_satuan', 'tbl_ingredient.ing_satuan_id=tbl_satuan.satuan_id', 'left');
        $this->db->join('tbl_stock_' . $outlet, 'tbl_ingredient.ing_inv_id=tbl_stock_' . $outlet . '.stock_id', 'left');
        $this->db->where('ing_menu_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

     function get_all_resep($outlet)
    {
        $this->db->select('*');
        $this->db->from('tbl_ingredient');
        $this->db->join('tbl_satuan', 'tbl_ingredient.ing_satuan_id=tbl_satuan.satuan_id', 'left');
        $this->db->join('tbl_stock_' . $outlet, 'tbl_ingredient.ing_inv_id=tbl_stock_' . $outlet . '.stock_id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_kategori($outlet, $id)
    {
        $this->db->select('kategori_nama');
        $this->db->from('tbl_menu_kat');
        $this->db->join('tbl_kategori', 'tbl_menu_kat.kategori_id=tbl_kategori.kategori_id', 'left');
        $this->db->join('tbl_menu_' . $outlet, 'tbl_menu_kat.menu_id=tbl_menu_' . $outlet . '.menu_id', 'left');
        $this->db->where('tbl_menu_kat.menu_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
}