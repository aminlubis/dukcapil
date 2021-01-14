<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tmp_role_has_menu_model extends CI_Model {

	var $table = 'tmp_mst_role';
	var $column = array('tmp_mst_role.name','tmp_mst_role.is_active','tmp_mst_role.updated_date','tmp_mst_role.created_date', 'tmp_mst_level.name');
	var $select = 'tmp_mst_role.*, tmp_mst_level.name as level_name';
	var $order = array('tmp_mst_role.role_id' => 'DESC', 'tmp_mst_role.updated_date' => 'DESC');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _main_query(){
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->where($this->table.".is_deleted != 'Y'");
		$this->db->join('tmp_mst_level',$this->table.'.level_id=tmp_mst_level.level_id','left');
	}

	private function _get_datatables_query()
	{
		
		$this->_main_query();

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
			$this->db->where_in(''.$this->table.'.role_id',$id);
			$query = $this->db->get();
			return $query->result();
		}else{
			$this->db->where(''.$this->table.'.role_id',$id);
			$query = $this->db->get();
			return $query->row();
		}
		
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$get_data = $this->get_by_id($id);
		$this->db->where_in(''.$this->table.'.role_id', $id);
		return $this->db->update($this->table, array('is_deleted' => 'Y', 'is_active' => 'N'));
	}

	public function get_role_menu_by_role_id($id)
	{
		$this->db->select('tmp_mst_menu.name, tmp_role_has_menu.*');
		$this->db->from('tmp_role_has_menu');
		$this->db->join('tmp_mst_menu','tmp_mst_menu.menu_id=tmp_role_has_menu.menu_id','left');
		$this->db->join('tmp_mst_role','tmp_mst_role.role_id=tmp_role_has_menu.role_id','left');
		$this->db->where('tmp_role_has_menu.role_id', $id);
		$tmp_role_has_menu = $this->db->get()->result();
		$html = '';
		foreach ($tmp_role_has_menu as $key => $value) {
			# code...
			$html .= '<li>'.$value->name.' ('.$value->action_code.') </li>';
		}
		return $html;
	}

	public function get_checked_form($menu_id, $role_id, $code=''){
	 	$this->db->from('tmp_role_has_menu');
	 	$this->db->where(array('menu_id' => $menu_id, 'role_id'=> $role_id));
	 	$this->db->where("action_code LIKE '%$code%'");
	 	$exist = $this->db->get()->row();
	 	if($exist){
	 		return 'checked';
	 	}else{
	 		return false;
	 	}
	 }


}
