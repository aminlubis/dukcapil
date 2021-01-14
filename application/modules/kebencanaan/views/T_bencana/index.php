<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script>

jQuery(function($) {  

  $('.date-picker').datepicker({  
  autoclose: true,   
  todayHighlight: true,
  format: 'yyyy-mm-dd', 
  })  
  //show datepicker when clicking on the icon
  .next().on(ace.click_event, function(){  
  $(this).prev().focus();    
  });
    
})
    function set_data_final(id_bencana){
      if(confirm('Are you sure?')){
        $.ajax({
          url : 'kebencanaan/T_bencana/set_data_final',
          type: "POST",
          data: {ID : id_bencana},
          dataType: "JSON",        
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
              reload_table();
            }else{
              $.achtung({message: jsonResponse.message, timeout:5});
            }
            achtungHideLoader();
          }
        });
      }
      
    }
  
</script>

<div class="row">
  <div class="col-xs-12">

    <div class="page-header">
      <h1>
        <?php echo $title?>
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          <?php echo isset($breadcrumbs)?$breadcrumbs:''?>
        </small>
      </h1>
    </div><!-- /.page-header -->
    
    <form class="form-horizontal" method="post" id="form_search" action="#">

      <div class="col-md-12">

        <b>PENCARIAN DATA BENCANA</b><br><br>
        <div class="form-group">
          <label class="control-label col-md-2">Bulan</label>
            <div class="col-md-2">
              <?php echo $this->master->get_bulan('' , 'bulan', 'bulan', 'form-control', '','') ?>
            </div>
            <label class="control-label col-md-1">Tahun</label>
            <div class="col-md-2">
              <?php echo $this->master->get_tahun('' , 'tahun', 'tahun', 'form-control', '', '') ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Jenis Bencana</label>
            <div class="col-md-2">
                <?php echo $this->master->custom_selection($params = array('table' => 'global_parameter', 'id' => 'value', 'name' => 'label', 'where' => array('is_active' => 'Y', 'flag' => 'jenis_bencana') ), '' , 'jenis_bencana', 'jenis_bencana', 'form-control', '', '') ?>
            </div>
            <label class="control-label col-md-1">Status</label>
            <div class="col-md-2">
                <?php echo $this->master->custom_selection($params = array('table' => 'global_parameter', 'id' => 'value', 'name' => 'label', 'where' => array('is_active' => 'Y', 'flag' => 'status_bencana') ), '' , 'status_bencana', 'status_bencana', 'form-control', '', '') ?>
            </div>
            <label class="control-label col-md-1">Level</label>
            <div class="col-md-2">
                <?php echo $this->master->custom_selection($params = array('table' => 'global_parameter', 'id' => 'value', 'name' => 'label', 'where' => array('is_active' => 'Y', 'flag' => 'level_bencana') ), '' , 'level_bencana', 'level_bencana', 'form-control', '', '') ?>
            </div>
        </div>

        <div class="form-group">
            
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Provinsi</label>
            <div class="col-md-2">
                <?php echo $this->master->custom_selection($params = array('table' => 'provinces', 'id' => 'id', 'name' => 'name', 'where' => array() ), '' , 'province', 'province', 'form-control', '', '') ?>
            </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Berdasarkan tanggal</label>
          <div class="col-md-2">
              <select name="date_by" id="date_by" class="form-control">
                <option value="created_date">Created Date</option>
                <option value="updated_date">Last Update</option>
                <option value="tanggal_kejadian">Kejadian Bencana</option>
              </select>
          </div>
            <div class="col-md-2" style="margin-left: -20px">
              <div class="input-group">
                <input class="form-control date-picker" name="from_tgl" id="from_tgl" type="text" data-date-format="yyyy-mm-dd" value=""/>
                <span class="input-group-addon">
                  <i class="fa fa-calendar bigger-110"></i>
                </span>
              </div>
            </div>

            <label class="control-label col-md-1" style="margin-left: -8px">s/d Tanggal</label>
            <div class="col-md-2">
              <div class="input-group">
                <input class="form-control date-picker" name="to_tgl" id="to_tgl" type="text" data-date-format="yyyy-mm-dd" value=""/>
                <span class="input-group-addon">
                  <i class="fa fa-calendar bigger-110"></i>
                </span>
              </div>
            </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2 ">&nbsp;</label>
          <div class="col-md-10" style="margin-left: 6px">
            <a href="#" id="btn_search_data" class="btn btn-xs btn-default">
              <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
              Search
            </a>
            <a href="#" id="btn_reset_data" class="btn btn-xs btn-warning">
              <i class="ace-icon fa fa-refresh icon-on-right bigger-110"></i>
              Reset
            </a>
            <a href="#" id="btn_export_excel" class="btn btn-xs btn-success">
              <i class="fa fa-file-word-o bigger-110"></i>
              Export Excel
            </a>
          </div>
        </div>

      </div>

      <div class="clearfix" style="margin-bottom:-5px">
        <?php echo $this->authuser->show_button('kebencanaan/T_bencana','C','',1)?>
        <?php echo $this->authuser->show_button('kebencanaan/T_bencana','D','',5)?>
        <div class="pull-right tableTools-container"></div>
      </div>
      <hr class="separator">
      <!-- div.table-responsive -->

      <!-- div.dataTables_borderWrap -->
      <div style="margin-top:-27px">
        <table id="dynamic-table" base-url="kebencanaan/T_bencana" url-detail="kebencanaan/T_bencana/show_detail" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>  
            <th width="30px" class="center"></th>
            <th width="40px" class="center"></th>
            <th width="40px" class="center"></th>
            <th width="40px"></th>
            <th width="70px">ID</th>
            <th>Nama Bencana</th>
            <th>Waktu</th>
            <th>Provinsi</th>
            <th>Level</th>
            <th>Status</th>
            <th width="180px">Last Update</th>
            <th width="70px">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      </div>

    </form>

  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/als_datatable_with_detail.js'?>"></script>



