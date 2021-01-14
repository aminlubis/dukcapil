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
  
    $('#form_Tmp_role_has_menu').ajaxForm({
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
          $('#page-area-content').load('setting/Tmp_role_has_menu?_=' + (new Date()).getTime());
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
              <form class="form-horizontal" method="post" id="form_Tmp_role_has_menu" action="<?php echo site_url('setting/Tmp_role_has_menu/process')?>" enctype="multipart/form-data">
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->role_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Level</label>
                  <div class="col-md-2">
                    <?php echo $this->master->custom_selection(array('table'=>'tmp_mst_level', 'where'=>array('is_active'=>'Y'), 'id'=>'level_id', 'name' => 'name'),isset($value)?$value->level_id:'','level_id','level_id','chosen-slect form-control',($flag=='read')?'readonly':'','');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Role Name</label>
                  <div class="col-md-2">
                    <input name="name" id="name" value="<?php echo isset($value)?$value->name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Description</label>
                  <div class="col-md-4">
                  <textarea name="description" class="form-control" <?php echo ($flag=='read')?'readonly':''?> style="height:50px !important"><?php echo isset($value)?$value->description:''?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">&nbsp;</label>
                  <div class="col-md-10">
                    <table class="table table-striped table-bordered">
                          <thead>
                            <tr style="color:black">
                              <th class="center">Nama Menu</th>
                              <?php 
                                $no = 0;
                                foreach ($function as $key => $row_function) {
                              ?>
                              <th class="center"><?php echo strtoupper($row_function->name). '<br>[ '.$row_function->code.' ]'?></th>
                              <?php $no++; }?>
                            </tr>
                          </thead>

                          <tbody>
                            <?php
                              foreach ($menus as $key2 => $row_menus) {
                            ?>
                            <tr>
                              <td>
                                <?php echo ucfirst($row_menus['name']).' <b>('.$row_menus['modul_name'].')</b> '?>
                                <input type="hidden" name="menu_id[]" value="<?php echo $row_menus['menu_id']?>">
                              </td>

                               <?php 
                                $no = 0;
                                foreach ($function as $key3 => $func_row) {
                              ?>

                              <td class="center">
                                <label class="pos-rel">
                                  <?php if($row_menus['link'] != '#'){?>
                                    <input type="checkbox" name="<?php echo $row_menus['menu_id']; ?>[]" value="<?php echo $func_row->code?>" class="ace" <?php echo $this->Tmp_role_has_menu->get_checked_form($row_menus['menu_id'], $value->role_id, $func_row->code)?>/>
                                    <span class="lbl"></span>
                                  <?php }?>
                                </label>
                              </td>

                              <?php $no++; }?>

                            </tr>
                            <?php foreach ($row_menus['submenu'] as $rowsubmenu) {?>
                                <tr>
                                <td>&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i> <?php echo ucfirst($rowsubmenu['name'])?>
                                <input type="hidden" name="menu_id[]" value="<?php echo $rowsubmenu['menu_id']?>">
                                </td>

                                 <?php 
                                  $no = 0;
                                  foreach ($function as $key3 => $func_row) {
                                ?>

                                <td class="center">
                                  <label class="pos-rel">
                                    <input type="checkbox" name="<?php echo $rowsubmenu['menu_id']; ?>[]" value="<?php echo $func_row->code?>" class="ace" <?php echo $this->Tmp_role_has_menu->get_checked_form($rowsubmenu['menu_id'], $value->role_id, $func_row->code)?>/>
                                    <span class="lbl"></span>
                                  </label>
                                </td>

                                <?php $no++; }?>

                              </tr>

                              <?php }?>
                            
                            <?php }?>
                        </tbody>
                    </table>
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

                  <!--hidden field-->
                  <!-- <input type="text" name="id" value="<?php echo isset($value)?$value->role_id:0?>"> -->

                  <a onclick="getMenu('setting/Tmp_role_has_menu')" href="#" class="btn btn-sm btn-success">
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


