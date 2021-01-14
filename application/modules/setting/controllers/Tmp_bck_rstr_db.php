<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tmp_bck_rstr_db extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Index', 'setting/Tmp_bck_rstr_db');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            echo 'Session Expired !'; exit;
        }
        /*load model*/
        $this->load->model('Tmp_bck_rstr_db_model', 'Tmp_bck_rstr_db');
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
            'flag' => 'Create',
            'breadcrumbs' => $this->breadcrumbs->show(),
            'value' => $this->Tmp_bck_rstr_db->get_by_id(1)
        );
        /*load view index*/
        $this->load->view('Tmp_bck_rstr_db/form', $data);
    }

    
    public function process()
    {
       
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('id', 'ID', 'trim|required');
        $val->set_rules('app_name', 'Nama Aplikasi', 'trim|required');
        $val->set_rules('header_title', 'Judul Header Aplikasi', 'trim|required');
        $val->set_rules('footer', 'Teks Footer', 'trim|xss_clean');
        $val->set_rules('running_text', 'Teks Berjalan', 'trim|xss_clean');
        $val->set_rules('author', 'Author', 'trim|xss_clean');
        $val->set_rules('developer_name', 'Nama Developer', 'trim|xss_clean');
        $val->set_rules('db_name', 'DB Name', 'trim|xss_clean');
        $val->set_rules('company_name', 'Nama Perusahaan', 'trim|xss_clean');
        $val->set_rules('icon', 'Icon', 'trim|xss_clean');
        $val->set_rules('app_logo', 'Logo Aplikasi', 'trim|xss_clean');
        $val->set_rules('app_description', 'Description', 'trim|xss_clean');
        $val->set_rules('footer_text_form_login', 'Footer Text Form Login', 'trim|xss_clean');
        $val->set_rules('style_header_color', 'Warna Header', 'trim|xss_clean');

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

            $dataexc = array(
                'app_name' => $this->regex->_genRegex($val->set_value('app_name'),'RGXQSL'),
                'header_title' => $this->regex->_genRegex($val->set_value('header_title'),'RGXQSL'),
                'footer' => $this->regex->_genRegex($val->set_value('footer'),'RGXQSL'),
                'running_text' => $this->regex->_genRegex($val->set_value('running_text'),'RGXQSL'),
                'author' => $this->regex->_genRegex($val->set_value('author'),'RGXQSL'),
                'developer_name' => $this->regex->_genRegex($val->set_value('developer_name'),'RGXQSL'),
                'db_name' => $this->regex->_genRegex($val->set_value('db_name'),'RGXQSL'),
                'company_name' => $this->regex->_genRegex($val->set_value('company_name'),'RGXQSL'),
                'icon' => $this->regex->_genRegex($val->set_value('icon'),'RGXQSL'),
                'app_description' => $this->regex->_genRegex($val->set_value('app_description'),'RGXQSL'),
                'footer_text_form_login' => $this->regex->_genRegex($val->set_value('footer_text_form_login'),'RGXQSL'),
                'style_header_color' => $this->regex->_genRegex($val->set_value('style_header_color'),'RGXQSL'),
                'is_active' => 'Y',
            );

            if(isset($_FILES['icon']['name'])){
                /*hapus dulu file yang lama*/
                if( $id != 0 ){
                    $profile = $this->Tmp_bck_rstr_db->get_by_id(1);
                    if ($profile->app_logo != NULL) {
                        unlink(PATH_IMG_DEFAULT.$profile->app_logo.'');
                    }
                }
                $dataexc['app_logo'] = $this->upload_file->doUpload('icon', PATH_IMG_DEFAULT);
            }

            if(isset($_FILES['cover_login']['name'])){
                /*hapus dulu file yang lama*/
                if( $id != 0 ){
                    $profile = $this->Tmp_bck_rstr_db->get_by_id(1);
                    if ($profile->cover_login != NULL) {
                        unlink(PATH_IMG_DEFAULT.$profile->cover_login.'');
                    }
                }
                $dataexc['cover_login'] = $this->upload_file->doUpload('cover_login', PATH_IMG_DEFAULT);
            }

            $dataexc['updated_date'] = date('Y-m-d H:i:s');
            $dataexc['updated_by'] = json_encode(array('user_id' =>$this->regex->_genRegex($this->session->userdata('user')->user_id,'RGXINT'), 'fullname' => $this->regex->_genRegex($this->session->userdata('user')->fullname,'RGXQSL')));
            $this->db->update('tmp_profile_app', $dataexc, array('id' => $id));
                $newId = $id;
            $this->logs->save('tmp_profile_app', $newId, 'update record on '.$this->title.'', json_encode($dataexc),'id');

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

}


/* End of file example.php */
/* Location: ./application/modules/example/controllers/example.php */
