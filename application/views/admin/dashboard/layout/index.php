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
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>HUB</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Travel</b> Hub</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="/uploads/images/user.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><?php echo $user->username?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url(); ?>uploads/images/<?php echo $user->image?>" class="img-circle" alt="User Image">

                <p>
                  Admin<small>Member since <?php $joined = strtotime($user->date_joined);
                  // echo date('F j Y',$joined)
                  echo date('F j Y',$joined)
                  ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url(); ?>Admin/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">HEADER</li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="active treeview">
          <a href=""><i class="fa fa-navicon"></i> <span>Layout</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview"><a href="<?php echo base_url(); ?>Admin/image_slider"><i class="fa fa-angle-right"></i>Image Slider</a></li>
              <li class="treeview"><a href="<?php echo base_url(); ?>Admin/site_icon"><i class="fa fa-angle-right"></i>Site Icon</a></li>
              <li class="treeview"><a href="<?php echo base_url(); ?>Admin/site_logo"><i class="fa fa-angle-right"></i>Site Logo</a></li>
              <li class="active treeview"><a href="<?php echo base_url(); ?>Admin/site_details"><i class="fa fa-angle-right"></i>Site Details</a></li>
              <li class="treeview"><a href="<?php echo base_url(); ?>Admin/about_page"><i class="fa fa-angle-right"></i>About page</a></li>
          </ul>
        </li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/localities"><i class="fa fa-map-marker"></i> <span>Localities</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/categories"><i class="fa fa-edit"></i> <span>Categories</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/events"><i class="fa fa-calendar"></i> <span>Events</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/forum"><i class="fa fa-comments"></i> <span>Forum</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/themes"><i class="fa fa-cog"></i> <span>Themes</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/advertisements"><i class="fa fa-usd"></i> <span>Advertisements</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/accounts"><i class="fa fa-user"></i> <span>Accounts</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Site Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form class="" action="<?php echo base_url(); ?>Admin/save_site_settings" method="post" enctype="multipart/form-data">
                <span style="font-style:italic;font-weight:bold;">Please fill up all fields with *</span>
                <div class="form-group">
                  <label>Site Title*</label>
                  <input type="text" name="title" class="form-control" value="<?php if (!empty($title->value)) { echo $title->value; } ?>" max="80">
                  <span style="color:red" class="help-block"><?php echo form_error('title'); ?></span>
                </div>
                <div class="form-group input-width center-block">
                  <label>Tagline*</label>
                  <textarea class="form-control" name="tagline" rows="8" max="800"><?php if (!empty($tagline->value)) { echo $tagline->value; } ?></textarea>
                  <span style="color:red" class="help-block"><?php echo form_error('tagline'); ?></span>
                </div>
              </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" name="create" class="btn btn-success" value="Add"><i class="fa fa-floppy-o"></i> Save</button>
                </div>
              </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Social</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form class="" action="<?php echo base_url(); ?>Admin/save_social" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Facebook:</label>
                  <input type="text" name="facebook" class="form-control" value="<?php if (!empty($facebook->value)) { echo $facebook->value; } ?>" placeholder="ex:https://www.facebook.com/travel.hub">
                  <span style="color:red" class="help-block"><?php echo form_error('facebook'); ?></span>
                </div>
                <div class="form-group">
                  <label>Instagram:</label>
                  <input type="text" name="instagram" class="form-control" value="<?php if (!empty($instagram->value)) { echo $instagram->value; } ?>" placeholder="ex:https://www.instagram.com/travelhub/">
                  <span style="color:red" class="help-block"><?php echo form_error('instagram'); ?></span>
                </div>
                <div class="form-group">
                  <label>Twitter:</label>
                  <input type="text" name="twitter" class="form-control" value="<?php if (!empty($twitter->value)) { echo $twitter->value; } ?>" placeholder="ex:https://twitter.com/travelhub">
                  <span style="color:red" class="help-block"><?php echo form_error('twitter'); ?></span>
                </div>
                <div class="form-group">
                  <label>Email:</label>
                  <input type="text" name="email" class="form-control" value="<?php if (!empty($email->value)) { echo $email->value; } ?>" placeholder="youremail@example.com">
                  <span style="color:red" class="help-block"><?php echo form_error('email'); ?></span>
                </div>
              </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" name="create" class="btn btn-success" value="Add"><i class="fa fa-floppy-o"></i> Save</button>
                </div>
              </form>
          </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.9.0
    </div>
    <strong>Copyright &copy; 2017-2018 Travel Hub.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

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
</body>
</html>
