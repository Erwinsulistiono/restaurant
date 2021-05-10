<?php
class M_login extends CI_Model
{

    public function cekadmin($username, $password)
    {
        $query = $this->db->select()
            ->from('tbl_pengguna')
            ->where('pengguna_username', $username)
            ->where('pengguna_password', $password)
            ->get();

        return $query->row_array();
    }
}
