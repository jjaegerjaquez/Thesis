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

  <!-- NAVBAR -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown notifications-menu" id="notif-div">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i><?php if (!empty($notif_count)): ?><span class="label label-warning" id="notif-count"><?php echo $notif_count->notif_count?></span>
              <?php endif; ?>
            </a>
            <ul class="dropdown-menu">
              <!-- <li class="header">You have 10 notifications</li> -->
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php if (!empty($notifications)): ?>
                    <?php foreach ($notifications as $key => $notification): ?>
                      <?php if ($notification->type_of_notification == 'Review'): ?>
                        <li>
                          <a href="<?php echo $notification->href ?>">
                            <i class="ion-compose"></i> <?php echo $notification->title_content ?>
                          </a>
                        </li>
                      <?php elseif ($notification->type_of_notification == 'Vote'):?>
                        <li>
                          <a href="<?php echo $notification->href ?>">
                            <i class="ion-heart"></i> <?php echo $notification->title_content ?>
                          </a>
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <li>You have no notifications</li>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url();?>Account/notifications">View all</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <?php if (!empty($account->username)): ?>
                <?php echo $account->username?>
              <?php else: ?>
                Admin
              <?php endif; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url() ?>Account/security">Security</a></li>
              <li><a href="<?php echo base_url() ?>Account/details">Account Details</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo base_url() ?>Account/logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- END NAVBAR -->

  <div class="container">
    <div class="row">
      <ul class="breadcrumb">
        <li><a href="<?php echo base_url() ?>Account">Back to Dashboard</a></li>
        <li class="active">Profile</li>
      </ul>
      <div class="col-lg-3">
        <div class="row">
          <div class="col-lg-12 switch" style="padding:0;margin-left:5px;">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <?php if (count($businesses) == 1): ?>
                  <a href="#" aria-haspopup="true" aria-expanded="false"><?php if (!empty($business_name)): ?>
                  <?php echo $business_name?>
                  <?php else: ?>
                    Business
                  <?php endif; ?> </a>
                <?php else: ?>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if (!empty($business_name)): ?>
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
                          <li><a href="<?php echo base_url() ?>Account/switch_business?business=<?php echo urlencode($business->business_name) ?>"><?php echo $business->business_name ?></a></li>
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
      <div class="col-lg-3 box-div">
        <?php if (!empty($details->image)): ?>
          <img src="<?php echo $details->image?>" class="center-block" alt="User Image" width="200px" height="200px">
        <?php else: ?>
          <img src="<?php echo base_url() ?>public/img/default-img.jpg" class="center-block" alt="User Image" width="200px" height="200px">
        <?php endif; ?>
        <div class="add-box pull-right">
          <a href="<?php echo base_url() ?>Account/new_business"><span><i class="ion-ios-plus"></i> </span>New business</a>
        </div>
        <div class="vertical-menu">
          <a href="<?php echo base_url() ?>Account">Dashboard</a>
          <a href="<?php echo base_url() ?>Account/profile" class="active">Profile</a>
          <a href="<?php echo base_url() ?>Account/site_identity">Site Identity</a>
          <a href="<?php echo base_url() ?>Light/home">Home Page Settings</a>
          <a href="<?php echo base_url() ?>Light/about">About Page Settings</a>
          <a href="<?php echo base_url() ?>Light/gallery">Gallery Page Settings</a>
          <a href="<?php echo base_url() ?>Light/contacts">Contacts Page Settings</a>
          <a href="<?php echo base_url() ?>Light/theme">Theme</a>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="col-lg-5 box-div2">
          <div class="row text-title header-row">
            <h3 class="title">Profile Image</h3>
            <hr>
          </div>
          <div class="text-center">
            <div class="form-group">
              <div id="upload-image"></div>
            </div>
            <div class="form-group">
              <label for="">Select profile image:</label>
              <input type="file" id="images" class="form-control">
              <button class="btn btn-success cropped_image help-block"><i class="fa fa-floppy-o"></i> Save</button>
            </div>
            <div class="form-group text-center">
              <label style="display:none;" id="upload-lbl" class="alert alert-info">Uploading your file, please wait a moment...</label>
            </div>
          </div>
        </div>
        <div class="col-lg-7 box-div2">
          <div class="row text-title header-row">
            <h3 class="title">Basic Info</h3>
            <hr>
            <span class="required-text">Please fill out all fields with *</span>
          </div>
          <form class="" action="<?php echo base_url() ?>Account/save_profile" method="post" enctype="multipart/form-data">
            <?php if (empty($account->username)): ?>
              <div class="form-group">
                <label>Username* <small><span style="font-style:italic;">You can set your username only once.</span></small></label>
                <input type="text" name="username" class="form-control" value="" maxlength="25">
                <span style="color:red" class="help-block"><?php echo form_error('username'); ?></span>
              </div>
            <?php endif; ?>
            <div class="form-group">
              <label>Business Category*</label>
              <select class="form-control" name="category" id="category">
                <option value ="<?php if (!empty($details->category)): ?><?php echo $details->category ?><?php endif;?>" selected><?php if (!empty($details->category)): ?><?php echo $details->category ?> <?php endif; ?></option>
                <?php foreach ($categories as $key => $category): ?>
                  <?php if ($details->category == $category->category): ?>
                  <?php else: ?>
                    <option value ="<?php echo $category->category?>"><?php echo $category->category?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
              <span style="color:red" class="help-block"><?php echo form_error('category'); ?></span>
            </div>
            <div class="form-group">
              <label>Business Name*</label>
              <input type="text" name="business_name" class="form-control" value="<?php if (!empty($details->business_name)): ?><?php echo $details->business_name ?><?php endif; ?>" maxlength="50">
              <span style="color:red" class="help-block"><?php echo form_error('business_name'); ?></span>
            </div>
            <div class="row">
              <div class="col-lg-8" style="padding-right:0px;">
                <div class="form-group">
                  <label>Address*</label>
                  <input type="text" name="address" class="form-control" value="<?php if (!empty($details->address)): ?><?php echo $details->address ?><?php endif; ?>" maxlength="200">
                  <span style="color:red" class="help-block"><?php echo form_error('address'); ?></span>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label>City/Province*</label>
                  <select class="form-control" name="city_province" id="city_province">
                    <option value ="<?php if (!empty($details->locality)): ?> <?php echo $details->locality ?><?php endif;?>" selected><?php if (!empty($details->locality)): ?> <?php echo $details->locality ?> <?php endif; ?></option>
                    <?php foreach ($localities as $key => $locality): ?>
                      <?php if ($details->locality == $locality->locality): ?>
                      <?php else: ?>
                        <option value ="<?php echo $locality->locality?>"><?php echo $locality->locality?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <span style="color:red" class="help-block"><?php echo form_error('city_province'); ?></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Cellphone Number (Do NOT include the leading 0)*</label>
              <div class="input-group">
                <div class="input-group-addon"><i>+63</i></div>
                <input type="text" name="cellphone_number" class="form-control input-style" value="<?php if (!empty($details->cellphone)): ?><?php echo $details->cellphone ?><?php endif; ?>" placeholder="917XXXXXXX" maxlength="10">
              </div>
              <span style="color:red" class="help-block"><?php echo form_error('cellphone_number'); ?></span>
            </div>
            <div class="form-group">
              <label>Telephone Number:</label>
              <input type="text" name="telephone_number" class="form-control" value="<?php if (!empty($details->telephone)): ?><?php echo $details->telephone ?><?php endif; ?>" maxlength="11">
              <span style="color:red" class="help-block"><?php echo form_error('telephone_number'); ?></span>
            </div>
            <div class="form-group">
              <label>Contact Person*</label>
              <input type="text" name="contact_person" class="form-control" value="<?php if (!empty($details->contact_person)): ?><?php echo $details->contact_person ?><?php endif; ?>" maxlength="50">
              <span style="color:red" class="help-block"><?php echo form_error('contact_person'); ?></span>
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
		width: 200,
		height: 200,
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
  if ($('#images').val()=='') {

	}else {
    $('#upload-lbl').show();
	}
	$image_crop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (response) {
    var file_input = $('#images').val();
		$.ajax({
			url: "<?php echo base_url() ?>Account/upload_profile_img",
			type: "POST",
			data: {"image":response,"file":file_input},
			success: function (data) {
        $('#upload-lbl').show();
        alert(data);
        $(location).attr('href','<?php echo base_url() ?>Account/profile');
				// html = '<img src="' + response + '" />';
				// $("#upload-image-i").html(html);
			}
		});
	});
});
</script>
</body>
</html>
