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
  <link href="https://fonts.googleapis.com/css?family=Oswald:400,500" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/destination/all/style.css">
</head>
<body>
  <?php if ($this->session->userdata('traveller_is_logged_in')): ?>
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
            <li><a href="#">Categories</a></li>
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
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $traveller_details->username?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/Home/profile">Account Settings</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/Home/logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <!-- END NAVBAR -->
  <?php else: ?>
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

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="login">
      <div class="modal-dialog warning">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Login</h3>
          </div>
          <div class="modal-body login-body">
            <form class="" action="/Login/login" method="post" enctype="multipart/form-data">
              <div id="error_message"></div>
              <div class="col-lg-12" style="margin-bottom:15px;">
                <a href="#" data-toggle="modal" data-target="#supplier">
                  <div class="col-lg-6 col-md-6">
                    <div class="btn btn-default btn-block fb-btn">
                     <i class="fa fa-facebook-square"></i> Facebook
                    </div>
                  </div>
                </a>
                <a href="#" data-toggle="modal" data-target="#traveller">
                  <div class="col-lg-6 col-md-6">
                    <div class="btn btn-default btn-block google-btn">
                     <i class="fa fa-google-plus"></i> Google
                    </div>
                  </div>
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
    <div class="modal" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Register</h4>
            <p class="text-center">Please select a category</p>
          </div>
          <!-- START OF MODAL BODY-->
          <div class="modal-body">
            <a href="#" data-toggle="modal" data-target="#supplier">
              <div class="col-lg-6 col-md-6">
                <div class="btn btn-default btn-block">
                 <i class=""></i>Supplier
                </div>
              </div>
            </a>
            <a href="#" data-toggle="modal" data-target="#traveller">
              <div class="col-lg-6 col-md-6">
                <div class="btn btn-default btn-block">
                 <i class=""></i>Traveller
                </div>
              </div>
            </a>
            <!-- <a href="#" data-toggle="modal" data-target="#upload-avatar" class="button"><i class="fa fa-plus"></i> Upload new avatar</a> -->
          </div>
          <!-- END OF APPLICATION FORM MODAL BODY -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->

      <!--SUPPLIER REGISTER FORM-->
      <div class="modal" id="supplier" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Supplier Register</h4>
            </div>
            <div class="modal-body supplier-body">
              <form class="" action="" method="post" enctype="multipart/form-data">
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
              <input class="btn btn-warning login-btn" type="submit" name="Supplier" value="Register" id="Register">
              <button class="btn btn-default close-btn" type="button" name="button" data-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>
      <!-- END OF SUPPLIER REGISTER FORM -->

      <!-- TRAVELLER REGISTER FORM -->
      <div class="modal" id="traveller" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Traveller Register</h4>
            </div>
            <div class="modal-body">
              <form class="" action="" method="post" enctype="multipart/form-data">
                <div id="traveller_register_error_message"></div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="register_email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" id="traveller_register_email" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1" id="traveller_username" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon2"><i class="fa fa-lock"></i></span>
                    <input type="password" name="register_password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" id="traveller_register_password" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon2"><i class="fa fa-lock"></i></span>
                    <input type="password" name="register_confirm_password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon1" id="traveller_register_confirm_password" required>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <input class="btn btn-warning login-btn" type="submit" name="Traveller" value="Register" id="Register_Traveller">
              <button class="btn btn-default close-btn" type="button" name="button" data-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>
    </div>
    <!-- END TRAVELLER REGISTER FORM -->
    <!-- END REGISTER MODAL -->
    <!-- END OF NAV -->
  <?php endif; ?>

  <!-- CONTENT -->
  <div class="container">
    <div class="row content-header">
      <ul class="breadcrumb">
        <li><a href="<?php echo base_url()?>">Home</a></li>
        <li>Destinations</li>
        <li class="active">All</li>
      </ul>
      <span class="content-title"></span>
    </div>
    <div class="row content">
      <div class="col-xs-12 main-content">
        <!-- <div class="col-lg-12" style="background-color:pink;padding:15px 15px 15px 15px;">
          <div class="col-lg-2" style="background-color:tomato;padding:0;border-radius:5px;">
            <img src="/uploads/images/user.jpg" width="200px" height="200px" alt="">
          </div>
        </div>
        <div class="col-lg-12" style="background-color:gray;padding:50px;">

        </div> -->
          <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
            <div class="pull-left visible-lg visible-md visible-sm media-left"></div>
				<div class="row">
						  <div class="column">
							<label>A</label>
              <?php if (!empty($localities0)): ?>
                <?php foreach ($localities0 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>B</label>
              <?php if (!empty($localities1)): ?>
                <?php foreach ($localities1 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>C</label>
              <?php if (!empty($localities2)): ?>
                <?php foreach ($localities2 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>D</label>
              <?php if (!empty($localities3)): ?>
                <?php foreach ($localities3 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							</div>
						 <div class="column">
						 <label>E</label>
             <?php if (!empty($localities4)): ?>
               <?php foreach ($localities4 as $key => $locality): ?>
                 <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
               <?php endforeach; ?>
             <?php else: ?>
               <br>
             <?php endif; ?>
							<label>F</label>
              <?php if (!empty($localities5)): ?>
                <?php foreach ($localities5 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>G</label>
              <?php if (!empty($localities6)): ?>
                <?php foreach ($localities6 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>H</label>
              <?php if (!empty($localities7)): ?>
                <?php foreach ($localities7 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>I</label>
              <?php if (!empty($localities8)): ?>
                <?php foreach ($localities8 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							</div>
							<div class="column">
							<label>J</label>
              <?php if (!empty($localities9)): ?>
                <?php foreach ($localities9 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>K</label>
              <?php if (!empty($localities10)): ?>
                <?php foreach ($localities10 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>L</label>
              <?php if (!empty($localities11)): ?>
                <?php foreach ($localities11 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>M</label>
              <?php if (!empty($localities12)): ?>
                <?php foreach ($localities12 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>N</label>
              <?php if (!empty($localities13)): ?>
                <?php foreach ($localities13 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>O</label>
              <?php if (!empty($localities14)): ?>
                <?php foreach ($localities14 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
							<label>P</label>
              <?php if (!empty($localities15)): ?>
                <?php foreach ($localities15 as $key => $locality): ?>
                  <li><a href="/Destination/result/<?php echo str_replace(' ', '_', $locality->locality)?>"><?php echo $locality->locality ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <br>
              <?php endif; ?>
						  </div>
						</div>
				</div>
            </div>
          </div>
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
            <div class="text-center "> Copyright © 2017-2018. All right reserved.</div>
        </div>
    </div> <!--/.footer-bottom-->
  </footer>
  <!-- END FOOTER -->

<!-- jQuery 2.2.3 -->
<script src="jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
</script>
</body>
</html>
