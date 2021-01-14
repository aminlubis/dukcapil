<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_logistik extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'kebencanaan/T_logistik');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('kebencanaan/T_logistik_model', 'T_logistik');
        /*enable profiler*/
        $this->output->enable_profiler(false);
        /*profile class*/
        $this->title = ($this->lib_menus->get_menu_by_class(get_class($this)))?$this->lib_menus->get_menu_by_class(get_class($this))->name : 'Title';

    }

    public function index() {
        /*define variable data*/
        $data = array(
            'title' => 'Logistik & Peralatan',
            'breadcrumbs' => $this->breadcrumbs->show(),
            'id_bencana' => ( $_GET['id_bencana'] ) ? $_GET['id_bencana'] : '' ,
        );
        /*load view index*/
        $this->load->view('T_logistik/index', $data);
    }

    public function form($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'kebencanaan/T_logistik/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->T_logistik->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'kebencanaan/T_logistik/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_logistik/form', $data);
    }

    /*function for view data only*/
    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'kebencanaan/T_logistik/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->T_logistik->get_by_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_logistik/form', $data);
    }

    public function show_detail( $id )
    {
        $fields = $this->T_logistik->list_fields();
        $data = $this->T_logistik->get_by_id( $id );
        $html = $this->master->show_detail_row_table( $fields, $data );      

        echo json_encode( array('html' => $html) );
    }

    public function click_edit( $id ){
        $data = $this->T_logistik->get_by_id( $id );
        echo json_encode( $data );
    }

    public function get_data()
    {
        /*get data from model*/
        $list = $this->T_logistik->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center"><label class="pos-rel">
                        <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->id_bencana_logistik.'"/>
                        <span class="lbl"></span>
                    </label></div>';
            $row[] = '<div class="center"><div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">
                            <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-inverse">
                            <li><a href="#" onclick="click_edit('.$row_list->id_bencana_logistik.')">Update</a></li> 
                            <li><a href="#" onclick="click_delete('.$row_list->id_bencana_logistik.')">Delete</a></li> 
                        </ul>
                      </div></div>';
            
            $row[] = '<div class="center">'.$row_list->id_bencana_logistik.'</div>';
            $row[] = $this->tanggal->formatDateFormDmy($row_list->tanggal);
            $row[] = $row_list->nama_logistik;
            $row[] = $row_list->jenis_logistik;
            $row[] = $row_list->total_tersedia.' ( '.$row_list->satuan.' )';
            $row[] = $row_list->keterangan;
            $row[] = $row_list->flag;
            $row[] = $this->logs->show_logs_record_datatable($row_list);
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->T_logistik->count_all(),
                        "recordsFiltered" => $this->T_logistik->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function process()
    {
        
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('id_bencana', 'Id Bencana', 'trim|required');
        $val->set_rules('nama_logistik', 'Item Logistik', 'trim|required');
        $val->set_rules('jenis_logistik', 'Jenis Logistik', 'trim|required');
        $val->set_rules('tanggal', 'Tanggal', 'trim');
        $val->set_rules('total_tersedia', 'Jumlah', 'trim|required');
        $val->set_rules('satuan', 'Satuan', 'trim|required');
        $val->set_rules('keterangan', 'Keterangan', 'trim');
        $val->set_rules('tipe_flag_logistik', 'Tipe Flag', 'trim');

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
                'nama_logistik' => $this->regex->_genRegex( $val->set_value('nama_logistik'), 'RGXQSL' ), 
                'jenis_logistik' => $this->regex->_genRegex( $val->set_value('jenis_logistik'), 'RGXQSL' ), 
                'tanggal' => $this->regex->_genRegex( $val->set_value('tanggal') , 'RGXQSL' ), 
                'total_tersedia' => $this->regex->_genRegex( $val->set_value('total_tersedia'), 'RGXQSL' ), 
                'keterangan' => $this->regex->_genRegex( $val->set_value('keterangan'), 'RGXQSL' ), 
                'satuan' => $this->regex->_genRegex( $val->set_value('satuan'), 'RGXQSL' ), 
                'flag' => $this->regex->_genRegex( $val->set_value('tipe_flag_logistik'), 'RGXQSL' ), 
            );
            
            // print_r($dataexc);die;

            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*save post data*/
                $this->T_logistik->save($dataexc);
                $newId = $this->db->insert_id();
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*update record*/
                $this->T_logistik->update(array('id_bencana_logistik' => $id), $dataexc);
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
            if($this->T_logistik->delete_by_id($toArray)){
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
