<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_pencatatan_model extends CI_Model {

	var $table = 't_registrasi';
	var $column = array('t_registrasi.no_reg', 't_registrasi.no_akta');
	var $select = 't_registrasi.id, no_akta, no_reg, status_data, nama, jk, bayi_id, nik,tgl_lhr, nama_kk, t_registrasi.created_date, t_registrasi.created_by, t_registrasi.updated_date, t_registrasi.updated_by';

	var $order = array('t_registrasi.id' => 'DESC');

	public function __construct()
	{
		parent::__construct();
	}

	private function _main_query(){
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->join('t_ktp', 't_ktp.id=t_registrasi.bayi_id', 'left');

		
		
	}

	private function _get_datatables_query()
	{
		
		$this->_main_query();
		// filter by field
		if( isset($_GET['checked_nama']) AND $_GET['nama'] != '' ){
			$this->db->like('nama', $_GET['nama']);
		}

		if( isset($_GET['checked_no_akta']) AND $_GET['no_akta'] != '' ){
			$this->db->like('no_akta', $_GET['no_akta']);
		}

		if( isset($_GET['checked_tgl_entri']) AND $_GET['tgl_entri'] != '' ){
			$this->db->where('CAST(t_registrasi.created_date as DATE) = '."'".$_GET['tgl_entri']."'".' ');
		}

		if( isset($_GET['checked_tgl_lhr']) AND $_GET['tgl_lhr'] != '' ){
			$this->db->where('tgl_lhr', $_GET['tgl_lhr']);
		}

		if( isset($_GET['checked_proses']) AND $_GET['status_proses'] != '' ){
			$this->db->where('status_data', $_GET['status_proses']);
		}

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		// print_r($this->db->last_query());die;
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->_main_query();
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->_main_query();
		if(is_array($id)){
			$this->db->where_in(''.$this->table.'.id',$id);
			$query = $this->db->get();
			return $query->result();
		}else{
			$this->db->where(''.$this->table.'.id',$id);
			$query = $this->db->get();
			return $query->row();
		}
		
	}

	public function get_by_reg_id($id)
	{
		$result = $this->db->select('t_ktp.*, no_akta, no_reg, status_data, tgl_generated_no_akta')->join('t_registrasi','t_registrasi.id=t_ktp.reg_id','left')->get_where('t_ktp', array('reg_id' => $id) )->result();
		foreach ($result as $key => $value) {
			$getData[$value->flag_type] = $value;
		}

		return $getData;
		
	}

	public function save($data)
	{
		$this->db->insert('t_bencana', $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update('t_bencana', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$get_data = $this->get_by_id($id);
		if( $this->delete_image_default($get_data[0]) ){
			$this->db->where_in(''.'t_bencana'.'.id', $id);
			return $this->db->delete('t_bencana');
		}else{
			return false;
		}
		
	}

	public function delete_image_default($data){
		/*print_r($data);die;*/
		/*if file images exist*/
		if ( file_exists(PATH_IMG_CONTENT.$data->foto_default) ) {
			if($data->foto_default != NULL){
				/*delete first foto_default file*/
	            unlink(PATH_IMG_CONTENT.$data->foto_default);
			}
        }
        return true;
	}


	public function list_fields(){
		return $this->db->list_fields( $this->table );
	}


}
