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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato|Rubik+Mono+One" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/traveller/style.css">
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
          <li><a href="<?php echo base_url() ?>">Go back to Travel Hub</a></li>
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
              <li><a href="<?php echo base_url() ?>Home/profile">Account Settings</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo base_url() ?>Home/details">Account Details</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo base_url() ?>Home/logout">Logout</a></li>
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
        <li><a href="<?php echo base_url() ?>Home">Home</a></li>
        <li class="active">Security</li>
      </ul>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-3 side">
        <?php if (!empty($traveller_profile->image)): ?>
          <img src="<?php echo $traveller_profile->image?>" class="center-block" alt="User Image">
        <?php else: ?>
          <img src="<?php echo base_url() ?>public/img/default-img.jpg" class="center-block" alt="User Image" width="200px" height="200px">
        <?php endif; ?>
        <div class="vertical-menu">
          <a href="<?php echo base_url() ?>Home/image">Profile Image</a>
          <a href="<?php echo base_url() ?>Home/profile">Edit Profile</a>
          <a href="<?php echo base_url() ?>Home/security" class="active">Security</a>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="col-lg-6 box-style">
          <div class="row text-title header-row">
            <h3 class="title">Change email</h3>
            <hr>
          </div>
          <form class="" action="<?php echo base_url() ?>Home/update_email" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Email:</label>
              <input type="text" name="email" class="form-control" value="<?php if (!empty($traveller_details->email)): ?><?php echo $traveller_details->email?><?php endif; ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('email'); ?></span>
            </div>
            <div class="form-group">
              <button type="submit" name="save" class="btn btn-success form-control"><i class="fa fa-floppy-o"></i> Update</button>
            </div>
          </form>
        </div>
        <div class="col-lg-6 box-style">
          <div class="row text-title header-row">
            <h3 class="title">Change password</h3>
            <hr>
          </div>
          <form class="" action="<?php echo base_url() ?>Home/update_password" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Enter old password:</label>
              <input type="password" name="old_password" class="form-control" value="<?php echo set_value('old_password'); ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('old_password'); ?></span>
               <span style="color:red" class="help-block"><?= $this->session->flashdata('message') ?></span>
            </div>
            <div class="form-group">
              <label>Enter new password:</label>
              <input type="password" name="new_password" class="form-control" value="<?php echo set_value('new_password'); ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('new_password'); ?></span>
            </div>
            <div class="form-group">
              <label>Confirm new password:</label>
              <input type="password" name="confirm" class="form-control" value="<?php echo set_value('confirm'); ?>" maxlength="25">
              <span style="color:red" class="help-block"><?php echo form_error('confirm'); ?></span>
            </div>
            <div class="form-group">
              <button type="submit" name="save" class="btn btn-success form-control"><i class="fa fa-floppy-o"></i> Update</button>
            </div>
          </form>
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
                              <?php endif; ?> <a href="<?php echo base_url() ?>About/" target="_blank">Learn More</a>
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
<?php endif; ?>
</script>
</body>
</html>
