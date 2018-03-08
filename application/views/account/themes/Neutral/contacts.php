<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    <?php if (!empty($site_title)): ?>
      <?php echo $site_title->value ?>
    <?php else: ?>
      Site Title
    <?php endif; ?>
  </title>
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
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/Neutral/contact/style.css">
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
          <li><a href="/View/home/<?php echo str_replace(' ', '_', $details->business_name)?>">Home</a></li>
          <li><a href="/View/about/<?php echo str_replace(' ', '_', $details->business_name)?>">About</a></li>
          <li><a href="/View/gallery/<?php echo str_replace(' ', '_', $details->business_name)?>">Gallery</a></li>
          <li><a href="/View/contacts/<?php echo str_replace(' ', '_', $details->business_name)?>">Contact</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <section id="contact" class="content-section text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mx-auto">
          <h2>Contact Us</h2>
          <i class="fa fa-map-marker" aria-hidden="true"></i> <?php if (!empty($details->address)): ?> <?php echo $details->address ?> <?php else: ?> 911 Kapitan Tikong Corner LeonGuinto Street, Malate <?php endif; ?>
          <br><i class="fa fa-phone" aria-hidden="true"></i> <?php if (!empty($details->cellphone)): ?> <?php echo $details->cellphone ?> <?php else: ?> +639778423427 <?php endif; ?>
          <br><i class="fa fa-envelope" aria-hidden="true"></i> <?php if (!empty($details->email)): ?> <?php echo $details->email ?> <?php else: ?> youremail@example.com <?php endif; ?>
          <ul class="list-inline banner-social-buttons">
            <br>
            <?php if (!empty($facebook)): ?>
              <?php echo $facebook->value ?>
            <?php else: ?>
              <a href="#">
                <div class="col-lg-offset-3 col-lg-2 col-md-offset-3 col-md-2 col-xs-12" >
                  <div class="btn btn-default btn-block">
                   <i class="fa fa-facebook fa-fw"></i>Facebook
                  </div>
                </div>
              </a>
            <?php endif; ?>
            <?php if (!empty($instagram)): ?>
              <?php echo $instagram->value ?>
            <?php else: ?>
              <a href="#">
                <div class="col-lg-2 col-md-2">
                  <div class="btn btn-default btn-block col-xs-12">
                   <i class="fa fa-twitter fa-fw"></i>Instagram
                  </div>
                </div>
              </a>
            <?php endif; ?>
            <?php if (!empty($twitter)): ?>
              <?php echo $twitter->value ?>
            <?php else: ?>
              <a href="#">
                <div class="col-lg-2 col-md-2">
                  <div class="btn btn-default btn-block col-xs-12">
                    <i class="fa fa-instagram fa-fw"></i>Twitter
                  </div>
                </div>
              </a>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </section>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
