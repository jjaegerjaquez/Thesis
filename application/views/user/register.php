<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tours PH | Registration</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>public/thesis/AdminLTE/plugins/iCheck/square/blue.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css">

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
<div class="register-box lz-login">
  <div class="register-box-body">

  <div class="register-logo lz-logo">
    <a href="#"><b>Tours</b> PH</a>
  </div>
    <hr>
    <p class="login-box-msg">Register a new membership</p>
    <form action="/User/register_form" method="post"  class="lz-register-form">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" class="form-control lz-input" placeholder="E-mail">
        <span style="color:red" class="help-block"><?php echo form_error('email'); ?></span>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control lz-input" placeholder="Password">
        <span style="color:red" class="help-block"><?php echo form_error('password'); ?></span>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password" class="form-control lz-input" placeholder="Confirm Password">
        <span style="color:red" class="help-block"><?php echo form_error('confirm_password'); ?></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="">
            <label>
              <input type="checkbox" name="checkbox"> I agree to the <a href="#">terms</a>
              <span style="color:red" class="help-block"><?php echo form_error('checkbox'); ?></span>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4 text-right">
          <button type="submit" name="register" class="btn login-btn">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <hr>
      <a href="/User" class="text-center">I already have a membership</a>
    </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url() ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url() ?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url() ?>public/thesis/AdminLTE/plugins/iCheck/icheck.min.js"></script>

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
