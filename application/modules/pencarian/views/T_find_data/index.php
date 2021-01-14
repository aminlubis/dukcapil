<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script src="<?php echo base_url()?>assets/js/typeahead.js"></script>
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
    
})

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


    function set_data_final(id_bencana){
      if(confirm('Are you sure?')){
        $.ajax({
          url : 'pelaporan/T_input_data/set_data_final',
          type: "POST",
          data: {ID : id_bencana},
          dataType: "JSON",        
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
      }
      
    }
  
</script>

<div class="row">
  <div class="col-xs-12">

    <div class="page-header">
      <h1>
        <?php echo $title?>
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          <?php echo isset($breadcrumbs)?$breadcrumbs:''?>
        </small>
      </h1>
    </div><!-- /.page-header -->
    
    <form class="form-horizontal" method="post" id="form_search" action="#">

      <div class="col-md-12">

        <p><b>PENCARIAN AKTA KELAHIRAN</b></p>

        <div class="form-group">

          <div id="prov" <?php echo isset($value) ?'':'style="display:none"'; ?>>
            <label class="control-label col-md-2">Provinsi</label>
            <div class="col-md-3">
                <input id="inputProvinsi" style="margin-left:-9px;margin-bottom:3px;" class="form-control" name="provinsi" type="text" placeholder="Masukan keyword minimal 3 karakter" value=""/>
                <input type="hidden" name="provinsiHidden" value="" id="provinsiHidden">
            </div>


            <label class="control-label col-md-2" style="margin-left:-13px;">Kota / Kabupaten</label>
            <div class="col-md-3">
                <input id="inputKota" style="margin-left:-9px" class="form-control" name="kota" type="text" placeholder="Masukan keyword minimal 3 karakter" value=""/>
                <input type="hidden" name="kotaHidden" value="" id="kotaHidden">
            </div>
          </div>

        </div>

        <div class="form-group">
          <label class="control-label col-md-2">Kecamatan</label>
          <div class="col-md-3">
              <input id="inputKecamatan" class="form-control" name="kecamatan" type="text" placeholder="Masukan keyword minimal 3 karakter" value="" />
              <input type="hidden" name="kecamatanHidden" value="" id="kecamatanHidden">
          </div>
          

          <div id="village" <?php echo isset($value) ?'':'style="display:none"'; ?>>
            <label class="control-label col-md-2">Kelurahan</label>
            <div class="col-md-3">
                <input id="inputKelurahan" style="margin-left:-9px" class="form-control" name="kelurahan" type="text" placeholder="Masukan keyword minimal 3 karakter" value=""/> 
                <input type="hidden" name="kelurahanHidden" value="" id="kelurahanHidden">
            </div>
          </div>

        </div>
        
        <br>
        <p><b>PENCARIAN BERDASARKAN</b></p>


        <div class="form-group">
          <div class="control-label col-md-2">
            <div class="checkbox" style="margin-top: -5px">
              <label>
                <input name="form-field-checkbox" type="checkbox" class="ace">
                <span class="lbl"> No. Akta Kelahiran</span>
              </label>
            </div>
          </div>
          <div class="col-md-2" style="margin-left: -15px">
              <input type="text" value="" name="" id="" class="form-control">
          </div>

          <div class="control-label col-md-3">
            <div class="checkbox" style="margin-top: -5px">
              <label>
                <input name="form-field-checkbox" type="checkbox" class="ace">
                <span class="lbl"> Nama Kepala Keluarga</span>
              </label>
            </div>
          </div>
          <div class="col-md-2" style="margin-left: -15px">
              <input type="text" value="" name="" id="" class="form-control">
          </div>
          
        </div>

        <div class="form-group" style="margin-top: 3px">
          <div class="control-label col-md-2">
            <div class="checkbox" style="margin-top: -5px">
              <label>
                <input name="form-field-checkbox" type="checkbox" class="ace">
                <span class="lbl"> Tanggal Entri</span>
              </label>
            </div>
          </div>
          <div class="col-md-2" style="margin-left: -15px">
              <div class="input-group">
                <input class="form-control date-picker" name="from_tgl" id="from_tgl" type="text" data-date-format="yyyy-mm-dd" value=""/>
                <span class="input-group-addon">
                  <i class="fa fa-calendar bigger-110"></i>
                </span>
              </div>
          </div>

          <div class="col-md-2" style="margin-left: -19px">
            <a href="#" id="btn_search_data" class="btn btn-xs btn-primary">
              <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
              Tampilkan Data
            </a>
          </div>

        </div>

        <div class="clearfix" style="margin-bottom:-5px">
        <div class="pull-right tableTools-container"></div>
      </div>
      <br>
      <p><b>HASIL PENCARIAN DATA</b></p>
      <hr class="separator">
      <!-- div.table-responsive -->

      <!-- div.dataTables_borderWrap -->
      <div style="margin-top:-27px">
        <table id="dynamic-table" base-url="pelaporan/T_input_data" url-detail="pelaporan/T_input_data/show_detail" class="table table-striped table-bordered table-hover">
          <thead>
            <tr>  
              <th width="30px" class="center"></th>
              <th width="40px" class="center"></th>
              <th width="40px" class="center"></th>
              <th width="40px"></th>
              <th width="70px">ID</th>
              <th>No Akta</th>
              <th>Nama Lengkap</th>
              <th>Tanggal Entri</th>
              <th>Provinsi</th>
              <th>Kab/Kota</th>
              <th>Kecamatan</th>
              <th>Kabupaten</th>
              <th width="70px">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

      </div>

      

      

    </form>

  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/als_datatable_with_detail.js'?>"></script>



