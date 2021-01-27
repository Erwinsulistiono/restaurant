<?php
class M_menu extends CI_Model
{
    function get_resep($outlet, $id)
    {
        $query = $this->db->select()
            ->from('tbl_ingredient')
            ->join('tbl_satuan', 'tbl_ingredient.ing_satuan_id=tbl_satuan.satuan_id', 'LEFT')
            ->join("tbl_stock_$outlet", "tbl_ingredient.ing_inv_id=tbl_stock_$outlet.stock_id", 'LEFT')
            ->where('ing_menu_id', $id)
            ->get();

        return $query->result_array();
    }

    function get_all_resep($outlet)
    {
        $query = $this->db->select()
            ->from('tbl_ingredient')
            ->join('tbl_satuan', 'tbl_ingredient.ing_satuan_id=tbl_satuan.satuan_id', 'LEFT')
            ->join("tbl_stock_$outlet", "tbl_ingredient.ing_inv_id=tbl_stock_$outlet.stock_id", 'LEFT')
            ->get();

        return $query->result_array();
    }

    function get_kategori($outlet, $id)
    {
        $query = $this->db->select()
            ->from('tbl_menu_kat')
            ->join('tbl_kategori', 'tbl_menu_kat.kategori_id=tbl_kategori.kategori_id', 'LEFT')
            ->join("tbl_menu_$outlet", "tbl_menu_kat.menu_id=tbl_menu_$outlet.menu_id", 'LEFT')
            ->where('tbl_menu_kat.menu_id', $id)
            ->get();

        return $query->result_array();
    }
}
