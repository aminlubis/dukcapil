<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Final Class Lib_table
{


    public function schema($tablename)
    {

        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);
        return $this->get_information_schema_column($tablename);

    }

    public function get_information_schema_column($tablename)
    {

        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);
        $db->from('INFORMATION_SCHEMA.COLUMNS');
        $db->where('TABLE_NAME', $tablename);
        return $db->get()->result();

    }

    public function get_column($tablename)
    {
        $schema_info = $this->get_information_schema_column($tablename);
        foreach ($shema_info as $key => $value) {
            # code...
        }
    }

}