<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable= no">
  <title>Chanthel</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/css/chanthel.css">
  <script src="https://use.fontawesome.com/d4b37cd90f.js"></script>
  <link href="<?php echo base_url(); ?>assetsnew/plugins/icheck/skins/square/_all.css" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url(); ?>assetsnew/ico/PACS_favicon11.png" type="image/x-icon">
  <script src="<?php echo base_url(); ?>assetsnew/js/modernizr.custom.js"></script>
</head>
<body class="login">
  <!-- Login container -->
  <div class="login-container">

    <div class="login-logo">
      <img src="<?php echo base_url(); ?>/assets/img/logo-01.svg" alt="" width="100%" height="auto">
    </div>

    <div class="login-message">
      <p>Please Login to start your session</p>
    </div>
    <?php echo $this->session->flashdata('login');?>

    <!-- Login form -->
    <div class="login-form">
      <form id="loginform" action="Login/logmein" method="POST">
        <div class="form-group">
          <label for=""></label>
          <input class="form-control" type="text" name="username" value="" placeholder="Username">
        </div>
        <div class="form-group">
          <label for=""></label>
          <input class="form-control" type="password" name="password" value="" placeholder="Password">
        </div>
        <div class="login-message">
          <p class="pull-left"><input type="checkbox"><span style="margin-left:10px; vertical-align:baseline;">Remember Me</span></p>
          <p class="pull-right" style="color: #428bca;font-weight: 400; vertical-align:middle;">Forgot Password ?</p>
        </div>
        <button type="submit" name="button" class="button-primary" style="margin-top:20px">Login</button>
        <a type="button" name="button" class="button-danger" href="<?php echo base_url(); ?>Login/google_login"><i class="fa fa-google-plus" style="margin-right:10px"></i>Login Using Google</a>
      </form>
    </div>
    <!-- Login form end -->

  </div>
  <!-- Login container end -->
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assetsnew/plugins/icheck/icheck.js"></script>
<script type="text/javascript">
//icheck
$(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    increaseArea: '20%'
  });
});
</script>
</html>
