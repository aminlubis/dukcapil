
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
    <p style="font-weight: bold; font-size: 14px">DATA <?php echo strtoupper(str_replace('_',' ', $type)); ?></p>
    <!-- hidden form -->
    <input type="hidden" name="type" value="<?php echo $type; ?>">

    <div class="checkbox">
      <label>
        <input name="form-field-checkbox" type="checkbox" class="ace">
        <span class="lbl"> Surat Kelahiran dari Dokter/Bidan/Penolong</span>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <input name="form-field-checkbox" type="checkbox" class="ace">
        <span class="lbl"> Nama dan Identitas Saksi Kelahiran</span>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <input name="form-field-checkbox" type="checkbox" class="ace">
        <span class="lbl"> Kartu Keluarga (KK) Orang Tua</span>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <input name="form-field-checkbox" type="checkbox" class="ace">
        <span class="lbl"> Kartu Tanda Penduduk (KTP) Orang Tua</span>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <input name="form-field-checkbox" type="checkbox" class="ace">
        <span class="lbl"> Kutipan Akta Nikah/Akta Perkawinan Orang Tua</span>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <input name="form-field-checkbox" type="checkbox" class="ace">
        <span class="lbl"> SPTJM Kebenaran Data Kelahiran</span>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <input name="form-field-checkbox" type="checkbox" class="ace">
        <span class="lbl"> SPTJM Kebenaran Sebagai Pasangan Suami-Istri</span>
      </label>
    </div>

    <div class="row">
      <div class="form-actions center">
        <?php if($flag != 'read'):?>
        <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
            <i class="ace-icon fa fa-close icon-on-right bigger-110"></i>
            Reset Form
        </button>
        <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info">
            <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
            Simpan Data
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

        if (val_item) {          

            $.getJSON("<?php echo site_url('templates/References/getVillagesById') ?>/" + val_item, '', function (data) {                        

              $.each(data, function (i, o) {                  

                  console.log(o)
                  $('#zipcode').val(o.kode_pos);

              });            

            }); 
          }      
      }
    });
    

</script>

