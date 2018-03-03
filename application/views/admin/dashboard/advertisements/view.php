<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($title->value)) { echo $title->value; } else { echo "Title";}?></title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="logo" class="logo">
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
                <img src="/uploads/images/<?php echo $user->image?>" class="img-circle" alt="User Image">

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
                  <a href="/Admin/logout" class="btn btn-default btn-flat">Sign out</a>
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
        <li class="treeview"><a href="/Admin/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview"><a href="/Admin/layout"><i class="fa fa-navicon"></i> <span>Layout</span></a></li>
        <li class="treeview"><a href="/Admin/localities"><i class="fa fa-map-marker"></i> <span>Localities</span></a></li>
        <li class="treeview"><a href="/Admin/categories"><i class="fa fa-edit"></i> <span>Categories</span></a></li>
        <li class="treeview"><a href="/Admin/events"><i class="fa fa-calendar"></i> <span>Events</span></a></li>
        <li class="treeview"><a href="/Admin/forum"><i class="fa fa-comments"></i> <span>Forum</span></a></li>
        <li class="treeview"><a href="/Admin/themes"><i class="fa fa-cog"></i> <span>Themes</span></a></li>
        <li class="active treeview"><a href="/Admin/advertisements"><i class="fa fa-usd"></i> <span>Advertisements</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ad
        <small>details</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/Admin"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="/Admin/advertisements">Advertisements</a></li>
        <li class="active">View <?php echo $ad->title?></li>
      </ol>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <tr>
                <td><label>ID:</label></td>
                <td><?php echo $ad->advertisement_id;?></td>
              </tr>
              <tr>
                <td><label>Image:</label></td>
                <td><img src="<?php echo $ad->image?>" class="img-responsive" style="width:350px"/></td>
              </tr>
              <tr>
                <td><label>Period:</label></td>
                <td><?php $start = strtotime($ad->start_date); echo date('F j Y',$start)?> - <?php $end = strtotime($ad->end_date); echo date('F j Y',$end)?></td>
              </tr>
              <tr>
                <td><label>Business Name:</label></td>
                <td><?php echo $ad->business_name;?></td>
              </tr>
              <tr>
                <td><label>Title:</label></td>
                <td><?php echo $ad->title;?></td>
              </tr>
              <tr>
                <td><label>Subtext:</label></td>
                <td><?php echo $ad->subtext;?></td>
              </tr>
              <tr>
                <td><label>Description:</label></td>
                <td><?php echo $ad->description;?></td>
              </tr>
            </table>
            <a href="/Admin/advertisements" class="btn btn-danger pull-right"><i class="fa fa-chevron-left"></i> Back</a>
          </div>
        </div>
      </div>
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