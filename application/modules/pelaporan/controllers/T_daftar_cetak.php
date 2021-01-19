<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_daftar_cetak extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'pencarian/T_daftar_cetak');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
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
        $this->load->view('T_daftar_cetak/index', $data);
    }

    /*function for view data only*/
    public function preview_print($id)
    {
        $this->load->library('NumbersToWords');
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'pencarian/T_daftar_cetak/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->T_pencatatan->get_by_reg_id($id);
        $data['title'] = $this->title;
        $data['reg_id'] = $id;
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('T_daftar_cetak/preview_print', $data);
    }

    public function show_detail( $id )
    {
        $fields = $this->T_pencatatan->list_fields();
        $data = $this->T_pencatatan->get_by_id( $id );
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
            $row[] = '<div class="center"><a href="#" class="btn btn-xs btn-inverse" onclick="getMenu('."'pelaporan/T_daftar_cetak/preview_print/".$row_list->id."'".')"> <i class="fa fa-print"></i> </a></div>';
                   
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

    public function process()
    {
        
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('ID', 'REG ID', 'trim');

        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            
            // format no akta
            $format_no_akta = $this->master->formatNoAkta($_POST['ID']);

            $dataexc = array(
                'no_akta' => $format_no_akta,
                'tgl_generated_no_akta' => date('Y-m-d'),
                'status_data' => 2,
            );

            $this->db->update('t_registrasi', $dataexc, array('id' => $_POST['ID']) );

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

    public function find_data()
    {   
        $output = array( "data" => http_build_query($_POST) . "\n" );
        echo json_encode($output);
    }


}


/* End of file Gender.php */
/* Location: ./application/modules/product_type/controllers/product_type.php */
