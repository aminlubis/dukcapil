
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

<form class="form-horizontal" method="post" id="form-default" action="<?php echo site_url('kebencanaan/T_bencana/process')?>" enctype="multipart/form-data">
    <br>

    <div class="form-group">
    <label class="control-label col-md-2">ID</label>
    <div class="col-md-1">
        <input name="id" id="id" value="<?php echo isset($value)?$value->id_bencana:0?>" placeholder="Auto" class="form-control" type="text" readonly>
    </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Nama Bencana</label>
      <div class="col-md-4">
          <input name="nama_bencana" id="nama_bencana" value="<?php echo isset($value)?$value->nama_bencana:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Jenis Bencana</label>
      <div class="col-md-2">
      <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'jenis_bencana'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->jenis_bencana:'','jenis_bencana','jenis_bencana','chosen-slect form-control','','');?>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Tanggal Kejadian</label>  
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
      
      <label class="control-label col-md-1">Zona Waktu</label>
      <div class="col-md-5">
        <div class="radio">
          <label>
            <input name="zona_waktu" type="radio" class="ace" value="WIB" <?php echo isset($value) ? ($value->zona_waktu == 'WIB') ? 'checked="checked"' : '' : 'checked="checked"'; ?> <?php echo ($flag=='read')?'readonly':''?> />
            <span class="lbl"> WIB</span>
          </label>
          <label>
            <input name="zona_waktu" type="radio" class="ace" value="WITA" <?php echo isset($value) ? ($value->zona_waktu == 'WITA') ? 'checked="checked"' : '' : ''; ?> <?php echo ($flag=='read')?'readonly':''?>/>
            <span class="lbl"> WITA</span>
          </label>
          <label>
            <input name="zona_waktu" type="radio" class="ace" value="WIT" <?php echo isset($value) ? ($value->zona_waktu == 'WIT') ? 'checked="checked"' : '' : ''; ?> <?php echo ($flag=='read')?'readonly':''?>/>
            <span class="lbl"> WIT</span>
          </label>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Sumber Informasi</label>
      <div class="col-md-4">
          <input name="penanggung_jawab" id="penanggung_jawab" value="<?php echo isset($value)?$value->penanggung_jawab:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Foto Cover</label>
      <div class="col-md-3" style="margin-left: 5px">
          <input name="foto_default" id="foto_default"  class="form-control" type="file" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
    </div>
    <?php if(isset($value) AND $value->foto_default != NULL) :?>
    <div class="form-group">
      <label class="col-md-2">&nbsp;</label>
      <div class="col-md-3" style="margin-left: 5px">
          <a href="<?php echo base_url().PATH_IMG_CONTENT.$value->foto_default; ?>" target="_blank"><img src="<?php echo base_url().PATH_IMG_CONTENT.$value->foto_default; ?>" width="300px" style="margin-bottom: 10px"></a>
      </div>
    </div>
    <?php endif; ?>
    
    <div class="form-group">
      <label class="control-label col-md-2">No SK Darurat</label>
      <div class="col-md-4">
          <input name="no_sk_darurat" id="no_sk_darurat" value="<?php echo isset($value)?$value->no_sk_darurat:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-2">Upload Lampiran SK</label>
      <div class="col-md-3" style="margin-left: 5px">
          <input name="lampiran_sk" id="lampiran_sk"  class="form-control" type="file" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Status</label>
      <div class="col-md-2">
        <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'status_bencana'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->status_bencana:'','status_bencana','status_bencana','chosen-slect form-control','','');?>
      </div>
      <label class="control-label col-md-1">Level</label>
      <div class="col-md-2">
        <?php echo $this->master->custom_selection(array('table'=>'global_parameter', 'where'=>array('flag'=>'level_bencana'), 'id'=>'value', 'name' => 'label'),isset($value)?$value->level_bencana:'','level_bencana','level_bencana','chosen-slect form-control','','');?>
      </div>
    </div>
    
    
    <?php if(isset($value) AND $value->lampiran_sk != NULL) :?>
    <div class="form-group">
      <label class="col-md-2">&nbsp;</label>
      <div class="col-md-5" style="margin-left: 5px">
          <a href="<?php echo base_url().PATH_IMG_CONTENT.$value->lampiran_sk; ?>" target="_blank"><?php echo isset($value)?'Lampiran SK Darurat Nomor : '.$value->no_sk_darurat:'Lampiran SK'?></a>
      </div>
    </div>
    <?php endif; ?>

    <h3 class="header smaller lighter blue">
    Wilayah Bencana
    <small>Provinsi, Kabupaten/Kota, Kecamatan dan Wilayah Terdampak</small>
    </h3>

    <div class="form-group">
      <label class="control-label col-md-2">Pencarian Google</label>
      <div class="col-md-8">
        <div id="locationField">
          <input id="autocomplete" class="form-control" placeholder="Enter your address" onFocus="geolocate()" type="text"/>
        </div>
      </div>
    </div>

    <div class="form-group" id="address">
          <label class="control-label col-md-2">Provinsi</label>
          <div class="col-md-3">
              <input class="form-control" id="administrative_area_level_1" disabled type="text"/>
              <input type="hidden" name="provinsiHidden" value="<?php echo isset($value)?$value->provinsi:'' ?>" id="provinsiHidden">
          </div>
          <label class="control-label col-md-2">Kota / Kabupaten</label>
          <div class="col-md-3">
              <input class="form-control" id="locality" disabled type="text"/>
              <input type="hidden" name="kotaHidden" value="<?php echo isset($value)?$value->kabkota:'' ?>" id="kotaHidden">
          </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2">Longitude
            <span class="required" aria-required="true"> * </span>
        </label>
        <div class="col-sm-2">
            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Pilih Lokasi dari maps" value="<?php echo isset($value->longitude)?$value->longitude:106.8070193; ?>">
        </div>
        <label class="control-label col-md-1">Latitude
            <span class="required" aria-required="true"> * </span>
        </label>
        <div class="col-sm-2">
            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Pilih Lokasi dari maps" value="<?php echo isset($value->latitude)?$value->latitude:''; ?>">
        </div>
    </div>

    

    <!-- <div class="form-group">
      <label class="control-label col-md-2">Kecamatan</label>
      <div class="col-md-3">
          <input id="inputKecamatan" class="form-control" name="kecamatan" type="text" placeholder="Masukan keyword minimal 3 karakter" value="<?php echo isset($value)?($value->kecamatan!=null)?"$value->kecamatan : $value->nama_kec":'':''?>"  <?php echo ($flag=='read')?'readonly':''?>/>
          <input type="hidden" name="kecamatanHidden" value="<?php echo isset($value)?$value->kecamatan:''?>" id="kecamatanHidden">
      </div>
      <div id="village" <?php echo isset($value) ?'':'style="display:none"'; ?>>
          <label class="control-label col-md-2">Kelurahan</label>

          <div class="col-md-3">
              <input id="inputKelurahan" style="margin-left:-9px" class="form-control" name="kelurahan" type="text" placeholder="Masukan keyword minimal 3 karakter" value="<?php echo isset($value)?($value->kelurahan!=null)?"$value->kelurahan : $value->nama_kel":'':''?>" <?php echo ($flag=='read')?'readonly':''?>/> 
              <input type="hidden" name="kelurahanHidden" value="<?php echo isset($value)?$value->kelurahan:''?>" id="kelurahanHidden">
          </div>
      </div>
    </div> -->
                
    <!-- <div class="form-group">
      <label class="control-label col-md-2">Alamat Lengkap</label>
      <div class="col-md-4">
          <textarea name="alamat" class="form-control" style="height:80px !important"><?php echo isset($value)?$value->alamat:''?></textarea>
      </div>
    </div> -->

    <!-- <div class="form-group" style="padding-top: 5px">
      <label class="control-label col-md-2">Latitude</label>
      <div class="col-md-2">
          <input name="latitude" id="latitude" value="<?php echo isset($value)?$value->latitude:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
      <label class="control-label col-md-1">Longitude</label>
      <div class="col-md-2">
          <input name="longitude" id="longitude" value="<?php echo isset($value)?$value->longitude:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
      </div>
    </div> -->

    <div class="form-group">
      <label class="control-label col-md-2">Wilayah Terdampak</label>
      <div class="col-md-8" style="margin-left: 7px; margin-bottom: 3px">
          <input type="text" name="wilayah_terdampak" id="form-field-tags" value="<?php echo isset($value)?$value->wilayah_terdampak:''?>" placeholder="Enter tags ..." style="display: none;">
      </div>
    </div>

    <h3 class="header smaller lighter blue">
    Keterangan Bencana
    <small>Penyebab, Kronologi Bencana dan Bantuan Pusat (BNPB)</small>
    </h3>

    <!-- <div class="form-group">
      <label class="control-label col-md-2">Penyebab</label>
      <div class="col-md-10" style="margin-left: 5px">
          <div class="wysiwyg-editor" id="editor_penyebab"><?php echo isset($value->penyebab)?$value->penyebab:''?></div>
          <textarea spellcheck="false" id="penyebab" name="penyebab" style="display:none"><?php echo isset($value->penyebab)?$value->penyebab:''?></textarea>
      </div>
    </div> -->
    
    <div class="row">
      <div class="form-group" style="margin-top: 3px">
        <label class="col-md-6"><b>Kronologis kejadian bencana</b></label>
      </div>

      <div class="col-md-12">
          <div class="wysiwyg-editor" id="editor_kronologis"><?php echo isset($value->kronologis)?$value->kronologis:''?></div>
          <textarea spellcheck="false" id="kronologis" name="kronologis" style="display:none"><?php echo isset($value->kronologis)?$value->kronologis:''?></textarea>
      </div>
    </div>
    
    <div class="row" style="padding-top: 10px">
      <div class="form-group">
        <label class="col-md-6"><b>Upaya pemerintah pusat/daerah</b></label>
      </div>
      
      <div class="col-md-12">
          <div class="wysiwyg-editor" id="editor_bantuan_bnpb"><?php echo isset($value->bantuan_bnpb)?$value->bantuan_bnpb:''?></div>
          <textarea spellcheck="false" id="bantuan_bnpb" name="bantuan_bnpb" style="display:none"><?php echo isset($value->bantuan_bnpb)?$value->bantuan_bnpb:''?></textarea>
      </div>
    </div>
    
    <div class="row">
      <div class="form-actions center">
        <a onclick="getMenu('kebencanaan/T_bencana')" href="#" class="btn btn-sm btn-success">
            <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
            Kembali ke daftar
        </a>
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

    $('#inputKota').typeahead({
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
            $('#inputProvinsi').val('');
            $('#kotaHidden').val('');
            $('#inputKota').val('');           

            $.getJSON("<?php echo site_url('Templates/References/getRegencyById') ?>/" + val_item, '', function (data) {  
              
              $('#provinsiHidden').val(data.province_id);
              $('#inputProvinsi').val(data.province_name);
              $('#kotaHidden').val(data.regency_id);
              $('#inputKota').val(data.regency_name);           

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

<script src="<?php echo base_url()?>/assets/js/jquery-ui.custom.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.ui.touch-punch.js"></script>
<script src="<?php echo base_url()?>/assets/js/markdown/markdown.js"></script>
<script src="<?php echo base_url()?>/assets/js/markdown/bootstrap-markdown.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.hotkeys.js"></script>
<script src="<?php echo base_url()?>/assets/js/bootstrap-wysiwyg.js"></script>
<script src="<?php echo base_url()?>/assets/js/bootbox.js"></script>



<script type="text/javascript">
    jQuery(function($) {
      $('.wysiwyg-editor').ace_wysiwyg({
        toolbar:
        [
          {
            name:'font',
            title:'Custom tooltip',
            values:['Some Font!','Arial','Verdana','Comic Sans MS','Custom Font!']
          },
          null,
          {
            name:'fontSize',
            title:'Custom tooltip',
            values:{1 : 'Size#1 Text' , 2 : 'Size#1 Text' , 3 : 'Size#3 Text' , 4 : 'Size#4 Text' , 5 : 'Size#5 Text'} 
          },
          null,
          {name:'bold', title:'Custom tooltip'},
          {name:'italic', title:'Custom tooltip'},
          {name:'strikethrough', title:'Custom tooltip'},
          {name:'underline', title:'Custom tooltip'},
          null,
          'insertunorderedlist',
          'insertorderedlist',
          'outdent',
          'indent',
          null,
          {name:'justifyleft'},
          {name:'justifycenter'},
          {name:'justifyright'},
          {name:'justifyfull'},
          null,
          {
            name:'createLink',
            placeholder:'Custom PlaceHolder Text',
            button_class:'btn-purple',
            button_text:'Custom TEXT'
          },
          {name:'unlink'},
          null,
          {
            name:'insertImage',
            placeholder:'Custom PlaceHolder Text',
            button_class:'btn-inverse',
            //choose_file:false,//hide choose file button
            button_text:'Set choose_file:false to hide this',
            button_insert_class:'btn-pink',
            button_insert:'Insert Image'
          },
          null,
          {
            name:'foreColor',
            title:'Custom Colors',
            values:['red','green','blue','navy','orange'],
            /**
              You change colors as well
            */
          },
          /**null,
          {
            name:'backColor'
          },*/
          null,
          {name:'undo'},
          {name:'redo'},
          null,
          'viewSource'
        ],
        //speech_button:false,//hide speech button on chrome
        
        'wysiwyg': {
          hotKeys : {} //disable hotkeys
        }
        
      }).prev().addClass('wysiwyg-style2');

      
      
      //handle form onsubmit event to send the wysiwyg's content to server
      $('#form-default').on('submit', function(){
        
        //put the editor's html content inside the hidden input to be sent to server
        
        $('#penyebab').val($('#editor_penyebab').html());
        $('#kronologis').val($('#editor_kronologis').html());
        $('#bantuan_bnpb').val($('#editor_bantuan_bnpb').html());

        var formData = new FormData($('#form-default')[0]);
        /*formData.append('content', $('input[name=wysiwyg-value]' , this).val($('#editor').html()) ); */
        //pf_file_name = new Array();
        pf_file = new Array();

          var formData = new FormData($('#form-default')[0]);
          
          i=0;
          
          //formData.append('pf_file_name', pf_file_name);


        url = $('#form-default').attr('action');

        // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            
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
                $('#page-area-content').load('kebencanaan/T_bencana/form/'+jsonResponse.id+'');
              }else{
                $.achtung({message: jsonResponse.message, timeout:5});
              }
              achtungHideLoader();
            }
        });

        //but for now we will show it inside a modal box

        /*$('#modal-wysiwyg-editor').modal('show');
        $('#wysiwyg-editor-value').css({'width':'99%', 'height':'200px'}).val($('#editor').html());*/
        
        return false;
      });
      $('#form-default').on('reset', function() {
        $('#editor').empty();
      });
    });

  </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwKjP-500lfTc-2Jio-IWIf-6w3yDEg2I&libraries=places"></script>
<script>
// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:

$( "#autocomplete" )
  .keypress(function(event) {
    var keycode =(event.keyCode?event.keyCode:event.which); 
    if(keycode == 13){
      event.preventDefault();
      $('#administrative_area_level_1').focus();
    }
});

var placeSearch, autocomplete;

var componentForm = {
  // street_number: 'short_name',
  // route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  // country: 'long_name',
  // postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'), 
        {types: ['geocode']}
  );

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  // autocomplete.setFields(['address_component']);
  autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }

  // get geometry
  var geometry = place.geometry;
  $('#latitude').val(geometry.location.lat);
  $('#longitude').val(geometry.location.lng);
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwKjP-500lfTc-2Jio-IWIf-6w3yDEg2I&libraries=places&callback=initAutocomplete" async defer></script>
