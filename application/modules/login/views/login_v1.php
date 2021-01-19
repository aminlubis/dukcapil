<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Dinas Kependudukan dan Catatan Sipil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="<?php echo base_url()?>assets/login/pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>assets/login/pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url()?>assets/login/pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url()?>assets/login/pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="DUKCAPIL" content="yes">
    <meta name="DUKCAPIL" content="yes">
    <meta name="SIRS" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="<?php echo base_url()?>assets/login/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/login/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/login/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/login/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url()?>assets/login/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="<?php echo base_url()?>assets/login/pages/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/login/pages/css/ie9.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/login/pages/css/windows.chrome.fix.css" />'
    }
    </script>
  </head>
  <body class="fixed-header   ">
    <!-- START PAGE-CONTAINER -->
    <div class="login-wrapper ">
      <!-- START Login Background Pic Wrapper-->
      <div class="bg-pic">
        <!-- START Background Pic-->
        <?php
          $arr_cover = array('9.jpg'); 
              shuffle($arr_cover);
        ?>
        <img src="<?php echo base_url().'assets/login/img/cover/'.array_shift($arr_cover).''?>" data-src="<?php echo base_url().'assets/login/img/cover/'.array_shift($arr_cover).''?>" data-src-retina="<?php echo base_url().'assets/login/img/cover/'.array_shift($arr_cover).''?>" alt="" class="lazy">
        <!-- END Background Pic-->
        <!-- START Background Caption-->
        <!-- <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          <img alt="" class="m-t-5" data-src="<?php echo base_url()?>assets/login/img/logo-bnpb.png" data-src-retina="<?php echo base_url()?>assets/login/img/logo-bnpb.png" src="<?php echo base_url()?>assets/login/img/logo-bnpb.png" style="width:100%">
        </div> -->
        <!-- END Background Caption-->
      </div>
      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <h2>Dashboard Admin</h2>
          <small style="padding-top:-30px !important; font-size: 14px">Dinas Kependudukan dan Catatan Sipil</small>
          <p class="p-t-35">LOGIN FORM</p>
          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" method="POST" role="form" action="<?php echo base_url().'login/process'?>" autocomplete="off">
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label><i class="fa fa-user"></i> Username</label>
              <div class="controls">
                <input type="text" name="username" id="username" placeholder="Username" class="form-control" required>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label><i class="fa fa-key"></i> Password</label>
              <div class="controls">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 no-padding">
                <div class="checkbox ">
                  <input type="checkbox" value="1" id="checkbox1">
                  <label for="checkbox1">Remember me</label>
                </div>
              </div>
              <div class="col-md-6 text-right">
                <a href="#" class="text-info small">Need help?<br>Please call Administrator <br><i class="fa fa-phone"></i> <b>(021) - 756 6000</b> </a>
              </div>
            </div>
            <!-- END Form Control-->
            <button class="btn btn-danger btn-cons m-t-10" type="button" id="button-login"> <i class="fa fa-check-circle"></i> Login </button>
          </form>
          <!--END Login Form-->
          <div class="pull-bottom sm-pull-bottom">
            <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
              <div class="col-sm-12 no-padding m-t-12">
                <center>
              <img src="<?php echo PATH_IMG_DEFAULT.$profile_form->app_logo?>" width="250px"> &nbsp;&nbsp;
              <br>
              <br>
              <!-- &nbsp; &nbsp;<img src="<?php echo base_url()?>assets/login/img/logo-bnpb-2.png" alt="" width="60px"></center><br> -->
                <p style="text-align: justify; padding-left: 10px !important">
                  Copyright <?php echo date('Y')?> @ <?php echo COMPANY?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>
    <!-- END PAGE CONTAINER -->
  </body>

  <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='<?php echo base_url()?>assets/js/jquery.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo base_url()?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
    </script>

  <link href="<?php echo base_url()?>assets/achtung/ui.achtung-mins.css" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="<?php echo base_url()?>assets/achtung/ui.achtung-min.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>assets/achtung/achtung.js"></script> 
      <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.form.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-validation/dist/jquery.validate.js"></script> 
      <script>
      $('document').ready(function() {  

        /*========== PROCESS LOGIN ================*/
        $("#form-login").validate({focusInvalid:true});     
        $( "#username" )
          .keypress(function(event) {
            var keycode =(event.keyCode?event.keyCode:event.which); 
            if(keycode ==13){
              event.preventDefault();
              if($(this).valid()){
                $('#password').focus();
              }
              return false;       
            }
        });
        
        $( "#password" )
          .keypress(function(event) {
            var keycode =(event.keyCode?event.keyCode:event.which); 
            if(keycode ==13){
              if($("#form-login").valid()) {  
                $('#form-login').ajaxForm({
                  beforeSend: function() {
                    achtungShowLoader();
                  },
                  uploadProgress: function(event, position, total, percentComplete) {
                  },
                  complete: function(xhr) {     
                    var data=xhr.responseText;
                    var jsonResponse = JSON.parse(data);

                    if(jsonResponse.status === 200){
                      window.location = '<?php echo base_url().'main'?>';
                    }else{
                      $.achtung({message: jsonResponse.message, timeout:5});
                    }
                    achtungHideLoader();
                  }

                });
              }
              $("#form-login").submit();
            }
        });
        
        $( "#button-login" )
          .on("click",function(event) {
            var keycode =(event.keyCode?event.keyCode:event.which); 
              if($("#form-login").valid()) {  
                $('#form-login').ajaxForm({
                  beforeSend: function() {
                    achtungShowLoader();
                  },
                  complete: function(xhr) {  
                    //alert(xhr.responseText); return false;
                    var data=xhr.responseText;
                    var jsonResponse = JSON.parse(data);

                    if(jsonResponse.status === 200){
                      window.location = '<?php echo base_url().'main'?>';
                    }else{
                      $.achtung({message: jsonResponse.message, timeout:5});
                    }
                    achtungHideLoader();
                  }
                });
              }
              $("#form-login").submit();
            
        });
        
        $("#form-login input:text").first().focus();

        /*========== END PROCESS LOGIN ================*/
        
      });

      </script>

</html>