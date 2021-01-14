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

    $('#form-korban').ajaxForm({
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
            // getMenuTabs('kebencanaan/T_korban/?id_bencana='+jsonResponse.id_bencana+'', 'tabs_load_content');
            $('#form-korban')[0].reset();
            reload_table();
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

})

function click_edit( id ){
  preventDefault();
  $.getJSON("<?php echo site_url('kebencanaan/T_korban/click_edit/') ?>" + id, '' , function (data) {  
    // response data
      $('#id').val(data.id_bencana_history_korban);
      $('#tanggal').val(data.tanggal);
      $('#jam').val(data.jam);
      $('#ZONA_'+data.zona_waktu+'').prop('checked', true);
      var meninggal = JSON.parse(data.meninggal);
      $('#meninggal').val(meninggal.value); 
      var hilang = JSON.parse(data.hilang);
      $('#hilang').val(hilang.value);
      var luka = JSON.parse(data.luka);
      $('#luka').val(luka.value);
      var mengungsi = JSON.parse(data.mengungsi);
      $('#mengungsi').val(mengungsi.value);
      $('#satuan_korban_mengungsi option[value="'+mengungsi.satuan+'"]').prop("selected", true);
      var terdampak = JSON.parse(data.terdampak);
      $('#terdampak').val(terdampak.value); 
      $('#satuan_korban_terdampak option[value="'+terdampak.satuan+'"]').prop("selected", true);
      $('#keterangan').val(data.keterangan);
  }) 
}

function click_delete(myid){
  if(confirm('Are you sure?')){
    $.ajax({
        url: 'kebencanaan/T_korban/delete',
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
            $('#form-korban')[0].reset();
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
    <form class="form-horizontal" method="post" id="form-korban" action="<?php echo site_url('kebencanaan/T_korban/process')?>" enctype="multipart/form-data" autocomplete="off">
    <br>
        <!-- hidden form -->
        <input type="hidden" name="id_bencana" value="<?php echo isset($id_bencana)?$id_bencana:''?>">

        <div class="form-group">
          <label class="control-label col-md-2">ID</label>
          <div class="col-md-1">
              <input name="id" id="id" value="<?php echo isset($value)?$value->id_bencana_history_korban:0?>" placeholder="Auto" class="form-control" type="text" readonly>
          </div>
          <label class="control-label col-md-1">Tanggal</label>  
          <div class="col-md-2">
              <div class="input-group">
                  <input name="tanggal" id="tanggal" value="<?php echo isset($value)?$this->tanggal->formatDateForm($value->tanggal):date('Y-m-d')?>"  class="form-control date-picker" type="text">
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
          <label class="control-label col-md-2">Meninggal</label>
          <div class="col-md-1">
              <input name="meninggal" id="meninggal" value="<?php echo isset($value)?$value->meninggal:''?>" placeholder="" class="form-control" type="text" >
          </div>
          <label class="control-label col-md-1">Luka/Sakit</label>
          <div class="col-md-1">
              <input name="luka" id="luka" value="<?php echo isset($value)?$value->luka:''?>" placeholder="" class="form-control" type="text" >
          </div>
          <label class="control-label col-md-1">Hilang</label>
          <div class="col-md-1">
              <input name="hilang" id="hilang" value="<?php echo isset($value)?$value->hilang:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Mengungsi</label>
          <div class="col-md-1">
              <input name="mengungsi" id="mengungsi" value="<?php echo isset($value)?$value->mengungsi:''?>" placeholder="" class="form-control" type="text" >
          </div>
            <div class="col-md-2" style="margin-left: -20px">
            <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'satuan_korban'), 'id'=>'value', 'name' => 'label'),'','satuan_korban_mengungsi','satuan_korban_mengungsi','chosen-slect form-control','','');?>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Terdampak</label>
          <div class="col-md-1">
              <input name="terdampak" id="terdampak" value="<?php echo isset($value)?$value->terdampak:''?>" placeholder="" class="form-control" type="text" >
          </div>
            <div class="col-md-2" style="margin-left: -20px">
            <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'satuan_korban'), 'id'=>'value', 'name' => 'label'),'','satuan_korban_terdampak','satuan_korban_terdampak','chosen-slect form-control','','');?>
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
      <table id="dynamic-table" base-url="kebencanaan/T_korban/get_data?id_bencana=<?php echo isset($id_bencana)?$id_bencana:''?>" url-detail="kebencanaan/T_korban/show_detail" class="table table-striped table-bordered table-hover">
       <thead>
        <tr style="background-color: #213a6d">  
          <th width="40px" class="center"></th>
          <th width="40px"></th>
          <th width="70px">ID</th>
          <th>Tanggal</th>
          <th>Meninggal</th>
          <th>Luka/Sakit</th>
          <th>Mengungsi</th>
          <th>Hilang</th>
          <th>Terdampak</th>
          <th>Keterangan</th>
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



