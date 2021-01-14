<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tmp_mst_menu extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'setting/Tmp_mst_menu');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('Tmp_mst_menu_model', 'Tmp_mst_menu');
        /*enable profiler*/
        $this->output->enable_profiler(false);
        /*profile class*/
        $this->title = ($this->lib_menus->get_menu_by_class(get_class($this)))?$this->lib_menus->get_menu_by_class(get_class($this))->name : 'Title';

    }

    public function index() { 
        //echo '<pre>';print_r($this->session->all_userdata());
        /*define variable data*/
        $data = array(
            'title' => $this->title,
            'breadcrumbs' => $this->breadcrumbs->show()
        );
        /*load view index*/
        $this->load->view('Tmp_mst_menu/index', $data);
    }

    public function form($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'Tmp_mst_menu/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->Tmp_mst_menu->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'Tmp_mst_menu/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('Tmp_mst_menu/form', $data);
    }
    /*function for view data only*/
    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'Tmp_mst_menu/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->Tmp_mst_menu->get_by_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('Tmp_mst_menu/form', $data);
    }


    public function get_data()
    {
        /*get data from model*/
        $list = $this->Tmp_mst_menu->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->menu_id.'"/>
                            <span class="lbl"></span>
                        </label>
                      </div>';
            $row[] = '<div class="center">
                        '.$this->authuser->show_button('setting/Tmp_mst_menu','R',$row_list->menu_id,2).'
                        '.$this->authuser->show_button('setting/Tmp_mst_menu','U',$row_list->menu_id,2).'
                        '.$this->authuser->show_button('setting/Tmp_mst_menu','D',$row_list->menu_id,2).'
                      </div>'; 
            $row[] = '<div class="center">'.$row_list->menu_id.'</div>';
            $row[] = ucwords($row_list->name);
            $row[] = $row_list->modul_name;
            $row[] = ucfirst($row_list->class);
            $row[] = $row_list->link;
            $row[] = '<div class="center">'.$row_list->level.'</div>';
            $row[] = $row_list->icon;
            $row[] = '<div class="center">'.$row_list->counter.'</div>';
            $row[] = ($row_list->is_active == 'Y') ? '<div class="center"><span class="label label-sm label-success">Active</span></div>' : '<div class="center"><span class="label label-sm label-danger">Not active</span></div>';
            $row[] = $this->logs->show_logs_record_datatable($row_list);
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Tmp_mst_menu->count_all(),
                        "recordsFiltered" => $this->Tmp_mst_menu->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function process()
    {
       
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('modul_id', 'Modul', 'trim|required|integer');
        $val->set_rules('name', 'Name', 'trim|required');
        $val->set_rules('class', 'Class', 'trim|required|xss_clean');
        $val->set_rules('link', 'Link', 'trim|required|xss_clean');
        $val->set_rules('icon', 'Icon', 'trim|xss_clean');
        $val->set_rules('level', 'Level', 'trim|required|xss_clean|integer');
        $val->set_rules('counter', 'Counter', 'trim|required|xss_clean|integer');
        $val->set_rules('parent', 'Parent', 'trim|xss_clean|integer');
        $val->set_rules('description', 'Description', 'trim|xss_clean');
        $val->set_rules('is_active', 'Is Active', 'trim|xss_clean|alpha');
        $val->set_rules('set_shortcut', 'Set Shortcut', 'trim|xss_clean|alpha');

        $val->set_message('required', "Silahkan isi field \"%s\"");
        $val->set_message('integer', "Field \"%s\" harus diisi dengann angka");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            $id = ($this->input->post('id'))?$this->regex->_genRegex($this->input->post('id'),'RGXINT'):0;

            $dataexc = array(
                'modul_id' => $this->regex->_genRegex($val->set_value('modul_id'),'RGXINT'),
                'name' => $this->regex->_genRegex($val->set_value('name'),'RGXQSL'),
                'class' => $this->regex->_genRegex($val->set_value('class'),'RGXQSL'),
                'link' => $this->regex->_genRegex($val->set_value('link'),'RGXQSL'),
                'icon' => $this->regex->_genRegex($val->set_value('icon'),'RGXQSL'),
                'parent' => $this->regex->_genRegex($val->set_value('parent'),'RGXINT'),
                'counter' => $this->regex->_genRegex($val->set_value('counter'),'RGXINT'),
                'level' => $this->regex->_genRegex($val->set_value('level'),'RGXINT'),
                'description' => $this->regex->_genRegex($val->set_value('description'),'RGXQSL'),
                'is_active' => $this->regex->_genRegex($val->set_value('is_active'),'RGXAZ'),
                'set_shortcut' => $this->regex->_genRegex($val->set_value('set_shortcut'),'RGXAZ'),
                'is_deleted' => $this->regex->_genRegex('N','RGXAZ'),
            );
            
            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                $newId = $this->Tmp_mst_menu->save($dataexc);
                /*save logs*/
                /*$this->logs->save('tmp_mst_menu', $newId, 'insert new record on '.$this->title.' module', json_encode($dataexc),'menu_id');*/
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*print_r($dataexc);die;*/
                /*update record*/
                $this->Tmp_mst_menu->update(array('menu_id' => $id), $dataexc);
                $newId = $id;
                /*$this->logs->save('tmp_mst_menu', $newId, 'update record'.$this->title.' module', json_encode($dataexc), 'menu_id');*/
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
        $id=$this->input->post('ID')?$this->regex->_genRegex($this->input->post('ID',TRUE),'RGXQSL'):null;
        $toArray = explode(',',$id);
        if($id!=null){
            if($this->Tmp_mst_menu->delete_by_id($toArray)){
                $this->logs->save('tmp_mst_menu', $id, 'delete record', '', 'menu_id');
                echo json_encode(array('status' => 200, 'message' => 'Proses Hapus Data Berhasil Dilakukan'));

            }else{
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Hapus Data Gagal Dilakukan'));
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }


}


/* End of file example.php */
/* Location: ./application/modules/example/controllers/example.php */
