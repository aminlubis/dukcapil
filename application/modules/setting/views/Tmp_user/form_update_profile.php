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
  
    $('#form_update_profile').ajaxForm({
      beforeSend: function() {
        achtungShowLoader();  
      },
      uploadProgress: function(event, position, total, percentComplete) {
      },
      complete: function(xhr) {     
        var data=xhr.responseText;
        var jsonResponse = JSON.parse(data);

        if(jsonResponse.status === 200){
          $.achtung({message: jsonResponse.message, timeout:3});
          $('#page-area-content').load('setting/Tmp_user/form_update_profile?_=' + (new Date()).getTime());
          $('#message_success').show({
              speed: 'slow',
              timeout: 5000,
          });
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
    <div id="message_success" style="display:none" class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
          <i class="ace-icon fa fa-times"></i>
        </button>
        <p>
          <strong>
            <i class="ace-icon fa fa-check"></i>
            Sukses !
          </strong>
          Proses yang anda lakukan telah berhasil
        </p>
    </div>
    <!-- PAGE CONTENT BEGINS -->
          <div class="widget-body">
            <div class="widget-main no-padding">
              <form class="form-horizontal" method="post" id="form_update_profile" action="<?php echo site_url('setting/Tmp_user/process_profile_user')?>" enctype="multipart/form-data">
                  <br>
                  <div class="form-group">
                    <label class="control-label col-md-2">Profile ID</label>
                    <div class="col-md-1">
                      <input name="profile_id" id="profile_id" value="<?php echo isset($value)?$value->up_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Nama Lengkap</label>
                    <div class="col-md-4">
                      <input name="fullname_user" id="fullname_user" value="<?php echo isset($value)?$value->nama_lengkap:''?>" placeholder="" class="form-control" type="text"  >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Tempat Lahir</label>
                    <div class="col-md-3">
                      <input name="pob" id="pob" value="<?php echo isset($value)?$value->pob:''?>" placeholder="" class="form-control" type="text"  >
                    </div>
                    <label class="control-label col-md-2">Tanggal Lahir</label>
                    <div class="col-md-2">
                      <div class="input-group">
                        <input class="form-control date-picker" name="dob" id="dob" type="text" data-date-format="yyyy-mm-dd"  value="<?php echo isset($value)?$value->dob:date('Y-m-d')?>"/>
                        <span class="input-group-addon">
                          <i class="fa fa-calendar bigger-110"></i>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Alamat</label>
                    <div class="col-md-6">
                      <input name="address" id="address" value="<?php echo isset($value)?$value->address:''?>" placeholder="" class="form-control" type="text"  >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">No Telp/Hp</label>
                    <div class="col-md-3">
                      <input name="no_telp" id="no_telp" value="<?php echo isset($value)?$value->no_telp:''?>" placeholder="" class="form-control" type="text" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Gender?</label>
                    <div class="col-md-4">
                      <div class="radio">
                            <label>
                              <input name="gender" type="radio" class="ace" value="L" <?php echo isset($value) ? ($value->gender == 'L') ? 'checked="checked"' : '' : 'checked="checked"'; ?>  />
                              <span class="lbl"> Laki-laki</span>
                            </label>
                            <label>
                              <input name="gender" type="radio" class="ace" value="P" <?php echo isset($value) ? ($value->gender == 'P') ? 'checked="checked"' : '' : ''; ?> />
                              <span class="lbl"> Perempuan</span>
                            </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Foto Profil</label>
                    <div class="col-md-4">
                      <input type="file" name="images" class="form-control" id="images">
                    </div>
                  </div>
                  <?php if(isset($value->path_foto)) :?>

                     <div class="form-group">
                        <label class="control-label col-md-2">&nbsp;</label>
                        <div class="col-md-4">
                          <img style="max-width:150px" class="editable img-responsive" alt="<?php echo $this->session->userdata('user')->fullname?>" id="avatar2" src="<?php echo base_url().PATH_IMG_DEFAULT.$value->path_foto?>" />
                        </div>
                      </div>

                  <?php endif;?>

                  <div class="form-group">
                    <label class="control-label col-md-2">Facebook</label>
                    <div class="col-md-3">
                      <input name="facebook" id="facebook" value="<?php echo isset($value)?$value->facebook:''?>" placeholder="" class="form-control" type="text" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Twitter</label>
                    <div class="col-md-3">
                      <input name="twitter" id="twitter" value="<?php echo isset($value)?$value->twitter:''?>" placeholder="" class="form-control" type="text" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Instagram</label>
                    <div class="col-md-3">
                      <input name="instagram" id="instagram" value="<?php echo isset($value)?$value->instagram:''?>" placeholder="" class="form-control" type="text" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Quotes</label>
                    <div class="col-md-6">
                      <textarea class="form-control" name="about_me" style="height:100px !important"><?php echo isset($value)?$value->about_me:''?></textarea>
                    </div>
                  </div>

                  <div class="form-actions center">

                    <!--hidden field-->
                    <input name="user_id" id="user_id" value="<?php echo isset($value)?$value->user_id:0?>" placeholder="Auto" class="form-control" type="hidden" >
                    <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
                      <i class="ace-icon fa fa-close icon-on-right bigger-110"></i>
                      Reset
                    </button>
                    <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info">
                      <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
                      Submit
                    </button>
                  </div>
                </form>
            </div>
          </div>
    
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->


