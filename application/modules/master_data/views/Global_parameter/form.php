<div class="page-header">
  <h1>
    <?php echo $title?>
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      <?php echo $breadcrumbs?>
    </small>
  </h1>
</div><!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
      <div class="widget-body">
        <div class="widget-main no-padding">
            
          <form class="form-horizontal" method="post" id="form-default" action="<?php echo site_url('master_data/Global_parameter/process?flag='.$flag_string.'')?>" enctype="multipart/form-data">
              <br>
              <!-- hidden form -->
              <input type="hidden" name="flag" value="<?php echo $flag_string?>" id="flag_string">

              <div class="form-group">
                <label class="control-label col-md-2">ID</label>
                <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-2">Label</label>
                <div class="col-md-2">
                    <input name="label" id="label" value="<?php echo isset($value)?$value->label:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-2">Value</label>
                <div class="col-md-2">
                    <input name="value" id="value" value="<?php echo isset($value)?$value->value:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-2">Is active?</label>
                <div class="col-md-2">
                  <div class="radio">
                        <label>
                          <input name="is_active" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->is_active == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?> <?php echo ($flag=='read')?'readonly':''?> />
                          <span class="lbl"> Ya</span>
                        </label>
                        <label>
                          <input name="is_active" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->is_active == 'N') ? 'checked="checked"' : '' : ''; ?> <?php echo ($flag=='read')?'readonly':''?>/>
                          <span class="lbl">Tidak</span>
                        </label>
                  </div>
                </div>
              </div>
              
              <div class="form-actions center">
                <a onclick="getMenu('master_data/Global_parameter?flag=<?php echo $flag_string?>')" href="#" class="btn btn-sm btn-success">
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

          </form>

        </div>
      </div>
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

<script src="<?php echo base_url().'assets/js/custom/als_datatable.js'?>"></script>
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script src="<?php echo base_url()?>assets/js/typeahead.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-tag.js"></script>
<script>

    jQuery(function($) {  

        $('.date-picker').datepicker({  
        autoclose: true,   
        todayHighlight: true,
        dateFormat: 'yyyy-mm-dd'
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

<script src="<?php echo base_url()?>/assets/js/jquery-ui.custom.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.ui.touch-punch.js"></script>
<script src="<?php echo base_url()?>/assets/js/markdown/markdown.js"></script>
<script src="<?php echo base_url()?>/assets/js/markdown/bootstrap-markdown.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.hotkeys.js"></script>
<script src="<?php echo base_url()?>/assets/js/bootstrap-wysiwyg.js"></script>
<script src="<?php echo base_url()?>/assets/js/bootbox.js"></script>

<script type="text/javascript">
    jQuery(function($) {
      
      //handle form onsubmit event to send the wysiwyg's content to server
      $('#form-default').on('submit', function(){
        
        //put the editor's html content inside the hidden input to be sent to server
        
        $('#konten').val($('#editor_konten').html());

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
                $('#page-area-content').load('master_data/Global_parameter?flag='+$('#flag_string').val()+'&_=' + (new Date()).getTime());
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
        $('#editor_konten').empty();
      });
    });

  </script>