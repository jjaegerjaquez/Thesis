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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato|Rubik+Mono+One" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/themes/Classic/style.css">
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
          <img alt="Brand" src="/public/img/logo/TH-Logo-White.png" height="50px" width="100px">
        </a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if (!empty($account->username)): ?>
          <?php echo $account->username?>
          <?php else: ?>
            Admin
          <?php endif; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/Account/logout">Logout</a></li>
          </ul>
        </li>
      </ul>

    </div><!-- /.container-fluid -->
  </nav>
  <!-- END OF NAV -->

  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li><a href="/Account">Back to Dashboard</a></li>
        <li class="active">Customizing Contacts Page</li>
      </ul>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-3" style="background-color:#fff;border-right:10px solid #ebe9e9;padding-top: 20px;">
        <?php if (!empty($business->image)): ?>
          <img src="<?php echo $business->image?>" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php else: ?>
          <img src="/public/img/default-img.jpg" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php endif; ?>
        <div class="vertical-menu">
          <a href="/Account">Dashboard</a>
          <a href="/Account/profile">Profile</a>
          <a href="/Account/site_identity">Site Identity</a>
          <a href="/Classic/home">Home Page Settings</a>
          <a href="/Classic/about">About Page Settings</a>
          <a href="/Classic/gallery">Gallery Page Settings</a>
          <a href="/Classic/contacts">Contacts Page Settings</a>
          <a href="/Classic/image_slider">Image Slider</a>
          <a href="/Classic/theme" class="active">Theme</a>
        </div>
      </div>
      <div class="col-lg-9" style="background-color:#fff;">
        <div class="row text-title header-row">
          <h2 class="">Theme</h2>
          <hr>
        </div>
          <div class="col-lg-12" style="">
            <?php foreach ($themes as $key => $theme): ?>
              <div class="col-lg-4" style="background-color:#3c3734;padding:20px 10px 10px 10px;border-radius:5px;border-right:5px solid #fff;border-left:5px solid #fff;">
                <div class = "thumbnail">
                  <img src = "/uploads/images/admin/themes/<?php echo $theme->image?>" alt = "Generic placeholder thumbnail">
                </div>
                <div class = "caption">
                  <h3 style="color:#fff;"><?php echo $theme->theme?></h3>
                  <p>
                    <form class="" action="/Classic/save_template" method="post">
                      <a href = "#" class = "btn btn-primary" role = "button" style="background-color:#f37430;border:none;color:#3c3734;">View</a>
                      <button type="submit" name="template" class = "btn btn-primary" value="<?php echo $theme->theme?>" style="background-color:#f37430;border:none;color:#3c3734;">Apply</button>
                    </form>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
      </div>
    </div>
  </section>

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
