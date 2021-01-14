<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script>
jQuery(function($) {

  $('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true
  })
  //show datepicker when clicking on the icon
  .next().on(ace.click_event, function(){
    $(this).prev().focus();
  });
});

$(document).ready(function(){
  
    $('#form_Tmp_apps_config').ajaxForm({
      beforeSend: function() {
        achtungShowLoader();  
      },
      uploadProgress: function(event, position, total, percentComplete) {
      },
      complete: function(xhr) {     
        var data=xhr.responseText;
        var jsonResponse = JSON.parse(data);

        if(jsonResponse.status === 200){
          $.achtung({message: jsonResponse.message, timeout:5});
          $('#page-area-content').load('setting/Tmp_apps_config?_=' + (new Date()).getTime());
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

})

</script>

<div class="page-header">
  <h1>
    <?php echo $title?>
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      <?php echo $breadcrumbs?>
    </small>
  </h1>
</div><!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
          <div class="widget-body">
            <div class="widget-main no-padding">
              <form class="form-horizontal" method="post" id="form_Tmp_apps_config" action="<?php echo site_url('setting/Tmp_apps_config/process')?>" enctype="multipart/form-data">
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Nama Aplikasi</label>
                  <div class="col-md-3">
                    <input name="app_name" id="app_name" value="<?php echo isset($value)?$value->app_name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Judul Header Aplikasi</label>
                  <div class="col-md-3">
                    <input name="header_title" id="header_title" value="<?php echo isset($value)?$value->header_title:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Teks Footer</label>
                  <div class="col-md-4">
                    <input name="footer" id="footer" value="<?php echo isset($value)?$value->footer:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Teks Berjalan</label>
                  <div class="col-md-6">
                    <input name="running_text" id="running_text" value="<?php echo isset($value)?$value->running_text:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Author</label>
                  <div class="col-md-2">
                    <input name="author" id="author" value="<?php echo isset($value)?$value->author:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Developer Name</label>
                  <div class="col-md-2">
                    <input name="developer_name" id="developer_name" value="<?php echo isset($value)?$value->developer_name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">DB Name</label>
                  <div class="col-md-2">
                    <input name="db_name" id="db_name" value="<?php echo isset($value)?$value->db_name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Logo App</label>
                  <div class="col-md-4">
                    <input type="file" name="icon" class="form-control" id="icon">
                  </div>
                </div>
                <?php if(isset($value->app_logo)) :?>
                   <div class="form-group">
                      <label class="control-label col-md-2">&nbsp;</label>
                      <div class="col-md-4">
                        <img style="max-width:150px" class="editable img-responsive" alt="Logo App" id="avatar2" src="<?php echo base_url().PATH_IMG_DEFAULT.$value->app_logo?>" />
                      </div>
                    </div>
                <?php endif;?>

                <div class="form-group">
                  <label class="control-label col-md-2">Cover Login Page</label>
                  <div class="col-md-4">
                    <input type="file" name="cover_login" class="form-control" id="cover_login">
                  </div>
                </div>
                <?php if(isset($value->cover_login)) :?>
                   <div class="form-group">
                      <label class="control-label col-md-2">&nbsp;</label>
                      <div class="col-md-4">
                        <img style="max-width:150px" class="editable img-responsive" alt="Cover Login Page" id="avatar2" src="<?php echo base_url().PATH_IMG_DEFAULT.$value->cover_login?>" />
                      </div>
                    </div>
                <?php endif;?>

                <div class="form-group">
                  <label class="control-label col-md-2">File Tutorial </label>
                  <div class="col-md-4">
                    <input type="file" name="url_file_tutorial_apps" class="form-control" id="url_file_tutorial_apps">
                  </div>
                </div>
                <?php if(isset($value->url_file_tutorial_apps)) :?>
                   <div class="form-group">
                      <label class="control-label col-md-2">&nbsp;</label>
                      <div class="col-md-4">
                        <a href="<?php echo base_url().PATH_FILE_DEFAULT.$value->url_file_tutorial_apps?>" target="_blank">Download File Tutorial</a>
                      </div>
                    </div>
                <?php endif;?>

                <div class="form-group">
                  <label class="control-label col-md-2">Footer Text Form Login</label>
                  <div class="col-md-4">
                  <textarea name="footer_text_form_login" class="form-control" <?php echo ($flag=='read')?'readonly':''?> style="height:100px !important"><?php echo isset($value)?$value->footer_text_form_login:''?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Icon</label>
                  <div class="col-md-2">
                    <input name="icon" id="icon" value="<?php echo isset($value)?$value->icon:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Nama Perusahaan</label>
                  <div class="col-md-2">
                    <input name="company_name" id="company_name" value="<?php echo isset($value)?$value->company_name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-md-2">Warna Header</label>
                  <div class="col-md-2">
                    <select name="style_header_color" class="form-control">
                      <option value="">-Silahkan Pilih-</option>
                      <option value="default" <?php echo isset($value)?($value->style_header_color=='default')?'selected':'':'' ?> >Default</option>
                      <option value="blue" <?php echo isset($value)?($value->style_header_color=='blue')?'selected':'':'' ?>>Biru</option>
                      <option value="red" <?php echo isset($value)?($value->style_header_color=='red')?'selected':'':'' ?>>Merah</option>
                      <option value="dark" <?php echo isset($value)?($value->style_header_color=='dark')?'selected':'':'' ?>>Hitam</option>
                      <option value="orange" <?php echo isset($value)?($value->style_header_color=='orange')?'selected':'':'' ?>>Orange</option>
                      <option value="yellow" <?php echo isset($value)?($value->style_header_color=='yellow')?'selected':'':'' ?>>Kuning</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Description</label>
                  <div class="col-md-4">
                  <textarea name="app_description" class="form-control" <?php echo ($flag=='read')?'readonly':''?> style="height:100px !important"><?php echo isset($value)?$value->app_description:''?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Last update</label>
                  <div class="col-md-8" style="padding-top:8px">
                      <i class="fa fa-calendar"></i> <?php echo isset($value->updated_date)?$this->tanggal->formatDateTime($value->updated_date):isset($value)?$this->tanggal->formatDateTime($value->created_date):date('d-M-Y H:i:s')?> - 
                      by : <i class="fa fa-user"></i> <?php echo isset($value->updated_by)?$value->updated_by:isset($value->created_by)?$value->created_by:$this->session->userdata('user')->username?>
                  </div>
                </div>

                <div class="form-actions center">

                  <!--hidden field-->
                  <!-- <input type="text" name="id" value="<?php echo isset($value)?$value->id:0?>"> -->

                  <?php if($flag != 'read'):?>
                  <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
                    <i class="ace-icon fa fa-close icon-on-right bigger-110"></i>
                    Reset
                  </button>
                  <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info">
                    <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
                    Submit
                  </button>
                <?php endif; ?>
                </div>
              </form>
            </div>
          </div>
    
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->


