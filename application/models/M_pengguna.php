<?php
class M_pengguna extends CI_Model
{
    public function getPenggunaPerOutlet($outlet)
	{
        $this->db->select('*');
        $this->db->from('tbl_pengguna');
        $this->db->join('tbl_level_pos' , 'tbl_pengguna.pengguna_level = tbl_level_pos.level_id' , 'left');
        $this->db->where('tbl_pengguna.pengguna_outlet = '.$outlet);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function PenggunaOutlet($outlet)
	{
        $this->db->select('*');
        $this->db->from('tbl_pengguna');
        $this->db->join('tbl_level_admin' , 'tbl_pengguna.pengguna_level = tbl_level_admin.level_id' , 'left');
        $this->db->join('tbl_level_pos' , 'tbl_pengguna.pengguna_level = tbl_level_pos.level_id' , 'left');
        $this->db->where('tbl_pengguna.pengguna_outlet = '.$outlet);
        $query = $this->db->get();
        return $query->result_array();
    }
}