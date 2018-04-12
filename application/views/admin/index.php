<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($title->value)) { echo $title->value; } else { echo "Title";}?></title>
  <link rel="icon" href="<?php if (!empty($icon->value)) { echo $icon->value; } else { echo "Icon";}?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato|Rubik+Mono+One" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/superadmin/style.css">
</head>
<body>

  <!-- NAV -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="" href="">
          <img alt="Brand" src="<?php echo base_url(); ?>public/img/logo/TH-Logo.png" height="50px" width="100px">
        </a>
      </div>

    </div><!-- /.container-fluid -->
  </nav>
  <!-- END OF NAV -->

  <section class="container">
    <div class="row">
      <div class="col-lg-4 col-lg-offset-4" style="background-color:#fff;padding:20px;margin-top:50px;border-radius:10px;">
        <form class="" action="<?php echo base_url(); ?>Admin/login" method="post">
          <?php
            if ($error == '' || $error == NULL)
            {
            }
            else
            {
              echo '
                <div id="error_message" style="color:red">'.$error.'</div>
              ';
            }
          ?>
          <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" value="<?php echo set_value('username'); ?>" maxlength="25">
            <span style="color:red" class="help-block"><?php echo form_error('username'); ?></span>
          </div>
          <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" maxlength="50">
            <span style="color:red" class="help-block"><?php echo form_error('password'); ?></span>
          </div>
          <div class="form-group">
            <button type="submit" name="login" class="btn btn-success form-control">Login</button>
          </div>
        </form>
      </div>
    </div>
  </section>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
