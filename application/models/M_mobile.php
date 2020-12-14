<?php
class M_mobile extends CI_Model
{
    function insert_bulk_order($data, $db)
    {
        $this->db->insert_batch('cust_order_' . $db, $data);
        return $this->db->affected_rows() > 0;
    }

    function cek_status_pending($db, $plg_id)
    {
        $query = $this->db->get_where('cust_order_' . $db, ['order_userid' => $plg_id]);
        return $query->result_array();
    }

    function cek_status_approved($db, $plg_id)
    {
        $query = $this->db->get_where('tbl_order_' . $db, ['order_userid' => $plg_id]);
        return $query->result_array();
    }

    function getIdPelangganFromTableOrName($plg_nama, $plg_meja)
    {
        $this->db->select('*');
        $this->db->from('tbl_pelanggan');
        $this->db->where('plg_meja', $plg_meja);
        $this->db->like('plg_nama', $plg_nama);
        $query = $this->db->get();
        return $query->row_array();
    }

    function checkPelangganSession($plg_id)
    {
        $query = $this->db->get_where('tbl_pelanggan', ['plg_id' => $plg_id, 'plg_login_flg' => 'Y']);
        return $query->row_array();
    }
}
