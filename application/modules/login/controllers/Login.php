<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MX_Controller {

    function __construct() {
        parent::__construct();
        /*load libraries*/
        $this->load->library('bcrypt');
        $this->load->library('logs');
        $this->load->library('Form_validation');
        /*load model*/
        $this->load->model('login_model');
        $this->load->model('setting/Tmp_apps_config_model');
    }

    public function index() {
        $data = array(
                'profile_form' => $this->Tmp_apps_config_model->get_by_id(1),
            );

        $this->load->view('login_v1', $data);

    }

    public function process(){

        /*post username*/
        $username = $this->regex->_genRegex($this->input->post('username'), 'RGXQSL');
        /*hash password bcrypt*/
        $password = $this->input->post('password');

        // form validation
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // set message error
        $this->form_validation->set_message('required', "Silahkan isi field \"%s\"");
        $this->form_validation->set_message('min_length', "\"%s\" minimal 6 karakter");

        if ($this->form_validation->run() == FALSE)
        {
            $this->form_validation->set_error_delimiters('<div style="color:white"><i>', '</i></div>');
            //die(validation_errors());
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            //set session expire time, after that user should login again
            $this->session->sess_expiration = 6000;
            $this->session->sess_expire_on_close = FALSE;

            /*check username and password exist*/
            $result = $this->login_model->check_account($username,$password);
            if($result){
                /*clear token existing or before*/
                $this->login_model->clear_token($result->user_id);

                /*save data bellow in session*/
                $sess_data = array(
                    'logged' => TRUE,
                    'user' => $result,
                    'token' => $this->login_model->generate_token($result->user_id),
                    'menus' => $this->login_model->get_sess_menus($result->user_id),
                );
                if($this->login_model->get_user_profile($result->user_id) != false){
                    $sess_data['user_profile'] = $this->login_model->get_user_profile($result->user_id);
                }
                $this->session->set_userdata($sess_data);
                /*update last logon user*/
                $this->db->query("UPDATE tmp_user SET last_logon=now() WHERE username='".$result->username."' AND password='".$result->password."'");
                /*save log activities*/
                $this->logs->save('tmp_user', $result->user_id, 'user loged in', json_encode($sess_data), 'user_id');
                echo json_encode(array('status' => 200, 'message' => 'Login berhasil', 'logged' => TRUE, 'token' =>$sess_data['token'], 'user' => $sess_data['user'], 'user_profile' => isset($sess_data['user_profile'])?$sess_data['user_profile']:[] ));
            }else{
                echo json_encode(array('status' => 301, 'message' => 'Username dan Password tidak sesuai'));
            }
        
        }

    }

    public function logout()
    {   
        $sess_data = array ('user' => NULL,
                            'token' => NULL,
                            'menus' => NULL,
                            'logged'=>false
                            );
        $this->login_model->clear_token($this->session->userdata('user')->user_id);
        $this->session->unset_userdata($sess_data);
        $this->session->sess_destroy();
        redirect(base_url().'login');
    }


}

/* End of file empty_module.php */
/* Location: ./application/modules/empty_module/controllers/empty_module.php */

