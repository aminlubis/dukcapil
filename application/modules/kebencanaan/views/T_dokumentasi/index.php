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
  
    $('#form-dokumentasi').ajaxForm({
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
            // getMenuTabs('kebencanaan/T_dokumentasi/?id_bencana='+jsonResponse.id_bencana+'', 'tabs_load_content');
            $('#form-dokumentasi')[0].reset();
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
  $.getJSON("<?php echo site_url('kebencanaan/T_dokumentasi/click_edit/') ?>" + id, '' , function (data) {  
    // response data
      preventDefault();
      $('#id').val(data.id_bencana_dokumentasi);
      $('#tanggal').val(data.tanggal);
      $('#judul').val(data.judul);
      $('#link').val(data.link);
      $('#author').val(data.author);
      $('#keterangan').val(data.keterangan);
      $('#jenis_dok').val(data.tipe);
      if( data.tipe == 'Foto'){
        $('#div_foto').show();
        $('#foto_img').attr('src','uploaded/images/content/'+data.foto+'');
        $('#foto_img').attr('href','uploaded/images/content/'+data.foto+'');
      }else{
        $('#div_video').show();
      }
  }) 
}

function click_delete(myid){
  if(confirm('Are you sure?')){
    $.ajax({
        url: 'kebencanaan/T_dokumentasi/delete',
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
            $('#form-dokumentasi')[0].reset();
            $('#foto_img').attr('src','');
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
    <form class="form-horizontal" method="post" id="form-dokumentasi" action="<?php echo site_url('kebencanaan/T_dokumentasi/process')?>" enctype="multipart/form-data" autocomplete="off">
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
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Jenis Dokumentasi</label>
          <div class="col-md-2">
            <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_dok'), 'id'=>'value', 'name' => 'label'),'','jenis_dok','jenis_dok','chosen-slect form-control','','');?>
          </div>
        </div>

        <div style="<?php echo isset($value) ? ($value=='Foto')?'':'display: none' : 'display : none'?>" id="div_foto">
          <div class="form-group">
            <label class="control-label col-md-2">Gambar Cover</label>
            <div class="col-md-3" style="margin-left: 5px">
                <input name="foto" id="foto" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="file" multiple="multiple">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">&nbsp;</label>
            <div class="col-md-3" style="margin-left: 5px">
                <a href="#" target="_blank"><img src="" id="foto_img" width="300px" style="margin-bottom: 10px"></a>
            </div>
          </div>
        </div>

        <div class="form-group" style="<?php echo isset( $alue ) ? ($value=='Video') ? '' : 'display: none' : 'display:none'?>" id="div_video">
          <label class="control-label col-md-2">Link Youtube</label>
          <div class="col-md-3">
              <input name="link" id="link" value="<?php echo isset($value)?$value->link:''?>" placeholder="" class="form-control" type="text" multiple="multiple">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Judul</label>
          <div class="col-md-4">
              <input name="judul" id="judul" value="<?php echo isset($value)?$value->judul:''?>" placeholder="" class="form-control" type="text" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Sumber</label>
          <div class="col-md-2">
              <input name="author" id="author" value="<?php echo isset($value)?$value->author:''?>" placeholder="" class="form-control" type="text" >
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
    <?php endif?>

    <hr class="separator">
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div style="margin-top:-27px">
      <table id="dynamic-table" base-url="kebencanaan/T_dokumentasi/get_data?id_bencana=<?php echo isset($id_bencana)?$id_bencana:''?>" url-detail="kebencanaan/T_dokumentasi/show_detail" class="table table-striped table-bordered table-hover">
       <thead>
        <tr style="background-color: #213a6d">  
          <th width="40px" class="center"></th>
          <th width="40px"></th>
          <th width="70px">ID</th>
          <th>Judul</th>
          <th>Tanggal</th>
          <th>Jenis</th>
          <th>Sumber</th>
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



