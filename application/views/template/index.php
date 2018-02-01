<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Travel | Hub</title>
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
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css">
</head>
<body>
  <div class="container-fluid header">
    <h3>Travel Hub</h3>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-10" style="padding:20px 50px 20px 50px;background-color:#33beb1;border-radius:10px;">
        <h1>Choose your template.</h1>
        <?php foreach ($themes as $key => $theme): ?>
          <div class="col-lg-4" style="background-color:#3c3734;padding:20px 10px 10px 10px;border-radius:5px;border-right:5px solid #33beb1;border-left:5px solid #33beb1;">
            <div class = "thumbnail">
              <img src = "/uploads/images/admin/themes/<?php echo $theme->image?>" alt = "Generic placeholder thumbnail">
            </div>
            <div class = "caption">
              <h3 style="color:#fff;"><?php echo $theme->theme?></h3>
              <p>
                <form class="" action="/Account/save_template" method="post">
                  <a href = "#" class = "btn btn-primary" role = "button" style="background-color:#f37430;border:none;color:#3c3734;">View</a>
                  <button type="submit" name="template" class = "btn btn-primary" value="<?php echo $theme->theme?>" style="background-color:#f37430;border:none;color:#3c3734;">Apply</button>
                </form>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="col-lg-1"></div>
    </div>
  </div>

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
