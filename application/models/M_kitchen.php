<?php

class M_kitchen extends CI_Model
{
  public function getOrder($outlet)
  {
    $query = $this->db->select()
      ->from("tbl_order_$outlet AS tbl1")
      ->join("tbl_trx_pos_$outlet AS tbl2", 'tbl1.order_trx_reff=tbl2.trx_id', 'LEFT')
      ->join("tbl_menu_$outlet AS tbl3", 'tbl1.order_menu=tbl3.menu_id', 'LEFT')
      ->order_by('order_date', 'ASC')
      ->get();

    return $query->result_array();
  }

  function addNotesReturnOrder($outlet, $order_id, $notes)
  {
    $this->db->where('order_id', $order_id)
      ->update("tbl_order_$outlet", ['order_notes' => $notes]);
  }

  function updateFlgKitchen($outlet, $groupOrder, $groupId)
  {
    $this->db->where('order_trx_reff', $groupId)
      ->where('order_date', $groupOrder)
      ->update("tbl_order_$outlet", ['order_kitchen_flg' => 'Y']);
  }

  function updateFlgWaitress($outlet, $groupOrder, $groupId)
  {
    $this->db->where('order_trx_reff', $groupId)
      ->where('order_date', $groupOrder)
      ->update("tbl_order_$outlet", ['order_waitress_flg' => 'Y']);
  }

  function getOrderRecipe($outlet)
  {
    $query = $this->db->select()
      ->from("tbl_order_$outlet AS tbl1")
      ->join("tbl_ingredient AS tbl2", 'tbl1.order_menu=tbl2.ing_menu_id')
      ->join("tbl_stock_$outlet AS tbl3", 'tbl2.ing_inv_id=tbl3.stock_id')
      ->get();

    return $query->result_array();
  }
}
