<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<!-- timepicker -->
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script>
jQuery(function($) {

  $('.timepicker').timepicker({
    minuteStep: 1,
    showSeconds: true,
    showMeridian: false,
    disableFocus: true,
    icons: {
      up: 'fa fa-chevron-up',
      down: 'fa fa-chevron-down'
    }
  }).on('focus', function() {
    $('#timepicker1').timepicker('showWidget');
  }).next().on(ace.click_event, function(){
    $(this).prev().focus();
  });

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

  $('#ZONA_'+$('#zona_waktu_hidden').val()+'').prop('checked', true);
  
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
            // getMenuTabs('kebencanaan/T_dampak/?id_bencana='+jsonResponse.id_bencana+'', 'tabs_load_content');
            $('#form-logistik')[0].reset();
            reload_table();
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

})

$('select[name=asal_personil]').change(function(){
  if( $(this).val() == 'Perorangan' ){
    $('#div_jk').show();
  }
})

function click_edit( id ){
  $.getJSON("<?php echo site_url('kebencanaan/T_dampak/click_edit/') ?>" + id, '' , function (data) {  
    // response data
      preventDefault();
      $('#id').val(data.id_bencana_dampak);
      $('#tanggal').val(data.tanggal);
      $('#jam').val(data.jam);
      $('#ZONA_'+data.zona_waktu+'').prop('checked', true);
      $('#kategori_dampak').val(data.flag);
      $('#label').val(data.label);
      $('#value').val(data.value);
      $('#satuan').val(data.satuan);
  }) 
}

function click_delete(myid){
  if(confirm('Are you sure?')){
    $.ajax({
        url: 'kebencanaan/T_dampak/delete',
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

    <form class="form-horizontal" method="post" id="form-logistik" action="<?php echo site_url('kebencanaan/T_dampak/process')?>" enctype="multipart/form-data" autocomplete="off">
    <br>
        <!-- hidden form -->
        <input type="hidden" name="id_bencana" value="<?php echo isset($id_bencana)?$id_bencana:''?>">

        <div class="form-group">
          <label class="control-label col-md-1">ID</label>
          <div class="col-md-1">
              <input name="id" id="id" value="<?php echo isset($value)?$value->id_bencana_dampak:0?>" placeholder="Auto" class="form-control" type="text" readonly>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-1">Tanggal</label>  
          <div class="col-md-2">
              <div class="input-group">
                  <input name="tanggal" id="tanggal" value="<?php echo isset($value)?$value->tanggal:date('Y-m-d')?>"  class="form-control date-picker" type="text">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-calendar"></i>
                  </span>
              </div>
          </div>
          <!-- <label class="control-label col-md-1" style="margin-left: -10px">Jam</label>
          <div class="col-md-1">
              <input name="jam" id="jam" value="<?php echo isset($value)?$value->jam:''?>" placeholder="" class="form-control" type="text" >
          </div> -->
          <label class="control-label col-md-1" style="margin-left: -10px">Jam</label>
          <div class="col-md-2">
            <div class="input-group bootstrap-timepicker">
              <input id="jam" name="jam" type="text" class="timepicker form-control" value="<?php echo isset($value)?$this->tanggal->formatTime($value->jam):''?>">
              <span class="input-group-addon">
                <i class="fa fa-clock-o bigger-110"></i>
              </span>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="radio">
              <label>
                <input name="zona_waktu" type="radio" class="ace" id="ZONA_WIB" value="WIB" <?php echo isset($value) ? ($value->zona_waktu == 'WIB') ? 'checked="checked"' : '' : 'checked="checked"'; ?> />
                <span class="lbl"> WIB</span>
              </label>
              <label>
                <input name="zona_waktu" type="radio" class="ace" id="ZONA_WITA" value="WITA" <?php echo isset($value) ? ($value->zona_waktu == 'WITA') ? 'checked="checked"' : '' : ''; ?>/>
                <span class="lbl"> WITA</span>
              </label>
              <label>
                <input name="zona_waktu" type="radio" class="ace" id="ZONA_WIT" value="WIT" <?php echo isset($value) ? ($value->zona_waktu == 'WIT') ? 'checked="checked"' : '' : ''; ?>/>
                <span class="lbl"> WIT</span>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-1">Kategori</label>
          <div class="col-md-3">
            <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'kategori_dampak'), 'id'=>'value', 'name' => 'label'),'','kategori_dampak','kategori_dampak','chosen-slect form-control','','');?>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-1">Label</label>
          <div class="col-md-2">
              <input name="label" id="label" value="<?php echo isset($value)?$value->label:''?>" placeholder="" class="form-control" type="text" >
          </div>
          <label class="control-label col-md-1">Jumlah</label>
          <div class="col-md-1">
              <input name="value" id="value" value="<?php echo isset($value)?$value->value:''?>" placeholder="" class="form-control" type="text" >
          </div>
          <label class="control-label col-md-1">Satuan</label>
          <div class="col-md-2">
              <input name="satuan" id="satuan" value="<?php echo isset($value)?$value->satuan:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-1">&nbsp;</label>
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

    <hr class="separator">
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div style="margin-top:-27px">
      <table id="dynamic-table" base-url="kebencanaan/T_dampak/get_data?id_bencana=<?php echo isset($id_bencana)?$id_bencana:''?>" url-detail="kebencanaan/T_dampak/show_detail" class="table table-striped table-bordered table-hover">
       <thead>
          <tr style="background-color: #213a6d">  
          <th></th>
          <th></th>
          <th width="70px">ID</th>
          <th>Tanggal</th>
          <th>Jam</th>
          <th>Kategori</th>
          <th>Label</th>
          <th>Jumlah</th>
          <th>Last Update</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/als_datatable_custom_url.js'?>"></script>



