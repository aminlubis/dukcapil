<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Templates_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function graph_pengaduan_masuk_by_existing_year() {
        $query = "SELECT MONTH(pgd_tanggal) AS bln, COUNT(pgd_id) AS total
                    FROM mc_pengaduan WHERE YEAR(pgd_tanggal)=".date('Y')."
                    GROUP BY MONTH(pgd_tanggal)";

        $query2 = "SELECT MIN(pgd_tanggal)AS min_date, MAX(pgd_tanggal) AS max_date, COUNT(pgd_id) AS total
                    FROM mc_pengaduan
                    WHERE YEAR(pgd_tanggal) = ".date('Y')."";

        $data  = array(
            'result_month' => $this->db->query($query)->result(),
            'result_global' => $this->db->query($query2)->row(),
            );

        return $data;

    }

    function dashboard_sidasimadu_by_existing_year() {
        $query = "SELECT MONTH(sdmd_tanggal_pengaduan) AS bln, COUNT(sdmd_id)AS total
                    FROM sdmd_verifikasi_materil
                    WHERE YEAR(sdmd_tanggal_pengaduan)=".date('Y')."
                    GROUP BY MONTH(sdmd_tanggal_pengaduan)";

        $query2 = "SELECT MIN(sdmd_tanggal_pengaduan)AS min_date, MAX(sdmd_tanggal_pengaduan) AS max_date, COUNT(sdmd_id)  AS total
                    FROM sdmd_verifikasi_materil
                    WHERE YEAR(sdmd_tanggal_pengaduan) = ".date('Y')."";

        $data  = array(
            'result_month' => $this->db->query($query)->result(),
            'result_global' => $this->db->query($query2)->row(),
            );

        return $data;

    }



}
