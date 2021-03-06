<?PHP
class M_outlet extends CI_Model
{

	public function create_data_table_outlet($outlet_id)
	{
		$this->db->query("CREATE TABLE `tbl_kas_harian_$outlet_id` (
			`kas_id` bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`kas_tgl` date DEFAULT NULL,
			`kas_kd_outlet` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`kas_nm_outlet` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`kas_nm_kasir` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`kas_saldo_awal` double(17,5) DEFAULT NULL,
			`kas_saldo_akhir` double(17,5) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_lap_order_$outlet_id` (
			`order_id` bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`order_trx_reff` bigint(20) NOT NULL COMMENT 'reference ke tbl trx_pos',
			`order_menu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			`order_qty` int(10) NOT NULL,
			`order_harga` double(17,5) NOT NULL,
			`order_subtotal` double(17,5) NOT NULL,
			`order_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`order_date` datetime NOT NULL,
			`order_userid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_lap_trx_$outlet_id` (
			`trx_id` bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`trx_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			`trx_cust` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			`trx_date` datetime NOT NULL,
			`trx_userid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			`trx_subtotal` double(17,5) NOT NULL,
			`trx_discount` double(17,5) NOT NULL,
			`trx_tax_ppn` double(17,5) NOT NULL,
			`trx_tax_service` double(17,5) NOT NULL,
			`trx_grand_total` double(17,5) NOT NULL,
			`trx_notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
			`trx_payment` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			`trx_payreff` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`trx_cardno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			`trx_nomor` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_meja_$outlet_id` (
			`meja_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`meja_nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			`meja_lokasi` int(1) NOT NULL,
			`meja_cptcy` int(2) NOT NULL,
			`meja_pelanggan` int(5) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_menu_$outlet_id` (
		  menu_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			menu_nama varchar(100) NOT NULL,
			menu_deskripsi varchar(200) NOT NULL,
			menu_harga_lama double DEFAULT NULL,
			menu_harga_baru double NOT NULL,
			menu_likes int(11) NOT NULL DEFAULT 0,
			menu_gambar varchar(30) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_order_$outlet_id` (
			order_id bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			order_trx_reff bigint(20) NOT NULL,
			order_menu varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			order_qty int(10) NOT NULL,
			order_harga double(17,5) NOT NULL,
			order_subtotal double(17,5) NOT NULL,
			order_notes text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
			order_date datetime NOT NULL,
			order_userid varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			order_flg varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_stock_$outlet_id` (
			stock_id bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			stock_reffid bigint(20) NOT NULL,
			stock_kode varchar(20) NOT NULL,
			stock_nama varchar(50) NOT NULL,
			stock_qty double(17,5) NOT NULL,
			stock_satuan varchar(20) NOT NULL,
			stock_min_qty double(17,5) NOT NULL,
			stock_harga double(17,5) NOT NULL,
			stock_kat varchar(20) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_trx_pos_$outlet_id` (
			trx_id bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			trx_table varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			trx_cust varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			trx_date datetime NOT NULL,
			trx_userid varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			trx_subtotal double(17,5) NOT NULL,
			trx_discount double(17,5) NOT NULL,
			trx_tax_ppn double(17,5) NOT NULL,
			trx_tax_service double(17,5) NOT NULL,
			trx_grand_total double(17,5) NOT NULL,
			trx_notes text COLLATE utf8mb4_unicode_ci NOT NULL,
			trx_payment varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			trx_kitchen varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
			trx_waitres varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `cust_order_$outlet_id` (
		  order_id bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
		  order_menu varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
		  order_qty int(10) NOT NULL,
		  order_harga double(17,5) NOT NULL,
		  order_subtotal double(17,5) NOT NULL,
		  order_notes text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_date datetime NOT NULL,
		  order_userid varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
		  order_admin_flg varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
		  order_trx_tipe varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
		  order_cust_table varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_cust_address varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_cust_notes varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_cust_platno varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_cust_phone varbinary(50) DEFAULT NULL,
		  order_payment_id bigint(20) DEFAULT NULL,
		  order_payment_nama varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_nomor_kartu varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_nomor_reff varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		  order_voucher_id varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

		$this->db->query("CREATE TABLE `tbl_kitchen_$outlet_id` (
			kitchen_id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			kitchen_nama varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
			kitchen_createdat datetime NOT NULL,
			kitchen_updatedat datetime NOT NULL,
			kitchen_updatedby varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
	}

	public function delete_data_table_outlet($outlet_id)
	{
		$this->db->query("DROP TABLE `tbl_kas_harian_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_lap_order_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_lap_trx_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_meja_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_menu_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_order_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_stock_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_trx_pos_$outlet_id`;");
		$this->db->query("DROP TABLE `cust_order_$outlet_id`;");
		$this->db->query("DROP TABLE `tbl_kitchen_$outlet_id`;");
	}
}
