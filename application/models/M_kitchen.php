<?php

class M_kitchen extends CI_Model
{
  public function getOrder($outlet)
  {
    $this->db->select('trx_id, trx_table, trx_date, order_kitchen_flg, order_waitress_flg, order_date, trx_tipe');
    $this->db->from('tbl_order_' . $outlet);
    $this->db->join('tbl_trx_pos_' . $outlet, 'tbl_order_' . $outlet . '.order_trx_reff=tbl_trx_pos_' . $outlet . '.trx_id', 'left');
    $this->db->group_by('order_date');
    $this->db->order_by('order_date', 'asc');
    $query = $this->db->get();
    return $query->result_array();
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
}