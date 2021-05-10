<?php
class M_laporan_harian extends CI_Model
{

    public function get_sales_per_kategori()
    {
        $tgl = date("Y-m-d");
        $outlet = $this->session->userdata('pengguna_outlet');
        $out_nama = $this->get_nama_outlet($outlet);

        $query = $this->db->select("order_menu, order_harga, trx_cust, '$out_nama' AS out_nama")
            ->select_sum("order_qty")
            ->select_sum("order_subtotal")
            ->from("tbl_lap_order_$outlet AS tbl1")
            ->join("tbl_lap_trx_$outlet AS tbl2", "tbl1.order_trx_reff=tbl2.trx_id", "LEFT")
            ->where("DATE(trx_date)", $tgl)
            ->group_by("order_menu")
            ->order_by('order_subtotal', 'DESC')
            ->limit(20)
            ->get();

        return $query->result_array();
    }

    public function get_laporan_harian()
    {
        $tgl = date("Y-m-d");
        $outlet = $this->session->userdata('pengguna_outlet');
        $out_nama = $this->get_nama_outlet($outlet);

        $query = $this->db->select('SUM(trx_subtotal) AS trx_subtotal, SUM(trx_discount) AS trx_discount')
            ->select('SUM(trx_tax_ppn) AS trx_tax_ppn, SUM(trx_tax_service) AS trx_tax_service')
            ->select('SUM(trx_grand_total) AS trx_grand_total')
            ->select("trx_date, '$out_nama' AS out_nama, DATE(trx_date) AS periode")
            ->from("tbl_lap_trx_$outlet")
            ->where("DATE(trx_date)", $tgl)
            ->order_by('trx_date', 'DESC')
            ->group_by('DATE(trx_date)')
            ->get();

        return $query->result_array();
    }

    public function get_today_trx()
    {
        $tgl = date("Y-m-d");
        $outlet = $this->session->userdata('pengguna_outlet');

        $query = $this->db->select()
            ->select('SUM(trx_grand_total) AS sum_grand_total')
            ->from("tbl_lap_trx_$outlet")
            ->where("DATE(trx_date)", $tgl)
            ->order_by('trx_date', 'DESC')
            ->group_by('trx_payment')
            ->get();

        return $query->result_array();
    }

    public function count_total_porsi()
    {
        $tgl = date("Y-m-d");
        $outlet = $this->session->userdata('pengguna_outlet');

        $query = $this->db->select('SUM(order_qty) AS total_porsi')
            ->from("tbl_lap_order_$outlet")
            ->where("DATE(order_date)", $tgl)
            ->group_by('DATE(order_date)')
            ->get();

        return $query->row_array();
    }

    public function count_total_trx()
    {
        $tgl = date("Y-m-d");
        $outlet = $this->session->userdata('pengguna_outlet');

        $query = $this->db->select()
            ->from("tbl_lap_trx_$outlet")
            ->where("DATE(trx_date)", $tgl)
            ->order_by('trx_date', 'DESC')
            ->get();

        return $query->result_array();
    }

    public function get_nama_outlet($outlet_id)
    {
        $query = $this->db->select('out_nama')
            ->where('out_id', $outlet_id)
            ->get('tbl_outlet');

        return $query->row('out_nama');
    }
}
