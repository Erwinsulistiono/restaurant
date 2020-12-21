<?php
class M_pengguna extends CI_Model
{
    public function get_pengguna_pos($outlet_id)
    {
        $query = $this->db->select()
            ->from('tbl_pengguna AS tbl1')
            ->join('tbl_level_pos AS tbl2', 'tbl1.pengguna_level=tbl2.level_id', 'LEFT')
            ->where('pengguna_outlet', $outlet_id)
            ->get();

        return $query->result_array();
    }

    public function get_pengguna($outlet_id)
    {
        $query =  $this->db->select()
            ->from('tbl_pengguna AS tbl1')
            ->join('tbl_level_admin AS tbl2', 'tbl1.pengguna_level = tbl2.level_id', 'LEFT')
            ->join('tbl_level_pos AS tbl3', 'tbl1.pengguna_level = tbl3.level_id', 'LEFT')
            ->where('pengguna_outlet', $outlet_id)
            ->get();

        return $query->result_array();
    }
}
