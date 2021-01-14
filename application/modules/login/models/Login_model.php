<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function check_account($usr, $pass) {
        /*get hash password*/
        $data = $this->get_hash_password($usr);
        /*validate account*/
        if($data){
            if($this->bcrypt->check_password($pass, $data->password)){
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function get_hash_password($usr){

        $query = $this->db->select('tmp_user.*, tmp_user_profile.path_foto')
                          ->select('(SELECT GROUP_CONCAT(tmp_mst_role.`name` SEPARATOR "/") AS role 
                                        FROM tmp_user_has_role 
                                        LEFT JOIN tmp_mst_role ON tmp_mst_role.`role_id`=tmp_user_has_role.role_id 
                                    WHERE user_id=tmp_user.user_id) as role')
                          ->join('tmp_user_profile','tmp_user_profile.user_id=tmp_user.user_id','left')
                          ->get_where('tmp_user', array('username' => $usr, 'tmp_user.is_active' => 'Y'))->row();
        if($query){
            return $query;
        }else{
            return false;
        }
    }

    public function get_sess_menus($user_id){

        /*get session menu by role*/
        $getData = [];
        $find_menus = $this->find_menus($user_id, 0);  
        foreach($find_menus as $row){
            /*find sub menus*/
            $find_sub_menus = $this->find_menus($user_id, $row->menu_id); 
            $row->sub_menus = $find_sub_menus;
            $getData[] = $row;
        }
        return $getData;
    }

    function find_menus($user_id, $parent) {

        $this->db->select('tmp_role_has_menu.menu_id,tmp_mst_menu.name,tmp_mst_menu.class,tmp_mst_menu.link,tmp_mst_menu.level,tmp_mst_menu.parent,tmp_mst_menu.icon,tmp_mst_menu.counter,tmp_role_has_menu.role_id');
        $this->db->from('tmp_role_has_menu');
        $this->db->join('tmp_mst_menu','tmp_mst_menu.menu_id=tmp_role_has_menu.menu_id');
        $this->db->where('tmp_role_has_menu.role_id IN (SELECT role_id FROM tmp_user_has_role WHERE user_id='.$user_id.') ');
        $this->db->where(array('tmp_mst_menu.is_active' => 'Y', 'tmp_mst_menu.parent' => $parent));
        $this->db->group_by('tmp_role_has_menu.menu_id,tmp_mst_menu.name,tmp_mst_menu.class,tmp_mst_menu.link,tmp_mst_menu.level,tmp_mst_menu.parent,tmp_mst_menu.icon,tmp_mst_menu.counter,tmp_role_has_menu.role_id');
        $this->db->order_by('tmp_mst_menu.counter', 'ASC');
        return $this->db->get()->result();
    }

    public function generate_token($user_id){

        $static_str='Login';
        $currenttimeseconds = date("mdY_His");
        $token_id=$static_str.$user_id.$currenttimeseconds;
        $data = array(
                 'token' => md5($token_id),
                 'type' => $static_str,
                 'created_date' => date('Y-m-d H:i:s'),
                 'user_id' => $user_id,
                 );
        $this->db->insert('token', $data);
        return md5($token_id);
    }

    public function clear_token($user_id){
        return $this->db->delete('token', array('user_id' => $user_id));
    }

    public function get_user_profile($user_id){
        $profile = $this->db->get_where('tmp_user_profile', array('user_id' => $user_id))->row();

        if(!empty($profile)){
            return $profile;
        }else{
            return false;
        }
    }

}
