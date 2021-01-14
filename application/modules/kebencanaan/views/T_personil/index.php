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
            // getMenuTabs('kebencanaan/T_personil/?id_bencana='+jsonResponse.id_bencana+'', 'tabs_load_content');
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
    $('#div_profesi').show();
    $('#jumlah_personil').val(1).attr('readonly', true);
  }else{
    $('#div_jk').hide();
    $('#div_profesi').hide();
  }
})

function click_edit( id ){
  $.getJSON("<?php echo site_url('kebencanaan/T_personil/click_edit/') ?>" + id, '' , function (data) {  
    // response data
      preventDefault();
      $('#id').val(data.id_bencana_personil);
      $('#tanggal_kedatangan').val(data.tanggal_kedatangan);
      $('#nama_personil').val(data.nama_personil);
      $('#asal_personil').val(data.asal_personil);
      $('#jumlah_personil').val(data.jumlah_personil);
      $('#jenis_kelamin').val(data.jenis_kelamin);
      $('#profesi').val(data.profesi);
      $('#keterangan').val(data.keterangan);
      if( data.asal_personil == 'Perorangan' ){
        $('#div_jk').show();
        $('#div_profesi').show();
      }
  }) 
}

function click_delete(myid){
  if(confirm('Are you sure?')){
    $.ajax({
        url: 'kebencanaan/T_personil/delete',
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
    <form class="form-horizontal" method="post" id="form-logistik" action="<?php echo site_url('kebencanaan/T_personil/process')?>" enctype="multipart/form-data" autocomplete="off">
    <br>
        <!-- hidden form -->
        <input type="hidden" name="id_bencana" value="<?php echo isset($id_bencana)?$id_bencana:''?>">

        <div class="form-group">
          <label class="control-label col-md-2">ID</label>
          <div class="col-md-1">
              <input name="id" id="id" value="<?php echo isset($value)?$value->id_bencana_personil:0?>" placeholder="Auto" class="form-control" type="text" readonly>
          </div>
          <label class="control-label col-md-2">Tanggal Kedatangan</label>  
          <div class="col-md-2">
              <div class="input-group">
                  <input name="tanggal_kedatangan" id="tanggal_kedatangan" value="<?php echo isset($value)?$value->tanggal_kedatangan:date('Y-m-d')?>"  class="form-control date-picker" type="text">
                  <span class="input-group-addon">
                  <i class="ace-icon fa fa-calendar"></i>
                  </span>
              </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Asal Relawan</label>
          <div class="col-md-2">
            <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'asal_relawan'), 'id'=>'value', 'name' => 'label'),'','asal_personil','asal_personil','chosen-slect form-control','','');?>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Nama</label>
          <div class="col-md-4">
              <input name="nama_personil" id="nama_personil" value="<?php echo isset($value)?$value->nama_personil:''?>" placeholder="" class="form-control" type="text" >
              <span style="margin-left: 5px;"><i>Nama Instansi/Organisasi/Badan/Lembaga/Koordinator</i></span>
          </div>
        </div>
        <div class="form-group" style="display: none; padding-top: 6px" id="div_jk" >
          <label class="control-label col-md-2">Jenis Kelamin</label>
          <div class="col-md-3">
            <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_kelamin'), 'id'=>'value', 'name' => 'label'),'','jenis_kelamin','jenis_kelamin','chosen-slect form-control','','');?>
            <span style="margin-left: 5px;">Diisi jika relawan perorangan</span>
          </div>
        </div>
        <div class="form-group" style="padding-top: 6px; display: none" id="div_profesi">
          <label class="control-label col-md-2">Profesi</label>
          <div class="col-md-3">
              <input name="profesi" id="profesi" value="<?php echo isset($value)?$value->profesi:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Jumlah Personil</label>
          <div class="col-md-1">
              <input name="jumlah_personil" id="jumlah_personil" value="<?php echo isset($value)?$value->jumlah_personil:''?>" placeholder="" class="form-control" type="text" >
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
      <table id="dynamic-table" base-url="kebencanaan/T_personil/get_data?id_bencana=<?php echo isset($id_bencana)?$id_bencana:''?>" url-detail="kebencanaan/T_personil/show_detail" class="table table-striped table-bordered table-hover">
       <thead>
          <tr style="background-color: #213a6d">  
          <th></th>
          <th></th>
          <th width="70px">ID</th>
          <th>Nama</th>
          <th>Tanggal</th>
          <th>Asal Relawan</th>
          <th>Jumlah Personil</th>
          <th>Keterangan</th>
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



