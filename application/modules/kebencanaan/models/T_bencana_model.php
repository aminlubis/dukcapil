<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_bencana_model extends CI_Model {

	var $table = 'v_bencana';
	var $column = array('v_bencana.nama_bencana');
	var $select = 'v_bencana.*';

	var $order = array('v_bencana.id_bencana' => 'DESC');

	public function __construct()
	{
		parent::__construct();
	}

	private function _main_query(){
		$this->db->select($this->select);
		$this->db->from($this->table);

		$level = $this->authuser->filtering_data_by_level_user($this->table, $this->session->userdata('user')->user_id);
		if ( !in_array($level, array(1) ) ) {
			# code...
			$format_json = json_encode(array('user_id' => $this->session->userdata('user')->user_id, 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
			$this->db->like($this->table.'.created_by', (string)$format_json);
		}

		if( isset($_GET['bulan']) AND $_GET['bulan'] != 0 ){
			$this->db->where('MONTH(tanggal_kejadian)', $_GET['bulan']);
		}

		if( isset($_GET['tahun']) AND $_GET['tahun'] != 0 ){
			$this->db->where('YEAR(tanggal_kejadian)', $_GET['tahun']);
		}

		if( isset($_GET['jenis_bencana']) AND $_GET['jenis_bencana'] != 0 ){
			$this->db->where('jenis_bencana', $_GET['jenis_bencana']);
		}

		if( isset($_GET['status_bencana']) AND $_GET['status_bencana'] != 0 ){
			$this->db->where('status_bencana', $_GET['status_bencana']);
		}

		if( isset($_GET['level_bencana']) AND $_GET['level_bencana'] != 0 ){
			$this->db->where('level_bencana', $_GET['level_bencana']);
		}

		if( isset($_GET['province']) AND $_GET['province'] != 0 ){
			$this->db->where('provinsi', $_GET['province']);
		}

		if( isset($_GET['date_by']) ){
			if( isset($_GET['from_tgl']) AND $_GET['from_tgl'] != '' AND isset($_GET['to_tgl']) AND $_GET['to_tgl'] != ''  ){
				$this->db->where('CAST('.$_GET['date_by'].' as DATE) BETWEEN '."'".$_GET['from_tgl']."'".' AND '."'".$_GET['to_tgl']."'".' ');

				// $this->db->where(''.$_GET['date_by'].' >= '."'".$_GET['from_tgl']."'".' AND '.$_GET['date_by'].' <= '."'".$_GET['to_tgl']."'".' ');

			}
		}

		
		
	}

	private function _get_datatables_query()
	{
		
		$this->_main_query();
		$this->db->where('status_data','sementara');

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
		$this->db->where('status_data','sementara');
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->_main_query();
		if(is_array($id)){
			$this->db->where_in(''.$this->table.'.id_bencana',$id);
			$query = $this->db->get();
			return $query->result();
		}else{
			$this->db->where(''.$this->table.'.id_bencana',$id);
			$query = $this->db->get();
			return $query->row();
		}
		
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
			$this->db->where_in(''.'t_bencana'.'.id_bencana', $id);
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
