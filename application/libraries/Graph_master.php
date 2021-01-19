<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class Graph_master {

    function get_graph($params) {
    	
    	$data = $this->setting_module($params);

		return $data;
		
    }

    function setting_module($params) {
		$CI =&get_instance();
		$db = $CI->load->database('default', true);

		/*modul setting*/
		if($params['prefix']==1){	

			$fields = array('Penerbitan_Akta_kelahiran'=>'total');
			$title = '<span style="font-size:13.5px">Grafik Penerbitan Akta Kelahiran</span>';
			$subtitle = 'Source: SIAK - DUKCAPIL ';
			$db->select('MONTH(tgl_generated_no_akta) AS bulan, COUNT(id) AS total');
			$db->from('t_registrasi');
			$db->where('YEAR(tgl_generated_no_akta)='.date('Y').'');
			$db->group_by('MONTH(tgl_generated_no_akta)');
			/*excecute query*/
			$data = $db->get()->result_array();
		}

		// if($params['prefix']==2){	
		// 	$fields = array('nama_jenis_bencana' => 'total');
		// 	$title = '<span style="font-size:13.5px">Persantase Bencana Berdasarkan Jenis Bencana </span>';
		// 	$subtitle = 'Source: I-Tangguh Dashboard';
		// 	$db->select('nama_jenis_bencana, COUNT(id_bencana) as total');
		// 	$db->from('v_bencana');
		// 	$db->where('YEAR(tanggal_kejadian)='.date('Y').'');
		// 	$db->group_by('nama_jenis_bencana');
		// 	$db->order_by('COUNT(id_bencana)', 'DESC');
		// 	/*excecute query*/
		// 	$data = $db->get()->result_array();
		// }

		// if($params['prefix']==3){	
		// 	$fields = array('Jenis_Bencana' => 'nama_jenis_bencana', 'Total' => 'total');
		// 	$title = '<span style="font-size:13.5px">Data Bencana Berdasarkan Jenis Bencana </span>';
		// 	$subtitle = 'Source: I-Tangguh Dashboard';
		// 	$db->select('nama_jenis_bencana, COUNT(id_bencana) AS total');
		// 	$db->from('v_bencana');
		// 	$db->where('YEAR(tanggal_kejadian)='.date('Y').'');
		// 	$db->group_by('nama_jenis_bencana');
		// 	$db->order_by('COUNT(id_bencana)', 'DESC');
		// 	/*excecute query*/
		// 	$data = $db->get()->result_array();
		// }

		// if($params['prefix']==4){	

		// 	$title = '<span style="font-size:13.5px">Grafik Data Bencana Berdasarkan Provinsi</span>';
		// 	$subtitle = 'Source: I-Tangguh Dashboard ';
		// 	$db->select('nama_prov, COUNT(id_bencana) AS total');
		// 	$db->from('v_bencana');
		// 	$db->where('YEAR(tanggal_kejadian)='.date('Y').'');
		// 	$db->group_by('nama_prov');
		// 	/*excecute query*/
		// 	$data = $db->get()->result_array();
		// 	foreach($data as $row){
		// 		$fields[$row['nama_prov']] = $row['total'];
		// 	}
		// }
		

		/*find and set type chart*/
		$chart = $this->chartTypeData($params['TypeChart'], $fields, $params, $data);
		$chart_data = array(
			'title' 	=> $title,
			'subtitle' 	=> $subtitle,
			'xAxis' 	=> isset($chart['xAxis'])?$chart['xAxis']:'',
			'series' 	=> isset($chart['series'])?$chart['series']:'',
			);

		return $chart_data;
		
    }


    public function chartTypeData($style, $fields, $params, $data){

    	switch ($style) {
    		case 'column':
    			/*lanjutkan buat function jika ada style yang lain*/
    			if ($params['style']==1) {
    				return $this->ColumnStyleOneData($fields, $params, $data);
    			}
    			break;
    		case 'pie':
    			if ($params['style']==1) {
    				return $this->PieStyleOneData($fields, $params, $data);
    			}
    			break;
    		case 'line':
    			if ($params['style']==1) {
    				return $this->LineStyleOneData($fields, $params, $data);
    			}
    			break;
    		case 'table':
    			if ($params['style']==1) {
    				return $this->TableStyleOneData($fields, $params, $data);
    			}
				break;
			case 'bar-basic':
				if ($params['style']==1) {
					return $this->BarBasicStyleOneData($fields, $params, $data);
				}
				break;
    		
    		default:
    			# code...
    			break;
    	}
	}
	
    public function ColumnStyleOneData($fields, $params, $data){
    	$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
    	
        $getData = array();
		foreach($data as $key=>$row){
			foreach ($fields as $kf => $vf) {
				$getData[$kf][$row['bulan']-1] = (int)$row[$vf];
			}
		}
		
		for ($i=0; $i < 12; $i++) { 
			foreach ($fields as $kf2 => $vf2) {
				if(!isset($getData[$kf2][$i])){
					$getData[$kf2][$i] = 0;
				}
				ksort($getData[$kf2]);
			}
			$categories[] = $CI->tanggal->getBulan($i+1);
			
		}

		foreach ($getData as $k => $r) {
			$series[] = array('name' => $k, 'data' => $r );
		}
		
		$chart_data = array(
			'xAxis' 	=> array('categories' => $categories),
			'series' 	=> $series,
		);
		return $chart_data;
    }

    public function PieStyleOneData($fields, $params, $data){
    	$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
    	
        $getData = array();
		foreach($data as $key=>$row){
			foreach ($fields as $kf => $vf) {
				$getData[$row[$kf]][] = (int)$row[$vf];
			}
		}

		foreach ($getData as $k => $r) {
			$series[] = array($k, array_sum($r));
		}
		$chart_data = array(
			'series' 	=> $series,
		);
		return $chart_data;
	}
	
	public function BarBasicStyleOneData($fields, $params, $data){
    	$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
    	
		$getData = array();
		$categories = array();
		foreach ($fields as $kf => $vf) {
			$categories[] = (string)$kf;
		}
		foreach ($fields as $kf => $vf) {
			$series[] = $vf;
		}
		
		$chart_data = array(
			'xAxis' 	=> array('categories' => $categories, 'title' => array('text' => 'Nama Provinsi') ),
			'series' 	=> array( array('name' => 'Tahun '.date('Y').'', 'data' => $series) ),
		);
		// echo '<pre>';print_r($chart_data);die;
		return $chart_data;
    }

    public function LineStyleOneData($fields, $params, $data){
    	$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
    	
        $getData = array();
		foreach($data as $key=>$row){
			foreach ($fields as $kf => $vf) {
				$getData[$kf][$row['bulan']-1] = (int)$row[$vf];
			}
		}
		
		for ($i=0; $i < 12; $i++) { 
			foreach ($fields as $kf2 => $vf2) {
				if(!isset($getData[$kf2][$i])){
					$getData[$kf2][$i] = 0;
				}
				ksort($getData[$kf2]);
			}
			$categories[] = $CI->tanggal->getBulan($i+1);
			
		}

		foreach ($getData as $k => $r) {
			$series[] = array('name' => $k, 'data' => $r );
		}
		
		$chart_data = array(
			'xAxis' 	=> array('categories' => $categories),
			'series' 	=> $series,
		);
		return $chart_data;
    }

    public function TableStyleOneData($fields, $params, $data){
    	$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
    	
        $html = '';
        $html .='<table class="table table-bordered table-hover"><thead>
			        <tr><th width="20px" class="center">No</th>';
		        foreach ($fields as $kf => $vf) {
		        	$html .= '<th>'.ucfirst($kf).'</th>';
		        }
      	$html .='</thead>';
      	$html .='<tbody>';
      	$no=0;
      	foreach ($data as $key => $value) { $no++;
      		$html .='<tr>';
	      	$html .='<td align="center">'.$no.'</td>';
	      	foreach ($fields as $keyf => $valuef) {
	      		$html .='<td align="left">'.ucwords(strtolower($value[$valuef])).'</td>';
	      	}
	      	$html .='</tr>';
      	}
      	
      	$html .='</tbody>';
      	$html .='</table>';

        $chart_data = array(
			'xAxis' 	=> 0,
			'series' 	=> $html,
		);
		return $chart_data;
    }
	
}

?>