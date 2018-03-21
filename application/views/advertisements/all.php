<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($title->value)) { echo $title->value; } else { echo "Title";}?></title>
  <link rel="icon" href="<?php if (!empty($icon->value)) { echo $icon->value; } else { echo "Icon";}?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,500,700|Roboto:300,400,500" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/advertisements/all/style.css">
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
            <li><a href="/Category/all">Categories</a></li>
            <li><a href="/Destination/all">Destinations</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="ion-android-more-horizontal"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/Advertisement/all">Deals</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/Forum/all">Forum</a></li>
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
          <li class=""><a href="/Category/all">Categories</a></li>
          <li><a href="/Destination/all">Destinations</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="ion-android-more-horizontal"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/Advertisement/all">Deals</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="/Forum/all">Forum</a></li>
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
              <div class="agreement-box">
                <p>By clicking register you agree to our <span><a href="#">Terms Of Use</a></span> and <span><a href="#">Privacy Policy</a></span></p>
              </div>
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
              <div class="agreement-box">
                <p>By clicking register you agree to our <span><a href="#">Terms Of Use</a></span> and <span><a href="#">Privacy Policy</a></span></p>
              </div>
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
      <ul class="breadcrumb navbar-bottom">
  	     <li><a href="<?php echo base_url()?>">Home</a></li>
         <li>Hot Deals</li>
         <li>All</li>
  		</ul>
    </div>
    <div class="row content">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-content">
        <div class="media" style="background-color:#fff;padding:15px 15px 15px 15px;">
            <?php if (!empty($advertisements)): ?>
              <?php foreach ($advertisements as $key => $ad): ?>
                <div class="col-lg-3 col-md-3 col-sm-4">
                  <div class="date">
                    <span>
                      <?php $start = strtotime($ad->start_date); echo date('F j Y',$start)?>
                    </span>
                  </div>
                  <div class="thumbnail">
                    <a href="/Advertisement/result/<?php echo $ad->advertisement_id?>"><img src="<?php echo $ad->image?>" alt="image"></a>
                    <br>
                    <div class="text-center ad-title">
                      <div class="list-text">
                        <p><?php echo $ad->title?></p>
                      </div>
                    </div>
                  </div>
          			</div>
              <?php endforeach; ?>
            <?php else: ?>
              0 results
            <?php endif; ?>
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
                      <div class="col-lg-6 col-lg-offset-3">
                        <p>
                            <?php if (!empty($tagline->value)): ?>
                              <?php echo $tagline->value ?>
                              <?php else: ?>
                                Travel Hub is a lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            <?php endif; ?> <a href="/About">Learn More</a>
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
              }else if (msg == 'Login') {
                $('#login').hide();
                window.location.reload();
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
          register_confirm_password: $('#register_confirm_password').val(),
          type: $('#Register').attr('name')
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
  $('#Register_Traveller').click(function() {
      $('#register_error_message').show();
      var register_data = {
          register_email: $('#traveller_register_email').val(),
          username: $('#traveller_username').val(),
          register_password: $('#traveller_register_password').val(),
          register_confirm_password: $('#traveller_register_confirm_password').val(),
          type: $('#Register_Traveller').attr('name')
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
              $('#traveller_register_error_message').html('<div class="alert alert-danger">'+ message +'</div>');
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
