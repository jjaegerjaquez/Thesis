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
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,700|Roboto:300,400,500" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css">
</head>
<body>
  <div class="container-fluid header">
    <h4>Travel Hub</h4>
  </div>
  <div class="container text-center setup-header">
    <span>Welcome to Travel Hub</span>
    <h3>Getting Started</h3>
    <p>We can't wait to get to know you, please enter your firstname and lastname to get you started.</p>
  </div>
  <form class="" action="<?php echo base_url(); ?>Home/save_name" method="post">
    <div class="container">
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 box" style="padding-top:40px;">
          <div class="col-lg-6" style="padding-left:0;">
            <div class="form-group">
              <input type="text" name="firstname" value="" class="form-control" placeholder="Firstname">
              <span style="color:red" class="help-block"><?php echo form_error('firstname'); ?></span>
            </div>
          </div>
          <div class="col-lg-6" style="padding:0;">
            <div class="form-group">
              <input type="text" name="lastname" value="" class="form-control" placeholder="Lastname">
              <span style="color:red" class="help-block"><?php echo form_error('lastname'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3 footer-setup text-center">
          <input class="btn btn-primary btn-lg back-btn" type="submit" name="update" id="save" value="Save"></input>
        </div>
      </div>
    </div>
  </form>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/js/demo.js"></script>
<script>
</script>
</body>
</html>
