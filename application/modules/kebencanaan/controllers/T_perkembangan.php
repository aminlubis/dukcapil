<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_perkembangan extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'kebencanaan/T_perkembangan');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('kebencanaan/T_perkembangan_model', 'T_perkembangan');
        /*enable profiler*/
        $this->output->enable_profiler(false);
        /*profile class*/
        $this->title = ($this->lib_menus->get_menu_by_class(get_class($this)))?$this->lib_menus->get_menu_by_class(get_class($this))->name : 'Title';

    }

    public function index() {
        /*define variable data*/
        $data = array(
            'title' => 'Perkembangan Bencana',
            'breadcrumbs' => $this->breadcrumbs->show(),
            'id_bencana' => ( $_GET['id_bencana'] ) ? $_GET['id_bencana'] : '' ,
        );
        /*load view index*/
        $this->load->view('T_perkembangan/index', $data);
    }

    public function form($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'kebencanaan/T_perkembangan/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->T_perkembangan->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'kebencanaan/T_perkembangan/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_perkembangan/form', $data);
    }

    /*function for view data only*/
    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'kebencanaan/T_perkembangan/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->T_perkembangan->get_by_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_perkembangan/form', $data);
    }

    public function show_detail( $id )
    {
        $fields = $this->T_perkembangan->list_fields();
        $data = $this->T_perkembangan->get_by_id( $id );
        $html = $this->master->show_detail_row_table( $fields, $data );      

        echo json_encode( array('html' => $html) );
    }

    public function click_edit( $id ){
        $data = $this->T_perkembangan->get_by_id( $id );
        echo json_encode( $data );
    }

    public function get_data()
    {
        /*get data from model*/
        $list = $this->T_perkembangan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center"><label class="pos-rel">
                        <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->id_bencana_perkembangan.'"/>
                        <span class="lbl"></span>
                    </label></div>';
            $row[] = '<div class="center"><div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">
                            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-inverse">
                            <li><a href="#" onclick="click_edit('.$row_list->id_bencana_perkembangan.')">Update</a></li> 
                            <li><a href="#" onclick="click_delete('.$row_list->id_bencana_perkembangan.')">Delete</a></li> 
                        </ul>
                      </div></div>';
            
            $row[] = '<div class="center">'.$row_list->id_bencana_perkembangan.'</div>';
            $row[] = $this->tanggal->formatDateFormDmy($row_list->tanggal).' '.$row_list->waktu.' '.$row_list->zona_waktu;
            $row[] = $row_list->kendala;
            $row[] = $row_list->kondisi;
            $row[] = $row_list->kebutuhan;
            $row[] = $this->logs->show_logs_record_datatable($row_list);
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->T_perkembangan->count_all(),
                        "recordsFiltered" => $this->T_perkembangan->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function process()
    {
        // print_r($_POST);die;
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('id_bencana', 'Id Bencana', 'trim|required');
        $val->set_rules('tanggal', 'Tanggal', 'trim|required');
        $val->set_rules('waktu', 'Jam', 'trim');
        $val->set_rules('zona_waktu', 'Zona Waktu', 'trim');
        $val->set_rules('kendala', 'Kendala', 'trim');
        $val->set_rules('kondisi', 'Kondisi', 'trim|required');
        $val->set_rules('kebutuhan', 'Kebutuhan', 'trim');

        // $val->set_rules('dampak', 'Dampak', 'trim');
        // $val->set_rules('upaya', 'Upaya', 'trim');
       
        // $val->set_rules('relawan', 'Relawan', 'trim');
        // $val->set_rules('logistik', 'Logistik', 'trim');
        // $val->set_rules('kerusakan', 'Kerusakan', 'trim');
        // $val->set_rules('korban', 'Korban', 'trim');
        
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
                'id_bencana' => $this->regex->_genRegex( $val->set_value('id_bencana'), 'RGXINT' ), 
                'tanggal' => $this->regex->_genRegex( $val->set_value('tanggal'), 'RGXQSL' ), 
                'waktu' => $this->regex->_genRegex( $val->set_value('waktu'), 'RGXQSL' ), 
                'zona_waktu' => $this->regex->_genRegex( $val->set_value('zona_waktu'), 'RGXQSL' ), 
                'kendala' => $this->regex->_genRegex( $val->set_value('kendala'), 'RGXQSL' ), 
                'kondisi' => $this->regex->_genRegex( $val->set_value('kondisi'), 'RGXQSL' ), 
                'kebutuhan' => $this->regex->_genRegex( $val->set_value('kebutuhan'), 'RGXQSL' ), 
                // 'dampak' => $this->regex->_genRegex( $val->set_value('dampak'), 'RGXQSL' ), 
                // 'upaya' => $this->regex->_genRegex( $val->set_value('upaya'), 'RGXQSL' ), 
                // 'relawan' => $this->regex->_genRegex( $val->set_value('relawan'), 'RGXQSL' ), 
                // 'logistik' => $this->regex->_genRegex( $val->set_value('logistik'), 'RGXQSL' ), 
                // 'kerusakan' => $this->regex->_genRegex( $val->set_value('kerusakan'), 'RGXQSL' ), 
                // 'korban' => $this->regex->_genRegex( $val->set_value('korban'), 'RGXQSL' ), 
            );
            
            // print_r($dataexc);die;

            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*save post data*/
                $this->T_perkembangan->save($dataexc);
                $newId = $this->db->insert_id();
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*update record*/
                $this->T_perkembangan->update(array('id_bencana_perkembangan' => $id), $dataexc);
                $newId = $id;
            }

            // update t bencana
            $update_bencana = array();
            $update_bencana['updated_date'] = date('Y-m-d H:i:s');
            $update_bencana['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
            $this->db->update('t_bencana', $update_bencana, array('id_bencana' => $dataexc['id_bencana']) );

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Gagal Dilakukan'));
            }
            else
            {
                $this->db->trans_commit();
                echo json_encode(array('status' => 200, 'message' => 'Proses Berhasil Dilakukan', 'id_bencana' => $newId));
            }
        }
    }

    public function delete()
    {
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        $toArray = explode(',',$id);
        if($id!=null){
            if($this->T_perkembangan->delete_by_id($toArray)){
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
