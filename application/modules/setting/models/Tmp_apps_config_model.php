<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tmp_apps_config_model extends CI_Model {

	var $table = 'tmp_profile_app';
	var $select = 'tmp_profile_app.*';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _main_query(){
		$this->db->select($this->select);
		$this->db->from($this->table);
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


}
