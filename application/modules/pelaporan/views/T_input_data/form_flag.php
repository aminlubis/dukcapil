
<style>
  /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
  #map {
    height: 100%;
  }
  .tags{
    width: 100% !important;
  }
</style>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

<form class="form-horizontal" method="post" id="form-default" action="<?php echo site_url('pelaporan/T_input_data/process')?>" enctype="multipart/form-data">
    <br>
    <!-- hidden form -->
    <input type="hidden" name="type" value="<?php echo $type; ?>">

    <div class="form-group">
      <label class="control-label col-md-2">ID</label>
      <div class="col-md-1">
          <input name="id" id="id" value="<?php echo isset($value)?$value->id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">NIK</label>
      <div class="col-md-4">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> style="width: 200px !important">
      </div>

      <label class="control-label col-md-2">Nama Lengkap</label>
      <div class="col-md-4">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>

    </div>

    <div class="form-group">      
      <label class="control-label col-md-2">Jenis Kelamin</label>
      <div class="col-md-4">
        <div class="radio">
          <label>
            <input name="zona_waktu" type="radio" class="ace" id="jk_l" value="L" <?php echo isset($value) ? ($value->zona_waktu == 'L') ? 'checked="checked"' : '' : 'checked="checked"'; ?> />
            <span class="lbl"> Laki-Laki</span>
          </label>
          <label>
            <input name="zona_waktu" type="radio" class="ace" id="jk_p" value="p" <?php echo isset($value) ? ($value->zona_waktu == 'p') ? 'checked="checked"' : '' : ''; ?>/>
            <span class="lbl"> Perempuan</span>
          </label>
        </div>
      </div>
      <label class="control-label col-md-2">Tempat Dilahirkan</label>
      <div class="col-md-2">
      <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_bencana'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->jenis_bencana:'','jenis_bencana','jenis_bencana','chosen-slect form-control','','');?>
      </div>

    </div>
    

    <div class="form-group">
      <label class="control-label col-md-2">Tempat Kelahiran</label>
      <div class="col-md-4">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> style="width: 200px !important">
      </div>
      <label class="control-label col-md-2">Tanggal Lahir</label>  
      <div class="col-md-2">
          <div class="input-group">
              <input name="tanggal_kejadian" id="tanggal_kejadian" value="<?php echo isset($value)?$value->tanggal_kejadian:''?>"  class="form-control date-picker" type="text">
              <span class="input-group-addon">
              <i class="ace-icon fa fa-calendar"></i>
              </span>
          </div>
      </div>
      <label class="control-label col-md-1" style="margin-left: -10px">Jam</label>
      <div class="col-md-2">
        <div class="input-group bootstrap-timepicker">
          <input id="jam_kejadian" name="jam_kejadian" type="text" class="timepicker form-control" value="<?php echo isset($value)?$this->tanggal->formatTime($value->jam_kejadian):''?>">
          <span class="input-group-addon">
            <i class="fa fa-clock-o bigger-110"></i>
          </span>
        </div>
      </div>

    </div>


    <div class="form-group">
      <label class="control-label col-md-2">Kelahiran Ke</label>
      <div class="col-md-4">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> style="width: 100px !important">
      </div>
      <label class="control-label col-md-2">Jenis Kelahiran</label>
      <div class="col-md-3">
      <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_bencana'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->jenis_bencana:'','jenis_bencana','jenis_bencana','chosen-slect form-control','','');?>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Penolong Kelahiran</label>
      <div class="col-md-4">
      <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_bencana'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->jenis_bencana:'','jenis_bencana','jenis_bencana','chosen-slect form-control','','');?>
      </div>

      <label class="control-label col-md-2">Berat Bayi</label>
      <div class="col-md-1">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
      <label class="control-label col-md-1">Panjang</label>
      <div class="col-md-1">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>

    </div>

    <div class="form-group">
      <label class="control-label col-md-2">No Kartu Keluarga</label>
      <div class="col-md-4">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
      <label class="control-label col-md-2">Nama Kepala Keluarga</label>
      <div class="col-md-4">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
    </div>
    
    <div class="row">
      <div class="form-actions center">
      
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
    </div>
    
</form>

<script src="<?php echo base_url().'assets/js/custom/als_datatable.js'?>"></script>
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script src="<?php echo base_url()?>assets/js/typeahead.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-tag.js"></script>

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

    // $('#inputKelurahan').typeahead({
    //     source: function (query, result) {
    //         $.ajax({
    //             url: "Templates/References/getVillage",
    //             data: 'keyword=' + query + '&district=' + $('#kecamatanHidden').val(),             
    //             dataType: "json",
    //             type: "POST",
    //             success: function (response) {
    //             result($.map(response, function (item) {
    //                 return item;
    //             }));
    //             }
    //         });
    //     },
    //     afterSelect: function (item) {
    //     // do what is needed with item
    //     var val_item=item.split(':')[0];
    //     $('#kelurahanHidden').val(val_item);

    //     if (val_item) {          

    //         $.getJSON("<?php echo site_url('Templates/References/getVillagesById') ?>/" + val_item, '', function (data) {                        

    //             $.each(data, function (i, o) {                  

    //                 console.log(o)
    //                 $('#zipcode').val(o.kode_pos);

    //             });            

    //         }); 
    //         }      
    //     }
    // });
    

</script>

