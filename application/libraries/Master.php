<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class Master {


    function get_tahun($nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$year = array();
		$now = date('Y');
		for ($i=$now-2; $i < $now+2 ; $i++) { 
			$year[] = $i;
		}
		$data = $year;

		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Silahkan pilih - </option>';

				foreach($data as $row){
					$sel = $nid==$row?'selected':'';
					$field.='<option value="'.$row.'" '.$sel.' >'.strtoupper($row).'</option>';
				}	
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function custom_selection_radio($custom=array(), $nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		if(isset($custom['where_in'])){
			$db->where_in($custom['where_in']['col'],$custom['where_in']['val']);
			$data = $db->get($custom['table'])->result_array();

		}else if(isset($custom['like'])&&isset($custom['where'])){
			$db->like($custom['like']['col'],$custom['like']['val']);
			$db->where($custom['where']);
			$data = $db->get($custom['table'])->result_array();
		}else{
			$data = $db->where($custom['where'])->get($custom['table'])->result_array();
		}

		$field='';

		$field.='<div class="checkbox">';
		foreach($data as $row){
			$sel = $nid==$row[$custom['id']]?'checked':'';
			$field.='<label>';
			$field.='<input type="checkbox" name="'.$name.'" class="ace" value="'.$row[$custom['id']].'" '.$sel.'>';
			$field.='<span class="lbl"> '.$row[$custom['name']].' </span>';
			$field.='</label>';
		}	
		$field.='</div>';
			
		
		return $field;
		
    }
    
    function get_bulan($nid='',$name,$id,$class='',$required='',$inline='') {
		//print_r($nid);die;
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$year = array();
		for ($i=1; $i < 13 ; $i++) { 
			$list = array(
				'key' => $i,
				'value' => $CI->tanggal->getBulan($i),
				);
			$year[] = $list;
		}
		$data = $year;

		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.=$fieldset.'
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="0" '.$selected.'> - Silahkan pilih - </option>';

				foreach($data as $row){
					$sel = $nid==$row['key']?'selected':'';
					$field.='<option value="'.$row['key'].'" '.$sel.' >'.strtoupper($row['value']).'</option>';
				}	
			
		$field.='
		</select>
		'.$fieldsetend;
		
		return $field;
		
    }

    function custom_selection($custom=array(), $nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		if(isset($custom['where_in'])){
			$db->where_in($custom['where_in']['col'],$custom['where_in']['val']);
			$data = $db->get($custom['table'])->result_array();

		}else if(isset($custom['where'])&&isset($custom['where_in'])){
			$db->where_in($custom['where_in']['col'],$custom['where_in']['val']);
			$db->where($custom['where']);
			$data = $db->get($custom['table'])->result_array();
		}else if(isset($custom['like'])&&isset($custom['where'])){
			$db->like($custom['like']['col'],$custom['like']['val']);
			$db->where($custom['where']);
			$data = $db->get($custom['table'])->result_array();
		}else{
			$data = $db->where($custom['where'])->get($custom['table'])->result_array();
		}
        //$data = $db->where($custom['where'])->get($custom['table'])->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.='
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - Silahkan pilih - </option>';

				foreach($data as $row){
					$sel = $nid==$row[$custom['id']]?'selected':'';
					$field.='<option value="'.$row[$custom['id']].'" '.$sel.' >'.strtoupper($row[$custom['name']]).'</option>';
				}	
			
		$field.='
		</select>
		';
		
		return $field;
		
    }

    function custom_selection_with_db_selected($custom=array(), $nid='',$name,$id,$class='',$required='',$inline='', $load_db) {
		
		$CI =&get_instance();
		$db = $CI->load->database($load_db, TRUE);
		
		if(isset($custom['where_in'])){
			$db->where_in($custom['where_in']['col'],$custom['where_in']['val']);
			$data = $db->get($custom['table'])->result_array();

		}else if(isset($custom['where'])&&isset($custom['where_in'])){
			$db->where_in($custom['where_in']['col'],$custom['where_in']['val']);
			$db->where($custom['where']);
			$data = $db->get($custom['table'])->result_array();
		}else if(isset($custom['like'])&&isset($custom['where'])){
			$db->like($custom['like']['col'],$custom['like']['val']);
			$db->where($custom['where']);
			$data = $db->get($custom['table'])->result_array();
		}else{
			$data = $db->where($custom['where'])->get($custom['table'])->result_array();
		}
        //$data = $db->where($custom['where'])->get($custom['table'])->result_array();
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.='
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - Silahkan pilih - </option>';

				foreach($data as $row){
					$sel = $nid==$row[$custom['id']]?'selected':'';
					$field.='<option value="'.$row[$custom['id']].'" '.$sel.' >'.strtoupper($row[$custom['name']]).'</option>';
				}	
			
		$field.='
		</select>
		';
		
		return $field;
		
    }

    function custom_selection_checkbox($custom=array(), $nid='',$name, $id, $class='', $required='', $inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		if(isset($custom['where_in'])){
			$db->where_in($custom['where_in']['col'],$custom['where_in']['val']);
			$data = $db->get($custom['table'])->result_array();

		}else if(isset($custom['where'])&&isset($custom['where_in'])){
			$db->where_in($custom['where_in']['col'],$custom['where_in']['val']);
			$db->where($custom['where']);
			$data = $db->get($custom['table'])->result_array();
		}else if(isset($custom['like'])&&isset($custom['where'])){
			$db->like($custom['like']['col'],$custom['like']['val']);
			$db->where($custom['where']);
			$data = $db->get($custom['table'])->result_array();
		}else{
			$data = $db->where($custom['where'])->get($custom['table'])->result_array();
		}
        //$data = $db->where($custom['where'])->get($custom['table'])->result_array();
		
		$selected = explode(',', $nid);
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.='<div class="checkbox">';
		foreach($data as $row){
			if( in_array($row[$custom['name']], $selected)){
				$checked = 'checked';
			}else{
				$checked = '';
			}
			$field.='
	              <label>
	                <input name="'.$name.'" type="checkbox" class="ace" value="'.$row[$custom['name']].'" '.$checked.'>
	                <span class="lbl"> '.ucwords( $row[$custom['name']] ).' </span>
	              </label>
			';
		}	
		$field.='</div>';
			
		
		return $field;
		
    }


    function custom_selection_with_join($custom=array(), $nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		$select = array( $custom['id'], $custom['name'] );
		$db->select( $select );
		foreach ($custom['join'] as $k => $v) {
			$db->join($v['relation_table'],$custom['table'].'.'.$v['relation_ref_id'].'='.$v['relation_table'].'.'.$v['relation_id'],$v['join_type']);
		}
        $db->where($custom['where']);
        foreach ($select as $rw) {
        	$db->group_by($rw, 'ASC');
        }
		$data = $db->get($custom['table'])->result_array();

		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.='
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - Silahkan pilih - </option>';

				foreach($data as $row){
					$sel = $nid==$row[$custom['id']]?'selected':'';
					$field.='<option value="'.$row[$custom['id']].'" '.$sel.' >'.strtoupper($row[$custom['name']]).'</option>';
				}	
			
		$field.='
		</select>
		';
		
		return $field;
		
    }


    function on_change_custom_selection($custom=array(), $nid='',$name,$id,$class='',$required='',$inline='') {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		
		if($nid != ''){
        	$data = $db->where($custom['id'], $nid)
        			   ->where($custom['where'])
        			   ->get($custom['table'])->result_array();
		}else{
			$data = array();
		}
		
		$selected = $nid?'':'selected';
		$readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
		
		$starsign = $required?'*':'';
		
		$fieldset = $inline?'':'<fieldset>';
		$fieldsetend = $inline?'':'</fieldset>';
		
		$field='';
		$field.='
		<select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
			<option value="" '.$selected.'> - Silahkan pilih - </option>';

				foreach($data as $row){
					$sel = $nid==$row[$custom['id']]?'selected':'';
					$field.='<option value="'.$row[$custom['id']].'" '.$sel.' >'.strtoupper($row[$custom['name']]).'</option>';
				}	
			
		$field.='
		</select>
		';
		
		return $field;
		
    }

    function get_change($params=array(), $nid='',$name,$id,$class='',$required='',$inline='') {
        
        $CI =&get_instance();
        $db = $CI->load->database('default', TRUE);
        
        if($nid!=''){
            $data = $db->where($params['id'], $nid)->get($params['table'])->result_array();
        }else{
            $data = array();
        }

        $selected = $nid?'':'selected';
        $readonly = '';//$CI->session->userdata('nrole')=='approver'?'readonly':'';
        
        $starsign = $required?'*':'';
        
        $fieldset = $inline?'':'<fieldset>';
        $fieldsetend = $inline?'':'</fieldset>';
        
        $field='';
        $field.=$fieldset.'
        <select class="'.$class.'" name="'.$name.'" id="'.$id.'" '.$readonly.' '.$required.' >
            <option value="0" '.$selected.'> - Silahkan pilih - </option>';
                foreach($data as $row){
                    $sel = $nid==$row[$params['id']]?'selected':'';
                    $field.='<option value="'.$row[$params['id']].'" '.$sel.' >'.strtoupper($row[$params['name']]).'</option>';
                }
                
            
        $field.='
        </select>
        '.$fieldsetend;
        return $field;
        
    }
    

    function get_custom_data($table, $select, $where, $return) {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$db->select($select);
		$db->from($table);
		$db->where($where);
		$qry = $db->get()->$return();
		return $qry;
		
    }

    function get_max_number($table, $field) {
		
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$db->select_max($field);
		$db->from($table);
		$qry = $db->get()->row();
		/*plus 1*/
		$max_num = $qry->$field + 1 ;
		return $max_num;
		
    }

   	function show_detail_row_table( $fields, $data, $exp_field=[]){

   		$CI =&get_instance();
   		$CI->load->library('session');
   		$sess_role = $CI->session->userdata('user')->role;
   		$html = '<br>';
		$html .= '<div class="row"><div class="col-md-12">';
        $html .= '<b>DETAIL DATA</b><br>';
   		
   		$exp_field_origin = array('is_active','is_deleted','created_date','created_by','updated_date','updated_by','log_id');
		   $merge_exp_field = array_merge($exp_field_origin, $exp_field);
		$html .= '<table>';
   		if($sess_role=='Admin Sistem'){
            foreach ($fields as $key => $value) {
                if(!in_array($value, $exp_field )){
                	$html .= '<tr>';    
                	$html .= '<td width="150px">'.ucfirst($value).'</td><td style="text-align: justify"> '.$data->$value.'</td>';    
                	$html .= '</tr>';    
            	}
            }
   		}else{
            foreach ($fields as $key => $value) {
            	if(!in_array($value, $merge_exp_field )){
					$html .= '<tr>';    
                	$html .= '<td width="150px">'.ucfirst($value).'</td><td> '.$data->$value.'</td>';    
                	$html .= '</tr>';  
            	}
            }
   		}
		$html .= '<table>';
	    $html .= '</div></div">';

   		return $html;

	   }
	   
	   public function formatNoReg($reg_id){
			$CI =&get_instance();
			$db = $CI->load->database('default', TRUE);
			$query = "select (count(no_akta) + 1) as no_urut from t_registrasi where no_akta is not null and tgl_generated_no_akta = '".date('Y-m-d')."' and id != ".$reg_id."";
			$exc_qry = $db->query($query)->row();
			$format = '317406-REG.AL-'.date('dmY').'-000'.$exc_qry->no_urut;

			return $format;
	   }

	   public function formatNoAkta($reg_id){
		$CI =&get_instance();
		$db = $CI->load->database('default', TRUE);
		$query = "select (count(no_akta) + 1) as no_urut from t_registrasi where no_akta is not null and tgl_generated_no_akta = '".date('Y-m-d')."' and id != ".$reg_id."";
		$exc_qry = $db->query($query)->row();
		$format = '3174-AL-'.date('dmY').'-000'.$exc_qry->no_urut;

		return $format;
   }

	   function convert_num_to_text_ind($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->convert_num_to_text_ind($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->convert_num_to_text_ind($nilai/10)." puluh". $this->convert_num_to_text_ind($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->convert_num_to_text_ind($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->convert_num_to_text_ind($nilai/100) . " ratus" . $this->convert_num_to_text_ind($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->convert_num_to_text_ind($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->convert_num_to_text_ind($nilai/1000) . " ribu" . $this->convert_num_to_text_ind($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->convert_num_to_text_ind($nilai/1000000) . " juta" . $this->convert_num_to_text_ind($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->convert_num_to_text_ind($nilai/1000000000) . " milyar" . $this->convert_num_to_text_ind(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->convert_num_to_text_ind($nilai/1000000000000) . " trilyun" . $this->convert_num_to_text_ind(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

}