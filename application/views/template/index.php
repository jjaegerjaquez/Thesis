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
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/setup/style.css">
</head>
<body>
  <div class="container-fluid header">
    <h4>Travel Hub</h4>
  </div>
  <div class="container text-center setup-header">
    <span>Step 3 of 3</span>
    <h3>Let's set up your site look</h3>
    <p>Choose which theme your site will use</p>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-10 theme-box">
        <?php foreach ($themes as $key => $theme): ?>
          <div class="col-lg-4 box-style">
            <div class = "thumbnail">
              <?php if (!empty($theme->image)): ?>
                <img src = "<?php echo $theme->image?>" alt = "image">
              <?php else: ?>
                <img src = "<?php echo base_url(); ?>public/img/themes/default-img.jpg" alt = "image">
              <?php endif; ?>
            </div>
            <div class = "caption">
              <h3><?php echo $theme->theme?></h3>
              <p>
                <form class="" action="<?php echo base_url(); ?>Account/save_template" method="post">
                  <a target="_blank" href = "<?php echo base_url(); ?>Theme/preview/<?php echo $theme->theme?>" class = "btn btn-primary" role = "button">Preview</a>
                  <button type="submit" name="template" class = "btn btn-primary" value="<?php echo $theme->theme?>">Apply</button>
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
