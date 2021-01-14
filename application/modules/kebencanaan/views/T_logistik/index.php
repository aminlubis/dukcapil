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
});

$(document).ready(function(){
  
    $('#form-logistik').ajaxForm({
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
            // getMenuTabs('kebencanaan/T_logistik/?id_bencana='+jsonResponse.id_bencana+'', 'tabs_load_content');
            $('#form-logistik')[0].reset();
            reload_table();
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

})

function click_edit( id ){
  $.getJSON("<?php echo site_url('kebencanaan/T_logistik/click_edit/') ?>" + id, '' , function (data) {  
    // response data
      preventDefault();
      $('#id').val(data.id_bencana_logistik);
      $('#tipe_flag_logistik').val(data.flag);
      $('#tanggal').val(data.tanggal);
      $('#tanggal').val(data.tanggal);
      $('#nama_logistik').val(data.nama_logistik);
      $('#jenis_logistik').val(data.jenis_logistik);
      $('#total_tersedia').val(data.total_tersedia);
      $('#satuan').val(data.satuan);
      $('#keterangan').val(data.keterangan);
  }) 
}

function click_delete(myid){
  if(confirm('Are you sure?')){
    $.ajax({
        url: 'kebencanaan/T_logistik/delete',
        type: "post",
        data: {ID:myid},
        dataType: "json",
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

  }else{
    return false;
  }
  
}

</script>

<div class="row">
  <div class="col-xs-12">

    <h3 class="header smaller lighter blue">
      <?php echo $title?>
    </h3>
    <?php if(!isset($_GET['readonly'])) :?>

    <form class="form-horizontal" method="post" id="form-logistik" action="<?php echo site_url('kebencanaan/T_logistik/process')?>" enctype="multipart/form-data" autocomplete="off">
    <br>
        <!-- hidden form -->
        <input type="hidden" name="id_bencana" value="<?php echo isset($id_bencana)?$id_bencana:''?>">

        <div class="form-group">
          <label class="control-label col-md-2">ID</label>
          <div class="col-md-1">
              <input name="id" id="id" value="<?php echo isset($value)?$value->id_bencana_logistik:0?>" placeholder="Auto" class="form-control" type="text" readonly>
          </div>
          <label class="control-label col-md-2">Tanggal datang logistik</label>  
          <div class="col-md-2">
              <div class="input-group">
                  <input name="tanggal" id="tanggal" value="<?php echo isset($value)?$this->tanggal->formatDateForm($value->tanggal):date('Y-m-d')?>" class="form-control date-picker" type="text">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-calendar"></i>
                  </span>
              </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-2">Jenis Logistik</label>
          <div class="col-md-2">
          <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'tipe_flag_logistik'), 'id'=>'value', 'name' => 'label'),'','tipe_flag_logistik','tipe_flag_logistik','chosen-slect form-control','','');?>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-2">Nama Item</label>
          <div class="col-md-4">
              <input name="nama_logistik" id="nama_logistik" value="<?php echo isset($value)?$value->nama_logistik:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-2">Jenis</label>
          <div class="col-md-2">
              <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_logistik'), 'id'=>'value', 'name' => 'label'),'','jenis_logistik','jenis_logistik','chosen-slect form-control','','');?>
          </div>
          <label class="control-label col-md-1">Jumlah</label>
          <div class="col-md-1">
              <input name="total_tersedia" id="total_tersedia" value="<?php echo isset($value)?$value->total_tersedia:''?>" placeholder="" class="form-control" type="text" >
          </div>
          <label class="control-label col-md-1">Satuan</label>
          <div class="col-md-2">
            <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'satuan'), 'id'=>'value', 'name' => 'label'),'','satuan','satuan','chosen-slect form-control','','');?>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-2">Keterangan</label>
          <div class="col-md-4">
              <textarea name="keterangan" id="keterangan" class="form-control" style="height:50px !important"></textarea>
          </div>
        </div>
        
        <div class="form-group" style="padding-top: 3px">
          <label class="control-label col-md-2">&nbsp;</label>
          <div class="col-md-4">
            <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
                <i class="ace-icon fa fa-refresh icon-on-right bigger-110"></i>
                Reset
            </button>
            <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info" style="margin-left:-1%">
                <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
                Simpan
            </button>
          </div>
        </div>

    </form>
    <?php endif; ?>
    <hr class="separator">
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div style="margin-top:-27px">
      <table id="dynamic-table" base-url="kebencanaan/T_logistik/get_data?id_bencana=<?php echo isset($id_bencana)?$id_bencana:''?>" url-detail="kebencanaan/T_logistik/show_detail" class="table table-striped table-bordered table-hover">
       <thead>
        <tr style="background-color: #213a6d">  
          <th width="40px" class="center"></th>
          <th width="40px"></th>
          <th width="70px">ID</th>
          <th>Tanggal</th>
          <th>Deskripsi Item</th>
          <th>Jenis</th>
          <th>Jumlah Tersedia</th>
          <th>Keterangan</th>
          <th>Flag</th>
          <th>Last Updated</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/als_datatable_custom_url.js'?>"></script>



