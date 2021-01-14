<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tmp_user extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'setting/Tmp_user');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('Tmp_user_model', 'Tmp_user');

        /*load library*/
        $this->load->library('bcrypt');
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
        $this->load->view('Tmp_user/index', $data);
    }

    public function form($id='')
    {
        /*if id is not null then will show form edit*/
        if( $id != '' ){
            /*breadcrumbs for edit*/
            $this->breadcrumbs->push('Edit '.strtolower($this->title).'', 'Tmp_user/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
            /*get value by id*/
            $data['value'] = $this->Tmp_user->get_by_id($id);
            /*initialize flag for form*/
            $data['flag'] = "update";
        }else{
            /*breadcrumbs for create or add row*/
            $this->breadcrumbs->push('Add '.strtolower($this->title).'', 'Tmp_user/'.strtolower(get_class($this)).'/form');
            /*initialize flag for form add*/
            $data['flag'] = "create";
        }
        /*title header*/
        $data['title'] = $this->title;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('Tmp_user/form', $data);
    }
    /*function for view data only*/
    public function show($id)
    {
        /*breadcrumbs for view*/
        $this->breadcrumbs->push('View '.strtolower($this->title).'', 'Tmp_user/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*define data variabel*/
        $data['value'] = $this->Tmp_user->get_by_id($id);
        $data['title'] = $this->title;
        $data['flag'] = "read";
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('Tmp_user/form', $data);
    }


    public function get_data()
    {
        /*get data from model*/
        $list = $this->Tmp_user->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->user_id.'"/>
                            <span class="lbl"></span>
                        </label>
                      </div>';
            $row[] = '<div class="center">
                        '.$this->authuser->show_button('setting/Tmp_user','R',$row_list->user_id,2).'
                        '.$this->authuser->show_button('setting/Tmp_user','U',$row_list->user_id,2).'
                        '.$this->authuser->show_button('setting/Tmp_user','D',$row_list->user_id,2).'
                      </div>'; 
            $row[] = '<div class="center">'.$row_list->user_id.'</div>';
            $row[] = strtoupper($row_list->fullname);
            $row[] = $row_list->email;
            $row[] = $row_list->username;
            $row[] = ($row_list->is_active == 'Y') ? '<div class="center"><span class="label label-sm label-success">Active</span></div>' : '<div class="center"><span class="label label-sm label-danger">Not active</span></div>';
            $row[] = $this->logs->show_logs_record_datatable($row_list);
                   
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Tmp_user->count_all(),
                        "recordsFiltered" => $this->Tmp_user->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function process()
    {
       
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('fullname', 'Fullname', 'trim|required');
        $val->set_rules('email', 'Email', 'trim|required|valid_email');
        $val->set_rules('username', 'Username', 'trim|required');
        $val->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $val->set_rules('confirm', 'Password Confirmation', 'trim|required|matches[password]');
        $val->set_rules('is_active', 'Is Active', 'trim|xss_clean');
        $val->set_rules('flag_user', 'Jenis Pengguna', 'trim|xss_clean');

        $val->set_message('required', "Silahkan isi field \"%s\"");
        $val->set_message('matches', "\"%s\" tidak sesuai dengan password");
        $val->set_message('valid_email', "\"%s\" tidak valid");
        $val->set_message('min_length', "\"%s\" minimal 6 karakter");

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
                'fullname' => $this->regex->_genRegex($val->set_value('fullname'),'RGXQSL'),
                'username' => $this->regex->_genRegex($val->set_value('username'),'RGXQSL'),
                'email' => $this->regex->_genRegex($val->set_value('email'),'RGXQSL'),
                'password' => $this->bcrypt->hash_password($val->set_value('password')),
                'is_active' => $this->regex->_genRegex($val->set_value('is_active'),'RGXAZ'),
                'is_deleted' => $this->regex->_genRegex('N','RGXAZ'),
                'flag_user' => $this->regex->_genRegex($val->set_value('flag_user'),'RGXAZ'),
            );
            //print_r($dataexc);die;
            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*save post data*/
                $newId = $this->Tmp_user->save($dataexc);
                $this->logs->save('tmp_user', $newId, 'insert new record', json_encode($dataexc), 'user_id');
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                /*update record*/
                $this->Tmp_user->update(array('user_id' => $id), $dataexc);
                $newId = $id;
                $this->logs->save('tmp_user', $newId, 'update record', json_encode($dataexc), 'user_id');
            }
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Gagal Dilakukan'));
            }
            else
            {
                $this->db->trans_commit();
                //redirect(base_url().'login/logout');
                echo json_encode(array('status' => 200, 'message' => 'Proses Berhasil Dilakukan'));
            }
        }
    }

    public function process_profile_user()
    {

        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('fullname_user', 'Nama Lengkap', 'trim|required');
        $val->set_rules('pob', 'Tempat Lahir', 'trim|required');
        $val->set_rules('dob', 'Tanggal Lahir', 'trim|required');
        $val->set_rules('no_telp', 'No Telp', 'trim');
        $val->set_rules('address', 'Alamat', 'trim');
        $val->set_rules('facebook', 'Facebook', 'trim');
        $val->set_rules('twitter', 'Twitter', 'trim');
        $val->set_rules('instagram', 'Instagram', 'trim');
        $val->set_rules('about_me', 'Quote', 'trim');
        $val->set_rules('gender', 'Gender', 'trim|required');
        $val->set_rules('user_id', 'User ID', 'trim|required');

        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            $id = ($this->input->post('user_id'))?$this->regex->_genRegex($this->input->post('user_id'),'RGXINT'):0;

            $dataexc = array(
                'fullname' => $this->regex->_genRegex($val->set_value('fullname_user'),'RGXQSL'),
                'pob' => $this->regex->_genRegex($val->set_value('pob'),'RGXQSL'),
                'dob' => $this->regex->_genRegex($val->set_value('dob'),'RGXQSL'),
                'address' => $this->regex->_genRegex($val->set_value('address'),'RGXQSL'),
                'no_telp' => $this->regex->_genRegex($val->set_value('no_telp'),'RGXQSL'),
                'facebook' => $this->regex->_genRegex($val->set_value('facebook'),'RGXQSL'),
                'twitter' => $this->regex->_genRegex($val->set_value('twitter'),'RGXQSL'),
                'instagram' => $this->regex->_genRegex($val->set_value('instagram'),'RGXQSL'),
                'about_me' => $this->regex->_genRegex($val->set_value('about_me'),'RGXQSL'),
                'gender' => $this->regex->_genRegex($val->set_value('gender'),'RGXAZ'),
                'user_id' => $this->regex->_genRegex($val->set_value('user_id'),'RGXINT'),
            );
            

            if(isset($_FILES['images']['name'])){
                /*hapus dulu file yang lama*/
                if( $id != 0 ){
                    $profile = $this->Tmp_user->get_by_id($val->set_value('user_id'));
                    if ($profile->path_foto != NULL) {
                        unlink(PATH_PHOTO_PROFILE_DEFAULT.$profile->path_foto.'');
                    }
                }

                $dataexc['path_foto'] = $this->upload_file->doUpload('images', PATH_PHOTO_PROFILE_DEFAULT);
            }
            //echo '<pre>';print_r($id);die;
            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                $this->db->insert('tmp_user_profile', $dataexc);
                $newId = $this->db->insert_id();
                $this->logs->save('tmp_user_profile', $newId, 'insert new record on '.$this->title.' module', json_encode($dataexc),'user_id');
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
                $this->db->update('tmp_user_profile', $dataexc, array('user_id' => $id));
                $newId = $id;
                 /*save logs*/
                $this->logs->save('tmp_user_profile', $newId, 'update record on '.$this->title.' module', json_encode($dataexc),'user_id');
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
            if($this->Tmp_user->delete_by_id($toArray)){
                $this->logs->save('tmp_user', $id, 'delete record', '', 'user_id');
                echo json_encode(array('status' => 200, 'message' => 'Proses Hapus Data Berhasil Dilakukan'));

            }else{
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Hapus Data Gagal Dilakukan'));
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }

    public function account_setting()
    {
        /*if id is not null then will show form edit*/
        $id=$this->session->userdata('user')->user_id;

        /*breadcrumbs for edit*/
        $this->breadcrumbs->push('Account Setting', 'Tmp_user/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*get value by id*/
        $data['value'] = $this->Tmp_user->get_by_id($id);
        /*echo '<pre>'; print_r($this->db->last_query());die;*/
        /*initialize flag for form*/
        $data['flag'] = "update";

        /*title header*/
        $data['title'] = 'Account Setting';
        /*show breadcrumbs*/
        $data['breadcrumbs'] = '';//$this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('Tmp_user/form_account_setting', $data);
    }

    public function form_update_profile()
    {
        /*if id is not null then will show form edit*/
        $id=$this->session->userdata('user')->user_id;
        /*breadcrumbs for edit*/
        $this->breadcrumbs->push('Update Profile Amin', 'Tmp_user/'.strtolower(get_class($this)).'/'.__FUNCTION__.'/'.$id);
        /*get value by id*/
        $data['value'] = $this->Tmp_user->get_by_id($id);
        /*echo '<pre>'; print_r($this->session->all_userdata());die;*/
        /*initialize flag for form*/
        $data['flag'] = "update";

        /*title header*/
        $data['title'] = 'Profile '.$this->session->userdata('user')->fullname;
        /*show breadcrumbs*/
        $data['breadcrumbs'] = '';//$this->breadcrumbs->show();
        /*load form view*/
        $this->load->view('Tmp_user/form_update_profile', $data);
    }


}


/* End of file example.php */
/* Location: ./application/modules/example/controllers/example.php */
