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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if ($business->username == "" or $business->username == NULL) {
            echo "Admin-".$account->user_id;
          }else {
            echo $business->username;
          }?> <span class="caret"></span></a>
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
        <li class="active">Welcome to Travel Hub</li>
      </ul>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-3" style="background-color:#fff;border-right:10px solid #ebe9e9;padding-top: 20px;">
        <?php if (!empty($business->image)): ?>
          <img src="/uploads/<?php echo $account->username?>/<?php echo $business->image?>" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php else: ?>
          <img src="/public/img/default-img.jpg" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php endif; ?>
        <div class="vertical-menu">
          <a href="/Account" class="active">Dashboard</a>
          <a href="/Account/profile">Profile</a>
          <a href="/Account/site_identity">Site Identity</a>
          <a href="/Classic/home">Home Page Settings</a>
          <a href="/Classic/about">About Page Settings</a>
          <a href="/Classic/gallery">Gallery Page Settings</a>
          <a href="/Classic/contacts">Contacts Page Settings</a>
          <a href="/Classic/image_slider">Image Slider</a>
          <a href="/Classic/theme">Theme</a>
        </div>
      </div>
      <div class="col-lg-9" style="background-color:#fff;padding-top:20px;">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Votes</span>
                <span class="info-box-number">139</span>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Reviews</span>
                <span class="info-box-number">150</span>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa  fa-bar-chart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rating</span>
                <span class="info-box-number">4.7</span>
              </div>
            </div>
          </div>
      </div>
        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="box box-widget">
              <div class="box-header with-border">
                <h3 class="box-title">Reviews</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-footer box-comments">
                <div class="box-comment">
                  <!-- User image -->
                  <img class="img-circle img-sm" src="/uploads/images/maria.jpg" alt="User Image">

                  <div class="comment-text">
                        <span class="username">
                          Maria Gonzales
                          <span class="text-muted pull-right">8:03 PM Today</span>
                        </span><!-- /.username -->
                    I am inlove with their food! Super yummy and the place, super
                    beautiful and comfortable.
                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.box-comment -->
                <div class="box-comment">
                  <!-- User image -->
                  <img class="img-circle img-sm" src="/uploads/images/james.jpg" alt="User Image">

                  <div class="comment-text">
                        <span class="username">
                          James Reid
                          <span class="text-muted pull-right">8:03 PM Today</span>
                        </span><!-- /.username -->
                    Delicious food, nice ambiance, and very friendly staffs. Will definitely
                    go back here again.
                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.box-comment -->
              </div>
              <!-- /.box-footer -->
              <div class="box-footer box-comments">
                <div class="box-comment">
                  <!-- User image -->
                  <img class="img-circle img-sm" src="/uploads/images/abel.jpg" alt="User Image">

                  <div class="comment-text">
                        <span class="username">
                          The Weeknd
                          <span class="text-muted pull-right">8:03 PM Today</span>
                        </span><!-- /.username -->
                  Very nice place, food and staff. But the service took so long.
                  </div>
                  <!-- /.comment-text -->
                </div>
            </div>
            <!-- /.box -->
            <div class="box-footer box-comments">
              <div class="box-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="/uploads/images/Maddie.jpg" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                        Maddie Madayag
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span><!-- /.username -->
                The best restaurant eveeer! I can't help but be addicted. The food is
                superb! The staffs are very accomodating. I love the place sooo much!
                </div>
                <!-- /.comment-text -->
              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
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
