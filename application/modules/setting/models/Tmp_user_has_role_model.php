<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tmp_user_has_role_model extends CI_Model {

	var $table = 'tmp_user';
	var $column = array('tmp_user.fullname','tmp_user.email','tmp_user.username','tmp_user.is_active');
	var $select = 'tmp_user.email, fullname, username, is_active, is_deleted, user_id, created_date, created_by, updated_date, updated_by, password';

	var $order = array('tmp_user.user_id' => 'DESC', 'tmp_user.updated_date' => 'DESC');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _main_query(){
		$this->db->select('(SELECT GROUP_CONCAT(role_name) AS role_name
							FROM (SELECT tmp_user_has_role.user_id, tmp_user_has_role.role_id, tmp_mst_role.name AS role_name
								FROM tmp_user_has_role 
								LEFT JOIN tmp_mst_role ON tmp_mst_role.`role_id`=tmp_user_has_role.`role_id`)AS aTable WHERE aTable.`user_id`=tmp_user.`user_id`
							GROUP BY user_id) AS role_name');
		$this->db->select($this->select);
		$this->db->from($this->table);
		$this->db->where($this->table.".is_deleted != 'Y'");
		$this->db->where($this->table.".flag_user != 'Publik'");
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
		//print_r($this->db->last_query());
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
			$this->db->where_in(''.$this->table.'.user_id',$id);
			$query = $this->db->get();
			return $query->result();
		}else{
			$this->db->where(''.$this->table.'.user_id',$id);
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
		$this->db->where_in(''.$this->table.'.user_id', $id);
		return $this->db->update($this->table, array('is_deleted' => 'Y', 'is_active' => 'N'));
	}

	public function check_selected($role_id, $user_id){
	 	$this->db->from('tmp_user_has_role');
	 	$this->db->where(array('role_id'=> $role_id, 'user_id' => $user_id));
	 	$exist = $this->db->get()->row();
	 	if($exist){
	 		return 'selected';
	 	}else{
	 		return false;
	 	}
	 }


}
