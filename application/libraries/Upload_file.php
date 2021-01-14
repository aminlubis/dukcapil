<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final Class upload_file
{

    function process($params)
    {
        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);

        $vdir_upload = $params['path'];
        $tipe_file = $_FILES['file']['type'];
        $vfile_upload = $vdir_upload . $params['name'];

        if (move_uploaded_file($_FILES[$params['inputname']]["tmp_name"], $vfile_upload)) {
            return true;
        } else {
            return false;
        }

    }

    function doUpload($inputname, $path)
    {
        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);

        $random = rand(1, 99);
        $unique_filename = str_replace(' ', '_', $random . preg_replace('/\s+/', '', $_FILES['' . $inputname . '']['name']));
        $vfile_upload = $path . $unique_filename;
        $type_file = $_FILES['' . $inputname . '']['type'];
        if (move_uploaded_file($_FILES[$inputname]["tmp_name"], $vfile_upload)) {
            return $unique_filename;
        } else {
            return false;
        }

    }

    function getUploadedFile($wp_id)
    {

        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);

        $html = '';
        $db->where('wp_id', $wp_id);
        $files = $db->get('web_attachment')->result();

        $html = '<h3><b><i class="fa fa-file"></i> Attachment Files</b></h3> <br>';
        $html .= '<table id="attc_table_id" class="table table-striped table-bordered">';
        $html .= '<tr style="background-color:#ec2028; color:white">';
        $html .= '<th width="30px" class="center">No</th>';
        $html .= '<th width="100px">Title</th>';
        $html .= '<th width="100px">Owner</th>';
        $html .= '<th width="100px">Filename</th>';
        $html .= '<th width="70px" class="center">Size</th>';
        $html .= '<th width="100px" class="center">Type</th>';
        $html .= '<th width="100px">Created Date</th>';
        $html .= '<th width="60px" class="center">Download</th>';
        $html .= '<th width="60px" class="center">Delete</th>';
        $html .= '</tr>';
        $no = 1;
        if (count($files) > 0) {
            foreach ($files as $key => $row_list) {
                # code...
                $html .= '<tr id="tr_id_' . $row_list->wa_id . '">';
                $html .= '<td align="center">' . $no . '</td>';
                $html .= '<td align="left">' . $row_list->wa_name . '</td>';
                $html .= '<td align="left">' . $row_list->wa_owner . '</td>';
                $html .= '<td align="left">' . $row_list->wa_filename . '</td>';
                $size_to_kb = $row_list->wa_size / 1024;
                $html .= '<td align="center">' . number_format($size_to_kb) . ' KB</td>';
                $html .= '<td align="center">' . $row_list->wa_type . '</td>';
                $html .= '<td align="center">' . $row_list->created_date . '</td>';
                $html .= '<td align="center"><a href="Templates/Attachment/download_attachment?fname=' . $row_list->wa_fullpath . '" style="color:red">Download</a></td>';
                //$html .= '<td align="center"><a href="#" class="delete_attachment" data-id="'.$row_list->wa_id.'"><i class="fa fa-times-circle red"></i></a></td>';
                $html .= '<td align="center"><a href="#" class="delete_attachment" onclick="delete_attachment(' . $row_list->wa_id . ')"><i class="fa fa-times-circle red"></i></a></td>';
                $html .= '</tr>';
                $no++;
            }
        } else {
            $html .= '<tr><td colspan="9">- File not found -</td></tr>';
        }

        $html .= '</table>';


        return $html;

    }

    function doUploadMultiple($params)
    {
        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);
        $CI->load->library('upload');
        //$CI->load->library('image_lib'); 
        $getData = array();
        foreach ($_FILES['' . $params['name'] . '']['name'] as $i => $values) {

            $_FILES['userfile']['name'] = $_FILES['' . $params['name'] . '']['name'][$i];
            $_FILES['userfile']['type'] = $_FILES['' . $params['name'] . '']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['' . $params['name'] . '']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $_FILES['' . $params['name'] . '']['error'][$i];
            $_FILES['userfile']['size'] = $_FILES['' . $params['name'] . '']['size'][$i];

            $random = rand(1, 99);
            $nama_file_unik = $random . preg_replace('/\s+/', '', $_FILES['' . $params['name'] . '']['name'][$i]);
            $type_file = $_FILES['' . $params['name'] . '']['type'][$i];

            $config = array(
                'allowed_types' => '*',
                'file_name' => $nama_file_unik,
                'max_size' => '999999',
                'overwrite' => TRUE,
                'remove_spaces' => TRUE,
                'upload_path' => $params['path']
            );

            $CI->upload->initialize($config);

            if ($_FILES['userfile']['tmp_name'][$i]) {

                if (!$CI->upload->do_upload()) :
                    $error = array('error' => $CI->upload->display_errors());
                else :

                    $data = array('upload_data' => $CI->upload->data());
                    /*cek attchment exist*/

                    $datainsertattc = array(
                        'product_id' => $params['ref_id'],
                        'file_name' => $nama_file_unik,
                        'size' => $_FILES[$params['name']]['size'][$i],
                        'type' => $type_file,
                        'file_url' => $params['path'] . $nama_file_unik,
                        'is_default' => ($params['name'] == 'image_default') ? 'Y' : 'N',
                        'created_date' => date('Y-m-d H:i:s'),
                        'created_by' => $CI->session->userdata('user')->fullname,
                    );

                    //print_r($datainsertattc);die;
                    $db->insert('cms_product_has_images', $datainsertattc);


                    $getData[] = $datainsertattc;

                endif;

            }

        }

        return $getData;
    }

    function doUploadMultipleWeb($params)
    {
        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);
        $CI->load->library('upload');
        //$CI->load->library('image_lib'); 
        $getData = array();
        $arr_name = explode(',', $_POST['pf_file_name']);

        foreach ($_FILES['' . $params['name'] . '']['name'] as $i => $values) {

            $_FILES['userfile']['name'] = $_FILES['' . $params['name'] . '']['name'][$i];
            $_FILES['userfile']['type'] = $_FILES['' . $params['name'] . '']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $_FILES['' . $params['name'] . '']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $_FILES['' . $params['name'] . '']['error'][$i];
            $_FILES['userfile']['size'] = $_FILES['' . $params['name'] . '']['size'][$i];

            $random = rand(1, 99);
            $nama_file_unik = str_replace(' ', '_', $random . $_FILES['' . $params['name'] . '']['name'][$i]);
            $type_file = $_FILES['' . $params['name'] . '']['type'][$i];

            $config = array(
                'allowed_types' => '*',
                'file_name' => $nama_file_unik,
                'max_size' => '999999',
                'overwrite' => TRUE,
                'remove_spaces' => TRUE,
                'upload_path' => $params['path']
            );

            $CI->upload->initialize($config);

            if ($_FILES['userfile']['tmp_name']) {

                if (!$CI->upload->do_upload()) :
                    $error = array('error' => $CI->upload->display_errors());
                else :

                    $data = array('upload_data' => $CI->upload->data());
                    /*cek attchment exist*/

                    $datainsertattc = array(
                        'reff_table' => $params['table'],
                        'reff_id' => $params['id'],
                        'attc_name' => isset($arr_name[$i]) ? $arr_name[$i] : 'Lampiran File',
                        'owner' => $CI->session->userdata('user')->fullname,
                        'name' => $_FILES['' . $params['name'] . '']['name'][$i],
                        'path' => $nama_file_unik,
                        'fullpath' => $params['path'] . $nama_file_unik,
                        'type' => $type_file,
                        'size' => $_FILES['' . $params['name'] . '']['size'][$i],
                        'created_date' => date('Y-m-d H:i:s'),
                    );
                    $CI->db->insert('web_attachment', $datainsertattc);

                    $getData[] = $datainsertattc;

                endif;

            }

        }

        return $getData;
    }


    function check_existing($params)
    {

        $CI =& get_instance();
        $db = $CI->load->database('default', TRUE);

        $files = $this->getUploadedFile($params, 'data');
        /*if exist file*/
        if (count($files) > 0) {
            foreach ($files as $key => $value) {
                if (file_exists($value->attc_fullpath)) {
                    unlink($value->attc_fullpath);
                }
                $CI->db->delete('tr_attachment', array('wa_id' => $value->wa_id));
            }
        }

        return true;

    }

}