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
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/themes/Classic/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/crop/croppie.css">
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
            <li><a href="<?php echo base_url(); ?>Account/security">Security</a></li>
            <li><a href="<?php echo base_url(); ?>Account/details">Account Details</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo base_url(); ?>Account/logout">Logout</a></li>
          </ul>
        </li>
      </ul>

    </div><!-- /.container-fluid -->
  </nav>
  <!-- END OF NAV -->

  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Account">Back to Dashboard</a></li>
        <li class="active">Customizing site identity</li>
      </ul>
      <div class="col-lg-3">
        <div class="row">
          <div class="col-lg-12 switch" style="padding:0;">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <?php if (count($businesses) == 1): ?>
                  <a href="#" aria-haspopup="true" aria-expanded="false"><?php if (!empty($account->username)): ?>
                  <?php echo $business_name?>
                  <?php else: ?>
                    Business
                  <?php endif; ?> </a>
                <?php else: ?>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if (!empty($account->username)): ?>
                  <?php echo $business_name?>
                  <?php else: ?>
                    Business
                  <?php endif; ?> <span class="caret"></span></a>
                <?php endif; ?>
                  <?php if (!empty($businesses)): ?>
                    <ul class="dropdown-menu">
                      <?php foreach ($businesses as $key => $business): ?>
                        <?php if ($business->business_name == $business_name): ?>
                        <?php else: ?>
                          <li><a href="<?php echo base_url(); ?>Account/switch?business=<?php echo $business->business_name ?>"><?php echo $business->business_name ?></a></li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </ul>
                  <?php else: ?>
                  <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-3" style="background-color:#fff;border-right:10px solid #ebe9e9;padding-top: 20px;">
        <?php if (!empty($details->image)): ?>
          <img src="<?php echo $details->image?>" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php else: ?>
          <img src="<?php echo base_url(); ?>public/img/default-img.jpg" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php endif; ?>
        <div class="add-box pull-right">
          <a href="<?php echo base_url(); ?>Account/new"><span><i class="ion-ios-plus"></i> </span>New business</a>
        </div>
        <div class="vertical-menu">
          <a href="<?php echo base_url(); ?>Account">Dashboard</a>
          <a href="<?php echo base_url(); ?>Account/profile">Profile</a>
          <a href="<?php echo base_url(); ?>Account/site_identity" class="active">Site Identity</a>
          <a href="<?php echo base_url(); ?>Classic/home">Home Page Settings</a>
          <a href="<?php echo base_url(); ?>Classic/about">About Page Settings</a>
          <a href="<?php echo base_url(); ?>Classic/gallery">Gallery Page Settings</a>
          <a href="<?php echo base_url(); ?>Classic/contacts">Contacts Page Settings</a>
          <a href="<?php echo base_url(); ?>Classic/image_slider">Image Slider</a>
          <a href="<?php echo base_url(); ?>Classic/theme">Theme</a>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="col-lg-6" style="background-color:#fff;border-right:10px solid #ebe9e9;">
          <div class="row text-title header-row">
            <h3 class="title">Logo</h3>
            <hr>
          </div>
          <div class="form-group">
            <?php if (!empty($site_logo->value)): ?>
              <img class="center-block" src="<?php echo $site_logo->value?>" alt="" height="100px" height="50px">
            <?php else: ?>
              <img class="center-block" src="<?php echo base_url(); ?>public/img/logo1.png" alt="" height="100px" height="50px">
            <?php endif; ?>
          </div>
          <div class="text-center">
            <div class="form-group">
              <div id="upload-image"></div>
            </div>
            <div class="form-group">
              <label for="">Select image:</label>
              <input type="file" id="images" class="form-control">
              <button class="btn btn-success cropped_image help-block"><i class="fa fa-floppy-o"></i> Save</button>
            </div>
          </div>
        </div>
        <div class="col-lg-6" style="background-color:#fff;">
          <div class="row text-title header-row">
            <h3 class="title">Site Identity</h3>
            <hr>
            <span class="required-text">Please fill out all fields with *</span>
          </div>
          <form class="" action="<?php echo base_url(); ?>Account/save_site_identity" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Site Title*</label>
              <input type="text" name="site_title" class="form-control" value="<?php if (!empty($site_title->value)) { echo $site_title->value; } ?>" maxlength="80" placeholder="Add your site title here">
              <span style="color:red" class="help-block"><?php echo form_error('site_title'); ?></span>
            </div>
            <div class="form-group input-width center-block">
              <label>Tagline*</label>
              <textarea class="form-control" name="site_tagline" maxlength="180" placeholder="Add your business tagline here" rows="6"><?php if (!empty($site_tagline->value)) { echo $site_tagline->value; }?></textarea>
              <span style="color:red" class="help-block"><?php echo form_error('site_tagline'); ?></span>
            </div>
            <div class="form-group">
              <button type="submit" name="save" class="btn btn-success form-control"><i class="fa fa-floppy-o"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/crop/croppie.js"></script>
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
$image_crop = $('#upload-image').croppie({
	enableExif: true,
	viewport: {
		width: 250,
		height: 100,
		type: 'square'
	},
	boundary: {
		width: 300,
		height: 200
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
		size: { width: 500, height: 200 }
	}).then(function (response) {
    var file_input = $('#images').val();
		$.ajax({
			url: "<?php echo base_url() ?>Account/upload_site_logo",
			type: "POST",
			data: {"image":response,"file":file_input},
			success: function (data) {
        alert(data);
        $(location).attr('href','<?php echo base_url() ?>Account/site_identity');
				// html = '<img src="' + response + '" />';
				// $("#upload-image-i").html(html);
			}
		});
	});
});
</script>
</body>
</html>
