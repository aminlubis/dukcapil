<script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
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

$(document).ready(function(){
  
    $('#form_Tmp_bck_rstr_db').ajaxForm({
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
          $('#page-area-content').load('setting/Tmp_bck_rstr_db?_=' + (new Date()).getTime());
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    }); 

})

</script>

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

                <div class="col-sm-6">
                    <div class="widget-box">
                      <div class="widget-header">
                        <h4 class="smaller">
                          Backup DB
                        </h4>
                      </div>

                      <div class="widget-body">
                        <div class="widget-main">
                          <form class="form-horizontal" method="post" id="form_Tmp_bck_rstr_db" action="<?php echo site_url('setting/Tmp_bck_rstr_db/process')?>" enctype="multipart/form-data">
                            <div class="form-group">
                              <label class="control-label col-md-3">Tanggal Backup</label>
                                <div class="col-md-5">
                                  <div class="input-group">
                                    <input class="form-control date-picker" name="tgl_bckup" id="tgl_bckup" type="text" data-date-format="yyyy-mm-dd" value=""/>
                                    <span class="input-group-addon">
                                      <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                  </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-md-12">
                                  <b>Keterangan :</b>
                                  <ul>
                                    <li>Silahkan lakukan backup secara rutin untuk keamanan data anda.</li>
                                    <li>backup secara otomatis akan dilakukan setiap tanggal yang telah ditentukan dimulai pada pukul 00.00 WIB.</li>
                                    <li>Sistem akan berhenti beberapa saat sampai selesai proses backup.</li>
                                  </ul>
                                </div>
                            </div>
                          <div class="form-group">
                            <label class="control-label col-md-2">Last backup</label>
                            <div class="col-md-10" style="padding-top:8px">
                                <i class="fa fa-calendar"></i> <?php echo isset($value->updated_date)?$this->tanggal->formatDateTime($value->updated_date):isset($value)?$this->tanggal->formatDateTime($value->created_date):date('d-M-Y H:i:s')?> - 
                                by : <i class="fa fa-user"></i> <?php echo isset($value->updated_by)?$value->updated_by:isset($value->created_by)?$value->created_by:$this->session->userdata('user')->username?>
                            </div>
                          </div>
                          <hr>

                          <p>
                            <span class="btn btn-sm btn-primary btn-block" data-rel="tooltip" title="" data-original-title="Default">-:: BACKUP ::-</span>
                          </p>

                          </form>

                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="widget-box">
                      <div class="widget-header">
                        <h4 class="smaller">
                          Restore DB
                        </h4>
                      </div>

                      <div class="widget-body">
                        <div class="widget-main">
                          <form class="form-horizontal" method="post" id="form_Tmp_bck_rstr_db" action="<?php echo site_url('setting/Tmp_bck_rstr_db/process')?>" enctype="multipart/form-data">

                            <div class="form-group">
                              <label class="control-label col-md-3">File db (.sql)</label>
                              <div class="col-md-6">
                                <input type="file" name="icon" class="form-control" id="icon">
                              </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-md-12">
                                  <b>Keterangan :</b>
                                  <ul>
                                    <li>Proses restore data akan memerlukan waktu beberapa menit sehingga akan mengganggu proses yang sedang berjalan, maka dari itu harus dipastikan tidak ada proses yang berjalan pada sistem selama proses restore data.</li>
                                  </ul>
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3">Last restore</label>
                              <div class="col-md-9" style="padding-top:8px;font-size:10px">
                                  <i class="fa fa-calendar"></i> <?php echo isset($value->updated_date)?$this->tanggal->formatDateTime($value->updated_date):isset($value)?$this->tanggal->formatDateTime($value->created_date):date('d-M-Y H:i:s')?>
                                  <i class="fa fa-user"></i> <?php echo isset($value->updated_by)?$value->updated_by:isset($value->created_by)?$value->created_by:$this->session->userdata('user')->username?>
                              </div>
                            </div>
                            <hr>
                            <p>
                              <span class="btn btn-sm btn-success btn-block" data-rel="tooltip" title="" data-original-title="Default">-:: RESTORE ::-</span>
                            </p>

                          </form>
                        </div>
                      </div>
                    </div>
                </div>

                
            </div>
          </div>
    
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->


