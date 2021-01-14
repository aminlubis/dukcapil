<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _main_query(){
		$this->db->select('web_modul.wm_name, COUNT(web_posting.wm_id) AS total');
		$this->db->from('web_posting');
		$this->db->join('web_modul', 'web_modul.wm_id=web_posting.wm_id','left');
		$this->db->group_by('web_posting.wm_id');
	}

	public function get_graph_data()
	{
		$this->_main_query();
		return $this->db->get()->result();
	}


}
