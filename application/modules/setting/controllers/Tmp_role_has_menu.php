<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tmp_role_has_menu extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'setting/Tmp_role_has_menu');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('Tmp_role_has_menu_model', 'Tmp_role_has_menu');
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
        $this->load->view('Tmp_role_has_menu/index', $data);
    }

    public function form($id='')
    {
        $this->load->library('lib_menus');
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.$this->title.'', 'Tmp_role_has_menu/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->Tmp_role_has_menu->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.$this->title.'', 'Tmp_role_has_menu/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $data['function'] = $this->db->get('tmp_mst_function')->result();
        $data['menus'] = $this->lib_menus->get_master_menus($id);

        /*load form view*/
        $this->load->view('Tmp_role_has_menu/form', $data);
    }
    /*function for view data only*/
    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.$this->title.'', 'Tmp_role_has_menu/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->Tmp_role_has_menu->get_by_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('Tmp_role_has_menu/form', $data);
    }


    public function get_data()
    {
        /*get data from model*/
        $list = $this->Tmp_role_has_menu->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->role_id.'"/>
                            <span class="lbl"></span>
                        </label>
                      </div>';
            $row[] = '<div class="center">
                        '.$this->authuser->show_button('setting/Tmp_role_has_menu','U',$row_list->role_id,2).'
                      </div>'; 
            $row[] = '<div class="center">'.$row_list->role_id.'</div>';
            $row[] = strtoupper($row_list->name);
            $row[] = $row_list->level_name;
            $row[] = $row_list->description;
            $row[] = $this->Tmp_role_has_menu->get_role_menu_by_role_id($row_list->role_id);
            $row[] = ($row_list->is_active == 'Y') ? '<div class="center"><span class="label label-sm label-success">Active</span></div>' : '<div class="center"><span class="label label-sm label-danger">Not active</span></div>';
            $row[] = $this->logs->show_logs_record_datatable($row_list);
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Tmp_role_has_menu->count_all(),
                        "recordsFiltered" => $this->Tmp_role_has_menu->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function process()
    {
       
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('level_id', 'Level', 'trim|required');
        $val->set_rules('name', 'Role Name', 'trim|required');
        $val->set_rules('description', 'Description', 'trim|xss_clean');

        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            $id = ($this->input->post('id'))?$this->regex->_genRegex($this->input->post('id'),'RGXINT'):0;
            $menu_id = $this->input->post('menu_id');
            if($menu_id){
                /*drop menu role*/
                $this->db->delete('tmp_role_has_menu', array('role_id' => $id));
                foreach ($menu_id as $key => $val_menu_id) {
                   if($this->regex->_genRegex($this->input->post($val_menu_id),'RGXINT')){
                        $get_menu_data = $this->db->get_where('tmp_mst_menu', array('menu_id'=>$val_menu_id))->row();
                        /*if not main menu*/
                        if($get_menu_data->parent != 0){
                            /*check main menu is exist*/
                            $main_menu = $this->db->query("SELECT * FROM tmp_role_has_menu WHERE menu_id= (SELECT parent FROM tmp_mst_menu WHERE menu_id=".$val_menu_id." AND role_id=".$id.")")->row();
                            /*if empty main menu*/
                            if(empty($main_menu)){
                                /*then insert first main menu to role has menu*/
                                $data = array(
                                    'role_id' => $this->regex->_genRegex($id,'RGXINT'),
                                    'menu_id' => $this->regex->_genRegex($get_menu_data->parent,'RGXINT'),
                                    'action_code' => 'C,R,U,D',
                                );                   
                                $this->db->insert('tmp_role_has_menu', $data);
                            }

                            $arr = $this->input->post($val_menu_id)?$this->input->post($val_menu_id):[];
                            if(count($arr) > 0){
                                $action_code = implode(',',$arr);
                                $data = array(
                                    'role_id' => $this->regex->_genRegex($id,'RGXINT'),
                                    'menu_id' => $this->regex->_genRegex($val_menu_id,'RGXINT'),
                                    'action_code' => $this->regex->_genRegex($action_code,'RGXQSL'),
                                );                   
                                $this->db->insert('tmp_role_has_menu', $data);
                            }

                        }else{
                            $arr = $this->input->post($val_menu_id)?$this->input->post($val_menu_id):[];
                            if(count($arr) > 0){
                                $action_code = implode(',',$arr);
                                $data = array(
                                    'role_id' => $this->regex->_genRegex($id,'RGXINT'),
                                    'menu_id' => $this->regex->_genRegex($val_menu_id,'RGXINT'),
                                    'action_code' => $this->regex->_genRegex($action_code,'RGXQSL'),
                                );                   
                                $this->db->insert('tmp_role_has_menu', $data);
                            }
                        }
                   }                   
                }
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
            if($this->Tmp_role_has_menu->delete_by_id($toArray)){
                $this->logs->save('tmp_role_has_menu', $id, 'delete record', '', 'role_id');
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
