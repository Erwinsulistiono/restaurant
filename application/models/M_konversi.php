<?php
class M_konversi extends CI_Model
{
    function get_konversi_all()
    {
        $this->db->order_by('satuan_reff', 'ASC');
        $query = $this->db->get('tbl_satuan');
        return $query->result_array();
    }
}
