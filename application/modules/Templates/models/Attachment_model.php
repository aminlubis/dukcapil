<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attachment_model extends CI_Model {

	var $table = 'web_attachment';
	var $column = array('web_attachment.wa_id','web_attachment.wa_name','web_attachment.wa_owner','web_attachment.wa_name','web_attachment.wa_fullpath','web_attachment.wa_size','web_attachment.wa_type','web_attachment.created_date');
	var $select = 'web_attachment.*';
	var $order = array('web_attachment.created_date' => 'DESC');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _main_query(){
		$this->db->select($this->select);
		$this->db->from($this->table);
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
			$this->db->where_in(''.$this->table.'.wa_id',$id);
			$query = $this->db->get();
			return $query->result();
		}else{
			$this->db->where(''.$this->table.'.wa_id',$id);
			$query = $this->db->get();
			return $query->row();
		}
		
	}

	public function get_attachment_by_params($params)
	{
		$this->db->from('web_attachment');
		$this->db->where('web_attachment.ref_table', $params['ref_table']);
		$this->db->where_in('web_attachment.ref_id', $params['ref_id']);
		return $this->db->get()->result();		
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
		/*if file images exist*/
		if (file_exists($get_data->wa_fullpath)) {
			$this->delete_attachment_by_id($id);
			/*delete first images file*/
            unlink($get_data->wa_fullpath);			

        }else{
        	return false;
        }
		
	}

	public function delete_attachment_by_id($id)
	{
		$get_data = $this->db->get_where('web_attachment', array('wa_id'=>$id))->row();
		//print_r($get_data->fullpath);die;
		if (file_exists($get_data->wa_fullpath)) {
			unlink($get_data->wa_fullpath);
		}
		$this->db->where('web_attachment.wa_id', $id);
		return $this->db->delete('web_attachment');

		
	}

	
}
