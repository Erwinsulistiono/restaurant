<?php

class M_kitchen extends CI_Model
{
  public function getOrder($outlet)
  {
    $this->db->select('*');
    $this->db->from("tbl_order_$outlet as tbl1");
    $this->db->join("tbl_trx_pos_$outlet as tbl2", 'tbl1.order_trx_reff=tbl2.trx_id', 'left');
    $this->db->join("tbl_menu_$outlet as tbl3", 'tbl1.order_menu=tbl3.menu_id', 'left');
    // $this->db->group_by('order_date');
    $this->db->order_by('order_date', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  function addNotesReturnOrder($outlet, $order_id, $notes)
  {
    $this->db->where(['order_id' => $order_id]);
    $this->db->update("tbl_order_$outlet", ['order_notes' => $notes]);
  }

  function updateFlgKitchen($outlet, $groupOrder, $groupId)
  {
    $this->db->where(['order_trx_reff' => $groupId, 'order_date' => $groupOrder]);
    $this->db->update('tbl_order_' . $outlet, ['order_kitchen_flg' => 'Y']);
  }

  function updateFlgWaitress($outlet, $groupOrder, $groupId)
  {
    $this->db->where(['order_trx_reff' => $groupId, 'order_date' => $groupOrder]);
    $this->db->update('tbl_order_' . $outlet, ['order_waitress_flg' => 'Y']);
  }

  function getOrderRecipe($outlet)
  {
    $this->db->select('*');
    $this->db->from("tbl_order_$outlet AS tbl1");
    $this->db->join("tbl_ingredient AS tbl2", "tbl1.order_menu = tbl2.ing_menu_id");
    $this->db->join("tbl_stock_$outlet AS tbl3", "tbl2.ing_inv_id=tbl3.stock_id");
    $query = $this->db->get();
    return $query->result_array();
  }
}
