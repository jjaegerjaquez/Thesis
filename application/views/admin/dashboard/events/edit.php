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
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/crop/croppie.css">
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
        <li class="treeview">
          <a href=""><i class="fa fa-navicon"></i> <span>Layout</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview"><a href="<?php echo base_url(); ?>Admin/image_slider"><i class="fa fa-angle-right"></i>Image Slider</a></li>
              <li class="treeview"><a href="<?php echo base_url(); ?>Admin/site_icon"><i class="fa fa-angle-right"></i>Site Icon</a></li>
              <li class="treeview"><a href="<?php echo base_url(); ?>Admin/site_logo"><i class="fa fa-angle-right"></i>Site Logo</a></li>
              <li class="treeview"><a href="<?php echo base_url(); ?>Admin/site_details"><i class="fa fa-angle-right"></i>Site Details</a></li>
              <li class="treeview"><a href="<?php echo base_url(); ?>Admin/about_page"><i class="fa fa-angle-right"></i>About page</a></li>
          </ul>
        </li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/localities"><i class="fa fa-map-marker"></i> <span>Localities</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/categories"><i class="fa fa-edit"></i> <span>Categories</span></a></li>
        <li class="active treeview"><a href="<?php echo base_url(); ?>Admin/events"><i class="fa fa-calendar"></i> <span>Events</span></a></li>
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit event</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-lg-6">
                <div class="form-group text-center">
                  <label style="display:none;" id="upload-lbl" class="alert alert-info">Uploading your file, please wait a moment...</label>
                </div>
                <div class="form-group">
                  <label for="">Select image</label>
                  <input type="file" id="images" class="form-control">
                </div>
                <div class="form-group">
                  <div id="upload-image"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div id="error_message"></div>
                <div class="form-inline">
                  <div class="form-group">
                    <label>Start:</label>
                    <input type="date" name="start" value="<?php if (!empty($event->start_date)): ?><?php echo $event->start_date ?><?php endif; ?>" id="start">
                    <span style="color:red" class="help-block"><?php echo form_error('start'); ?></span>
                  </div>
                  <div class="form-group">
                    <label>End:</label>
                    <input type="date" name="end" value="<?php if (!empty($event->end_date)): ?><?php echo $event->end_date ?><?php endif; ?>" id="end">
                    <span style="color:red" class="help-block"><?php echo form_error('end'); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Event Title:</label>
                  <input type="text" name="title" class="form-control" value="<?php if (!empty($event->title)): ?><?php echo $event->title ?><?php endif; ?>" id="title">
                  <span style="color:red" class="help-block"><?php echo form_error('title'); ?></span>
                </div>
                <div class="form-group">
                  <label>Type of event:</label>
                  <input type="text" name="type" class="form-control"  id="type" value="<?php if (!empty($event->type)): ?><?php echo $event->type ?><?php endif; ?>" placeholder="Holiday, Festival etc.">
                  <span style="color:red" class="help-block"><?php echo form_error('type'); ?></span>
                </div>
                <div class="form-group">
                  <label>Place:</label>
                  <input type="text" name="place" class="form-control" value="<?php if (!empty($event->place)): ?><?php echo $event->place ?><?php endif; ?>" id="place">
                  <span style="color:red" class="help-block"><?php echo form_error('place'); ?></span>
                </div>
                <div class="form-group input-width center-block">
                  <label>Description:</label>
                  <textarea class="form-control" name="description" id="description"><?php if (!empty($event->description)): ?><?php echo $event->description ?><?php endif; ?></textarea>
                  <span style="color:red" class="help-block"><?php echo form_error('description'); ?></span>
                </div>
                <div class="form-group">
                  <button class="btn btn-success cropped_image help-block"><i class="fa fa-floppy-o"></i> Update</button>
                  <a href="<?php echo base_url(); ?>Admin/events" class="btn btn-danger" style="margin-top:5px;"><i class="fa fa-chevron-left"></i> Back</a>
                </div>
              </div>
            </div><!-- /.box-body -->
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
<script src="<?php echo base_url(); ?>public/js/crop/croppie.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/js/demo.js"></script>
<script>
$image_crop = $('#upload-image').croppie({
	enableExif: true,
	viewport: {
    width: 456,
		height: 256,
		type: 'square'
	},
	boundary: {
    width: 500,
		height: 300
	}
});
$('#images').on('change', function () {
	var reader = new FileReader();
	reader.onload = function (e) {
		$image_crop.croppie('bind', {
			url: e.target.result
		}).then(function(){
			// console.log('<?php echo base_url() ?>');
		});
	}
	reader.readAsDataURL(this.files[0]);
});

$('.cropped_image').on('click', function (ev) {
  if ($('#images').val()=='') {

	}else {
    $('#upload-lbl').show();
	}
	$image_crop.croppie('result', {
		type: 'canvas',
		size: { width: 1366, height: 768 }
	}).then(function (response) {
    var file_input = $('#images').val();
    var start = $('#start').val();
    var end = $('#end').val();
    var title = $('#title').val();
    var type = $('#type').val();
    var place = $('#place').val();
    var description = $('#description').val();
		$.ajax({
			url: "<?php echo base_url() ?>Admin/update_event/<?php echo $event->event_id?>",
			type: "POST",
			data: {"image":response,"file":file_input,"start":start,"end":end,"title":title,"type":type,"place":place,"description":description},
			success: function (data) {
        if (data == 'Please select an image') {
          alert(data);
        }
        else if (data == 'Event updated!') {
          $('#upload-lbl').hide();
          alert(data);
          $(location).attr('href','<?php echo base_url() ?>Admin/events');
        }
        else if (data == 'Event cannot be updated') {
          $('#upload-lbl').hide();
          alert(data);
        }
        else {
          $('#upload-lbl').hide();
          $('#error_message').html('<div class="alert alert-danger">'+ data +'</div>');
        }
			}
		});
	});
});
</script>
</body>
</html>
