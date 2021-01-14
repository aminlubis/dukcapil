<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo $app->app_name?></title>

    <meta name="description" content="top menu &amp; navigation" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- css default for blank page -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-fonts.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
    
    <script src="<?php echo base_url()?>assets/js/ace-extra.js"></script>
    <!-- css default for blank page -->
    <!-- Favicon -->

    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.custom.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/select2.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-editable.css" />

    <link rel="shortcut icon" href="<?php echo PATH_IMG_DEFAULT.$app->app_logo?>">
  </head>

  <body class="no-skin">
    <!-- #section:basics/navbar.layout -->
    <div id="navbar" class="navbar navbar-default navbar-collapse h-navbar" style="background: url('assets/images/<?php echo $app->style_header_color?>.png');">
      <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
      </script>

      <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
          <!-- #section:basics/navbar.layout.brand -->
          <a href="#" class="navbar-brand">
            <small>
              <img src="<?php echo PATH_IMG_DEFAULT.$app->app_logo?>" width="40px" style="margin: -16px -7px -14px">&nbsp;
              <?php echo $app->app_name?>
            </small>
          </a>

          <!-- /section:basics/navbar.layout.brand -->

          <!-- #section:basics/navbar.toggle -->
          <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
            <span class="sr-only">Toggle user menu</span>

            <img src="<?php echo base_url()?>assets/avatars/avatar5.png" alt="<?php echo $this->session->userdata('user')->username?>" />
          </button>

          <!-- <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
          </button> -->

          <!-- /section:basics/navbar.toggle -->
        </div>

        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
          <ul class="nav ace-nav">
            <!-- #section:basics/navbar.user_menu -->
            <li class="light-blue user-min">
              <a data-toggle="dropdown" href="#" class="dropdown-toggle">
              <img class="nav-user-photo" src="<?php echo isset($this->session->userdata('user')->path_foto) ? base_url().PATH_IMG_DEFAULT.$this->session->userdata('user')->path_foto:base_url().'assets/avatars/user.jpg'?>" alt="<?php echo $this->session->userdata('user')->fullname?>'s Photo" height="95%"/>
                <span class="user-info">
                  <small>Welcome,</small>
                  <i><?php echo $this->session->userdata('user')->username?></i>
                </span>

                <i class="ace-icon fa fa-caret-down"></i>
              </a>

              <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <li>
                  <a href="<?php echo base_url().'login/logout'?>">
                    <i class="ace-icon fa fa-power-off"></i>
                    Logout
                  </a>
                </li>
              </ul>
            </li>

            <!-- /section:basics/navbar.user_menu -->
          </ul>
        </div>

        <!-- /section:basics/navbar.dropdown -->
        <nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">
          <!-- #section:basics/navbar.nav -->
          <ul class="nav navbar-nav">


            <li>
              <a href="#">
                <i class="ace-icon fa fa-user"></i>
                <?php echo $this->session->userdata('user')->username; ?>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="ace-icon fa fa-calendar"></i>
                <?php echo date('l, d F Y'); ?> 
              </a>
            </li>


          </ul>

        </nav>
      </div><!-- /.navbar-container -->
    </div>

    <!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container">
      <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>

      <!-- /section:basics/sidebar.horizontal -->
      <div class="main-content">
        <div class="main-content-inner">
          <!-- #section:basics/content.breadcrumbs -->
          <?php
            $arr_color_breadcrumbs = array('#f4ae11');
            shuffle($arr_color_breadcrumbs);
          ?>
          <div class="breadcrumbs" id="breadcrumbs" style="background-color:<?php echo array_shift($arr_color_breadcrumbs)?>">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
          </div>
          <div class="page-content">
            <div class="row">
              <div class="col-md-12">

              <div class="row">

                <div class="col-xs-12">  

                  <div class="page-header">    

                    <h1>      

                      Verifikasi

                      <small>        

                        <i class="ace-icon fa fa-angle-double-right"></i>          

                        Verifikasi Data Pasien

                      </small>        

                    </h1>      

                  </div>  

                  <!-- div.dataTables_borderWrap -->

                  <div>   

                    <form class="form-horizontal" method="post" id="form_verifikasi_data_pasien" action="<?php echo site_url('registration/reg_online/process_verifikasi_data_pasien')?>" enctype="multipart/form-data">     
                        <!-- hidden form  -->
                        <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user')->user_id; ?>">
                        <input type="hidden" name="token" value="<?php echo $this->session->userdata('token'); ?>">

                        <div class="alert alert-block alert-success">
                          <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                          </button>

                          <p>
                            <strong>
                              <i class="ace-icon fa fa-check"></i>
                              Lengkapi Data!
                            </strong>
                            Untuk dapat melanjutkan Transaksi Booking Online, silahkan lengkapi data anda dibawah ini !
                          </p>

                          <p>
                            <button class="btn btn-sm btn-success" data-dismiss="alert">Lanjutkan</button>
                            <a href="<?php echo base_url().'main'?>" class="btn btn-sm btn-danger">Lewati</a>
                          </p>
                        </div>

                        <div class="form-group">

                          <label class="control-label col-md-3"><b>Masukan Nomor Medical Record (MR)</b></label>            

                          <div class="col-md-4">            

                            <div class="input-group">

                              <input type="text" name="no_mr" id="form_cari_pasien" class="form-control search-query" placeholder="Masukan Nomor Medical Record (MR)">

                              <input type="hidden" name="no_mr" value="" id="noMrHidden">

                              <span class="input-group-btn">

                                <button type="button" id="btn_search_pasien" class="btn btn-default btn-sm">

                                  <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>

                                  Search

                                </button>

                              </span>

                            </div>

                          </div>

                        </div>

                        <p style="margin-top:5px"><i class="fa fa-user"></i> Form Profile Pasien </p>

                        <div class="form-group">

                          <label class="control-label col-md-2">Nomor KTP</label>            

                          <div class="col-md-2">       

                              <input type="text" name="no_ktp" id="no_ktp" class="form-control" disabled>

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="control-label col-md-2">Nama Pasien</label>            

                          <div class="col-md-2">       

                              <input type="text" name="fullname" id="fullname" class="form-control" disabled>

                          </div>

                          <label class="control-label col-md-1">JK</label>            

                          <div class="col-md-1">       

                              <input type="text" name="gender" id="gender" class="form-control" disabled>

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="control-label col-md-2">Tempat Lahir</label>            

                          <div class="col-md-2">      

                              <input type="text" name="pob" id="pob" class="form-control" disabled>

                          </div>

                          <label class="control-label col-md-1">Tanggal</label>            

                          <div class="col-md-2">      

                              <input type="text" name="dob" id="dob" class="form-control" disabled>

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="control-label col-md-2">Alamat</label>            

                          <div class="col-md-4">        

                              <input type="text" name="address" id="address" class="form-control" disabled>

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="control-label col-md-2">No Telp/HP</label>            

                          <div class="col-md-2">        

                              <input type="text" name="no_telp" id="no_telp" class="form-control" disabled>

                          </div>

                          <label class="control-label col-md-1">Foto Profile</label>            

                          <div class="col-md-2">        

                              <input type="file" name="path_foto" class="form-control" disabled>

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="control-label col-md-2">&nbsp;</label>            

                          <div class="col-md-4">        

                              <button type="button" id="btn_ubah_form" name="submit" class="btn btn-sm btn-success">
                                <i class="ace-icon fa fa-edit icon-on-right bigger-110"></i>
                                Ubah
                              </button>

                              <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info" style="display:none">
                                <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
                                Simpan
                              </button>

                          </div>

                        </div>

                    </form>

                  </div>

                </div><!-- /.col -->

              </div><!-- /.row -->


              <!-- end form profile -->
              </div>
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div>
      </div><!-- /.main-content -->

      <div class="footer">
        <div class="footer-inner">
          <!-- #section:basics/footer -->
          <div class="footer-content">
            <span class="bigger-120">
              <?php echo $app->footer?>
            </span>
          </div>

          <!-- /section:basics/footer -->
        </div>
      </div>

      <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
      </a>
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='<?php echo base_url()?>assets/js/jquery.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
    </script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.js"></script>

    <!-- page specific plugin scripts -->

    <!--[if lte IE 8]>
      <script src="<?php echo base_url()?>assets/js/excanvas.js"></script>
    <![endif]-->
    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.ui.touch-punch.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.js"></script>
    
    <!-- achtung loader -->
    <link href="<?php echo base_url()?>assets/achtung/ui.achtung-mins.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url()?>assets/achtung/ui.achtung-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/achtung/achtung.js"></script> 

    <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-validation/dist/jquery.validate.js"></script>

    <script src="<?php echo base_url()?>assets/js/custom/menu_load_page.js"></script>
    <script src="<?php echo base_url()?>assets/js/date-time/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/datepicker.css" />

    <script>

    var token = "<?php echo $this->session->userdata('token')?>";

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
  
        $('#form_tmp_user').ajaxForm({
          beforeSend: function() {
            achtungShowLoader();  
          },
          uploadProgress: function(event, position, total, percentComplete) {
          },
          complete: function(xhr) {     
            var data=xhr.responseText;
            var jsonResponse = JSON.parse(data);

            if(jsonResponse.status === 200){
              $.achtung({message: jsonResponse.message, timeout:3});
              $('#message_success').show({
                  speed: 'slow',
                  timeout: 5000,
              });
            }else{
              $.achtung({message: jsonResponse.message, timeout:5});
            }
            achtungHideLoader();
          }
        });

        $('#form_update_profile').ajaxForm({
          beforeSend: function() {
            achtungShowLoader();  
          },
          uploadProgress: function(event, position, total, percentComplete) {
          },
          complete: function(xhr) {     
            var data=xhr.responseText;
            var jsonResponse = JSON.parse(data);

            if(jsonResponse.status === 200){
              $.achtung({message: jsonResponse.message, timeout:3});
              $('#message_success').show({
                  speed: 'slow',
                  timeout: 1000,
              });
            }else{
              $.achtung({message: jsonResponse.message, timeout:5});
            }
            achtungHideLoader();
          }
        });


      })

      function exc_my_account() {
        $('#form_tmp_user').submit();
        return false;
      }

      function exc_update_profile() {
        $('#form_update_profile').submit();
        return false;
      }

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

        
        $('#form_cari_pasien').focus();    

        $('#form_verifikasi_data_pasien').ajaxForm({      

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

              /*show massage success*/
              setTimeout(function(){location.href=jsonResponse.redirect} , 2000);   

            }else{          

              $.achtung({message: jsonResponse.message, timeout:5});          

            }        

            achtungHideLoader();        

          }      

        });     

          
        $( "#form_cari_pasien" )    

          .keypress(function(event) {        

            var keycode =(event.keyCode?event.keyCode:event.which);         

            if(keycode ==13){          

              event.preventDefault();          

              if($(this).valid()){            

                $('#btn_search_pasien').focus();            

              }          

              return false;                 

            }        

        });      


        $('#btn_search_pasien').click(function (e) {      

          e.preventDefault();      

          if( $("#form_cari_pasien").val() == "" ){

            alert('Masukan keyword minimal 3 Karakter !');

            return $("#form_cari_pasien").focus();

          }else{

            achtungShowLoader();

            $.getJSON("<?php echo site_url('registration/reg_pasien/search_pasien') ?>?keyword=" + $("#form_cari_pasien").val()+'&token='+token+'', '', function (data) {              
              
              /*response data*/
              if ( data.status !== 200) { 

                $.achtung({message: data.message, timeout:5});

              }else{

                if( data.count == 0){

                  $('#form_cari_pasien').closest('form').trigger("reset");

                  alert('Data tidak ditemukan'); 

                  $("#form_cari_pasien").focus();

                }else{

                  var obj = data.result[0];

                  $('#no_mr').val(obj.no_mr);

                  $('#noMrHidden').val(obj.no_mr);

                  $('#no_ktp').val(obj.no_ktp);

                  $('#fullname').val(obj.nama_pasien);

                  $('#gender').val(obj.jen_kelamin);

                  if( obj.jen_kelamin == 'L' ){
                  
                    $('#avatar').attr('src', '<?php echo base_url()?>assets/avatars/boy.jpg');
                  
                  }else{
                    
                    $('#avatar').attr('src', '<?php echo base_url()?>assets/avatars/girl.jpg');

                  }
                  
                  $('#no_telp').val(obj.tlp_almt_ttp);

                  $('#pob').val(obj.tempat_lahir);

                  $('#dob').val(obj.tgl_lhr);

                  $('#address').val(obj.almt_ttp_pasien);
                  
                  penjamin = (obj.nama_perusahaan==null)?'-':obj.nama_perusahaan;

                  $('#kode_perusahaan').val(obj.nama_perusahaan);

                }

              }

            achtungHideLoader();

            });             
            
          }    

        });    

        $('#btn_ubah_form').click(function (e) { 
          $("#form_verifikasi_data_pasien input").prop("disabled", false); 
          $("#btnSave").show('fast'); 
        });

        function formatDate(date) {
          var hours = date.getHours();
          var minutes = date.getMinutes();
          var ampm = hours >= 12 ? 'pm' : 'am';
          hours = hours % 12;
          hours = hours ? hours : 12; // the hour '0' should be '12'
          minutes = minutes < 10 ? '0'+minutes : minutes;
          var strTime = hours + ':' + minutes + ' ' + ampm;
          return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear();
        }
        

    })

    

    </script>
    
  </body>
</html>
