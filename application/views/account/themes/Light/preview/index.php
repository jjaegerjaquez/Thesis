<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Light</title>
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
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Oswald:400,500" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/Light/style.css">
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
        <a class="navbar-brand" href="<?php echo base_url(); ?>Theme/preview/Light">Site Title</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?php echo base_url() ?>Theme/preview/Light">HOME</a></li>
      		<li><a href="#about">ABOUT</a></li>
      		<li><a href="#gallery">GALLERY</a></li>
      		<li><a href="#contact">CONTACT</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- END OF NAV -->

  <header class="masthead" style="background-image: url('<?php echo base_url() ?>public/img/Light/home-bg.jpg')">  <!-- 1279 x 699 pixels -->
    <div class="overlay"></div>
		<div class="container">
      <div class="row">
        <div class=" col-md-12">
          <div class="site-heading">
            <h1>Your Site Title Goes Here</h1>
            <span class="subheading">Your tagline appears here</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="container home-style">
    <div class="row">
      <div class="col-lg-12 col-md-12 mx-auto">
        <div class="post-preview">
          <h2 class="post-title">You can add text here</h2>
        </div>
         <p class = "text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sodales turpis nec ullamcorper euismod. Etiam arcu nisi, interdum non facilisis ut, vestibulum eget nisi. In scelerisque diam eu enim maximus, sed faucibus magna consectetur. Donec nulla nisi, scelerisque et urna quis, feugiat sodales felis. Sed sit amet magna et risus facilisis molestie. Donec vestibulum nulla non massa finibus bibendum. Phasellus sit amet lectus nec sem scelerisque sollicitudin. In dictum lectus nec bibendum eleifend. Aliquam nec odio aliquam, posuere nisi sed, iaculis urna.</p>
      </div>
    </div>
	</section>

  <section id="about">
    <header class="masthead" style="background-image: url('<?php echo base_url() ?>public/img/Light/about-bg.jpg')"> <!-- 1600 x 1000 pixels -->
      <div class="overlay"></div>
      <section class="container about-style">
        <div class="row">
          <div class=" col-md-12">
            <div class="page-heading">
              <h1>About</h1>
            </div>
          </div>
        </div>
      </section>
    </header>
	</section>

  <div class="container about-style">
    <div class="row">
      <div class="col-lg-12 col-md-12 mx-auto">
        <h2>Add another text here</h2>
        <div class="post-preview">
          <p class = "text-justify">
            In ex metus, vulputate vel imperdiet tempor, gravida in nibh. Etiam in bibendum est. Aliquam justo turpis, lobortis sed ullamcorper ac, tincidunt vel ligula. Pellentesque dolor ante, interdum ut tempor non, egestas non arcu. Nulla in porttitor velit. Sed interdum purus eget efficitur gravida. Pellentesque dignissim dignissim est. Sed varius vel arcu vel laoreet. Curabitur porta augue eu sapien consequat ornare. Fusce ante eros, dignissim eget laoreet sit amet, gravida ut nisi. Nulla facilisi.
          </p>
        </div>
      </div>
    </div>
  </div>

  <section id="gallery">
    <div class="row">
      <div class=" col-md-12">
        <div class="page-heading" style="text-align:center">
          <h1>Gallery</h1>
        </div>
      </div>
    </div>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    	  <li data-target="#myCarousel" data-slide-to="5"></li>
        <li data-target="#myCarousel" data-slide-to="6"></li>
    	  <li data-target="#myCarousel" data-slide-to="7"></li>
        <li data-target="#myCarousel" data-slide-to="8"></li>
    	  <li data-target="#myCarousel" data-slide-to="9"></li>
        <li data-target="#myCarousel" data-slide-to="10"></li>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <div class="item active">
          <img src="<?php echo base_url() ?>public/img/Light/img2.jpg" alt="Los Angeles">
        </div>
        <div class="item">
          <img src="<?php echo base_url() ?>public/img/Light/img3.jpg" alt="Chicago">
        </div>
        <div class="item">
          <img src="<?php echo base_url() ?>public/img/Light/img5.jpg" alt="New York">
        </div>
    	 <div class="item">
    	   <img src="<?php echo base_url() ?>public/img/Light/img6.jpg" alt="New York">
    	 </div>
    	 <div class="item">
          <img src="<?php echo base_url() ?>public/img/Light/img7.jpg" alt="New York">
        </div>
    	 <div class="item">
    	   <img src="<?php echo base_url() ?>public/img/Light/img8.jpg" alt="New York">
    	 </div>
    	 <div class="item">
    	   <img src="<?php echo base_url() ?>public/img/Light/img9.jpg" alt="New York">
    	 </div>
    	 <div class="item">
    	   <img src="<?php echo base_url() ?>public/img/Light/img10.jpg" alt="New York">
    	 </div>
    	 <div class="item">
    	   <img src="<?php echo base_url() ?>public/img/Light/img11.jpg" alt="New York">
    	 </div>
      </div>
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
	</section>

  <section id="contact">
    <footer class="footer1">
      <div class="footer">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="footer-desc text-center">
                <p><h2 style="color:#ffffff"> Contact Us </h2></p>
              </div>
            </div>
            <div class="col-md-4">
              <ul class="links">
                <li><i class="fa fa-envelope"><span> youremail@example.com</span></i></li>
                <li><i class="fa fa-phone"><span> 09xxxxxxxxxx</span></i></li>
                <li><i class="fa fa-location-arrow"><span> Your address goes here</span></i></li>
              </ul>
            </div>
            <div class="col-md-4">
              <ul class="social">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
              </ul>
            </div>
          </div> <!--/.row-->
        </div> <!--/.container-->
      </div> <!--/.footer-->
      <div class="footer-bottom">
        <div class="container">
          <div class="text-center"> Copyright © 2017-2018. All right reserved.</div>
        </div>
      </div> <!--/.footer-bottom-->
    </footer>
  </section>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
