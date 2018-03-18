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
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/themes/Neutral/style.css">
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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if (!empty($account->username)): ?> <?php echo $account->username ?> <?php endif; ?><span class="caret"></span></a>
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
        <li class="active">Customizing Profile</li>
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
                          <li><a href="/Account/switch?business=<?php echo $business->business_name ?>"><?php echo $business->business_name ?></a></li>
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
          <img src="/public/img/default-img.jpg" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php endif; ?>
        <div class="add-box pull-right">
          <a href="/Account/new"><span><i class="ion-ios-plus"></i> </span>New business</a>
        </div>
        <div class="vertical-menu">
          <a href="/Account">Dashboard</a>
          <a href="/Account/profile" class="active">Profile</a>
          <a href="/Account/site_identity">Site Identity</a>
          <a href="/Neutral/home">Home Page Settings</a>
          <a href="/Neutral/about">About Page Settings</a>
          <a href="/Neutral/gallery">Gallery Page Settings</a>
          <a href="/Neutral/contacts">Contacts Page Settings</a>
          <a href="/Neutral/theme">Theme</a>
        </div>
      </div>
      <div class="col-lg-9" style="background-color:#fff;">
        <div class="row text-title header-row">
          <h2 class="">Basic Info</h2>
          <hr>
        </div>
        <form class="" action="/Account/save_profile" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Profile Image:
              <br>
              <span style="color:#323339;"><small> Note: Please upload an image with 500 pixels x 500 pixels or 200 pixels x 200 pixels dimension.</small></span>
            </label>
            <input class="" type="file" name="picture" />
          </div>
          <div class="form-group">
            <label>Business Category:</label>
            <select class="form-control" name="category" id="category">
              <option value ="<?php if (!empty($details->category)): ?> <?php echo $details->category ?><?php endif;?>" selected><?php if (!empty($details->category)): ?> <?php echo $details->category ?> <?php endif; ?></option>
              <?php foreach ($categories as $key => $category): ?>
                <option value ="<?php echo $category->category?>"><?php echo $category->category?></option>
              <?php endforeach; ?>
            </select>
            <span style="color:red" class="help-block"><?php echo form_error('category'); ?></span>
          </div>
          <div class="form-group">
            <label>City/Province:</label>
            <select class="form-control" name="city_province" id="city_province">
              <option value ="<?php if (!empty($details->locality)): ?> <?php echo $details->locality?><?php endif;?>" selected><?php if (!empty($details->locality)): ?> <?php echo $details->locality ?> <?php endif; ?></option>
              <?php foreach ($localities as $key => $locality): ?>
                <option value ="<?php echo $locality->locality?>"><?php echo $locality->locality?></option>
              <?php endforeach; ?>
            </select>
            <span style="color:red" class="help-block"><?php echo form_error('city_province'); ?></span>
          </div>
          <div class="form-group">
            <label>Business Name:</label>
            <input type="text" name="business_name" class="form-control" value="<?php if (!empty($details->business_name)): ?> <?php echo $details->business_name ?><?php endif; ?>" maxlength="25">
            <span style="color:red" class="help-block"><?php echo form_error('business_name'); ?></span>
          </div>
          <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" class="form-control" value="<?php if (!empty($details->address)): ?> <?php echo $details->address ?><?php endif; ?>" maxlength="50">
            <span style="color:red" class="help-block"><?php echo form_error('address'); ?></span>
          </div>

          <div class="form-group">
            <label>Cellphone Number: (Do NOT include the leading 0)</label>
            <div class="input-group">
              <div class="input-group-addon"><i>+63</i></div>
              <input type="text" name="cellphone_number" class="form-control input-style" value="<?php if (!empty($details->cellphone)): ?> <?php echo $details->cellphone ?><?php endif; ?>" placeholder="917XXXXXXX" maxlength="10">
            </div>
            <span style="color:red" class="help-block"><?php echo form_error('cellphone_number'); ?></span>
          </div>
          <div class="form-group">
            <label>Telephone Number:</label>
            <input type="text" name="telephone_number" class="form-control" value="<?php if (!empty($details->telephone)): ?> <?php echo $details->telephone ?><?php endif; ?>" maxlength="11">
            <span style="color:red" class="help-block"><?php echo form_error('telephone_number'); ?></span>
          </div>
          <div class="form-group">
            <label>Contact Person:</label>
            <input type="text" name="contact_person" class="form-control" value="<?php if (!empty($details->contact_person)): ?> <?php echo $details->contact_person ?><?php endif; ?>" maxlength="50">
            <span style="color:red" class="help-block"><?php echo form_error('contact_person'); ?></span>
          </div>
          <div class="form-group">
            <button type="submit" name="save" class="btn btn-success form-control"><i class="fa fa-floppy-o"></i> Save</button>
          </div>
        </form>
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
