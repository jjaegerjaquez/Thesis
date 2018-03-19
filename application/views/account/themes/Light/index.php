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
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Oswald:400,500" rel="stylesheet">
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
        <a class="navbar-brand" href="<?php echo $details->website_url?>">
          <?php if (!empty($site_title)): ?>
            <?php echo $site_title->value ?>
          <?php else: ?>
            Site Title
          <?php endif; ?>
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#home">HOME</a></li>
      		<li><a href="#about">ABOUT</a></li>
      		<li><a href="#gallery">GALLERY</a></li>
      		<li><a href="#contact">CONTACT</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- END OF NAV -->
<?php if (!empty($home_bg->value)): ?>
  <header class="masthead" style="background-image: url('<?php echo $home_bg->value?>')" id="home">  <!-- 1279 x 699 pixels -->
<?php else: ?>
  <header class="masthead" style="background-image: url('/public/img/Light/home-bg.jpg')" id="home">  <!-- 1279 x 699 pixels -->
<?php endif; ?>
    <div class="overlay"></div>
		<div class="container">
      <div class="row">
        <div class=" col-md-12">
          <div class="site-heading">
            <h1>
              <?php if (!empty($site_title)): ?>
                <?php echo $site_title->value ?>
              <?php else: ?>
                Site Title
              <?php endif; ?>
            </h1>
            <span class="subheading">
              <?php if (!empty($site_tagline)): ?>
                <?php echo $site_tagline->value ?>
              <?php else: ?>
                Enter you site tagline here
              <?php endif; ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="container home-style">
    <div class="row">
      <div class="col-lg-12 col-md-12 mx-auto">
        <div class="post-preview">
          <h4 class="post-title">
            <?php if (!empty($home_title)): ?>
              <?php echo $home_title->value ?>
            <?php else: ?>
              Enter text here.
            <?php endif; ?>
          </h4>
        </div>
         <p class = "text-justify">
           <?php if (!empty($home_description)): ?>
             <?php echo $home_description->value ?>
           <?php else: ?>
             Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.
           <?php endif; ?>
         </p>
      </div>
    </div>
	</section>

  <section id="about">
    <?php if (!empty($about_header_image)): ?>
      <header class="masthead" style="background-image: url('<?php echo $about_header_image->value?>')"> <!-- 1600 x 1000 pixels -->
    <?php else: ?>
      <header class="masthead" style="background-image: url('/public/img/Light/about-bg.jpg')"> <!-- 1600 x 1000 pixels -->
    <?php endif; ?>
        <div class="overlay"></div>
        <section class="container about-style">
          <div class="row">
            <div class=" col-md-12">
              <div class="page-heading">
                <h1>About Us</h1>
              </div>
            </div>
          </div>
        </section>
      </header>
	</section>

  <div class="container about-style">
    <div class="row">
      <div class="col-lg-12 col-md-12 mx-auto">
        <h2>
          <?php if (!empty($about_title)): ?>
            <?php echo $about_title->value ?>
          <?php else: ?>
            Enter text here.
          <?php endif; ?>
        </h2>
        <div class="post-preview">
          <p class = "text-justify">
            <?php if (!empty($about_description)): ?>
              <?php echo $about_description->value ?>
            <?php else: ?>
              Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.
            <?php endif; ?>
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
        <?php if (!empty($gallery_images)): ?>
          <?php $ctr = 1;?>
          <?php foreach ($gallery_images as $key => $gallery_image): ?>
            <li data-target="#myCarousel" data-slide-to="<?php echo $ctr ?>" class="<?php if($ctr <=1 ){ echo 'active';}?>"></li>
            <?php $ctr++;?>
          <?php endforeach; ?>
        <?php else: ?>
          <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
      	  <li data-target="#myCarousel" data-slide-to="4"></li>
          <li data-target="#myCarousel" data-slide-to="5"></li>
      	  <li data-target="#myCarousel" data-slide-to="6"></li>
          <li data-target="#myCarousel" data-slide-to="7"></li>
      	  <li data-target="#myCarousel" data-slide-to="8"></li>
          <li data-target="#myCarousel" data-slide-to="9"></li>
        <?php endif; ?>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <?php if (!empty($gallery_images)): ?>
          <?php $ctr = 1;?>
          <?php foreach ($gallery_images as $key => $gallery_image): ?>
            <div class="item <?php if($ctr <=1 ){ echo 'active';}?>">
              <img src="<?php echo $gallery_image->value?>">
            </div>
            <?php $ctr++;?>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="item active">
            <img src="/public/img/Light/img2.jpg" alt="Los Angeles">
          </div>
          <div class="item">
            <img src="/public/img/Light/img3.jpg" alt="Chicago">
          </div>
          <div class="item">
            <img src="/public/img/Light/img5.jpg" alt="New York">
          </div>
        	 <div class="item">
        	   <img src="/public/img/Light/img6.jpg" alt="New York">
        	 </div>
        	 <div class="item">
              <img src="/public/img/Light/img7.jpg" alt="New York">
            </div>
        	 <div class="item">
        	   <img src="/public/img/Light/img8.jpg" alt="New York">
        	 </div>
        	 <div class="item">
        	   <img src="/public/img/Light/img9.jpg" alt="New York">
        	 </div>
        	 <div class="item">
        	   <img src="/public/img/Light/img10.jpg" alt="New York">
        	 </div>
        	 <div class="item">
        	   <img src="/public/img/Light/img11.jpg" alt="New York">
        	 </div>
        <?php endif; ?>
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
                <p><h2 style="color:#ffffff"> Contact Us </h2>
              </div>
            </div>
            <div class="col-md-4">
              <ul>
                <li><i class="fa fa-envelope"><span><?php if (!empty($details->email)): ?>
                  <?php echo $details->email ?>
                <?php else: ?>
                  youremail@example.com
                <?php endif; ?></span></i></li>
                <li><i class="fa fa-phone"><span> <?php if (!empty($details->cellphone)): ?>
                  <?php echo $details->cellphone ?>
                <?php else: ?>
                  0xxxxxxxxxxx
                <?php endif; ?></span></i></li>
                <li><i class="fa fa-location-arrow"><span> <?php if (!empty($details->address)): ?>
                  <?php echo $details->address ?>
                <?php else: ?>
                  Your address goes here
                <?php endif; ?> </span></i></li>
              </ul>
            </div>
            <div class="col-md-4">
              <ul class="social">
                <?php if (!empty($facebook)): ?>
                  <li><a href="<?php echo $facebook->value?>"><i class="fa fa-facebook"></i></a></li>
                <?php else: ?>
                  <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <?php endif; ?>
                <?php if (!empty($twitter)): ?>
                  <li><a href="<?php echo $twitter->value?>"><i class="fa fa-twitter"></i></a></li>
                <?php else: ?>
                  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if (!empty($instagram)): ?>
                  <li><a href="<?php echo $instagram->value?>"><i class="fa fa-instagram"></i></a></li>
                <?php else: ?>
                  <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <?php endif; ?>
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
