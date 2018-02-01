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
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato|Rubik+Mono+One" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/search-page/style.css">
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
        <a class="navbar-brand" href="#">
          <img alt="Brand" src="...">
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Separated link</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
          </li> -->
        </ul>
        <form class="navbar-form navbar-left">
          <div class="input-group">
            <div class="input-group-addon"><i class="ion-location input-style"></i></div>
            <input type="text" class="form-control" placeholder="Location">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search for..">
          </div>
          <button type="submit" class="btn btn-default search-btn">Search</button>
        </form>
        <ul class="nav navbar-nav navbar-right btn-padding">
          <li><a href="#" class="btn btn-primary login-btn">Login</a></li>
          <li><a href="#" class="btn btn-primary">Register</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- END OF NAV -->

  <!-- CONTENT -->
  <div class="container">
    <div class="row content-header">
      <ul class="breadcrumb">
        <li><a href="<?php echo base_url()?>">Home</a></li>
        <li><a href="/Category">Categories</a></li>
        <li class="active"><?php echo $category?></li>
      </ul>
      <span class="content-title"><?php echo $category?></span>
    </div>
    <div class="row content">
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 side-content">
        <label>Filters</label>
        <div class="separator"></div>
        <label>Sort By</label>
        <ul class="sort-list">
          <li><a href="#">Popularity - <span>high to low</span></a></li>
          <li><a href="#">Rating - <span>high to low</span></a></li>
          <li><a href="#">Recently Added</a></li>
        </ul>
      </div>
      <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 main-content">
        <!-- <div class="col-lg-12" style="background-color:pink;padding:15px 15px 15px 15px;">
          <div class="col-lg-2" style="background-color:tomato;padding:0;border-radius:5px;">
            <img src="/uploads/images/user.jpg" width="200px" height="200px" alt="">
          </div>
        </div>
        <div class="col-lg-12" style="background-color:gray;padding:50px;">

        </div> -->
        <?php foreach ($results as $key => $result): ?>
          <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
            <div class="pull-left visible-lg visible-md visible-sm media-left"><img class="media-object" src="/uploads/images/<?php echo $result->image?>" alt="/uploads/images/user.jpg" width="200px" height="200px"></div>
            <div class="media-body rating">
              <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="/uploads/images/user.jpg" alt="/uploads/images/user.jpg"><br class="hidden-lg hidden-md hidden-sm">
              <span class="pull-right votes-style" style="">231 Votes</span>
              <span class="badge pull-right rating-style" style="">4.5</span>
              <h3 class="media-heading business-title"><?php echo $result->business_name?></h3>
              <div class="separator"></div>
              <ul>
                <li class="detail-list"><i class="ion-location icons"></i>&nbsp; <?php echo $result->address?></li>
                <li class="detail-list"><i class="ion-iphone icons">&nbsp;</i>   <?php echo $result->cellphone?></li>
                <li class="detail-list"><i class="ion-ios-telephone icons"></i> <?php echo $result->telephone?></li>
              </ul>
              <div class="row">
                <div class="col-xs-6">
                  <a href="#" class="btn btn-lg btn-primary btn-style">
                    <div class="space"></div>
    			        <span class="" style="color: #f37430;">Visit Website</span>
    		          </a>
                  <!-- <button type="button" name="button" class="form-control">Visit Website</button> -->
                </div>
                <div class="col-xs-6">
                  <a href="#" class="btn btn-lg btn-primary btn-style">
                  <div class="space"></div>
    			        <span class="" style="color: #f37430;">View</span>
    		          </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <!-- END OF CONTENT -->

  <!-- FOOTER -->
  <footer class="footer1">
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="footer-desc text-center">
                        <img src="logo" width="82" height="48" alt="">
                        <p>
                            <a href="/" rel="home" title="Travel Hub">Travel Hub</a> is a lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <a href="/about/">Learn More</a>
                        </p>
                    </div>
                </div>
                <div class="col-xs-12">
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
</script>
</body>
</html>
