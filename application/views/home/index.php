<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($title->value)) { echo $title->value; } else { echo "Title";}?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato|Rubik+Mono+One" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
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
      <ul class="nav navbar-nav">
        <li class=""><a href="#">Categories</a></li>
        <li><a href="#">Destinations</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="ion-android-more-horizontal"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Deals</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Forum</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Most Viewed</a></li>
          </ul>
        </li>
        <li><a href="#"><span class="ion-ios-search-strong"></span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="" data-toggle="modal" data-target="#login"> Login</a></li>
        <li><a href="" class="register" data-toggle="modal" data-target="#register">Register</a></li>
      </ul>
    </div>
  </div>
  </nav>
  <!-- END NAVBAR -->

  <!-- IMAGE SLIDER -->
  <div id="slider" class="carousel slide" data-ride="carousel">
    <form class="search-panel" action="" method="post">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-lg-offset-2 col-sm-3 col-sm-offset-2 col-sm-12 no-gutter">
            <div class="input-group">
              <div class="input-group-addon"><i class="ion-location input-style"></i></div>
              <input type="text" class="form-control input-style" placeholder="Location">
            </div>
          </div>
          <div class="col-lg-4 col-sm-4 col-sm-12 no-gutter">
            <input type="text" class="form-control input-style" placeholder="Search for...">
          </div>
          <div class="col-lg-1 col-sm-1 col-sm-12 no-gutter">
            <input class="btn search-btn btn-block" type="submit" value="Search">
          </div>
        </div>
      </div>
    </form>
    <!-- indicators dot nav -->
    <ol class="carousel-indicators">
      <li data-target="#slider" data-slide-to="0" class="active"></li>
      <li data-target="#slider" data-slide-to="1"></li>
      <li data-target="#slider" data-slide-to="2"></li>
    </ol>
    <!-- wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img class="carousel-img" src="/public/img/image1.jpg" style="height:80vh;width:100%;">
      </div>
      <div class="item">
        <img class="carousel-img" src="/public/img/image2.jpg" style="height:80vh;width:100%;">
      </div>
      <div class="item">
        <img class="carousel-img" src="/public/img/image3.jpg" style="height:80vh;width:100%;">
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
  <!-- END IMAGE SLIDER -->

  <!-- LOGIN MODAL -->
  <div class="modal fade" id="login">
    <div class="modal-dialog warning">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 style="color:#FFFFFF" class="login-logo text-center">Travel Hub | Login</h3>
        </div>
        <div class="modal-body">
          <form class="" action="/Login/login" method="post" enctype="multipart/form-data">
            <div id="error_message"></div>
            <div class="form-group">
              <a href="#" class="btn btn-lg btn-block omb_btn-facebook">
			        <i class="fa fa-facebook visible-xs"></i>
			        <span class="hidden-xs">Facebook</span>
		        </a>
            </div>
            <div class="form-group">
              <a href="#" class="btn btn-lg btn-block omb_btn-google">
			        <i class="fa fa-facebook visible-xs"></i>
			        <span class="hidden-xs">Google</span>
		        </a>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" id="email" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" id="password" required>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <input class="btn btn-warning login login-btn" type="submit" name="login" value="Login" id="Submit">
          <button class="btn btn-default close-btn" type="button" name="button" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- END LOGIN  -->

  <!-- REGISTER MODAL -->
  <div class="modal fade" id="register">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 style="color:#FFFFFF" class="login-logo text-center">Travel Hub | Register</h3>
        </div>
        <div class="modal-body">
          <form class="" action="/Lol" method="post" enctype="multipart/form-data">
            <div id="register_error_message"></div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                <input type="email" name="register_email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" id="register_email" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1" id="username" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-lock"></i></span>
                <input type="password" name="register_password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" id="register_password" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-lock"></i></span>
                <input type="password" name="register_confirm_password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon1" id="register_confirm_password" required>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <input class="btn btn-warning login-btn" type="submit" name="register" value="Register" id="Register">
          <button class="btn btn-default close-btn" type="button" name="button" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- END REGISTER -->

  <!-- CATEGORIES SECTION -->
  <section class="container categories-section">
    <div class="row text-title header-row">
      <h1 class="lato text-header">Discover</h1>
      <p>Quick search for what you're looking for</p>
    </div>
    <div class="row row1">
      <div class="sidebar-social text-center">
        <ul>
          <?php foreach ($categories as $key => $category): ?>
            <div class="col-lg-2 col-sm-2 col-xs-12">
              <li>
                <a href="/Category/result/<?php echo $category->category?>" title="<?php echo $category->category?>" target="_self" rel="nofollow">
                  <img src="/public/img/icons/<?php echo $category->image?>" width="25px" height="25px" alt="">
                  <span><?php echo $category->category?></span>
                </a>
              </li>
            </div>
          <?php endforeach; ?>

          <!-- <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Fast Food" target="_self" rel="nofollow">
                <img src="/public/img/icons/fast-food.png" width="25px" height="25px" alt="">
                <span>Fast Food</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Restaurant" target="_self" rel="nofollow">
                <img src="/public/img/icons/restaurant.png" width="25px" height="25px" alt="">
                <span>Restaurant</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Night Market" target="_self" rel="nofollow">
                <img src="/public/img/icons/night.png" width="25px" height="25px" alt="">
                <span>Night Market</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Bar" target="_self" rel="nofollow">
                <img src="/public/img/icons/bar.png" width="25px" height="25px" alt="">
                <span>Bar</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Lodging" target="_self" rel="nofollow">
                <img src="/public/img/icons/lodging.png" width="25px" height="25px" alt="">
                <span>Lodging</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Shoe Shop" target="_self" rel="nofollow">
                <img src="/public/img/icons/shoe.png" width="25px" height="25px" alt="">
                <span>Shop Shop</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Dress Shop" target="_self" rel="nofollow">
                <img src="/public/img/icons/dress.png" width="25px" height="25px" alt="">
                <span>Dress Shop</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Public Market" target="_self" rel="nofollow">
                <img src="/public/img/icons/public-market.png" width="25px" height="25px" alt="">
                <span>Public Market</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Spa" target="_self" rel="nofollow">
                <img src="/public/img/icons/spa.png" width="25px" height="25px" alt="">
                <span>Spa</span>
              </a>
            </li>
          </div>
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="Car Rental" target="_self" rel="nofollow">
                <img src="/public/img/icons/car.png" width="25px" height="25px" alt="">
                <span>Car Rental</span>
              </a>
            </li>
          </div> -->
          <div class="col-lg-2 col-sm-2 col-xs-12">
            <li>
              <a href="" title="See All" target="_self" rel="nofollow">
                <img src="/public/img/icons/search.png" width="25px" height="25px" alt="">
                <span style="color:#fba100;">See All</span>
              </a>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </section>
  <!-- END CATEGORIES SECTION -->

  <!-- DESTINATION SECTION -->
  <section class="container destination-section">
    <div class="row text-title header-row">
      <h1 class="lato text-header">Explore</h1>
      <p>Explore by places or localities</p>
    </div>
    <div class="row row2">
      <div class="col-lg-12 destination-list">
        <ul>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Manila" target="_self" rel="nofollow">
                <label>Manila <span>(250 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Boracay" target="_self" rel="nofollow">
                <label>Boracay <span>(182 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Cebu" target="_self" rel="nofollow">
                <label>Cebu <span>(176 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Bohol" target="_self" rel="nofollow">
                <label>Bohol <span>(163 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Palawan" target="_self" rel="nofollow">
                <label>Palawan <span>(154 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Baguio" target="_self" rel="nofollow">
                <label>Baguio <span>(142 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Davao" target="_self" rel="nofollow">
                <label>Davao <span>(131 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Vigan" target="_self" rel="nofollow">
                <label>Vigan <span>(129 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Tagaytay" target="_self" rel="nofollow">
                <label>Tagaytay <span>(126 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Batangas" target="_self" rel="nofollow">
                <label>Batangas <span>(123 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Taguig" target="_self" rel="nofollow">
                <label>Taguig <span>(119 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Puerto Galera" target="_self" rel="nofollow">
                <label>Puerto Galera <span>(115 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Bataan" target="_self" rel="nofollow">
                <label>Bataan <span>(108 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Bacolod" target="_self" rel="nofollow">
                <label>Bacolod <span>(101 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="Banaue" target="_self" rel="nofollow">
                <label>Banaue <span>(85 places)</span></label>
              </a>
            </li>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <li>
              <a href="" title="See All" target="_self" rel="nofollow">
                <label class="see-all-color">See All</label>
              </a>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </section>
  <!-- END DESTINATION SECTION -->

  <!-- HOT DEALS SECTION -->
  <section class="container hot-deals-section">
    <div class="row text-title header-row">
      <h1 class="lato text-header">Hot Deals</h1>
      <p>Discover great finds and deals for a discounted price</p>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-12 col-xs-12 no-spacing">
          <div class="info-box">
            <a href="#">
              <span class="info-box-icon bg-aqua box-1"></span>
              <div class="info-box-content">
                <span class="info-box-number">Summer Sale: Up to 70% sale!</span>
                <p>Visit Summer Craze PH for great find summer goodies!</p>
              </div>
            </a>
          </div>
      </div>
      <div class="col-lg-4 col-md-12 col-xs-12 no-spacing">
          <div class="info-box">
            <a href="#">
              <span class="info-box-icon bg-aqua box-2"></span>
              <div class="info-box-content">
                <span class="info-box-number">Treat for your Barkada!</span>
                <p>Come with us at Cebu Resorts and enjoy your trip with barkada!</p>
              </div>
            </a>
          </div>
      </div>
      <div class="col-lg-4 col-md-12 col-xs-12 no-spacing">
          <div class="info-box">
            <a href="#">
              <span class="info-box-icon bg-aqua box-3"></span>
              <div class="info-box-content">
                <span class="info-box-number">Discounted Luggage!</span>
                <p>Premium quality luggage here at Luggage Store.</p>
              </div>
            </a>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-12 col-xs-12 no-spacing">
          <div class="info-box">
            <a href="#">
              <span class="info-box-icon bg-aqua box-3"></span>
              <div class="info-box-content">
                <span class="info-box-number">Discounted Luggage!</span>
                <p>Premium quality luggage here at Luggage Store.</p>
              </div>
            </a>
          </div>
      </div>
      <div class="col-lg-4 col-md-12 col-xs-12 no-spacing">
          <div class="info-box">
            <a href="#">
              <span class="info-box-icon bg-aqua box-1"></span>
              <div class="info-box-content">
                <span class="info-box-number">Summer Sale: Up to 70% sale!</span>
                <p>Visit Summer Craze PH for great find summer goodies!</p>
              </div>
            </a>
          </div>
      </div>
      <div class="col-lg-4 col-md-12 col-xs-12 no-spacing">
          <div class="info-box text-center">
            <a href="">
              <div class="icon deal-box">
                <i class="fa fa-tags" style="margin-top:20px;"></i>
              </div>
              <span style="color:#f37430;">View all deals</span>
            </a>
          </div>
      </div>
    </div>
  </section>
  <!-- END HOT DEALS -->

  <!-- EVENTS -->
  <section class="container efc-section">
    <div class="row">
      <div class="col-lg-4 col-md-12">
        <div class="row text-title header-row">
          <h1 class="lato text-header">EVENTS</h1>
          <!-- <p>Discover great finds and deals for a discounted price</p> -->
        </div>
        <div class="row" style="background-color:pink;">
          <div class="spacer"></div>
          <a href="#" class="event">
            <div class="event-container">
              <span class="date-container">
                <span class="date">31<span class="month">may</span></span>
              </span>
              <span class="detail-container">
                <span class="title">linden hills farmers market</span>
              <span class="description">Every other Sunday</span>
              </span>
              </span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="event">
            <div class="event-container">
              <span class="date-container">
                <span class="date">31<span class="month">may</span></span>
              </span>
              <span class="detail-container">
                <span class="title">linden hills farmers market</span>
              <span class="description">Every other Sunday</span>
              </span>
              </span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="event">
            <div class="event-container">
              <span class="date-container">
                <span class="date">31<span class="month">may</span></span>
              </span>
              <span class="detail-container">
                <span class="title">linden hills farmers market</span>
              <span class="description">Every other Sunday</span>
              </span>
              </span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="event">
            <div class="see-all-container text-center">
              <span class="">
                <span class="title">SEE ALL</span>
              </span>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="row text-title header-row">
          <h1 class="lato text-header">TOP FORUM</h1>
          <!-- <p>Discover great finds and deals for a discounted price</p> -->
        </div>
        <div class="row">
          <div class="spacer"></div>
          <a href="#" class="forum">
            <div class="forum-container">
              <span class="forum-title">Tips for a stress free vacationnnnnnnnn?</span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="forum">
            <div class="forum-container">
              <span class="forum-title">Tips for a stress free vacationnnnnnnnn?</span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="forum">
            <div class="forum-container">
              <span class="forum-title">Tips for a stress free vacationnnnnnnnn?</span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="forum">
            <div class="forum-container">
              <span class="forum-title">Tips for a stress free vacationnnnnnnnn?</span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="forum">
            <div class="forum-container">
              <span class="forum-title">Tips for a stress free vacationnnnnnnnn?</span>
            </div>
          </a>
          <div class="spacer"></div>
          <a href="#" class="event">
            <div class="see-all-container-forum text-center">
              <span class="">
                <span class="title">SEE ALL</span>
              </span>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="row text-title header-row">
          <h1 class="lato text-header">COUNT</h1>
          <!-- <p>Discover great finds and deals for a discounted price</p> -->
        </div>
        <div class="row count-list">
          <ul>
            <li>
              <a href="" target="_self" rel="nofollow">
                <label><span>500 </span>Localities</label>
              </a>
            </li>
            <li>
              <a href="" target="_self" rel="nofollow">
                <label><span>1000 </span>Restaurants</label>
              </a>
            </li>
            <li>
              <a href="" target="_self" rel="nofollow">
                <label><span>900 </span>Hotels</label>
              </a>
            </li>
            <li>
              <a href="" target="_self" rel="nofollow">
                <label><span>786 </span>Resorts</label>
              </a>
            </li>
            <li>
              <a href="" target="_self" rel="nofollow">
                <label><span>5000 </span>Reviews</label>
              </a>
            </li>
            <li>
              <a href="" target="_self" rel="nofollow">
                <label><span>3000 </span>Suppliers</label>
              </a>
            </li>
            <li>
              <a href="" target="_target" rel="nofollow">
                <label class="count-see-all">SEE ALL</label>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- END EVENTS -->

  <!-- FOOTER -->
  <footer class="footer1">
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="footer-desc text-center">
                        <div class="col-lg-6 col-lg-offset-3">
                          <p>
                              <?php if (!empty($tagline->value)): ?>
                                <?php echo $tagline->value ?>
                                <?php else: ?>
                                  Travel Hub is a lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                              <?php endif; ?> <a href="/about/">Learn More</a>
                          </p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <ul class="social">
                        <li><a href="<?php if (!empty($facebook->value)): ?> <?php echo $facebook->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php if (!empty($twitter->value)): ?> <?php echo $twitter->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?php if (!empty($google->value)): ?> <?php echo $google->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="<?php if (!empty($instagram->value)): ?> <?php echo $instagram->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
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
  <!-- END FOOTER -->

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

$('#Submit').click(function() {
    $('#error_message').show();
    var form_data = {
        email: $('#email').val(),
        password: $('#password').val()
    };
    $.ajax({
        url: "/Home/login",
        type: 'POST',
        data: form_data,
        success: function(msg) {
            if (msg =='Invalid') {
              $('#error_message').html('<div class="alert alert-danger">Email is not registered, please register first</div>');
            }else if (msg =="Unconfirmed") {
              $('#login').hide();
              $(location).attr('href','/Verify/unconfirmed');
            }else if (msg =='Incorrect') {
              $('#error_message').html('<div class="alert alert-danger">Incorrect password</div>');
            }else if (msg =='Set up') {
              $('#login').hide();
              $(location).attr('href','/Home/set_up');
            }else if (msg == 'Dashboard') {
              $('#login').hide();
              $(location).attr('href','/Account');
            }else {
              $('#error_message').html('<div class="alert alert-danger">'+ msg +'</div>');
            }
        }
    });
    return false;
});
$('#login').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    $('#error_message').hide();
})
$('#Register').click(function() {
    $('#register_error_message').show();
    var register_data = {
        register_email: $('#register_email').val(),
        username: $('#username').val(),
        register_password: $('#register_password').val(),
        register_confirm_password: $('#register_confirm_password').val()
    };
    $.ajax({
        url: "/Home/register",
        type: 'POST',
        data: register_data,
        success: function(message) {
          if (message=='Successful') {
            $('#register').hide();
            $(location).attr('href','/Verify');
          }else if (message=='Unsucessful') {
            $('#register').hide();
            $(location).attr('href','/Verify/not_sent');
          }
          else {
            $('#register_error_message').html('<div class="alert alert-danger">'+ message +'</div>');
          }
        }
    });
    return false;
});
$('#register').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    $('#register_error_message').hide();
})
</script>
</body>
</html>
