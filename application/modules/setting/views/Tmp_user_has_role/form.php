<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-multiselect.css" />
<script>
$(document).ready(function(){
  
    $('#form_Tmp_user_has_role').ajaxForm({
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
          $('#page-area-content').load('setting/Tmp_user_has_role?_=' + (new Date()).getTime());
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
              <form class="form-horizontal" method="post" id="form_Tmp_user_has_role" action="<?php echo site_url('setting/Tmp_user_has_role/process')?>" enctype="multipart/form-data">
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->user_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Fullname</label>
                  <div class="col-md-2">
                    <input name="fullname" id="fullname" value="<?php echo isset($value)?$value->fullname:''?>" placeholder="" class="form-control" type="text" readonly >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Email</label>
                  <div class="col-md-2">
                    <input name="email" id="email" value="<?php echo isset($value)?$value->email:''?>" placeholder="" class="form-control" type="text" readonly >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Username</label>
                  <div class="col-md-2">
                    <input name="username" id="username" value="<?php echo isset($value)?$value->username:''?>" placeholder="" class="form-control" type="text" readonly >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Password</label>
                  <div class="col-md-2">
                    <input name="password" id="password" value="<?php echo isset($value)?$value->password:''?>" placeholder="" class="form-control" type="password" readonly >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-2">Password Confirmation</label>
                  <div class="col-md-2">
                    <input name="confirm" id="confirm" value="" placeholder="" class="form-control" type="password" readonly >
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2" for="role_id">User Group</label>
                    <div class="col-xs-12 col-sm-9">
                      <!-- #section:plugins/input.multiselect -->
                      <select id="role_id" class="multiselect" multiple="multiple" name="user_role[]">
                        <?php 
                          foreach($role as $row){
                            $check_selected = $this->Tmp_user_has_role->check_selected($row->role_id, $value->user_id); 
                            $selected = ($check_selected != false)?'selected':'';
                            echo '<option value="'.$row->role_id.'" '.$selected.'>'.$row->name.'</option>';
                          }
                        ?>
                      </select>

                      <!-- /section:plugins/input.multiselect -->
                    </div>
                  </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Is active?</label>
                  <div class="col-md-2">
                    <div class="radio">
                          <label>
                            <input name="is_active" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->is_active == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?> readonly />
                            <span class="lbl"> Ya</span>
                          </label>
                          <label>
                            <input name="is_active" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->is_active == 'N') ? 'checked="checked"' : '' : ''; ?> readonly/>
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
                  <!-- <input type="text" name="id" value="<?php echo isset($value)?$value->user_id:0?>"> -->

                  <a onclick="getMenu('setting/Tmp_user_has_role')" href="#" class="btn btn-sm btn-success">
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

<script type="text/javascript">
      jQuery(function($){
          
        //////////////////
        $('.multiselect').multiselect({
         enableFiltering: true,
         buttonClass: 'btn btn-white btn-primary',
         templates: {
          button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"></button>',
          ul: '<ul class="multiselect-container dropdown-menu"></ul>',
          filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
          filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
          li: '<li><a href="javascript:void(0);"><label></label></a></li>',
          divider: '<li class="multiselect-item divider"></li>',
          liGroup: '<li class="multiselect-item group"><label class="multiselect-group"></label></li>'
         }
        });
        
        
        //in ajax mode, remove remaining elements before leaving page
        /*$(document).one('ajaxloadstart.page', function(e) {
          $('.multiselect').multiselect('destroy');
        });*/
      
      });
    </script>



