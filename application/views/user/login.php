<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tours PH | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/plugins/iCheck/square/blue.css">

  <link rel="stylesheet" href="<?php echo base_url();?>public/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style>
    html{
      background: url(<?php echo base_url(); ?>public/img/login-bg.jpg);
      background-size: cover;
      overflow: hidden;
    }
    body.login-page {
      background: transparent;
    }
  </style>

</head>
<body class="hold-transition login-page">
<div class="login-box lz-login">
  <!-- /.login-logo -->
  <div class="login-box-body">
  <div class="register-logo lz-logo">
    <a href="#"><b>Tours</b> PH</a>
  </div>
    <hr>
    <p class="login-box-msg">Sign in to start your session</p>
    <form action="/User/login" method="post" class="lz-login-form">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control lz-input" placeholder="Email">
        <span class="fa fa-envelope form-control-feedback"></span>
        <span style="color:red" class="help-block"><?php echo form_error('email'); ?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control lz-input" placeholder="Password">
        <span class="fa fa-lock form-control-feedback"></span>
        <span style="color:red" class="help-block"><?php echo form_error('password'); ?></span>
      </div>
      <div class="row">
        <div class="col-xs-4 text-right pull-right">
          <button type="submit" class="btn login-btn">Login</button>
        </div>
      </div>
    </form>

    <hr>

    <div class="row lz-footer">
      <div class="col-md-6">
        <a href="#">I forgot my password</a>
      </div>
      <div class="col-md-6 text-right">
        <a href="/User/register">Register a new membership</a>
      </div>
    </div>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
