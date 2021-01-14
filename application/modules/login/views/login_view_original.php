 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Form Login</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font-awesome.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-fonts.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.css" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url()?>assets/images/i-tangguh-icon.png">
    
  </head>
  <style type="text/css">
    #body-style {
      background-image:url(<?php echo PATH_IMG_DEFAULT.$profile_form->cover_login?>);
      background-size: 100%; 
      background-attachment: fixed;
      background-position: center;
      background-size: cover;
      opacity: 1;
      /*filter: alpha(opacity=50);*/
      background-repeat: no-repeat;
    }
  </style>

  <body class="login-layout light-login" id="body-style">
    <div class="main-container">
      <div class="main-content">
        <div class="row">

        <br><br><br><br><br>
          <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">

              <div class="center">
                <h1>
                  <img src="<?php echo PATH_IMG_DEFAULT.$profile_form->app_logo?>">
                </h1>
                <h3 class="dark" id="id-text" style="font-size: 14px; margin-top: -5px; color: #213a6d  !important; font-weight: bold">Mewujudkan Indonesia Tangguh Bencana<br><small></small></h3>
                <h4 class="dark" id="company-text" style="font-size: 16px;">BADAN NASIONAL PENANGGULANGAN BENCANA</h4>
              </div>
              <div class="space-6"></div>
              <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header blue lighter bigger">
                        <i class="ace-icon fa fa-lock blue"></i>
                        FORM LOGIN
                      </h4>
                      <div class="space-6"></div>
                      <form method="post" action="<?php echo base_url().'index.php/login/process'?>" id="form-login">
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" placeholder="Username" name="username" id="username" value="<?php echo set_value('username')?>" />
                              <i class="ace-icon fa fa-user"></i>
                              <?php echo form_error('username'); ?>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php echo set_value('password')?>" />
                              <i class="ace-icon fa fa-lock"></i>
                              <?php echo form_error('password'); ?>
                            </span>
                          </label>

                          <!-- <label for='message'>Masukan kode dibawah ini </label>
                          <center>
                            <img src="<?php echo base_url().'assets/captcha/captcha.php?rand='.rand().''?>" id="captchaimg" width="200px"> -->
                            <!-- <p id="captImg"><?php echo $captchaImg; ?></p>
                          </center>

                          <br>
                          <input type="text" class="form-control" placeholder="Validation code" name="captcha_code" id="captcha_code" value="" />
                          <?php echo form_error('captcha_code'); ?>
                          <br>
                          

                          Tidak dapat melihat gambar? Klik <a href="javascript:void(0);" class="refreshCaptcha" >disini</a> untuk refresh. -->
                          

                          <div class="space"></div>

                          <div class="clearfix">
                            <label class="inline">
                              <input type="checkbox" class="ace" />
                              <span class="lbl"> Ingatkan saya</span>
                            </label>

                            <input type="button" id="button-login" value="Sign In" class="width-35 pull-right btn btn-sm btn-primary" >

                            <!-- <button id="button-login" name="Submit" value="submit" class="width-35 pull-right btn btn-sm btn-primary">
                              <i class="ace-icon fa fa-key"></i>
                              <span class="bigger-110">Masuk</span>
                            </button> -->
                          </div>
                          
                          <div class="space-4"></div>
                        </fieldset>
                      </form>
                      <br>
                     
                      <div class="space-6"></div>

                    </div><!-- /.widget-main -->
                    <div class="toolbar clearfix">
                      <div style="width:30% !important; padding-left:15px">
                        <img src="<?php echo PATH_IMG_DEFAULT.$profile_form->app_logo?>" width="80px">
                      </div>
                      <div style="width:70% !important; text-align:left;float:left; font-size:11px;color:white;padding-top:15px">
                        <?php echo $profile_form->footer_text_form_login?>
                      </div>
                    </div>
                  </div><!-- /.widget-body -->
                </div><!-- /.login-box -->

              </div><!-- /.position-relative -->

              <!-- <div class="navbar-fixed-top align-right">
                <br />
                &nbsp;
                <a id="btn-login-dark" href="#">Dark</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-blur" href="#">Blur</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-light" href="#">Light</a>
                &nbsp; &nbsp; &nbsp;
              </div> -->
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

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

    <!-- inline scripts related to this page -->
    <script type="text/javascript">    
      
      
      //you don't need this, just used for changing background
      jQuery(function($) {
       $('#btn-login-dark').on('click', function(e) {
        $('body').attr('class', 'login-layout');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'blue');
        
        e.preventDefault();
       });
       $('#btn-login-light').on('click', function(e) {
        $('body').attr('class', 'login-layout light-login');
        $('#id-text2').attr('class', 'black');
        $('#id-company-text').attr('class', 'blue');
        
        e.preventDefault();
       });
       $('#btn-login-blur').on('click', function(e) {
        $('body').attr('class', 'login-layout blur-login');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'light-blue');
        
        e.preventDefault();
       });
       
      });
    </script>

      <link href="<?php echo base_url()?>assets/achtung/ui.achtung-mins.css" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="<?php echo base_url()?>assets/achtung/ui.achtung-min.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>assets/achtung/achtung.js"></script> 
      <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.form.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-validation/dist/jquery.validate.js"></script> 
      <script>
      $('document').ready(function() {  

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
        
      });
      </script>
  </body>
</html>

