
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
  <input type="hidden" name="reg_id" value="<?php echo $type; ?>">

  <div class="form-group">
    <label class="control-label col-md-2">ID</label>
    <div class="col-md-1">
        <input name="id" id="id" value="<?php echo isset($value)?$value->id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-2">NIK</label>
    <div class="col-md-4">
        <input name="nik" id="nik" value="<?php echo isset($value)?$value->nik:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> style="width: 200px !important">
    </div>

    <label class="control-label col-md-2">Nama Lengkap</label>
    <div class="col-md-4">
        <input name="nama" id="nama" value="<?php echo isset($value)?$value->nama:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
    </div>

  </div>

  <div class="form-group">      
    <label class="control-label col-md-2">Jenis Kelamin</label>
    <div class="col-md-4">
      <div class="radio">
        <label>
          <input name="jk" type="radio" class="ace" id="jk_l" value="L" <?php echo isset($value) ? ($value->jk == 'L') ? 'checked="checked"' : '' : 'checked="checked"'; ?> />
          <span class="lbl"> Laki-Laki</span>
        </label>
        <label>
          <input name="jk" type="radio" class="ace" id="jk_p" value="p" <?php echo isset($value) ? ($value->jk == 'p') ? 'checked="checked"' : '' : ''; ?>/>
          <span class="lbl"> Perempuan</span>
        </label>
      </div>
    </div>
    <label class="control-label col-md-2">Tempat Dilahirkan</label>
    <div class="col-md-2">
    <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'tempat_dilahirkan'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->tempat_dilahirkan:'','tempat_dilahirkan','tempat_dilahirkan','chosen-slect form-control','','');?>
    </div>

  </div>
  

  <div class="form-group">
    <label class="control-label col-md-2">Tempat Kelahiran</label>
    <div class="col-md-4">
        <input name="tempat_kelahiran" id="tempat_kelahiran" value="<?php echo isset($value)?$value->tempat_kelahiran:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> style="width: 200px !important">
    </div>
    <label class="control-label col-md-2">Tanggal Lahir</label>  
    <div class="col-md-2">
        <div class="input-group">
            <input name="tgl_lhr" id="tgl_lhr" value="<?php echo isset($value)?$value->tgl_lhr:''?>"  class="form-control date-picker" type="text">
            <span class="input-group-addon">
            <i class="ace-icon fa fa-calendar"></i>
            </span>
        </div>
    </div>
    <label class="control-label col-md-1" style="margin-left: -10px">Jam</label>
    <div class="col-md-2">
      <div class="input-group bootstrap-timepicker">
        <input id="jam_lhr" name="jam_lhr" type="text" class="timepicker form-control" value="<?php echo isset($value)?$this->tanggal->formatTime($value->jam_lhr):''?>">
        <span class="input-group-addon">
          <i class="fa fa-clock-o bigger-110"></i>
        </span>
      </div>
    </div>

  </div>


  <div class="form-group">
    <label class="control-label col-md-2">Kelahiran Ke</label>
    <div class="col-md-4">
        <input name="lhr_ke" id="lhr_ke" value="<?php echo isset($value)?$value->lhr_ke:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> style="width: 100px !important">
    </div>
    <label class="control-label col-md-2">Jenis Kelahiran</label>
    <div class="col-md-3">
    <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_kelahiran'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->jenis_kelahiran:'','jenis_kelahiran','jenis_kelahiran','chosen-slect form-control','','');?>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-md-2">Penolong Kelahiran</label>
    <div class="col-md-4">
    <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'penolong_kelahiran'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->penolong_kelahiran:'','penolong_kelahiran','penolong_kelahiran','chosen-slect form-control','','style="width: 150px"');?>
    </div>

    <label class="control-label col-md-2">Berat Bayi</label>
    <div class="col-md-1">
        <input name="bb" id="bb" value="<?php echo isset($value)?$value->bb:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
    </div>
    <label class="control-label col-md-1">Panjang</label>
    <div class="col-md-1">
        <input name="panjang" id="panjang" value="<?php echo isset($value)?$value->panjang:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
    </div>

  </div>

  <div class="form-group">
    <label class="control-label col-md-2">No Kartu Keluarga</label>
    <div class="col-md-4">
        <input name="no_kk" id="no_kk" value="<?php echo isset($value)?$value->no_kk:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
    </div>
    <label class="control-label col-md-2">Nama Kepala Keluarga</label>
    <div class="col-md-4">
        <input name="nama_kk" id="nama_kk" value="<?php echo isset($value)?$value->nama_kk:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
    </div>
  </div>
  
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
          $('#reg_id').val(jsonResponse.reg_id);
          $('#id').val(jsonResponse.ktp_id);
          oTable.ajax.reload();
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
  

</script>

