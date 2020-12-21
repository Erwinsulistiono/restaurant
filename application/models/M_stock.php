<?php
class M_stock extends CI_Model
{

    public function get_qty_diff($id, $qty, $outlet)
    {
        $query = $this->db->select('stock_id, stock_nama, stock_min_qty, stock_satuan')
            ->select('stock_qty - (b.ing_qty * c.satuan_val * ' . $qty . ') AS stock_qty')
            ->from("tbl_stock_$outlet AS tbl1")
            ->join('tbl_ingredient AS tbl2', 'tbl2.ing_inv_id = tbl1.stock_id', 'INNER')
            ->join('tbl_satuan AS tbl3', 'tbl3.satuan_id = tbl2.ing_satuan')
            ->where('tbl2.ing_menu_id', $id)
            ->get();

        return $query->result_array();
    }

    public function getIngredientAll($outlet)
    {
        $query = $this->db->select()
            ->from('tbl_ingredient AS tbl1')
            ->join("tbl_menu_$outlet AS tbl2", 'tbl2.menu_id = tbl1.ing_menu_id', 'LEFT')
            ->join("tbl_stock_$outlet AS tbl3", 'tbl3.stock_id = tbl1.ing_inv_id', 'LEFT')
            ->join('tbl_satuan AS tbl4', 'tbl4.satuan_id = tbl1.ing_satuan_id', 'LEFT')
            ->get();

        return $query->result_array();
    }

    public function get_qty_added($id, $qty, $outlet)
    {
        $query = $this->db->select('stock_id, stock_qty + (b.ing_qty * c.satuan_val * ' . $qty . ') AS stock_qty')
            ->from("tbl_stock_$outlet AS tbl1")
            ->join('tbl_ingredient AS tbl2', 'tbl2.ing_inv_id = tbl1.stock_id', 'INNER')
            ->join('tbl_satuan AS tbl3', 'tbl3.satuan_id = tbl2.ing_satuan_id', 'INNER')
            ->where('ing_menu_id', $id)
            ->get();

        return $query->result_array();
    }
}
