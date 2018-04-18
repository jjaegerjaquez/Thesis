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
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/events"><i class="fa fa-calendar"></i> <span>Events</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/forum"><i class="fa fa-comments"></i> <span>Forum</span></a></li>
        <li class="treeview"><a href="<?php echo base_url(); ?>Admin/themes"><i class="fa fa-cog"></i> <span>Themes</span></a></li>
        <li class="active treeview"><a href="<?php echo base_url(); ?>Admin/advertisements"><i class="fa fa-usd"></i> <span>Advertisements</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Admin"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo base_url(); ?>Admin/advertisements">Advertisements</a></li>
        <li class="active">Add Advertisement</li>
      </ol>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Add regular ad</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-lg-6">
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
              <div class="form-group">
                <label>Type*</label>
                <select class="form-control" name="contract" id="contract">
                  <option value="" selected disabled></option>
                  <option value="Month">1 Month</option>
                  <option value="Quarter">Quarter</option>
                  <option value="Half">Half</option>
                  <option value="Year">1 year</option>
                </select>
              </div>
              <div class="form-inline">
                <div class="form-group">
                  <label>Period*</label>
                  <input type="date" name="start" value="<?php echo set_value('start'); ?>" id="start">
                  <span style="color:red" class="help-block"><?php echo form_error('start'); ?></span>
                </div>
                <div class="form-group">
                  <input type="date" name="end" value="<?php echo set_value('end'); ?>" id="end">
                  <span style="color:red" class="help-block"><?php echo form_error('end'); ?></span>
                </div>
              </div>
              <div class="form-group">
                <label>Business ID*</label>
                <input type="text" name="business_id" class="form-control" value="<?php echo set_value('business_id'); ?>" placeholder="Enter business ID" id="business_id">
                <span style="color:red" class="help-block"><?php echo form_error('business_id'); ?></span>
              </div>
              <div class="form-group">
                <label>Title*</label>
                <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>" placeholder="Enter advertisement title" id="title">
                <span style="color:red" class="help-block"><?php echo form_error('title'); ?></span>
              </div>
              <div class="form-group">
                <label>Subtext*</label>
                <input type="text" name="subtext" class="form-control" value="<?php echo set_value('subtext'); ?>" placeholder="Enter advertisement subtext" id="subtext">
                <span style="color:red" class="help-block"><?php echo form_error('subtext'); ?></span>
              </div>
              <div class="form-group input-width center-block">
                <label>Description*</label>
                <textarea class="form-control" name="description" placeholder="Tell something about the advertisement here" rows="10" id="description"><?php echo set_value('description'); ?></textarea>
                <span style="color:red" class="help-block"><?php echo form_error('description'); ?></span>
              </div>
              <div class="form-group">
                <button class="btn btn-success cropped_image help-block"><i class="fa fa-floppy-o"></i> Add</button>
                <a href="<?php echo base_url(); ?>Admin/advertisements" class="btn btn-danger" style="margin-top:5px;"><i class="fa fa-chevron-left"></i> Back</a>
              </div>
            </div>
          </div><!-- /.box-body -->
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
    width: 250,
		height: 250,
		type: 'square'
	},
	boundary: {
    width: 300,
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
	$image_crop.croppie('result', {
		type: 'canvas',
		size: { width: 500, height: 500 }
	}).then(function (response) {
    var file_input = $('#images').val();
    var contract = $('#contract').val();
    var start = $('#start').val();
    var end = $('#end').val();
    var business_id = $('#business_id').val();
    var title = $('#title').val();
    var subtext = $('#subtext').val();
    var description = $('#description').val();
		$.ajax({
			url: "<?php echo base_url() ?>Admin/save_ad/Regular",
			type: "POST",
			data: {"image":response,"file":file_input,"contract":contract,"start":start,"end":end,"business_id":business_id,"title":title,"subtext":subtext,"description":description},
			success: function (data) {
        if (data == 'Please select an image') {
          alert(data);
        }
        else if (data == 'Advertisement added!') {
          alert(data);
          $(location).attr('href','<?php echo base_url() ?>Admin/advertisements');
        }
        else if (data == 'Advertisement cannot be added') {
          alert(data);
        }
        else {
          $('#error_message').html('<div class="alert alert-danger">'+ data +'</div>');
        }
			}
		});
	});
});
</script>
</body>
</html>
