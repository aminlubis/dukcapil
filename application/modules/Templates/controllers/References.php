<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class References extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	/*here function used for this application*/

	public function getProvince()
	{
        
		$result = $this->getProvinceByKeyword($_POST['keyword']);
		$arrResult = [];
		foreach ($result as $key => $value) {
			$arrResult[] = $value->id.' : '.$value->name;
		}
		echo json_encode($arrResult);
		
		
	}

	public function getProvinceByKeyword($key='')
	{
        $query = $this->db->where("name LIKE '%".$key."%' ")
        				  ->order_by('name', 'ASC')
                          ->get('provinces');
		
        return $query->result();
	}

	public function getRegencyByKeyword()
	{
        
		$query = $this->db->where("name LIKE '%".$_POST['keyword']."%' ")
        				  ->order_by('name', 'ASC')
                          ->get('regencies');
		$arrResult = [];
		foreach ($query->result() as $key => $value) {
			$arrResult[] = $value->id.' : '.$value->name;
		}
		echo json_encode($arrResult);
		
		
	}

	public function getDistricts()
	{
        
		$result = $this->getDistrictsByKeyword($_POST['keyword']);
		$arrResult = [];
		foreach ($result as $key => $value) {
			$arrResult[] = $value->id.' : '.$value->name;
		}
		echo json_encode($arrResult);
		
		
	}

	public function getDistrictsByKeyword($key='',$regency='')
	{
        $query = $this->db->where("name LIKE '%".$key."%' ")
        				  ->order_by('name', 'ASC')
                          ->get('districts');
		
        return $query->result();
	}

	public function getVillage()
	{
        
		$result = $this->getVillageByKeyword($_POST['keyword'],$_POST['district']);
		// print_r($this->db->last_query());die;
		$arrResult = [];
		foreach ($result as $key => $value) {
			$arrResult[] = $value->id.' : '.$value->name;
		}
		echo json_encode($arrResult);
		
		
	}

	public function getVillageByKeyword($key='',$district='')
	{
        $query = $this->db->where("name LIKE '%".$key."%' ")->where("district_id", $district)
        				  ->order_by('name', 'ASC')
                          ->get('villages');
		
        return $query->result();
	}

	public function getRegencyByProvince($provinceId='')
	{
        $query = $this->db->where('province_id', $provinceId)
        				  ->order_by('name', 'ASC')
                          ->get('regencies');
		
        echo json_encode($query->result());
	}

	public function getDistrictByRegency($regency_id='')
	{
        $query = $this->db->where('regency_id', $regency_id)
        				  ->order_by('name', 'ASC')
                          ->get('districts');
		
        echo json_encode($query->result());
	}

	public function getVillagesByDistrict($district_id='')
	{
        $query = $this->db->where('district_id', $district_id)
        				  ->order_by('name', 'ASC')
                          ->get('villages');
		
        echo json_encode($query->result());
	}

	public function getDistrictsById($id='')
	{
		$query = "select  b.id as province_id, b.name as province_name,c.id as regency_id,c.name as regency_name
				from districts a
				left join provinces b on b.id=a.province_id
				left join regencies c on c.id=a.regency_id
				where a.id=".$id." ";
		$exc = $this->db->query($query);
		echo json_encode($exc->row());
	}

	public function getRegencyById($id='')
	{
		$query = "select b.id as province_id, b.name as province_name, a.id as regency_id, a.name as regency_name, b.zona_waktu
				from regencies a
				left join provinces b on b.id=a.province_id
				where a.id=".$id." ";
		$exc = $this->db->query($query);
		echo json_encode($exc->row());
	}

	public function getMenuByModulId($modul_id='')
	{
        $query = $this->db->where('modul_id', $modul_id)->where('parent', 0)->where('is_active', 'Y')
        				  ->order_by('name', 'ASC')
                          ->get('tmp_mst_menu');
		
        echo json_encode($query->result());
	}

}
