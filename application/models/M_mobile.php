<?php
class M_mobile extends CI_Model
{
    function insert_bulk_order($data, $outlet_id)
    {
        $this->db->insert_batch("cust_order_$outlet_id", $data);
        return $this->db->affected_rows() > 0;
    }

    function cek_status_pending($outlet_id, $plg_id)
    {
        $query = $this->db->select()
            ->from("cust_order_$outlet_id")
            ->where('order_userid', $plg_id)
            ->get();

        return $query->result_array();
    }

    function cek_status_approved($outlet_id, $plg_id)
    {
        $query = $this->db->select()
            ->from("tbl_order_$outlet_id")
            ->where('order_userid', $plg_id)
            ->get();

        return $query->result_array();
    }

    function getIdPelangganFromTableOrName($plg_nama, $plg_meja)
    {
        $query = $this->db->select()
            ->from('tbl_pelanggan')
            ->where('plg_meja', $plg_meja)
            ->like('plg_nama', $plg_nama)
            ->get();

        return $query->row_array();
    }

    function checkPelangganSession($plg_id)
    {
        $query = $this->db->select()
            ->from('tbl_pelanggan')
            ->where('plg_id', $plg_id)
            ->where('plg_login_flg', 'Y')
            ->get();

        return $query->row_array();
    }
}
