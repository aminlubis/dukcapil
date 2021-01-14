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
  
    $('#form_Tmp_mst_menu').ajaxForm({
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
          $('#page-area-content').load('setting/Tmp_mst_menu?_=' + (new Date()).getTime());
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

    $('select[name="modul_id"]').change(function () {
        if ($(this).val()) {
            $.getJSON("<?php echo site_url('Templates/References/getMenuByModulId') ?>/" + $(this).val(), '', function (data) {
                $('#parent option').remove();
                $('<option value="">-Silahkan Pilih-</option>').appendTo($('#parent'));
                $.each(data, function (i, o) {
                    $('<option value="' + o.menu_id + '">' + o.name + '</option>').appendTo($('#parent'));
                });

            });
        } else {
            $('#parent option').remove()
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
              <form class="form-horizontal" method="post" id="form_Tmp_mst_menu" action="<?php echo site_url('setting/Tmp_mst_menu/process')?>" enctype="multipart/form-data" >
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->menu_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Modul</label>
                  <div class="col-md-2">
                    <?php echo $this->master->custom_selection(array('table'=>'tmp_mst_modul', 'where'=>array('is_active'=>'Y'), 'id'=>'modul_id', 'name' => 'name'),isset($value)?$value->modul_id:'','modul_id','modul_id','chosen-slect form-control',($flag=='read')?'readonly':'','');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Menu Name</label>
                  <div class="col-md-2">
                    <input name="name" id="name" value="<?php echo isset($value)?$value->name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Class</label>
                  <div class="col-md-2">
                    <input name="class" id="class" value="<?php echo isset($value)?$value->class:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                  <label class="control-label col-md-1">Link</label>
                  <div class="col-md-4">
                    <input name="link" id="link" value="<?php echo isset($value)?$value->link:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                 
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Icon</label>
                  <div class="col-md-2">
                    <input name="icon" id="icon" value="<?php echo isset($value)?$value->icon:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label class="control-label col-md-2">Date</label>
                  <div class="col-md-2">
                    <div class="input-group">
                      <input class="form-control date-picker" name="date" id="date" type="text" data-date-format="yyyy-mm-dd" <?php echo ($flag=='read')?'readonly':''?> value="<?php echo isset($value)?$value->date:''?>"/>
                      <span class="input-group-addon">
                        <i class="fa fa-calendar bigger-110"></i>
                      </span>
                    </div>
                  </div>
                </div> -->

                <div class="form-group">
                  <label class="control-label col-md-2">Parent Menu</label>
                  <div class="col-md-2">
                    <?php echo $this->master->custom_selection(array('table'=>'tmp_mst_menu', 'where'=>array('is_active'=>'Y', 'level' => 0), 'id'=>'menu_id', 'name' => 'name'),isset($value)?$value->parent:'','parent','parent','chosen-slect form-control',($flag=='read')?'readonly':'','');?>
                  </div>
                  <label class="control-label col-md-1">Level</label>
                  <div class="col-md-1">
                    <input name="level" id="level" value="<?php echo isset($value)?$value->level:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Counter</label>
                  <div class="col-md-1">
                    <input name="counter" id="counter" value="<?php echo isset($value)?$value->counter:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Description</label>
                  <div class="col-md-4">
                  <textarea name="description" class="form-control" <?php echo ($flag=='read')?'readonly':''?> style="height:50px !important"><?php echo isset($value)?$value->description:''?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Set Shorcut ?</label>
                  <div class="col-md-2">
                    <div class="radio">
                          <label>
                            <input name="set_shortcut" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->set_shortcut == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?> <?php echo ($flag=='read')?'readonly':''?> />
                            <span class="lbl"> Ya</span>
                          </label>
                          <label>
                            <input name="set_shortcut" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->set_shortcut == 'N') ? 'checked="checked"' : '' : ''; ?> <?php echo ($flag=='read')?'readonly':''?>/>
                            <span class="lbl">Tidak</span>
                          </label>
                    </div>
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
                            <span class="lbl">Tidak</span>
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
                  <a onclick="getMenu('setting/Tmp_mst_menu')" href="#" class="btn btn-sm btn-success">
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


