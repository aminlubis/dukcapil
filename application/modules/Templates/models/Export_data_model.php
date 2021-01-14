<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_data_model extends CI_Model {

	var $table = 'mc_pengaduan';
	var $column = array('mc_pengaduan.pgd_id','mc_pengaduan.pgd_no','mc_pengaduan.pgd_format_no', 'mc_pengaduan.pgd_tempat','mc_pengaduan.pgd_tanggal', 'mst_tipe_pengaduan.tp_name','mst_kategori_pemilu.kp_name','mst_alur_pengaduan.ap_name','mc_pengaduan_log.pl_pengadu','mc_pengaduan_log.pl_teradu');
	var $select = 'mc_pengaduan.*, mst_tipe_pengaduan.tp_name, mst_kategori_pemilu.kp_name, mst_alur_pengaduan.ap_name, mc_pengaduan_log.pl_pengadu, pl_teradu, pl_bukti, pl_peristiwa, v_pengaduan_hasil_penelitian_adm.verifikator, v_pengaduan_hasil_penelitian_adm.pgdhpa_pokok_pengaduan, v_pengaduan_hasil_penelitian_adm.ps_name';

	var $order = array('mc_pengaduan.pgd_id' => 'DESC','mc_pengaduan.pgd_tanggal' => 'DESC');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _main_query(){

		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('mc_pengaduan_log','mc_pengaduan_log.pgd_id='.$this->table.'.pgd_id','left');
		$this->db->join('v_pengaduan_hasil_penelitian_adm','v_pengaduan_hasil_penelitian_adm.pgd_id='.$this->table.'.pgd_id','left');
		$this->db->join('mst_tipe_pengaduan','mst_tipe_pengaduan.tp_id='.$this->table.'.tp_id','left');
		$this->db->join('mst_kategori_pemilu','mst_kategori_pemilu.kp_id='.$this->table.'.kp_id','left');
		$this->db->join('mst_alur_pengaduan','mst_alur_pengaduan.ap_id='.$this->table.'.ap_id','left');

		if(isset($_GET['year'])){
			if($_GET['year'] != 0){
				$this->db->where('YEAR(pgd_tanggal)', $_GET['year']);
			}
		}

		if(isset($_GET['tp_id']) and $_GET['tp_id'] != NULL){
			$this->db->where('mc_pengaduan.tp_id', $_GET['tp_id']);
		}

		if(isset($_GET['kp_id']) and $_GET['kp_id'] != NULL){
			$this->db->where('mc_pengaduan.kp_id', $_GET['kp_id']);
		}

		if(isset($_GET['ap_id']) and $_GET['ap_id'] != NULL){
			$this->db->where('mc_pengaduan.ap_id', $_GET['ap_id']);
		}

		if(isset($_GET['noreg']) and $_GET['noreg'] != NULL){
			$this->db->where('mc_pengaduan.pgd_id', $_GET['noreg']);
		}

		if(isset($_GET['prov']) and $_GET['prov'] != NULL and $_GET['prov'] != 0){
			$this->db->where('mc_pengaduan.province_id', $_GET['prov']);
		}

		if(isset($_GET['city']) and $_GET['city'] != NULL and $_GET['city'] != 0){
			$this->db->where('mc_pengaduan.city_id', $_GET['city']);
		}

		if(isset($_GET['frmdt']) and $_GET['frmdt'] != NULL and isset($_GET['todt']) and $_GET['todt']){
		$this->db->where('mc_pengaduan.pgd_tanggal BETWEEN '."'".$_GET['frmdt']."'".' AND '."'".$_GET['todt']."'".'');
		}

		/*just for admin*/
		if( !in_array($this->session->userdata('user')->role_id, array(1,4)) ){
			$this->db->where('pg_id', $this->session->userdata('user')->pg_id);
		}

		
	}

	function get_data()
	{
		$this->_main_query();
		$query = $this->db->get();
		return $query->result();
	}

	/*get data sidasi madu*/

	private function _main_query_sidasimadu(){

		$this->db->select('sdmd_verifikasi_materil.*, mst_status_verifikasi.sv_name, ver_adm.sv_name as rekomendasi_pengkaji, mst_jenis_pelanggaran.jp_name');
		$this->db->from('sdmd_verifikasi_materil');
		$this->db->join('mst_status_verifikasi','mst_status_verifikasi.sv_id=sdmd_verifikasi_materil.sdmd_hasil_vermat','left');
		$this->db->join('mst_status_verifikasi ver_adm','ver_adm.sv_id=sdmd_verifikasi_materil.sdmd_rekomendasi_pengkaji','left');
		$this->db->join('mst_jenis_pelanggaran','mst_jenis_pelanggaran.jp_id=sdmd_verifikasi_materil.sdmd_modus','left');
		
	}

	function get_data_sidasimadu()
	{
		$this->_main_query_sidasimadu();
		$query = $this->db->get();
		return $query->result();
	}

}
