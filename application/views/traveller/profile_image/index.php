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
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?php echo base_url(); ?>public/js/crop/jquery.guillotine.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,700|Roboto:300,400,500" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/traveller/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/crop/jquery.guillotine.css">
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
          <li>
            <a href="#"><span class="ion-ios-search-strong"></span></a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown notifications-menu" id="notif-div">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i><?php if (!empty($notif_count)): ?><span class="label label-warning" id="notif-count"><?php echo $notif_count->notif_count?></span>
              <?php endif; ?>
            </a>
            <ul class="dropdown-menu">
              <!-- <li class="header">You have 10 notifications</li> -->
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php foreach ($notifications as $key => $notification): ?>
                    <?php if ($notification->type_of_notification == 'Comment'): ?>
                      <li>
                        <a href="<?php echo $notification->href ?>">
                          <i class="ion-chatbubble"></i> <?php echo $notification->title_content ?>
                        </a>
                      </li>
                    <?php elseif ($notification->type_of_notification == 'Reply'):?>
                      <li>
                        <a href="<?php echo $notification->href ?>">
                          <i class="ion-chatbubbles"></i> <?php echo $notification->title_content ?>
                        </a>
                      </li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              </li>
              <!-- <li class="footer"><a href="#">View all</a></li> -->
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $traveller_details->username?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/Home/profile">Account Settings</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="/Home/details">Account Details</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="/Home/logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- END NAVBAR -->

  <div class="container" style="margin-top:80px;">
    <div class="row">
      <ul class="breadcrumb">
        <li><a href="/Home">Home</a></li>
        <li class="active">Profile</li>
      </ul>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-3" style="background-color:#fff;border-right:10px solid #ebe9e9;padding-top: 20px;">
        <?php if (!empty($traveller_profile->image)): ?>
          <img src="<?php echo $traveller_profile->image?>" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php else: ?>
          <img src="/public/img/default-img.jpg" class="img-circle center-block" alt="User Image" width="200px" height="200px">
        <?php endif; ?>
        <div class="vertical-menu">
          <a href="/Home/image" class="active">Profile Image</a>
          <a href="/Home/profile">Edit Profile</a>
          <a href="/Home/security">Security</a>
        </div>
      </div>
      <div class="col-lg-9" style="background-color:#fff;margin-bottom:5px;">
        <div class="row text-title header-row">
          <h2 class="title">Profile Image</h2>
          <hr>
        </div>
        <form class="" action="/Home/upload_img" method="post" enctype="multipart/form-data">
          <div class="col-lg-4">
            <div class="form-group">
              <input class="" type="file" name="picture" />
            </div>
            <div class="form-group">
              <button id="upload" type="submit" name="upload" class="btn btn-success form-control"><i class="ion-upload"></i> Upload</button>
            </div>
          </div>
        </form>
        <div class="col-lg-12 text-center" style="width:50%;">
          <?php if (!empty($_SESSION['image_crop'])): ?>
            <p><?php if (!empty($_SESSION['image_crop'])): ?><?php echo $_SESSION['image_crop'] ?><?php else: ?>/public/img/image-icon-300px.jpg<?php endif; ?></p>
              <div class="form-group">
                <img id="thepicture" src="<?php if (!empty($_SESSION['image_crop'])): ?><?php echo $_SESSION['image_crop'] ?><?php else: ?>/public/img/image-icon-300px.jpg<?php endif; ?>" alt="your image" />
              </div>
              <div class="form-group">
                <div id='controls'>
                  <button id='zoom_in' class="btn" type='button' title='Zoom in'> <i class="fa fa-search-plus"></i> </button>
                  <button id='zoom_out'class="btn" type='button' title='Zoom out'> <i class="fa fa-search-minus"></i> </button>
                </div>
              </div>
              <div class="form-group">
                <button id="crop" type="submit" name="save" class="btn btn-success form-control"><i class="fa fa-floppy-o"></i> Save & crop</button>
              </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

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

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>public/thesis/AdminLTE/dist/js/app.min.js"></script>
<script>
<?php if ($this->session->userdata('traveller_is_logged_in')): ?>
// (function() {
//   var notif = function(){
//     var user_id = {
//         user_id: "<?php echo $traveller_details->user_id ?>"
//     };
//     $.ajax({
//       url: "/Home/get_notif",
//       type: "POST",
//       data: user_id,
//       success: function (data){
//         // alert('Kumuha na ng notif');
//           $('#notif-div').html(data);
//       }
//     });
//   };
//   setInterval(function(){
//     notif();
//   }, 60000);
// })();
// $('#notif-div').on('click', '#notif-count', function() {
//     // alert('clicked');
//     var user_id = {
//              user_id: "<?php echo $traveller_details->user_id ?>"
//          };
//       $.ajax({
//           url: "/Home/is_unread",
//           type: 'POST',
//           data: user_id,
//           success: function(msg) {
//             // alert("Na read na");
//             $('#notif-count').html(msg);
//           }
//       });
// });
// $(":file").change(function () {
//         if (this.files && this.files[0]) {
//             var reader = new FileReader();
//             reader.onload = imageIsLoaded;
//             reader.readAsDataURL(this.files[0]);
//         }
//     });
//     function imageIsLoaded(e) {
//         $('#thepicture').attr('src', e.target.result);
//     };
// var defaultPicture = 'http://matiasgagliano.github.io/guillotine/img/unsplash.com_25.jpg';
jQuery(function() {
  var picture = $('#thepicture');
  picture.on('load', function() {
    var picture = $('#thepicture');
    picture.guillotine({width: 300, height: 300});
    $('#zoom_in').click(function(){
      picture.guillotine('zoomIn');
    });
    $('#zoom_out').click(function(){
      picture.guillotine('zoomOut');
    });
  })

  $('#crop').click(function() {
    var data = picture.guillotine('getData');
    $.ajax({
        url: "/Home/crop",
        type: 'POST',
        data: data,
        success: function(msg) {

          if (msg == 'Success') {
            alert('Success');
            $(location).attr('href','/Home/image');
            // $('#thepicture').attr('src', e.target.result);
          }else {
            alert(msg);
          }
        }
    });
  });
})
<?php endif; ?>
</script>
</body>
</html>
