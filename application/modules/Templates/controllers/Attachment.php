<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attachment extends MX_Controller {

    /*function constructor*/
    function __construct() {

        parent::__construct();
        /*breadcrumb default*/
        //$this->breadcrumbs->push('Index', 'templates/'.get_class($this).'');
        /*session redirect login if not login*/
        if($this->session->userdata('logged')!=TRUE){
            redirect(base_url().'Login');exit;
        }
        /*load model*/
        $this->load->model('attachment_model');
        $this->load->library('lib_menus');
        /*enable profiler*/
        $this->output->enable_profiler(false);
        $this->title = ($this->lib_menus->get_menu_by_class(get_class($this)))?$this->lib_menus->get_menu_by_class(get_class($this))->name : 'Title';

    }

    public function index() {
        /*define variable data*/
        $data = array(
            'title' => $this->title,
            'breadcrumbs' => $this->breadcrumbs->show()
        );
        /*load view index*/
        $this->load->view('attachment/index', $data);
    }

    public function get_data()
    {
        /*get data from model*/
        $list = $this->attachment_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row_list) {
            $no++;
            $row = array();
            $row[] = '<div class="center"><label class="pos-rel">
                        <input type="checkbox" class="ace" name="selected_id[]" value="'.$row_list->id.'"/>
                        <span class="lbl"></span>
                    </label></div>';
            $row[] = $row_list->id;
            $row[] = '<div class="left">'.$row_list->attc_name.'</div>';
            $row[] = '<div class="center">'.$row_list->owner.'</div>';
            $row[] = '<div class="left">'.$row_list->name.'</div>';
            $row[] = '<div class="center">'.number_format($row_list->size).'</div>';
            $row[] = '<div class="center">'.$row_list->type.'</div>';
            $row[] = '<div class="center">'.$this->tanggal->formatDateForm($row_list->created_date).'</div>';
            $row[] = '<div class="center">Download</div>';
            $row[] = '<div class="center"><div class="hidden-sm hidden-xs action-buttons">
                        '.$this->authuser->show_button('templates/attachment','D',$row_list->id,2).'
                      </div>
                      <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto"><i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                <li>'.$this->authuser->show_button('templates/attachment','D','',4).'</li>
                            </ul>
                        </div>
                    </div></div>';        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->attachment_model->count_all(),
                        "recordsFiltered" => $this->attachment_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function get_attachment($params){
        $list_attachment = $this->attachment_model->get_attachment_by_params($params);
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
        $no=1;
        if(count($list_attachment) > 0){
            foreach ($list_attachment as $key => $row_list) {
                # code...
                $html .= '<tr id="tr_id_'.$row_list->attc_id.'">';
                    $html .= '<td align="center">'.$no.'</td>';
                    $html .= '<td align="left">'.$row_list->attc_filename.'</td>';
                    $html .= '<td align="left">'.$row_list->attc_owner.'</td>';
                    $html .= '<td align="left">'.$row_list->attc_name.'</td>';
                    $size_to_kb = $row_list->attc_size / 1024;
                    $html .= '<td align="center">'.number_format($size_to_kb).' KB</td>';
                    $html .= '<td align="center">'.$row_list->attc_type.'</td>';
                    $html .= '<td align="center">'.$row_list->created_date.'</td>';
                    $html .= '<td align="center"><a href="Templates/attachment/download_attachment?fname='.$row_list->attc_fullpath.'" style="color:red">Download</a></td>';
                    //$html .= '<td align="center"><a href="#" class="delete_attachment" data-id="'.$row_list->attc_id.'"><i class="fa fa-times-circle red"></i></a></td>';
                    
                    $html .= '<td align="center"><a href="#" class="delete_attachment" onclick="delete_attachment('.$row_list->attc_id.')"><i class="fa fa-times-circle red"></i></a></td>';
                $html .= '</tr>';
            $no++;
            }
        }else{
            $html .=  '<tr><td colspan="9">- File not found -</td></tr>';
        }
        
        $html .= '</table>';
        return $html;
    }


    public function download_attachment(){
        $this->load->helper('download');
        $path = ($this->input->get('fname')) ? $this->input->get('fname') : NULL;  
        if(force_download(''.$path.'',NULL)){
            echo 'Download success';
        }else{
            echo 'File doesnt exist';
        }
    }

    public function upload_attachment($params){
        return $this->upload_file->doUploadMultiple($params);
    }

    public function delete_attachment()
    {
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        if($id!=null){
            if($this->attachment_model->delete_attachment_by_id($id)){
                echo json_encode(array('status' => 200, 'message' => 'Proses Hapus Data Berhasil Dilakukan'));
            }else{
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Hapus Data Gagal Dilakukan'));
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }





















    public function process()
    {
        
        /*print_r($_FILES);die;*/

        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('ws_name', 'Product Name', 'trim|required');
        $val->set_rules('ws_date', 'Date', 'trim|required');
        $val->set_rules('content', 'Content', 'trim');

        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            echo json_encode(array('status' => 301, 'message' => validation_errors()));
        }
        else
        {                       
            $this->db->trans_begin();
            $id = ($this->input->post('id'))?$this->input->post('id'):0;

            $dataexc = array(
                'ws_name' => $val->set_value('ws_name'),
                'ws_date' => $val->set_value('ws_date'),
                'ws_description' => $val->set_value('content'),
                'is_active' => $this->input->post('is_active'),
            );

            if($_FILES['images']['name'] != ''){
                /*hapus dulu file yang lama*/
                if( $id != 0 ){
                    $attachment = $this->attachment_model->get_by_id($id);
                    if (file_exists('uploaded/files/'.$attachment->ws_images.'')) {
                        unlink('uploaded/files/'.$attachment->ws_images.'');
                    }
                }

                $dataexc['ws_images'] = $this->upload_file->doUpload('images', 'uploaded/files/');
            }

            if($id==0){
                $dataexc['created_date'] = date('Y-m-d H:i:s');
                $dataexc['created_by'] = $this->session->userdata('user')->fullname;
                $this->db->insert('web_attachment', $dataexc);
                $last_id = $this->db->insert_id();
            }else{
                $dataexc['updated_date'] = date('Y-m-d H:i:s');
                $dataexc['updated_by'] = $this->session->userdata('user')->fullname;
                $this->db->update('web_attachment', $dataexc, array('id' => $id));
                $last_id = $id;
            }

            /*excecute upload*/
            if($last_id){
                $params['id'] = $last_id;
                $this->upload_file->doUploadMultiple(array(
                    'id' => $last_id,
                    'table' => 'web_attachment',
                    'name' => 'pf_file',
                    'path' => 'uploaded/files/',
                ));
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
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        $toArray = explode(',',$id);
        if($id!=null){
            if($this->attachment_model->delete_by_id($toArray)){
                echo json_encode(array('status' => 200, 'message' => 'Proses Hapus Data Berhasil Dilakukan'));
            }else{
                echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Hapus Data Gagal Dilakukan'));
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }

    public function delete_content_image()
    {
        $id=$this->input->post('ID')?$this->input->post('ID',TRUE):null;
        if($id!=null){
            if( $id != 0 ){
                $attachment = $this->attachment_model->get_by_id($id);
                if (file_exists('uploaded/files/'.$attachment->ws_images.'')) {
                    unlink('uploaded/files/'.$attachment->ws_images.'');
                    echo json_encode(array('status' => 200, 'message' => 'Proses Hapus Data Berhasil Dilakukan'));
                }else{
                    echo json_encode(array('status' => 301, 'message' => 'Maaf Proses Hapus Data Gagal Dilakukan'));
                }
            }
        }else{
            echo json_encode(array('status' => 301, 'message' => 'Tidak ada item yang dipilih'));
        }
        
    }

    

    

}


/* End of file templates.php */
/* Location: ./application/modules/templates/controllers/templates.php */
