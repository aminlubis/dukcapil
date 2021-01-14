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
  
    $('#form_Tmp_mst_modul').ajaxForm({
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
          $('#page-area-content').load('setting/Tmp_mst_modul?_=' + (new Date()).getTime());
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

    $('input[type=radio][name=is_new_tab]').on('change', function() {
     switch($(this).val()) {
         case 'Y':
             $('#div_new_tab').show('fast');
             break;
         case 'N':
             $('#div_new_tab').hide('fast');
             break;
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
              <form class="form-horizontal" method="post" id="form_Tmp_mst_modul" action="<?php echo site_url('setting/Tmp_mst_modul/process')?>" enctype="multipart/form-data">
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->modul_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Modul Name</label>
                  <div class="col-md-2">
                    <input name="name" id="name" value="<?php echo isset($value)?$value->name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Modul Title</label>
                  <div class="col-md-2">
                    <input name="title" id="title" value="<?php echo isset($value)?$value->title:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Icon</label>
                  <div class="col-md-2">
                    <input name="icon" id="icon" value="<?php echo isset($value)?$value->icon:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Kelompok Modul</label>
                  <div class="col-md-2">
                    <?php echo $this->master->custom_selection(array('table'=>'tmp_mst_group_modul', 'where'=>array('is_active'=>'Y'), 'id'=>'group_modul_id', 'name' => 'group_modul_name'),isset($value)?$value->group_modul_id:'','group_modul_id','group_modul_id','chosen-slect form-control',($flag=='read')?'readonly':'','');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Description</label>
                  <div class="col-md-4">
                  <textarea name="description" class="form-control" <?php echo ($flag=='read')?'readonly':''?> style="height:70px !important"><?php echo isset($value)?$value->description:''?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Open In New tab?</label>
                  <div class="col-md-4">
                    <div class="radio">
                          <label>
                            <input name="is_new_tab" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->is_new_tab == 'Y') ? 'checked="checked"' : '' : ''; ?> <?php echo ($flag=='read')?'readonly':''?> />
                            <span class="lbl"> Ya</span>
                          </label>
                          <label>
                            <input name="is_new_tab" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->is_new_tab == 'N') ? 'checked="checked"' : '' : 'checked="checked"'; ?> <?php echo ($flag=='read')?'readonly':''?>/>
                            <span class="lbl"> Tidak</span>
                          </label>
                    </div>
                    <i style="font-size:11px"> Jika memilih "Ya" maka ketika di klik modul akan di tampilkan pada tab yang baru, direkomendasikan untuk aplikasi yang bukan dari Als Framework</i>
                  </div>
                </div>

                <div class="form-group" id="div_new_tab" <?php echo isset($value)?($value->is_new_tab=='Y')?'':'style="display:none"':'style="display:none"'?>>
                  <label class="control-label col-md-2">Link On New Tab</label>
                  <div class="col-md-4">
                    <input name="link_on_new_tab" id="link_on_new_tab" value="<?php echo isset($value)?$value->link_on_new_tab:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Is active?</label>
                  <div class="col-md-2">
                    <div class="radio">
                          <label>
                            <input name="is_active" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->is_active == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?> <?php echo ($flag=='read')?'readonly':''?> />
                            <span class="lbl"> Ya</span>
                          </label>
                          <label>
                            <input name="is_active" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->is_active == 'N') ? 'checked="checked"' : '' : ''; ?> <?php echo ($flag=='read')?'readonly':''?>/>
                            <span class="lbl"> Tidak</span>
                          </label>
                    </div>
                  </div>
                </div>

                

                <div class="form-group">
                  <label class="control-label col-md-2">Last update</label>
                  <div class="col-md-8" style="padding-top:8px;font-size:11px">
                      <i class="fa fa-calendar"></i> <?php echo isset($value->updated_date)?$this->tanggal->formatDateTime($value->updated_date):isset($value)?$this->tanggal->formatDateTime($value->created_date):date('d-M-Y H:i:s')?> - 
                      by : <i class="fa fa-user"></i> <?php echo isset($value->updated_by)?$value->updated_by:isset($value->created_by)?$value->created_by:$this->session->userdata('user')->username?>
                  </div>
                </div>


                <div class="form-actions center">

                  <!--hidden field-->
                  <!-- <input type="text" name="id" value="<?php echo isset($value)?$value->modul_id:0?>"> -->

                  <a onclick="getMenu('setting/Tmp_mst_modul')" href="#" class="btn btn-sm btn-success">
                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                    Kembali ke daftar
                  </a>
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


