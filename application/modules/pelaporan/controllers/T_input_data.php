<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_input_data extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'pelaporan/T_input_data');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('pelaporan/T_input_data_model', 'T_input_data');
        
        /*enable profiler*/
        $this->output->enable_profiler(false);
        /*profile class*/
        $this->title = ($this->lib_menus->get_menu_by_class(get_class($this)))?$this->lib_menus->get_menu_by_class(get_class($this))->name : 'Title';

    }

    public function index() {
        /*define variable data*/
        // echo '<pre>'; print_r($this->session->all_userdata());die;
        $data = array(
            'title' => $this->title,
            'flag' => 'create',
            'breadcrumbs' => $this->breadcrumbs->show()
        );
        /*load view index*/
        $this->load->view('T_input_data/form', $data);
    }

    public function form_flag()
    {
        // reg id
        $id = ($_GET['reg_id'])?$_GET['reg_id']:'';
        $type = $_GET['flag'];

        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'pelaporan/T_input_data/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->T_input_data->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'pelaporan/T_input_data/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['type'] = $type;
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        if(in_array($type, array('ayah','ibu', 'saksi_1', 'saksi_2', 'pelapor'))){
            $this->load->view('T_input_data/form_flag', $data);
        }else if($type == 'bayi'){
            $this->load->view('T_input_data/form_bayi', $data);
        }else{
            $this->load->view('T_input_data/form_adm', $data);
        }
    }

    public function get_data()
    {
        /*get data from model*/
        $list = $this->T_input_data->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center"><label class="pos-rel">
                        <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->id.'"/>
                        <span class="lbl"></span>
                    </label></div>';
            $row[] = '';
            $row[] = $row_list->id;
            $row[] = '<div class="center"><div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">
                            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-inverse">
                            '.$this->authuser->show_button_dropdown('pencarian/T_input_data', array('R','U','D') ,$row_list->id).'   
                            <li><a href="'.base_url().'Templates/GenerateHtml/ExecutiveSummary/'.$row_list->id.'" target="_blank">Download Summary</a></li>
                        </ul>
                      </div></div>';
            
            $row[] = '<div class="center">'.$row_list->id.'</div>';
            $row[] = $row_list->nik;
            $row[] = $row_list->nama;
            $row[] = $row_list->tgl_lhr;
            $row[] = '<div class="center">'.strtoupper($row_list->flag_type).'</div>';
            $row[] = $this->logs->show_logs_record_datatable($row_list);
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->T_input_data->count_all(),
                        "recordsFiltered" => $this->T_input_data->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }


    public function process()
    {
        $this->load->library('form_validation');
        $val = $this->form_validation;

        $val->set_rules('type', 'Tipe Form', 'trim|required');
        $val->set_rules('nik', 'NIK', 'trim|required');
        $val->set_rules('nama', 'Nama Lengkap', 'trim|required');
        $val->set_rules('tgl_lhr', 'Tanggal Lahir', 'trim|required');
    
        if( in_array($_POST['type'], array('ibu', 'ayah', 'saksi_1', 'saksi_2', 'pelapor')) ){
            $val->set_rules('jenis_pekerjaan', 'Jenis Pekerjaan', 'trim|required');
            $val->set_rules('alamat', 'Alamat', 'trim|required');
            $val->set_rules('rt', 'RT', 'trim|required');
            $val->set_rules('rw', 'RW', 'trim|required');
            $val->set_rules('provinsiHidden', 'Provinsi', 'trim|required');
            $val->set_rules('kotaHidden', 'Kab/Kota', 'trim|required');
            $val->set_rules('kecamatanHidden', 'Kecamatan', 'trim|required');
            $val->set_rules('kelurahanHidden', 'Kelurahan', 'trim');
            $val->set_rules('kewarganegaraan', 'Kewarganegaraan', 'trim|required');
        }else if($_POST['type'] == 'bayi'){
            $val->set_rules('jk', 'Jenis Kelamin', 'trim|required');
            $val->set_rules('tempat_dilahirkan', 'Tempat Dilahirkan', 'trim');
            $val->set_rules('tempat_kelahiran', 'Tempat Kelahiran', 'trim');
            $val->set_rules('jam_lhr', 'Jam Kelahiran', 'trim|required');
            $val->set_rules('lhr_ke', 'Kelahiran Ke', 'trim|required');
            $val->set_rules('jenis_kelahiran', 'Jenis Kelahiran', 'trim|required');
            $val->set_rules('penolong_kelahiran', 'Penolong Kelahiran', 'trim|required');
            $val->set_rules('bb', 'Berat Badan', 'trim|required');
            $val->set_rules('panjang', 'Panjang Badan', 'trim|required');
            $val->set_rules('no_kk', 'No. KK', 'trim|required');
            $val->set_rules('nama_kk', 'Nama Kepala Keluarga', 'trim|required');    
        }
        
        $val->set_rules('kebangsaan', 'Kebangsaan', 'trim');
        $val->set_rules('tgl_perkawinan', 'Tanggal Perkawinan', 'trim');
        $val->set_rules('tgl_lapor', 'Tanggal lapor', 'trim');



        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            $register_id = ($this->input->post('reg_id'))?$this->input->post('reg_id'):0;
            $id = ($this->input->post('id'))?$this->input->post('id'):0;

            $dataexc = array(
                'flag_type' => $this->regex->_genRegex( $_POST['type'] , 'RGXQSL'),
                'nik' => $this->regex->_genRegex( $val->set_value('nik') , 'RGXQSL'),
                'nama' => $this->regex->_genRegex( $val->set_value('nama') , 'RGXQSL'),
                'jk' => $this->regex->_genRegex( $val->set_value('jk') , 'RGXQSL'),
                'tmp_lhr' => $this->regex->_genRegex( $val->set_value('tempat_kelahiran') , 'RGXQSL'),
                'tgl_lhr' => $this->regex->_genRegex( $val->set_value('tgl_lhr') , 'RGXQSL'),
                'jam_lhr' => $this->regex->_genRegex( $val->set_value('jam_lhr') , 'RGXQSL'),
                'pekerjaan' => $this->regex->_genRegex( $val->set_value('jenis_pekerjaan') , 'RGXQSL'),
                'provinsi' => $this->regex->_genRegex( $val->set_value('provinsiHidden') , 'RGXQSL'),
                'kabkota' => $this->regex->_genRegex( $val->set_value('kotaHidden') , 'RGXQSL'),
                'kecamatan' => $this->regex->_genRegex( $val->set_value('kecamatanHidden') , 'RGXQSL'),
                'kelurahan' => $this->regex->_genRegex( $val->set_value('kelurahanHidden') , 'RGXQSL'),
                'alamat' => $this->regex->_genRegex( $val->set_value('alamat') , 'RGXQSL'),
                'rt' => $this->regex->_genRegex( $val->set_value('rt') , 'RGXQSL'),
                'rw' => $this->regex->_genRegex( $val->set_value('rw') , 'RGXQSL'),
                'jenis_kelahiran' => $this->regex->_genRegex( $val->set_value('jenis_kelahiran') , 'RGXQSL'),
                'tempat_dilahirkan' => $this->regex->_genRegex( $val->set_value('tempat_dilahirkan') , 'RGXQSL'),
                'penolong_kelahiran' => $this->regex->_genRegex( $val->set_value('penolong_kelahiran') , 'RGXQSL'),
                'bb' => $this->regex->_genRegex( $val->set_value('bb') , 'RGXQSL'),
                'panjang' => $this->regex->_genRegex( $val->set_value('panjang') , 'RGXQSL'),
                'lhr_ke' => $this->regex->_genRegex( $val->set_value('lhr_ke') , 'RGXQSL'),
                'tgl_perkawinan' => $this->regex->_genRegex( $val->set_value('tgl_perkawinan') , 'RGXQSL'),
                'no_kk' => $this->regex->_genRegex( $val->set_value('no_kk') , 'RGXQSL'),
                'nama_kk' => $this->regex->_genRegex( $val->set_value('nama_kk') , 'RGXQSL'),
                'tgl_lapor' => $this->regex->_genRegex( $val->set_value('tgl_lapor') , 'RGXQSL'),
                'kewarganegaraan' => $this->regex->_genRegex( $val->set_value('kewarganegaraan') , 'RGXQSL'),
                'kebangsaan_wna' => $this->regex->_genRegex( $val->set_value('kebangsaan_wna') , 'RGXQSL'),
            );

            // cek reg id exist
            if($register_id == 0){
                // insert registrasi firs
                
                $this->db->insert('t_registrasi', array('status_data' => 1, 'created_date' => date('Y-m-d H:i:s'), 'created_by' => json_encode(array('user_id' => $this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL'))) ) );
                $reg_id = $this->db->insert_id();
            }else{
                $reg_id = $register_id;
            }
            
            if($id==0){
                $dataexc['reg_id'] = $reg_id;
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' => $this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*save post data*/
                $newId = $this->T_input_data->save($dataexc);
            }else{
                $dataexc['reg_id'] = $reg_id;
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*update record*/
                $this->T_input_data->update(array('id' => $id), $dataexc);
                $newId = $id;
            }

            if($_POST['type'] == 'bayi'){
                $format_no_reg = $this->master->formatNoReg($reg_id);
                $this->db->update('t_registrasi', array('bayi_id' => $newId, 'no_reg' => $format_no_reg), array('id' => $reg_id) );
            }
            

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Gagal Dilakukan'));
            }
            else
            {

                $this->db->trans_commit();
                echo json_encode(array('status' => 200, 'message' => 'Proses Berhasil Dilakukan', 'reg_id' => $reg_id, 'flag' => $_POST['type'], 'ktp_id' => $newId));
            }
        }
    }

    public function process_adm()
    {
        // print_r($_POST);die;
        $this->load->library('form_validation');
        $val = $this->form_validation;

        $val->set_rules('type', 'Type', 'trim');

        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            $register_id = ($this->input->post('reg_id'))?$this->input->post('reg_id'):0;
            
            // cek reg id exist
            if($register_id == 0){
                // insert registrasi first
                $this->db->insert('t_registrasi', array('no_reg' => '00'.$this->master->get_max_number('t_registrasi', 'id'),  'status_data' => 1) );
                $reg_id = $this->db->insert_id();
            }else{
                $reg_id = $register_id;
            }

            foreach ($_POST as $key => $value) {
                if ( !in_array($key, array('type','reg_id', 'submit')) ) {
                    $this->db->insert('t_registrasi_data_adm', array('reg_id' =>$reg_id, 'flag' => $key, 'created_date' => date('Y-m-d H:i:s'), 'created_by' => json_encode(array('user_id' => $this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')))) );
                    $this->db->trans_commit();
                }
            }
            // print_r($_POST);die;

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Gagal Dilakukan'));
            }
            else
            {

                $this->db->trans_commit();
                echo json_encode(array('status' => 200, 'message' => 'Proses Berhasil Dilakukan', 'reg_id' => $reg_id, 'flag' => $_POST['type']));
            }
        }
    }

    public function delete()
    {
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        $toArray = explode(',',$id);
        if($id!=null){
            if($this->T_input_data->delete_by_id($toArray)){
                echo json_encode(array('status' => 200, 'message' => 'Proses Hapus Data Berhasil Dilakukan'));
            }else{
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Hapus Data Gagal Dilakukan'));
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }


}


/* End of file Gender.php */
/* Location: ./application/modules/product_type/controllers/product_type.php */
