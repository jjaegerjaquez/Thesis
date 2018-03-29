<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($site_title)): ?><?php echo $site_title->value ?><?php else: ?>Site Title<?php endif; ?></title>
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
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/Neutral/gallery/style.css">
</head>
<body>

  <!-- NAV -->
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
          <li><a href="<?php echo base_url(); ?>View/home/<?php echo str_replace(' ', '_', $details->business_name)?>">Home</a></li>
          <li><a href="<?php echo base_url(); ?>View/about/<?php echo str_replace(' ', '_', $details->business_name)?>">About</a></li>
          <li><a href="<?php echo base_url(); ?>View/gallery/<?php echo str_replace(' ', '_', $details->business_name)?>">Gallery</a></li>
          <li><a href="<?php echo base_url(); ?>View/contacts/<?php echo str_replace(' ', '_', $details->business_name)?>">Contact</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="gallery col-lg-15 col-md-15 col-sm-15 col-xs-15">
        <br>
        <br>
        <br>
        <h1 class="gallery-title text-center">Gallery</h1>
      </div>
    </div>
    <div class="row">
      <?php if (!empty($gallery_images)): ?>
        <?php foreach ($gallery_images as $key => $gallery_image): ?>
          <div class="gallery_product1 col-lg-4 col-md-4 col-sm-4 col-xs-12 filter sprinkle">
            <img src="<?php echo $gallery_image->value?>" class="img-responsive" class="image"style="width:100%"> <!--width: 615 pixels height:409 pixels-->
            <div class="middle">
              <div class="text"></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="gallery_product1 col-lg-4 col-md-4 col-sm-4 col-xs-12 filter sprinkle">
          <img src="<?php echo base_url(); ?>public/img/Neutral/party.jpg" class="img-responsive" class="image"style="width:100%"> <!--width: 615 pixels height:409 pixels-->
          <div class="middle">
            <div class="text">Party</div>
          </div>
        </div>
        <div class="gallery_product2 col-lg-4 col-md-4 col-sm-4 col-xs-12 filter hdpe">
          <img src="<?php echo base_url(); ?>public/img/Neutral/weddingg.jpg" class="img-responsive"class="image2" style="width:100%"> <!--width: 615 pixels height:409 pixels-->
          <div class="middle2">
            <div class="text2">Wedding</div>
          </div>
        </div>
        <div class="gallery_product3 col-lg-4 col-md-4 col-sm-4 col-xs-12 filter irrigation">
          <img src="<?php echo base_url(); ?>public/img/Neutral/birthday.jpg" class="img-responsive" class="image3" style="width:100%"> <!--width: 591 pixels height:400 pixels-->
          <div class="middle3">
            <div class="text3">Birthday</div>
          </div>
        </div>
        <div class="gallery_product4 col-lg-4 col-md-4 col-sm-4 col-xs-12 filter sprinkle">
          <img src="<?php echo base_url(); ?>public/img/Neutral/valentinee.jpg" class="img-responsive" class="image4"style="width:100%"> <!--width: 615 pixels height:409 pixels-->
          <div class="middle4">
            <div class="text4">Valentine</div>
          </div>
        </div>
        <div class="gallery_product5 col-lg-4 col-md-4 col-sm-4 col-xs-12 filter hdpe">
          <img src="<?php echo base_url(); ?>public/img/Neutral/newyear.jpg" class="img-responsive"class="image5" style="width:100%"> <!--width: 720 pixels height:455 pixels-->
          <div class="middle5">
            <div class="text5">New Year</div>
          </div>
        </div>
        <div class="gallery_product6 col-lg-4 col-md-4 col-sm-4 col-xs-12 filter irrigation">
          <img src="<?php echo base_url(); ?>public/img/Neutral/christmas.jpg" class="img-responsive" class="image6" style="width:100%"> <!--width: 620 pixels height:413 pixels-->
          <div class="middle6">
            <div class="text6">Christmas</div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>


<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
