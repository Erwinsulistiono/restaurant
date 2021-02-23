<?php
class M_mobile extends CI_Model
{
    function insert_bulk_order($data, $outlet_id)
    {
        $this->db->insert_batch("cust_order_$outlet_id", $data);
        return $this->db->affected_rows() > 0;
    }

    function get_pelanggan_order($outlet_id, $trx_id)
    {
        $query = $this->db->select()
            ->from("tbl_order_$outlet_id AS tbl1")
            ->join("tbl_menu_$outlet_id AS tbl2", 'tbl1.order_menu=tbl2.menu_id', 'LEFT')
            ->join("tbl_trx_pos_$outlet_id AS tbl3", 'tbl1.order_trx_reff=tbl3.trx_id', 'LEFT')
            ->where('order_trx_reff', $trx_id)
            ->get();

        return $query->result_array();
    }

    function get_customer_by_name($plg_nama, $plg_meja)
    {
        $query = $this->db->select()
            ->from('tbl_pelanggan')
            ->where('plg_meja', $plg_meja)
            ->like('plg_nama', $plg_nama)
            ->get();

        return $query->row_array();
    }

    function check_session_pelanggan($plg_id)
    {
        $query = $this->db->select()
            ->from('tbl_pelanggan')
            ->where('plg_id', $plg_id)
            ->where('plg_login_flg', 'Y')
            ->get();

        return $query->row_array();
    }

    function check_member($plg_notelp, $plg_socmed)
    {
        $query = $this->db->select()
            ->from('tbl_pelanggan')
            ->like('plg_socmed', $plg_socmed)
            ->like('plg_notelp', $plg_notelp)
            ->get();

        return $query->row_array();
    }
}
