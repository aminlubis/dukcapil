<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script>
jQuery(function($) {

  $('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true
  })
  //show datepicker when clicking on the icon
  .next().on(ace.click_event, function(){
    $(this).prev().focus();
  });
});

function hapus_file(a, b)

{

  if(b != 0){
    $.getJSON("<?php echo base_url('posting/delete_file') ?>/" + b, '', function(data) {
        document.getElementById("file"+a).innerHTML = "";
        greatComplate(data);
    });
  }else{
    y = a ;
    document.getElementById("file"+a).innerHTML = "";
  }

}

counterfile = <?php $j=1;echo $j.";";?>

function tambah_file()

{

counternextfile = counterfile + 1;

counterIdfile = counterfile + 1;

document.getElementById("input_file"+counterfile).innerHTML = "<div id=\"file"+counternextfile+"\"><div class='form-group'><label class='control-label col-md-2'>&nbsp;</label><div class='col-md-2'><input type='text' name='pf_file_name[]' id='pf_file_name' class='form-control'></div><label class='control-label col-md-1'>File</label><div class='col-md-3'><input type='file' id='pf_file' name='pf_file[]' class='upload_file form-control' /></div><div class='col-md-1'><input type='button' onclick='hapus_file("+counternextfile+",0)' value='x' class='btn btn-sm btn-danger'/></div></div></div><div id=\"input_file"+counternextfile+"\"></div>";

counterfile++;

}

$(document).ready(function(){
  
    /*$('#form_posting').ajaxForm({

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
          $('#page-area-content').load('posting/attachment?_=' + (new Date()).getTime());
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }

    }); */
})

</script>

<style type="text/css">
  .deleted_file{
    display: none;
  }
  .hidden{
    display: none;
  }
</style>
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
              <form class="form-horizontal" method="post" id="form_posting" action="<?php echo site_url('posting/attachment/process')?>" enctype="multipart/form-data">
                <br>

                <div class="form-group">
                  <label class="control-label col-md-2">ID</label>
                  <div class="col-md-1">
                    <input name="id" id="id" value="<?php echo isset($value)?$value->ws_id:0?>" placeholder="Auto" class="form-control" type="text" readonly>
                  </div>
                  <label class="control-label col-md-1">Date</label>
                  <div class="col-md-2">
                    <div class="input-group">
                      <input class="form-control date-picker" name="ws_date" id="ws_date" type="text" data-date-format="yyyy-mm-dd" <?php echo ($flag=='read')?'readonly':''?> value="<?php echo isset($value)?$value->ws_date:date('Y-m-d')?>"/>
                      <span class="input-group-addon">
                        <i class="fa fa-calendar bigger-110"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Service Name</label>
                  <div class="col-md-5">
                    <input name="ws_name" id="ws_name" value="<?php echo isset($value)?$value->ws_name:''?>" placeholder="" class="form-control" type="text" <?php echo ($flag=='read')?'readonly':''?> >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Image File</label>
                  <div class="col-md-3">
                    <input type="file" id="images" name="images" class="upload_file form-control"/>
                  </div>
                </div>

                <?php 
                  if (isset($value)) :
                    if(file_exists('uploaded/files/'.$value->ws_images.'')) : 
                ?>
                <div class="form-group" id="form_content_image">
                  <label class="control-label col-md-2">&nbsp;</label>
                  <div class="col-md-4">
                    <img src="<?php echo base_url().'uploaded/files/'.$value->ws_images.''?>" style="width:100%; max-height:350px"><br> <a href="#" id="content_image" class="image_content" data-id="<?php echo $value->ws_id?>" style="color:red">[ Delete ]</a>
                  </div>
                </div>
                <?php 
                    endif;
                  endif;
                ?>


                <div class="form-group">
                  <label class="control-label col-md-2">Is active? ?</label>
                  <div class="col-md-2">
                    <div class="radio">
                          <label>
                            <input name="is_active" type="radio" class="ace" value="Y" <?php echo isset($value) ? ($value->is_active == 'Y') ? 'checked="checked"' : '' : 'checked="checked"'; ?> <?php echo ($flag=='read')?'readonly':''?> />
                            <span class="lbl"> Yes</span>
                          </label>
                          <label>
                            <input name="is_active" type="radio" class="ace" value="N" <?php echo isset($value) ? ($value->is_active == 'N') ? 'checked="checked"' : '' : ''; ?> <?php echo ($flag=='read')?'readonly':''?>/>
                            <span class="lbl"> No</span>
                          </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-2">Attachment Title</label>
                  <div class="col-md-2">
                    <input name="pf_file_name[]" id="pf_file_name" class="form-control" type="text">
                  </div>
                  <label class="control-label col-md-1">File</label>
                  <div class="col-md-3">
                    <input type="file" id="pf_file" name="pf_file[]" class="upload_file form-control"/>
                  </div>
                  <div class ="col-md-1">
                    <input onClick="tambah_file()" value="+" type="button" class="btn btn-sm btn-info" />
                  </div>
                </div>
                <div id="input_file<?php echo $j;?>"></div>
                <?php 
                  if(isset($attachment)) :
                    if(count($attachment) > 0 ) :
                ?>
                <div class="form-group">
                  <label class="control-label col-md-2">&nbsp;</label>
                  <div class="col-md-10">
                    <h3><b><i class="fa fa-file"></i> Attachment List</b></h3> <br>
                    <table id="attc_table_id" class="table table-striped table-bordered">
                      <thead>
                      <tr style="background-color:#ec2028; color:white">
                          <th width="30px" class="center">No</th>
                          <th width="150px">Title</th>
                          <th width="100px">Owner</th>
                          <th width="100px">Filename</th>
                          <th width="70px" class="center">Size</th>
                          <th width="100px" class="center">Type</th>
                          <th width="100px">Created Date</th>
                          <th width="60px" class="center">Download</th>
                          <th width="60px" class="center">Delete</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $html = '';
                          
                          $no=1;
                          if(count($attachment) > 0){
                              foreach ($attachment as $key => $row_list) {
                                  # code...
                                  echo '<tr id="'.$row_list->id.'">';
                                      echo '<td align="center">'.$no.'</td>';
                                      echo '<td align="left">'.$row_list->attc_name.'</td>';
                                      echo '<td align="left">'.$row_list->owner.'</td>';
                                      echo '<td align="left">'.$row_list->name.'</td>';
                                      echo '<td align="center">'.number_format($row_list->size).'</td>';
                                      echo '<td align="center">'.$row_list->type.'</td>';
                                      echo '<td align="center">'.$row_list->created_date.'</td>';
                                      echo '<td align="center"><a href="posting/attachment/download?fname='.$row_list->path.'" target="blank" style="color:red">Download</a></td>';
                                      echo '<td align="center"><a href="#" class="delete_attachment" data-id="'.$row_list->id.'"><i class="fa fa-times-circle red"></i></a></td>';
                                  echo '</tr>';
                              $no++;
                              }
                          }else{
                              echo '<tr><td colspan="9">- File not found -</td></tr>';
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <br>
                <?php 
                    endif; 
                  endif;
                  ?>
                <div class="form-group">
                  <label class="control-label col-md-2">Description</label>
                  <div class="col-md-10">
                    <div class="wysiwyg-editor" id="editor"><?php echo isset($value->ws_description)?$value->ws_description:''?></div>
                    <textarea spellcheck="false" id="content" name="content" class="hidden"></textarea>
                  </div>
                </div>

                


                <!-- <div class="form-group">
                  <label class="control-label col-md-2">Last update</label>
                  <div class="col-md-4" style="padding-top:8px">
                    <b>
                      <i class="fa fa-calendar"></i> <?php echo isset($value->updated_date)?$this->tanggal->formatDateTime($value->updated_date):isset($value)?$this->tanggal->formatDateTime($value->created_date):date('d-M-Y H:i:s')?> - 
                      by : <i class="fa fa-user"></i> <?php echo isset($value->updated_by)?$value->updated_by:isset($value->created_by)?$value->created_by:$this->session->userdata('user')->fullname?>
                    </b>
                  </div>
                </div>
 -->

                <div class="form-actions center">

                  <a onclick="getMenu('posting/attachment')" href="#" class="btn btn-sm btn-success">
                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                    Back to list
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

<script src="<?php echo base_url()?>/assets/js/jquery-ui.custom.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.ui.touch-punch.js"></script>
<script src="<?php echo base_url()?>/assets/js/markdown/markdown.js"></script>
<script src="<?php echo base_url()?>/assets/js/markdown/bootstrap-markdown.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.hotkeys.js"></script>
<script src="<?php echo base_url()?>/assets/js/bootstrap-wysiwyg.js"></script>
<script src="<?php echo base_url()?>/assets/js/bootbox.js"></script>

<script type="text/javascript">
      jQuery(function($) {
        $('#editor').ace_wysiwyg({
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
        $('#form_posting').on('submit', function(){
          
          //put the editor's html content inside the hidden input to be sent to server
          
          $('#content').val($('#editor').html());

          var formData = new FormData($('#form_posting')[0]);
          /*formData.append('content', $('input[name=wysiwyg-value]' , this).val($('#editor').html()) ); */
          pf_file_name = new Array();
          pf_file = new Array();

           var formData = new FormData($('#form_posting')[0]);
           
            i=0;
           
            $("input#pf_file_name").each(function(){
           
                pf_file_name[i] = $(this).val();
                pf_file[i] = $('input[type=file]')[i].files[i];
                i++;
           
            })

            formData.append('pf_file', pf_file);
            formData.append('pf_file_name', pf_file_name);


          url = $('#form_posting').attr('action');

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
                      $('#page-area-content').load('posting/attachment?_=' + (new Date()).getTime());
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
        $('#form_posting').on('reset', function() {
          $('#editor').empty();
        });

        $('.delete_attachment').click(function(e){  // ... or however you attach to that link
          e.preventDefault();
          var row = $(this).closest('tr');
          var myid = $(this).attr('data-id');
          //alert(myid);
          // hide this row first
          if(confirm('Are you sure?')){
          $.ajax({
              url: 'posting/attachment/delete_attachment',
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
                  row.hide();
                }else{
                  $.achtung({message: jsonResponse.message, timeout:5});
                }
                achtungHideLoader();
              }

            });

        }else{
          return false;
        }

      });

        $('#content_image').click(function(e){  // ... or however you attach to that link
          e.preventDefault();
          var myid = $(this).attr('data-id');
          // hide this row first
          if(confirm('Are you sure?')){
          $.ajax({
              url: 'posting/attachment/delete_content_image',
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
                  $('#form_content_image').hide();
                }else{
                  $.achtung({message: jsonResponse.message, timeout:5});
                }
                achtungHideLoader();
              }

            });

        }else{
          return false;
        }

      });

    });
    
    </script>



