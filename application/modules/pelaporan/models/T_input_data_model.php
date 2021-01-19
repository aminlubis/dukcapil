<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_input_data_model extends CI_Model {

	var $table = 't_ktp';
	var $column = array('t_ktp.nama_lengkap');
	var $select = 't_ktp.*';

	var $order = array('t_ktp.id' => 'DESC');

	public function __construct()
	{
		parent::__construct();
	}

	private function _main_query(){
		$this->db->select($this->select);
		$this->db->from($this->table);

		
		
	}

	private function _get_datatables_query()
	{
		
		$this->_main_query();
		$this->db->where('t_ktp.reg_id', $_GET['reg_id']);

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
		$this->db->where('t_ktp.reg_id', $_GET['reg_id']);
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

	public function save($data)
	{
		$this->db->insert('t_ktp', $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update('t_ktp', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$get_data = $this->get_by_id($id);
		if( $this->delete_image_default($get_data[0]) ){
			$this->db->where_in(''.'t_ktp'.'.id', $id);
			return $this->db->delete('t_ktp');
		}else{
			return false;
		}
		
	}


	public function list_fields(){
		return $this->db->list_fields( $this->table );
	}


}
