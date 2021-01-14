<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_bencana extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'kebencanaan/T_bencana');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('kebencanaan/T_bencana_model', 'T_bencana');
        
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
            'breadcrumbs' => $this->breadcrumbs->show()
        );
        /*load view index*/
        $this->load->view('T_bencana/index', $data);
    }

    public function form($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'kebencanaan/T_bencana/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->T_bencana->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'kebencanaan/T_bencana/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_bencana/form', $data);
    }

    public function form_data_awal($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'kebencanaan/T_bencana/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->T_bencana->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'kebencanaan/T_bencana/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_bencana/form_data_awal', $data);
    }

    

    /*function for view data only*/
    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'kebencanaan/T_bencana/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->T_bencana->get_by_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_bencana/form', $data);
    }

    public function show_detail( $id )
    {
        $fields = $this->T_bencana->list_fields();
        $data = $this->T_bencana->get_by_id( $id );
        $html = $this->master->show_detail_row_table( $fields, $data );      

        echo json_encode( array('html' => $html) );
    }

    public function get_data()
    {
        /*get data from model*/
        $list = $this->T_bencana->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center"><label class="pos-rel">
                        <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->id_bencana.'"/>
                        <span class="lbl"></span>
                    </label></div>';
            $row[] = '';
            $row[] = $row_list->id_bencana;
            $row[] = '<div class="center"><div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">
                            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-inverse">
                            '.$this->authuser->show_button_dropdown('kebencanaan/T_bencana', array('R','U','D') ,$row_list->id_bencana).'   
                            <li><a href="'.base_url().'Templates/GenerateHtml/ExecutiveSummary/'.$row_list->id_bencana.'" target="_blank">Download Summary</a></li>
                        </ul>
                      </div></div>';
            
            $row[] = '<div class="center">'.$row_list->id_bencana.'</div>';
            $row[] = $row_list->nama_bencana;
            $row[] = $this->tanggal->formatDateFormDmy($row_list->tanggal_kejadian).' - '.$row_list->jam_kejadian.' '.$row_list->zona_waktu;
            $row[] = $row_list->nama_prov;
            $row[] = $row_list->nama_level;
            $row[] = $row_list->nama_status_bencana;
            // $row[] = ($row_list->is_active == 'Y') ? '<div class="center"><span class="label label-sm label-success">Active</span></div>' : '<div class="center"><span class="label label-sm label-danger">Not active</span></div>';
            $row[] = $this->logs->show_logs_record_datatable($row_list);
            $row[] = '<div class="center"><a href="#" class="btn btn-xs btn-white btn-primary" onclick="set_data_final('.$row_list->id_bencana.')">Set Data Final <i class="fa fa-angle-double-down"></i> </a></div>';
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->T_bencana->count_all(),
                        "recordsFiltered" => $this->T_bencana->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function process()
    {
        
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('nama_bencana', 'Nama Bencana', 'trim|required');
        $val->set_rules('jenis_bencana', 'Jenis Bencanan', 'trim|required');
        $val->set_rules('penanggung_jawab', 'Penanggung Jawab', 'trim|required');
        $val->set_rules('provinsiHidden', 'Provinsi', 'trim|required');
        $val->set_rules('kotaHidden', 'Kab/Kota', 'trim');
        $val->set_rules('kecamatanHidden', 'Kecamatan', 'trim');
        $val->set_rules('kelurahanHidden', 'Kelurahan', 'trim');
        $val->set_rules('latitude', 'Latitude', 'trim|required');
        $val->set_rules('longitude', 'Longitude', 'trim|required');
        // $val->set_rules('alamat', 'Alamat Lengkap', 'trim');
        $val->set_rules('tanggal_kejadian', 'Tanggal Kejadian', 'trim|required');
        $val->set_rules('jam_kejadian', 'Jam', 'trim|required');
        $val->set_rules('zona_waktu', 'Zona Waktu', 'trim|required');
        $val->set_rules('wilayah_terdampak', 'Wilayah Terdampak', 'trim');
        // $val->set_rules('penyebab', 'Penyebab', 'trim');
        $val->set_rules('kronologis', 'Kronologis', 'trim');
        $val->set_rules('bantuan_bnpb', 'Bantuan BNPB', 'trim');
        $val->set_rules('level_bencana', 'Level Bencana', 'trim|required');
        $val->set_rules('status_bencana', 'Status Bencana', 'trim');
        $val->set_rules('no_sk_darurat', 'No SK Darurat', 'trim');

        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            $id = ($this->input->post('id'))?$this->input->post('id'):0;

            $dataexc = array(
                'nama_bencana' => $this->regex->_genRegex( $val->set_value('nama_bencana') , 'RGXQSL'),
                'jenis_bencana' => $this->regex->_genRegex( $val->set_value('jenis_bencana') , 'RGXQSL'),
                'penanggung_jawab' => $this->regex->_genRegex( $val->set_value('penanggung_jawab') , 'RGXQSL'),
                'provinsi' => $this->regex->_genRegex( $val->set_value('provinsiHidden') , 'RGXQSL'),
                'kabkota' => $this->regex->_genRegex( $val->set_value('kotaHidden') , 'RGXQSL'),
                'kecamatan' => $this->regex->_genRegex( $val->set_value('kecamatanHidden') , 'RGXQSL'),
                'kelurahan' => $this->regex->_genRegex( $val->set_value('kelurahanHidden') , 'RGXQSL'),
                'latitude' => $this->regex->_genRegex( $val->set_value('latitude') , 'RGXQSL'),
                'longitude' => $this->regex->_genRegex( $val->set_value('longitude') , 'RGXQSL'),
                // 'alamat' => $this->regex->_genRegex( $val->set_value('alamat') , 'RGXQSL'),
                'tanggal_kejadian' => $this->regex->_genRegex( $val->set_value('tanggal_kejadian') , 'RGXQSL'),
                'jam_kejadian' => $this->regex->_genRegex( $val->set_value('jam_kejadian') , 'RGXQSL'),
                'zona_waktu' => $this->regex->_genRegex( $val->set_value('zona_waktu') , 'RGXQSL'),
                'wilayah_terdampak' => $this->regex->_genRegex( $val->set_value('wilayah_terdampak') , 'RGXQSL'),
                // 'penyebab' => $this->regex->_genRegex( $val->set_value('penyebab') , 'RGXQSL'),
                'kronologis' => $this->regex->_genRegex( $val->set_value('kronologis') , 'RGXQSL'),
                'bantuan_bnpb' => $this->regex->_genRegex( $val->set_value('bantuan_bnpb') , 'RGXQSL'),
                'level_bencana' => $this->regex->_genRegex( $val->set_value('level_bencana') , 'RGXINT'),
                'status_bencana' => $this->regex->_genRegex( $val->set_value('status_bencana') , 'RGXINT'),
                'no_sk_darurat' => $this->regex->_genRegex( $val->set_value('no_sk_darurat') , 'RGXQSL'),
            );

            // foto cover bencana
            if(isset($_FILES['foto_default'] ['name']) AND $_FILES['foto_default'] ['name'] != ''){
                /*hapus dulu file yang lama*/
                if( $id != 0 ){
                    $res_dt = $this->T_bencana->get_by_id($id);
                    if($res_dt->foto_default != NULL){
                        if (file_exists(PATH_IMG_CONTENT.$res_dt->foto_default.'')) {
                            unlink(PATH_IMG_CONTENT.$res_dt->foto_default.'');
                        }    
                    }
                }
                $dataexc['foto_default'] = $this->upload_file->doUpload('foto_default', PATH_IMG_CONTENT);
            }

            // lampiran SK
            if(isset($_FILES['lampiran_sk'] ['name']) AND $_FILES['lampiran_sk'] ['name'] != ''){
                /*hapus dulu file yang lama*/
                if( $id != 0 ){
                    $res_dt = $this->T_bencana->get_by_id($id);
                    if($res_dt->lampiran_sk != NULL){
                        if (file_exists(PATH_IMG_CONTENT.$res_dt->lampiran_sk.'')) {
                            unlink(PATH_IMG_CONTENT.$res_dt->lampiran_sk.'');
                        }    
                    }
                }
                $dataexc['lampiran_sk'] = $this->upload_file->doUpload('lampiran_sk', PATH_IMG_CONTENT);
            }
            
            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' => $this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*save post data*/
                $this->T_bencana->save($dataexc);
                $newId = $this->db->insert_id();
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*update record*/
                $this->T_bencana->update(array('id_bencana' => $id), $dataexc);
                $newId = $id;
            }

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Gagal Dilakukan'));
            }
            else
            {
                // send topic
                $this->sentToTopic($newId);

                $this->db->trans_commit();
                echo json_encode(array('status' => 200, 'message' => 'Proses Berhasil Dilakukan', 'id' => $newId));
            }
        }
    }

    public function delete()
    {
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        $toArray = explode(',',$id);
        if($id!=null){
            if($this->T_bencana->delete_by_id($toArray)){
                echo json_encode(array('status' => 200, 'message' => 'Proses Hapus Data Berhasil Dilakukan'));
            }else{
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Hapus Data Gagal Dilakukan'));
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }

    public function set_data_final()
    {
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        if($id!=null){
            if( $this->T_bencana->update(array('id_bencana' => $id), array('status_data' => 'final') ) ){
                echo json_encode(array('status' => 200, 'message' => 'Proses Data Berhasil Dilakukan'));
            }else{
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Data Gagal Dilakukan'));
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }

    private function sentToTopic($id)
    {
        // load library
        $this->load->library('Firebase');
        $firebase = $this->firebase;
        $data = $this->T_bencana->get_by_id($id);
        if (is_null($data->notif_sent_at)) {
            $this->T_bencana->update( array('id_bencana' => $id), array('notif_sent_at' => date('Y-m-d H:i:s'), 'channel' => 'private-1_'.$id.'' ) );
            $firebase->createDataPayload([
                'id' => (string)$data->id_bencana,
                'title' => (string)$data->nama_bencana,
                'body' => (string)$data->kronologis,
                'created_at' => strtotime(date('Y-m-d H:i:s')),
            ])->sendToTopic('disaster');
        }
    }

    public function find_data()
    {   
        $output = array( "data" => http_build_query($_POST) . "\n" );
        echo json_encode($output);
    }


}


/* End of file Gender.php */
/* Location: ./application/modules/product_type/controllers/product_type.php */
