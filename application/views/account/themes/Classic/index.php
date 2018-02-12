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
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Dosis:300|Playfair+Display" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/template1/style.css">

</head>
<body onscroll="stickNav()">

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-6 logo">
        <img class="img-responsive center-block" width="400px;" src="/public/img/logo1.png" alt="Logo">
      </div>
      <div class="col-sm-3">
      </div>
    </div>
  </div>

  <nav class="navbar navbar-default navbar-custom" id="menu-bar">
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
        <ul class="nav navbar-nav">
          <li class="active"><a href="#slider">HOME</a></li>
          <li><a href="#about">ABOUT</a></li>
          <li><a href="#gallery">GALLERY</a></li>
          <li><a href="#contact">CONTACT</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="slider" class="carousel slide" data-ride="carousel">
    <!-- indicators dot nav -->
    <ol class="carousel-indicators">
      <li data-target="#slider" data-slide-to="0" class="active"></li>
      <li data-target="#slider" data-slide-to="1"></li>
      <li data-target="#slider" data-slide-to="2"></li>
    </ol>
    <!-- wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <?php if (!empty($image_sliders)): ?>
        <?php $ctr = 1;?>
        <?php foreach ($image_sliders as $key => $image_slider): ?>
          <div class="item <?php if($ctr <=1 ){ echo 'active';}?>">
            <img class="carousel-img" src="/uploads/<?php echo $details->username?>/<?php echo $image_slider->value?>">
          </div>
          <?php $ctr++;?>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="item active">
          <img class="carousel-img" src="/public/img/Template1/image1.jpg">
        </div>
        <div class="item">
          <img class="carousel-img" src="/public/img/Template1/image2.jpg">
        </div>
        <div class="item">
          <img class="carousel-img" src="/public/img/Template1/image3.jpg">
        </div>
      <?php endif; ?>
    </div>
    <!-- controls or next and prev btn -->
    <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#slider" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div class="container-fluid home-custom">
    <h1>
      <?php if (!empty($home_title->value)): ?>
        <?php echo $home_title->value?>
      <?php else: ?>
        Enter your text here
      <?php endif; ?>
    </h1>
    <hr>
    <div class="row">
      <div class="col-sm-6 col-md-6 home-text">
        <p class="text-justify">
          <?php if (!empty($home_description->value)): ?>
            <?php echo $home_description->value?>
          <?php else: ?>
            Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in
          <?php endif; ?>
        </p>
      </div>
    </div>
  </div>

  <!-- <div class="container-fluid about-header"></div> -->

  <div class="container-fluid about-custom" id="about">
    <h1>About</h1>
    <hr>
    <div class="row">
      <div class="col-sm-6 col-md-6 about-text">
        <!-- 600 x 500 -->
        <?php if (!empty($about_featured_image->value)): ?>
          <img class="about-img center-block img-responsive" src="/uploads/themes/<?php echo $details->template?>/<?php echo $about_featured_image->value?>" alt="">
        <?php else: ?>
          <img class="about-img center-block img-responsive" src="/public/img/Template1/image4.jpg" alt="">
        <?php endif; ?>
        <p class="text-justify">
          <?php if (!empty($about_description->value)): ?>
            <?php echo $about_description->value ?>
          <?php else: ?>
            Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.
          <?php endif; ?>
      </p>
      </div>
    </div>
  </div>

  <div class="container-fluid gallery-custom" id="gallery">
    <h1>Gallery</h1>
    <hr>
    <div class="row">
      <!-- 550 x 500 -->
      <?php if (!empty($gallery_images)): ?>
        <?php foreach ($gallery_images as $key => $gallery_image): ?>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" style="background-image: url(/uploads/<?php echo $details->username?>/<?php echo $gallery_image->value?>);"></div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by Sonnie Hiles on Unsplash" style="background-image: url(/public/img/Template1/gallery-1.jpg);"></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by Dan Michael Sinadjan on Unsplash" style="background-image: url(/public/img/Template1/gallery-2.jpg);"></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by Alexander Mils on Unsplash" style="background-image: url(/public/img/Template1/gallery-3.jpg);"></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by Osha Key on Unsplash" style="background-image: url(/public/img/Template1/gallery-4.jpg);"></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by frank mckenna on Unsplash" style="background-image: url(/public/img/Template1/gallery-5.jpg);"></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by Guillaume Jaillet on Unsplash" style="background-image: url(/public/img/Template1/gallery-6.jpg);"></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by freestocks.org on Unsplash" style="background-image: url(/public/img/Template1/gallery-7.jpg);"></div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col" title="Photo by Wesual Click on Unsplash" style="background-image: url(/public/img/Template1/gallery-8.jpg);"></div>
      <?php endif; ?>
    </div>
  </div>

  <div class="container-fluid contact-custom" id="contact">
    <h1>Contact</h1>
    <!-- <img src="/public/img/Template1/image5.jpg" alt="" width="550px" height="500px"> -->
    <hr>
    <div class="form-group">
      <span class="location-custom"><i class="fa fa-map-marker icon-custom"></i>
        <?php if (!empty($details->address)): ?>
          <?php echo $details->address ?>
        <?php else: ?>
          Enter you address here
        <?php endif; ?>
      </span>
    </div>
    <div class="form-group">
      <span class="location-custom"><i class="fa fa-phone icon-custom"></i>
        <?php if (!empty($details->telephone)): ?>
          <?php echo $details->telephone ?>
        <?php else: ?>
          Enter your telephone here
        <?php endif; ?>
      </span>
    </div>
    <div class="form-group">
      <span class="location-custom"><i class="fa fa-envelope icon-custom"></i>
        <?php if (!empty($details->email)): ?>
          <?php echo $details->email ?>
        <?php else: ?>
          youremail@example.com
        <?php endif; ?>
      </span>
    </div>
    <div class="form-group">
      <span style="font-size:18px;color:#323339;">Follow Us</span>
      <div class="row">
        <?php if (!empty($facebook->value)): ?>
          <a href="<?php echo $facebook->value?>" target="_blank"><span style="font-size:15px;color:#323339;"><i class="fa fa-facebook-square icon-custom"></i></span></a>
        <?php else: ?>
          <a href="#"><span style="font-size:15px;color:#323339;"><i class="fa fa-facebook-square icon-custom"></i></span></a>
        <?php endif; ?>
        <?php if (!empty($instagram->value)): ?>
          <a href="<?php echo $instagram->value?>" target="_blank"><span style="font-size:15px;color:#323339;"><i class="fa fa-instagram icon-custom"></i></span></a>
        <?php else: ?>
          <a href="#"><span style="font-size:15px;color:#323339;"><i class="fa fa-instagram icon-custom"></i></span></a>
        <?php endif; ?>
      </div>
    </div>
  </div>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/dist/js/demo.js"></script>
<script>
var navbar = document.getElementById("menu-bar");
var sticky = navbar.offsetTop;

function stickNav() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>
</body>
</html>
