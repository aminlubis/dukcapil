<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends MX_Controller {

    function __construct() {
        parent::__construct();
        /*breadcrumb default*/
        $this->breadcrumbs->push('Home', 'main');

        if($this->session->userdata('logged')!=TRUE){
            redirect(base_url().'login');
        }
        /*load other module*/
        $this->load->module('setting/Tmp_user');
        $this->load->model('setting/Tmp_user_model','Tmp_user');

    }

    public function index() {
        $this->load->library('lib_menus');
        $this->output->enable_profiler(false);
        /*breadcrumb*/
        $this->breadcrumbs->push('Welcome', 'main/'.strtolower(get_class($this)));
         $data = array(
            'title' => 'Dashboard',
            'subtitle' => COMPANY.' (BNPB)',
            'app' => $this->db->get_where('tmp_profile_app', array('id' => 1))->row(),
            'user' => $this->Tmp_user->get_by_id($this->session->userdata('user')->user_id),
            'profile_user' => $this->db->get_where('tmp_user_profile', array('user_id' => $this->session->userdata('user')->user_id))->row(),
            'modul' => $this->lib_menus->get_modules_by_user_id($this->session->userdata('user')->user_id),
            
        );

        $this->template->load($data, 'dashboard');
        
    }

}

/* End of file empty_module.php */
/* Location: ./application/modules/empty_module/controllers/empty_module.php */

