
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
  <link href="https://fonts.googleapis.com/css?family=Lato|Rubik+Mono+One" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
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
        <li><a href="" data-toggle="modal" data-target="#login"> Login</a></li>
        <li><a href="" class="register" data-toggle="modal" data-target="#register">Register</a></li>
      </ul>
    </div>
  </div>
  </nav>
  <div id="slider" class="carousel slide" data-ride="carousel">
    <form class="form-inline kc_fab_main_btn" action="" method="post">
      <div class="container text-center">
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-location-arrow"></i></div>
          <input type="text" class="form-control" placeholder="Location">
        </div>
        <div class="input-group">
          <input type="text" class="form-control" name="search" placeholder="Tell us what you're looking for...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
          </span>
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

  <div class="modal fade" id="register">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 style="color:#FFFFFF" class="login-logo text-center">Travel Hub | Register</h3>
        </div>
        <div class="modal-body">
          <form class="" action="/Register" method="post" enctype="multipart/form-data">
            <div id="register_error_message"></div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input type="email" name="register_email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" id="register_email" required>
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

  <section class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="lato"><strong>HOT DEALS</strong></h1>
        <small>Discover great finds and deals for a discounted price</small>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img src="/public/img/promo1.jpg" alt="" style="width:100%;height:150px;">
      </div>
    </div>
  </section>
  <section class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="lato"><strong>HOT DEALS</strong></h1>
        <small>Discover great finds and deals for a discounted price</small>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img src="/public/img/promo1.jpg" alt="" style="width:100%;height:150px;">
      </div>
    </div>
  </section>
  <section class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="lato"><strong>HOT DEALS</strong></h1>
        <small>Discover great finds and deals for a discounted price</small>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img src="/public/img/promo1.jpg" alt="" style="width:100%;height:150px;">
      </div>
    </div>
  </section>
  <section class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="lato"><strong>HOT DEALS</strong></h1>
        <small>Discover great finds and deals for a discounted price</small>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img src="/public/img/promo1.jpg" alt="" style="width:100%;height:150px;">
      </div>
    </div>
  </section>

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
// $(".login").click(function() {
//   var id = $(this).attr("id");
//   var email = $('#email').val();
//   var password = $('#password').val();
//   $.ajax({
//     url:"/Login/login",
//     method:"post",
//     data:{
//       'email':email,
//       'password':password
//     },
//     success:function(data){
//       var obj = $.parseJSON(data);
//       if (obj!=null) {
//         $('#email_error').html(obj['error_message']);
//       }
//     }
//   });
// });
$('#Submit').click(function() {
    $('#error_message').show();
    var form_data = {
        email: $('#email').val(),
        password: $('#password').val()
    };
    $.ajax({
        url: "/Login/login",
        type: 'POST',
        data: form_data,
        success: function(msg) {
            if (msg=='Invalid') {
              $('#error_message').html('<div class="alert alert-danger">Email is not registered, please register first</div>');
            }else if (msg=="Unconfirmed") {
              $('#login').hide();
              $(location).attr('href','/Verify/unconfirmed');
            }else if (msg=='Incorrect') {
              $('#error_message').html('<div class="alert alert-danger">Incorrect password</div>');
            }else if (msg=='Correct') {
              $('#login').hide();
              $(location).attr('href','/Dashboard');
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
        register_password: $('#register_password').val(),
        register_confirm_password: $('#register_confirm_password').val()
    };
    $.ajax({
        url: "/Register",
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
