<?php
class M_waitress extends CI_Model
{

  public function clear_order_after_cancelation($outlet_id, $trx_id)
  {
    $this->db->where('order_trx_reff', $trx_id)
      ->where('order_kitchen_flg', "Y")
      ->update("tbl_order_$outlet_id", ["order_cancel_flg" => 'Y']);
  }

  function get_all_order_by_id($trx_id, $outlet_id)
  {
    $query = $this->db->where('order_trx_reff', $trx_id)
      ->like('order_waitress_flg', 'N')
      ->count_all_results("tbl_order_$outlet_id");

    return $query;
  }
}
