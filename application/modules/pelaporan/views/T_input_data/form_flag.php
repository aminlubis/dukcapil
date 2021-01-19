
<br>
<div class="pull-right">
    <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-primary">
        <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
        Simpan Data
    </button>
</div>
<p style="font-weight: bold; font-size: 14px">DATA <?php echo strtoupper(str_replace('_',' ', $type)); ?></p>
<!-- hidden form -->
<input type="hidden" name="type" value="<?php echo $type; ?>">

<div class="form-group">
  <label class="control-label col-md-2">ID</label>
  <div class="col-md-1">
      <input name="id" id="id" value="<?php echo isset($value)?$value->id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-2">NIK <?php echo ucwords(str_replace('_',' ', $type)); ?></label>
  <div class="col-md-2">
      <input name="nik" id="nik" value="<?php echo isset($value)?$value->nik:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?>>
  </div>

  <label class="control-label col-md-2">Nama Lengkap</label>
  <div class="col-md-3">
      <input name="nama" id="nama" value="<?php echo isset($value)?$value->nama:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-2">Tanggal Lahir</label>  
  <div class="col-md-2">
      <div class="input-group">
          <input name="tgl_lhr" id="tgl_lhr" value="<?php echo isset($value)?$value->tgl_lhr:''?>"  class="form-control date-picker" type="text">
          <span class="input-group-addon">
          <i class="ace-icon fa fa-calendar"></i>
          </span>
      </div>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-2">Jenis Pekerjaan</label>
  <div class="col-md-3">
  <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_pekerjaan'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->jenis_pekerjaan:'','jenis_pekerjaan','jenis_pekerjaan','chosen-slect form-control','','');?>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-2">Alamat</label>
  <div class="col-md-4">
      <textarea name="alamat" id="alamat" value="<?php echo isset($value)?$value->alamat:''?>" placeholder="" style="height: 60px !important" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> ></textarea>
  </div>
</div>

<div class="form-group" style="margin-top: 3px">
  <label class="col-md-2">&nbsp;</label>
  <label class="control-label col-md-1" style="margin-left: 18px">RT</label>
  <div class="col-md-1">
      <input name="rt" id="rt" value="<?php echo isset($value)?$value->rt:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
  </div>
  <label class="control-label col-md-1">RW</label>
  <div class="col-md-1">
      <input name="rw" id="rw" value="<?php echo isset($value)?$value->rw:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
  </div>
</div>

<div class="form-group">

  <div id="prov" <?php echo isset($value) ?'':'style="display:none"'; ?>>
    <label class="control-label col-md-2">Provinsi</label>
    <div class="col-md-3">
        <input id="inputProvinsi" style="margin-left:-9px;margin-bottom:3px;" class="form-control" name="provinsi" type="text" placeholder="Masukan keyword minimal 3 karakter" value="<?php echo isset($value)?($value->id_dc_propinsi!=null)?"$value->id_dc_propinsi : $value->provinsi":'':''?>" <?php echo ($flag=='read')?'readonly':''?>/>
        <input type="hidden" name="provinsiHidden" value="<?php echo isset($value)?$value->id_dc_propinsi:'' ?>" id="provinsiHidden">
    </div>


    <label class="control-label col-md-2" style="margin-left:-13px;">Kota / Kabupaten</label>
    <div class="col-md-3">
        <input id="inputKota" style="margin-left:-9px" class="form-control" name="kota" type="text" placeholder="Masukan keyword minimal 3 karakter" value="<?php echo isset($value)?($value->id_dc_kota!=null)?"$value->id_dc_kota : $value->kota":'':''?>" <?php echo ($flag=='read')?'readonly':''?>/>
        <input type="hidden" name="kotaHidden" value="<?php echo isset($value)?$value->id_dc_kota:'' ?>" id="kotaHidden">
    </div>
  </div>

</div>

<div class="form-group">
  <label class="control-label col-md-2">Kecamatan</label>
  <div class="col-md-3">
      <input id="inputKecamatan" class="form-control" name="kecamatan" type="text" placeholder="Masukan keyword minimal 3 karakter" value="<?php echo isset($value)?($value->id_dc_kecamatan!=null)?"$value->id_dc_kecamatan : $value->kecamatan":'':''?>"  <?php echo ($flag=='read')?'readonly':''?>/>
      <input type="hidden" name="kecamatanHidden" value="<?php echo isset($value)?$value->id_dc_kecamatan:''?>" id="kecamatanHidden">
  </div>
  

  <div id="village" <?php echo isset($value) ?'':'style="display:none"'; ?>>
    <label class="control-label col-md-2">Kelurahan</label>
    <div class="col-md-3">
        <input id="inputKelurahan" style="margin-left:-9px" class="form-control" name="kelurahan" type="text" placeholder="Masukan keyword minimal 3 karakter" value="<?php echo isset($value)?($value->id_dc_kelurahan!=null)?"$value->id_dc_kelurahan : $value->kelurahan":'':''?>" <?php echo ($flag=='read')?'readonly':''?>/> 
        <input type="hidden" name="kelurahanHidden" value="<?php echo isset($value)?$value->id_dc_kelurahan:''?>" id="kelurahanHidden">
    </div>
  </div>

</div>
      
<div class="form-group">
  <label class="control-label col-md-2">Kewarganegaraan</label>
  <div class="col-md-2">
    <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'kewarganegaraan'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->kewarganegaraan:'','kewarganegaraan','kewarganegaraan','chosen-slect form-control','','');?>
  </div>
  <label class="control-label col-md-2">Kebangsaan (WNA)</label>
  <div class="col-md-3">
    <input id="kebangsaan" class="form-control" name="kebangsaan" type="text" value="<?php echo isset($value)?$value->kode_pos:''?>" <?php echo ($flag=='read')?'readonly':''?>/>
  </div>
</div>
<?php if($type == 'ibu') :?>
<div class="form-group">
  <label class="control-label col-md-2">Tanggal Perkawinan</label>  
  <div class="col-md-2">
      <div class="input-group">
          <input name="tgl_perkawinan" id="tgl_perkawinan" value="<?php echo isset($value)?$value->tgl_perkawinan:''?>"  class="form-control date-picker" type="text">
          <span class="input-group-addon">
          <i class="ace-icon fa fa-calendar"></i>
          </span>
      </div>
  </div>
</div>
<?php endif; ?>

<?php if($type == 'pelapor') :?>
<div class="form-group">
  <label class="control-label col-md-2">Tanggal Lapor</label>  
  <div class="col-md-2">
      <div class="input-group">
          <input name="tgl_lapor" id="tgl_lapor" value="<?php echo isset($value)?$value->tgl_lapor:''?>"  class="form-control date-picker" type="text">
          <span class="input-group-addon">
          <i class="ace-icon fa fa-calendar"></i>
          </span>
      </div>
  </div>
</div>
<?php endif; ?>



<script src="<?php echo base_url().'assets/js/custom/als_datatable.js'?>"></script>
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script src="<?php echo base_url()?>assets/js/typeahead.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-tag.js"></script>

<!-- timepicker -->
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-timepicker.js"></script>

<script>

$(document).ready(function(){
  
  $('#form-default').ajaxForm({
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
        $('#id').val(jsonResponse.ktp_id);
      }else{
        $.achtung({message: jsonResponse.message, timeout:5});
      }
      achtungHideLoader();
    }
  }); 
})

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

    var tag_input = $('#form-field-tags');
    try{
    tag_input.tag(
        {
        placeholder:tag_input.attr('placeholder'),
        //enable typeahead by specifying the source array
        // source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
        /**
        //or fetch data from database, fetch those that match "query"
        source: function(query, process) {
        $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
        .done(function(result_items){
        process(result_items);
        });
        }
        */
        }
    )

    //programmatically add a new
    // var $tag_obj = $('#form-field-tags').data('tag');
    // $tag_obj.add('Programmatically Added');
    }
    catch(e) {
    //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
    tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
    //$('#form-field-tags').autosize({append: "\n"});
    }
    
});

$('#locality').typeahead({
    source: function (query, result) {
        $.ajax({
            url: "Templates/References/getRegencyByKeyword",
            data: 'keyword=' + query ,         
            dataType: "json",
            type: "POST",
            success: function (response) {
            result($.map(response, function (item) {
                return item;
            }));
            }
        });
    },
    afterSelect: function (item) {
    // do what is needed with item
    var val_item=item.split(':')[0];
    var label=item.split(':')[1];
    $(this).val(label);

    if (val_item) {          

        $('#provinsiHidden').val('');
        $('#administrative_area_level_1').val('');
        $('#kotaHidden').val('');
        $('#locality').val('');           

        $.getJSON("<?php echo site_url('Templates/References/getRegencyById') ?>/" + val_item, '', function (data) {  
          
            $('#provinsiHidden').val(data.province_id);
            $('#administrative_area_level_1').val(data.province_name);
            $('#kotaHidden').val(data.regency_id);
            $('#locality').val(data.regency_name);           
            $('#ZONA_'+data.zona_waktu+'').prop('checked', true);
            $('#zona_waktu_hidden').val(data.zona_waktu);           
            
          });

          $('#prov').show('fast');
      }      
    }
});

$('#inputKecamatan').typeahead({
  source: function (query, result) {
      $.ajax({
          url: "Templates/References/getDistricts",
          data: 'keyword=' + query ,         
          dataType: "json",
          type: "POST",
          success: function (response) {
            result($.map(response, function (item) {
                return item;
            }));
          }
      });
  },
  afterSelect: function (item) {
    // do what is needed with item
    var val_item=item.split(':')[0];

    if (val_item) {          

      $('#provinsiHidden').val('');
      $('#inputProvinsi').val('');
      $('#kotaHidden').val('');
      $('#inputKota').val('');           

      $.getJSON("<?php echo site_url('templates/References/getDistrictsById') ?>/" + val_item, '', function (data) {  
        
        $('#provinsiHidden').val(data.province_id);
        $('#inputProvinsi').val(data.province_name);
        $('#kotaHidden').val(data.regency_id);
        $('#inputKota').val(data.regency_name);           

      }); 
      $('#kecamatanHidden').val(val_item);
      $('#prov').show('fast');
      $('#village').show('fast'); 
    }      
  }
});

$('#inputKelurahan').typeahead({
  source: function (query, result) {
      $.ajax({
          url: "Templates/References/getVillage",
          data: 'keyword=' + query + '&district=' + $('#kecamatanHidden').val(),             
          dataType: "json",
          type: "POST",
          success: function (response) {
            result($.map(response, function (item) {
                return item;
            }));
          }
      });
  },
  afterSelect: function (item) {
    // do what is needed with item
    var val_item=item.split(':')[0];
    $('#kelurahanHidden').val(val_item);
  
  }
});


</script>

