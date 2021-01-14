<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_data_final extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'kebencanaan/T_data_final');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('kebencanaan/T_data_final_model', 'T_data_final');
        /*enable profiler*/
        $this->output->enable_profiler(false);
        /*profile class*/
        $this->title = ($this->lib_menus->get_menu_by_class(get_class($this)))?$this->lib_menus->get_menu_by_class(get_class($this))->name : 'Title';

    }

    public function index() {
        /*define variable data*/
        $data = array(
            'title' => $this->title,
            'breadcrumbs' => $this->breadcrumbs->show()
        );
        /*load view index*/
        $this->load->view('T_data_final/index', $data);
    }

    public function form($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'kebencanaan/T_data_final/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->T_data_final->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'kebencanaan/T_data_final/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_data_final/form', $data);
    }

    public function form_data_awal($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'kebencanaan/T_data_final/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->T_data_final->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'kebencanaan/T_data_final/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_data_final/form_data_awal', $data);
    }
  
    /*function for view data only*/
    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'kebencanaan/T_data_final/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->T_data_final->get_by_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_data_final/form', $data);
    }

    public function show_detail( $id )
    {
        $fields = $this->T_data_final->list_fields();
        $data = $this->T_data_final->get_by_id( $id );
        $html = $this->master->show_detail_row_table( $fields, $data );      

        echo json_encode( array('html' => $html) );
    }

    public function get_data()
    {
        /*get data from model*/
        $list = $this->T_data_final->get_datatables();
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
                            '.$this->authuser->show_button_dropdown('kebencanaan/T_data_final', array('R','U','D') ,$row_list->id_bencana).'   
                        </ul>
                      </div></div>';
            
            $row[] = '<div class="center">'.$row_list->id_bencana.'</div>';
            $row[] = $row_list->nama_bencana;
            $row[] = $this->tanggal->formatDateFormDmy($row_list->tanggal_kejadian).' - '.$row_list->jam_kejadian;
            $row[] = $row_list->nama_prov.', '.$row_list->nama_kab.', '.$row_list->nama_kec.', '.$row_list->alamat;
            $row[] = $row_list->nama_level;
            $row[] = $row_list->ket_level;
            // $row[] = ($row_list->is_active == 'Y') ? '<div class="center"><span class="label label-sm label-success">Active</span></div>' : '<div class="center"><span class="label label-sm label-danger">Not active</span></div>';
            $row[] = $this->logs->show_logs_record_datatable($row_list);
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->T_data_final->count_all(),
                        "recordsFiltered" => $this->T_data_final->count_filtered(),
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
        $val->set_rules('provinsiHidden', 'Provinsi', 'trim');
        $val->set_rules('kotaHidden', 'Kab/Kota', 'trim');
        $val->set_rules('kecamatanHidden', 'Kecamatan', 'trim|required');
        $val->set_rules('kelurahanHidden', 'Kelurahan', 'trim');
        $val->set_rules('latitude', 'Latitude', 'trim');
        $val->set_rules('longitude', 'Longitude', 'trim');
        $val->set_rules('alamat', 'Alamat Lengkap', 'trim|required');
        $val->set_rules('tanggal_kejadian', 'Tanggal Kejadian', 'trim|required');
        $val->set_rules('jam_kejadian', 'Jam', 'trim|required');
        $val->set_rules('wilayah_terdampak', 'Wilayah Terdampak', 'trim');
        $val->set_rules('penyebab', 'Penyebab', 'trim');
        $val->set_rules('kronologis', 'Kronologis', 'trim');
        $val->set_rules('bantuan_bnpb', 'Bantuan BNPB', 'trim');
        $val->set_rules('level_bencana', 'Level Bencana', 'trim|required');
        $val->set_rules('status_bencana', 'Status Bencana', 'trim|required');

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
                'alamat' => $this->regex->_genRegex( $val->set_value('alamat') , 'RGXQSL'),
                'tanggal_kejadian' => $this->regex->_genRegex( $this->tanggal->sqlDateForm( $val->set_value('tanggal_kejadian') ) , 'RGXQSL'),
                'jam_kejadian' => $this->regex->_genRegex( $val->set_value('jam_kejadian') , 'RGXQSL'),
                'wilayah_terdampak' => $this->regex->_genRegex( $val->set_value('wilayah_terdampak') , 'RGXQSL'),
                'penyebab' => $this->regex->_genRegex( $val->set_value('penyebab') , 'RGXQSL'),
                'kronologis' => $this->regex->_genRegex( $val->set_value('kronologis') , 'RGXQSL'),
                'bantuan_bnpb' => $this->regex->_genRegex( $val->set_value('bantuan_bnpb') , 'RGXQSL'),
                'level_bencana' => $this->regex->_genRegex( $val->set_value('level_bencana') , 'RGXINT'),
                'status_bencana' => $this->regex->_genRegex( $val->set_value('status_bencana') , 'RGXINT'),
            );

            // print_r($dataexc);die;
            if(isset($_FILES['foto_default'] ['name']) AND $_FILES['foto_default'] ['name'] != ''){
                /*hapus dulu file yang lama*/
                if( $id != 0 ){
                    $res_dt = $this->T_data_final->get_by_id($id);
                    if($res_dt->foto_default != NULL){
                        if (file_exists(PATH_IMG_CONTENT.$res_dt->foto_default.'')) {
                            unlink(PATH_IMG_CONTENT.$res_dt->foto_default.'');
                        }    
                    }
                }
                $dataexc['foto_default'] = $this->upload_file->doUpload('foto_default', PATH_IMG_CONTENT);
            }
            
            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*save post data*/
                $this->T_data_final->save($dataexc);
                $newId = $this->db->insert_id();
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*update record*/
                $this->T_data_final->update(array('id_bencana' => $id), $dataexc);
                $newId = $id;
            }

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Gagal Dilakukan'));
            }
            else
            {
                $this->db->trans_commit();
                echo json_encode(array('status' => 200, 'message' => 'Proses Berhasil Dilakukan'));
            }
        }
    }

    public function delete()
    {
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        $toArray = explode(',',$id);
        if($id!=null){
            if($this->T_data_final->delete_by_id($toArray)){
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
