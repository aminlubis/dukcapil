<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_find_data extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'pencarian/T_find_data');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('pencarian/T_find_data_model', 'T_find_data');
        $this->load->model('pencarian/T_pencatatan_model', 'T_pencatatan');
        
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
        $this->load->view('T_find_data/index', $data);
    }

    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'pencarian/T_pencatatan/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->T_pencatatan->get_by_reg_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        // echo '<pre>'; print_r($data);die;
        /*load form view*/
        $this->load->view('T_find_data/view', $data);
    }

    public function show_detail( $id )
    {
        $fields = $this->T_find_data->list_fields();
        $data = $this->T_find_data->get_by_id( $id );
        $html = $this->master->show_detail_row_table( $fields, $data );      

        echo json_encode( array('html' => $html) );
    }

    public function get_data()
    {
        /*get data from model*/
        $list = $this->T_pencatatan->get_datatables();
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
                            '.$this->authuser->show_button_dropdown('pencarian/T_find_data', array('R','U','D') ,$row_list->id).'   
                        </ul>
                      </div></div>';
            
            $row[] = '<div class="center">'.$row_list->id.'</div>';
            $row[] = $row_list->no_reg;
            $row[] = $row_list->no_akta;
            $row[] = $row_list->nik;
            $row[] = $row_list->nama;
            $row[] = $row_list->tgl_lhr;
            $row[] = $row_list->jk;
            $row[] = $row_list->nama_kk;
            $row[] = $this->logs->show_logs_record_datatable($row_list);
            $status_txt = $this->master->get_custom_data('global_parameter', 'label', array('flag' => 'status_proses', 'value' => $row_list->status_data), 'row');
            $row[] = ($row_list->status_data == 1) ? '<div class="center"><span class="label label-sm label-warning">'.$status_txt->label.'</span></div>' : '<div class="center"><span class="label label-sm label-success">'.$status_txt->label.'</span></div>';
            $row[] = '<div class="center"><a href="#" class="btn btn-xs btn-white btn-primary" onclick="getMenu('."'pencarian/T_find_data/show/".$row_list->id."'".')">Tampilkan data <i class="fa fa-angle-double-down"></i> </a></div>';
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->T_pencatatan->count_all(),
                        "recordsFiltered" => $this->T_pencatatan->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function find_data()
    {   
        $output = array( "data" => http_build_query($_POST) . "\n" );
        echo json_encode($output);
    }


}


/* End of file Gender.php */
/* Location: ./application/modules/product_type/controllers/product_type.php */
