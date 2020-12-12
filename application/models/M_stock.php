<?php
class M_stock extends CI_Model
{

    public function get_qty_diff($id, $qty, $outlet)
    {
        $query = $this->db->query('SELECT a.stock_id, a.stock_nama, a.stock_min_qty, a.stock_satuan, a.stock_qty - (b.ing_qty * c.satuan_val * ' . $qty . ') as stock_qty FROM tbl_stock_' . $outlet . ' a
		INNER JOIN tbl_ingredient b ON a.stock_id=b.ing_inv_id
		INNER JOIN tbl_satuan c ON b.ing_satuan_id=c.satuan_id 
		WHERE b.ing_menu_id = ' . $id);
        return $query->result_array();
    }

    public function getIngredientAll($outlet)
    {
        $query = $this->db->query("SELECT ing_id, ing_menu_id, ing_inv_id, ing_qty, satuan_val, stock_qty, b.*
									FROM tbl_ingredient AS a
									LEFT JOIN tbl_menu_$outlet AS b ON a.ing_menu_id=b.menu_id
									LEFT JOIN tbl_stock_$outlet AS c ON a.`ing_inv_id` = c.`stock_id`
									LEFT JOIN tbl_satuan AS d ON a.`ing_satuan_id`=d.`satuan_id`");
        return $query->result_array();
    }

    public function get_qty_added($id, $qty, $outlet)
    {
        $query = $this->db->query('SELECT a.stock_id, a.stock_qty + (b.ing_qty * c.satuan_val * ' . $qty . ') as stock_qty FROM tbl_stock_' . $outlet . ' a
		INNER JOIN tbl_ingredient b ON a.stock_id=b.ing_inv_id
		INNER JOIN tbl_satuan c ON b.ing_satuan_id=c.satuan_id 
		WHERE b.ing_menu_id = ' . $id);
        return $query->result_array();
    }
}
