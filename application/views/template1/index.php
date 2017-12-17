<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tours | PH</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="http://localhost:8000/public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://localhost:8000/public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
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
          <li class="active"><a href="">HOME</a></li>
          <li><a href="">ABOUT</a></li>
          <li><a href="">GALLERY</a></li>
          <li><a href="">CONTACT</a></li>
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
      <div class="item active">
        <img class="carousel-img" src="/public/img/Template1/image1.jpg">
      </div>
      <div class="item">
        <img class="carousel-img" src="/public/img/Template1/image2.jpg">
      </div>
      <div class="item">
        <img class="carousel-img" src="/public/img/Template1/image3.jpg">
      </div>
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
    <h1>Welcome to Brand Name</h1>
    <hr>
    <div class="row">
      <div class="col-sm-6 col-md-6 home-text">
        <p class="text-justify">Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.</p>
        <p class="text-justify">Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.</p>
        <p class="text-justify">Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.</p>
      </div>
    </div>
  </div>

  <!-- <div class="container-fluid about-header"></div> -->

  <div class="container-fluid about-custom">
    <h1>About</h1>
    <hr>
    <div class="row">
      <div class="col-sm-6 col-md-6 about-text">
        <img class="about-img center-block img-responsive" src="/public/img/Template1/image4.jpg" alt="">
        <p class="text-justify">Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.</p>
        <p class="text-justify">Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.</p>
        <p class="text-justify">Lorem ipsum dolor sit amet, est purto labore in. Latine ornatus et est. Sea te nisl reque omnes. Ne eum graeco civibus. Ad indoctum concludaturque sea. Eu ferri ubique has. Volutpat corrumpit vix ut, expetenda appellantur sed an, vis error vituperata in.</p>
      </div>
    </div>
  </div>
  <!-- <div class="container-fluid gallery-custom">
    <h1>Gallery</h1>
    <hr>
    <div class="row">
      <div class="col-lg-4 col">
        <img class="gallery-img" src="/public/img/Template1/image6.jpg" width="350px" height="300px"  alt="">
      </div>
      <div class="col-lg-4 col-2">
        <img class="gallery-img" src="/public/img/Template1/image5.jpg" width="350px" height="300px"  alt="">
      </div>
    </div>
  </div> -->
  <!-- <div class="col-sm-10 center-block"> -->

  <div class="container-fluid gallery-custom">
    <h1>Gallery</h1>
    <hr>
    <div class="row">
      <div class="col-md-offset-3 col-md-3 col">
      </div>
      <div class="col-md-3 col-2">
      </div>
      <div class="col-md-offset-3 col-md-3 col">
      </div>
      <div class="col-md-3 col-2">
      </div>
      <div class="col-md-offset-3 col-md-3 col">
      </div>
      <div class="col-md-3 col-2">
      </div>
    </div>
  </div>

  <div class="container-fluid contact-custom">
    <h1>Contact</h1>
    <hr>
    <div class="form-group">
      <span class="location-custom"><i class="fa fa-map-marker icon-custom"></i>911 Kapitan Tikong Corner Leon Guinto Street, Malate</span>
    </div>
    <div class="form-group">
      <span class="location-custom"><i class="fa fa-phone icon-custom"></i>+63 9778423427</span>
    </div>
    <div class="form-group">
      <span class="location-custom"><i class="fa fa-envelope icon-custom"></i>samgyupsalamatresto@gmail.com</span>
    </div>
    <div class="form-group">
      <span style="font-size:18px;color:#323339;">Follow Us</span>
      <div class="row">
        <span style="font-size:15px;color:#323339;"><i class="fa fa-facebook-square icon-custom"></i></span>
        <span style="font-size:15px;color:#323339;"><i class="fa fa-instagram icon-custom"></i></span>
      </div>
    </div>
  </div>

<!-- jQuery 2.2.3 -->
<script src="http://localhost:8000/public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="http://localhost:8000/public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="http://localhost:8000/public/thesis/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="http://localhost:8000/public/thesis/AdminLTE/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="http://localhost:8000/public/thesis/AdminLTE/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="http://localhost:8000/public/thesis/AdminLTE/dist/js/demo.js"></script>
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
