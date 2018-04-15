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
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,700|Roboto:300,400,500" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/notifications/style.css">
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
                  <?php if (!empty($notifications)): ?>
                    <?php foreach ($notifications as $key => $notification): ?>
                      <?php if ($notification->type_of_notification == 'Review'): ?>
                        <li>
                          <a href="<?php echo $notification->href ?>">
                            <i class="ion-compose"></i> <?php echo $notification->title_content ?>
                          </a>
                        </li>
                      <?php elseif ($notification->type_of_notification == 'Vote'):?>
                        <li>
                          <a href="<?php echo $notification->href ?>">
                            <i class="ion-heart"></i> <?php echo $notification->title_content ?>
                          </a>
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <li>You have no notifications</li>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url();?>Account/notifications">View all</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $account->username?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url() ?>Account/security">Security</a></li>
              <li><a href="<?php echo base_url() ?>Account/details">Account Details</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo base_url() ?>Account/logout">Logout</a></li>
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
        <li><a href="<?php echo base_url() ?>Account">Back to dashboard</a></li>
        <li class="active">All notifications</li>
      </ul>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-12 box-style">
        <div class="row text-title header-row">
          <h3 class="title">Notifications</h3>
        </div>
        <div class="content visible-lg">
          <table class="table table-bordered table-striped dataTable" role="grid">
            <tbody>
                <?php foreach ($_notifications as $key => $_notification): ?>
                  <tr role="row" class="odd">
                    <td style="width:350px;"><a href="<?php echo $_notification->href?>"><?php echo $_notification->title_content ?></a></td>
                    <td style="width:500px;">
                      <?php if ($_notification->type_of_notification == 'Comment' || $_notification->type_of_notification == 'Reply'): ?>
                        <p><?php echo $_notification->body_content ?></p>
                      <?php endif; ?>
                    </td>
                    <td style="width:200px;"><?php echo date('F j, Y',strtotime($_notification->created_time))?></td>
                  </tr>
                <?php endforeach ?>
            </tbody>
          </table>
          <nav class="pull-right">
            <?php echo $this->pagination->create_links();?>
          </nav>
        </div>
        <div class="content hidden-lg" style="padding-bottom:100px;">
          <table class="table table-bordered table-striped dataTable" role="grid">
            <tbody>
                <?php foreach ($_notifications as $key => $_notification): ?>
                  <tr role="row" class="odd">
                    <td style="width:350px;"><a href="<?php echo $_notification->href?>"><?php echo $_notification->title_content ?></a></td>
                    <td style="width:500px;">
                      <?php if ($_notification->type_of_notification == 'Comment' || $_notification->type_of_notification == 'Reply'): ?>
                        <p><?php echo $_notification->body_content ?></p>
                      <?php endif; ?>
                    </td>
                    <td style="width:200px;"><?php echo date('F j, Y',strtotime($_notification->created_time))?></td>
                  </tr>
                <?php endforeach ?>
            </tbody>
          </table>
          <nav class="pull-right">
            <?php echo $this->pagination->create_links();?>
          </nav>
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
                              <?php endif; ?> <a href="<?php echo base_url() ?>About" target="_blank">Learn More</a>
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

<?php endif; ?>
</script>
</body>
</html>
