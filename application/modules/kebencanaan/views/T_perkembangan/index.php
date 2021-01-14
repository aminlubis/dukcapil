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
  
    $('#form-perkembangan').ajaxForm({
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
            // getMenuTabs('kebencanaan/T_perkembangan/?id_bencana='+jsonResponse.id_bencana+'', 'tabs_load_content');
            $('#form-perkembangan')[0].reset();
            reload_table();
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

})

$('select[name=jenis_dok]').change(function(){
  if( $(this).val() == 'Foto' ){
    $('#div_foto').show();
    $('#div_video').hide();
  }else{
    $('#div_foto').hide();
    $('#div_video').show();
  }
})
function click_edit( id ){
  $.getJSON("<?php echo site_url('kebencanaan/T_perkembangan/click_edit/') ?>" + id, '' , function (data) {  
    // response data
      preventDefault();
      $('#id').val(data.id_bencana_perkembangan);
      $('#tanggal').val(data.tanggal);
      $('#waktu').val(data.waktu);
      $('#ZONA_'+data.zona_waktu+'').prop('checked', true);
      $('#dampak').val(data.dampak);
      $('#upaya').val(data.upaya);
      $('#kendala').val(data.kendala);
      $('#kondisi').val(data.kondisi);
      $('#kebutuhan').val(data.kebutuhan);
      $('#relawan').val(data.relawan);
      $('#logistik').val(data.logistik);
      $('#kerusakan').val(data.kerusakan);
      $('#korban').val(data.korban);
  }) 
}

function click_delete(myid){
  if(confirm('Are you sure?')){
    $.ajax({
        url: 'kebencanaan/T_perkembangan/delete',
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
            $('#form-perkembangan')[0].reset();
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
    <form class="form-horizontal" method="post" id="form-perkembangan" action="<?php echo site_url('kebencanaan/T_perkembangan/process')?>" enctype="multipart/form-data" autocomplete="off">
    <br>
        <!-- hidden form -->
        <input type="hidden" name="id_bencana" value="<?php echo isset($id_bencana)?$id_bencana:''?>">

        <div class="form-group">
          <label class="control-label col-md-2">ID</label>
          <div class="col-md-1">
              <input name="id" id="id" value="<?php echo isset($value)?$value->id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
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
              <input name="waktu" id="waktu" value="<?php echo isset($value)?$value->waktu:''?>" placeholder="" class="form-control" type="text" >
          </div> -->

          <label class="control-label col-md-1" style="margin-left: -10px">Jam</label>
          <div class="col-md-2">
            <div class="input-group bootstrap-timepicker">
              <input id="waktu" name="waktu" type="text" class="timepicker form-control" value="<?php echo isset($value)?$this->tanggal->formatTime($value->waktu):''?>">
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

        <!-- <div class="form-group">
          <label class="control-label col-md-2">Dampak</label>
          <div class="col-md-10">
              <input name="dampak" id="dampak" value="<?php echo isset($value)?$value->dampak:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Upaya</label>
          <div class="col-md-10">
              <input name="upaya" id="upaya" value="<?php echo isset($value)?$value->upaya:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div> -->

        <div class="form-group">
          <label class="control-label col-md-2">Kondisi Mutakhir</label>
          <div class="col-md-7">
              <textarea class="form-control" name="kondisi" id="kondisi" style="height: 100px !important">
                <?php echo isset($value)?trim($value->kondisi):''?>
              </textarea>
              <!-- <input name="kondisi" id="kondisi" value="" placeholder="" class="form-control" type="text" > -->
          </div>
        </div>

        <div class="form-group" style="padding-top: 7px">
          <label class="control-label col-md-2">Kendala</label>
          <div class="col-md-7">
              <textarea class="form-control" name="kendala" id="kendala" style="height: 100px !important">
                <?php echo isset($value)?trim($value->kendala):''?>
              </textarea>

              <!-- <input name="kendala" id="kendala" value="<?php echo isset($value)?$value->kendala:''?>" placeholder="" class="form-control" type="text" > -->
          </div>
        </div>

        <div class="form-group" style="padding-top: 7px">
          <label class="control-label col-md-2">Kebutuhan</label>
          <div class="col-md-7">
              <textarea class="form-control" name="kebutuhan" id="kebutuhan" style="height: 100px !important">
                <?php echo isset($value)?trim($value->kebutuhan):''?>
              </textarea>

              <!-- <input name="kebutuhan" id="kebutuhan" value="<?php echo isset($value)?$value->kebutuhan:''?>" placeholder="" class="form-control" type="text" > -->
          </div>
        </div>

        <!-- <div class="form-group">
          <label class="control-label col-md-2">Relawan</label>
          <div class="col-md-10">
              <input name="relawan" id="relawan" value="<?php echo isset($value)?$value->relawan:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Logistik</label>
          <div class="col-md-10">
              <input name="logistik" id="logistik" value="<?php echo isset($value)?$value->logistik:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Kerusakan</label>
          <div class="col-md-10">
              <input name="kerusakan" id="kerusakan" value="<?php echo isset($value)?$value->kerusakan:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Korban</label>
          <div class="col-md-10">
              <input name="korban" id="korban" value="<?php echo isset($value)?$value->korban:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div> -->

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
      <table id="dynamic-table" base-url="kebencanaan/T_perkembangan/get_data?id_bencana=<?php echo isset($id_bencana)?$id_bencana:''?>" url-detail="kebencanaan/T_perkembangan/show_detail" class="table table-striped table-bordered table-hover">
       <thead>
        <tr style="background-color: #213a6d">  
          <th width="40px" class="center"></th>
          <th width="40px"></th>
          <th width="70px">ID</th>
          <th width="170px">Tanggal</th>
          <th>Kendala</th>
          <th>Kondisi</th>
          <th>Kebutuhan</th>
          <th width="120px">Last Updated</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/als_datatable_custom_url.js'?>"></script>



