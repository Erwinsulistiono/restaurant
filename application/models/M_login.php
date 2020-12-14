<?php
class M_login extends CI_Model
{

    public function cekadmin($u, $p)
    {
        $query = $this->db->get_where('tbl_pengguna', ['pengguna_username' => $u, 'pengguna_password' => $p]);
        return $query->row_array();
    }

    public function getMethodOfOrder($getMethod)
    {
        return $this->db->query('SELECT * FROM tbl_tipe_transaksi WHERE 
                                FIND_IN_SET('. $getMethod . ' ,tipe_pembayaran');
    }
}