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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato|Rubik+Mono+One" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/profile/style.css">
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
          <!-- <img alt="Brand" src="/public/img/logo/TH-Logo-White.png" height="25px" width="50px"> -->
        </a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning">10</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 10 notifications</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li>
                  <a href="#">
                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                    page and may cause design problems
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-users text-red"></i> 5 new members joined
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-user text-red"></i> You changed your username
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if (!empty($account->username)): ?>
          <?php echo $account->username?>
          <?php else: ?>
            Admin
          <?php endif; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>Account/security">Security</a></li>
            <li><a href="<?php echo base_url() ?>Account/details">Account Details</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo base_url() ?>Account/logout">Logout</a></li>
          </ul>
        </li>
      </ul>

    </div><!-- /.container-fluid -->
  </nav>
  <!-- END OF NAV -->

  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li><a href="<?php echo base_url() ?>Account">Go back to dashboard</a></li>
        <li class="active">Security</li>
      </ul>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-12" style="">
        <div class="col-lg-6" style="background-color:#fff;border-left:solid 10px #ebe9e9;padding-bottom:20px;">
          <div class="row text-title header-row">
            <h3 class="title">Change email</h3>
            <hr>
          </div>
          <form class="" action="<?php echo base_url() ?>Account/update_email" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Email:</label>
              <input type="text" name="email" class="form-control" value="<?php if (!empty($account->email)): ?><?php echo $account->email?><?php endif; ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('email'); ?></span>
            </div>
            <div class="form-group">
              <button type="submit" name="save" class="btn btn-success form-control"><i class="fa fa-floppy-o"></i> Update</button>
            </div>
          </form>
        </div>
        <div class="col-lg-6" style="background-color:#fff;border-left:solid 10px #ebe9e9;padding-bottom:20px;">
          <div class="row text-title header-row">
            <h3 class="title">Change password</h3>
            <hr>
          </div>
          <form class="" action="<?php echo base_url() ?>Account/update_password" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Enter old password:</label>
              <input type="password" name="old_password" class="form-control" value="<?php echo set_value('old_password'); ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('old_password'); ?></span>
               <span style="color:red" class="help-block"><?= $this->session->flashdata('message') ?></span>
            </div>
            <div class="form-group">
              <label>Enter new password:</label>
              <input type="password" name="new_password" class="form-control" value="<?php echo set_value('new_password'); ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('new_password'); ?></span>
            </div>
            <div class="form-group">
              <label>Confirm new password:</label>
              <input type="password" name="confirm" class="form-control" value="<?php echo set_value('confirm'); ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('confirm'); ?></span>
            </div>
            <div class="form-group">
              <button type="submit" name="save" class="btn btn-success form-control"><i class="fa fa-floppy-o"></i> Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer1">
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="footer-desc text-center">
                        <div class="col-lg-6 col-lg-offset-3">
                          <p>
                              <?php if (!empty($tagline->value)): ?>
                                <?php echo $tagline->value ?>
                                <?php else: ?>
                                  Travel Hub is a lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                              <?php endif; ?> <a href="<?php echo base_url() ?>About" target="_blank">Learn More</a>
                          </p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <ul class="social">
                        <li><a href="<?php if (!empty($facebook->value)): ?> <?php echo $facebook->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php if (!empty($twitter->value)): ?> <?php echo $twitter->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?php if (!empty($google->value)): ?> <?php echo $google->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="<?php if (!empty($instagram->value)): ?> <?php echo $instagram->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div> <!--/.row-->
        </div> <!--/.container-->
    </div> <!--/.footer-->

    <div class="footer-bottom">
        <div class="container">
            <div class="text-center"> Copyright © 2017-2018. All right reserved.</div>
        </div>
    </div> <!--/.footer-bottom-->
  </footer>
  <!-- END FOOTER -->

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
