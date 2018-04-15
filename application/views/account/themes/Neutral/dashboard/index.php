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
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/themes/Neutral/style.css">
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

  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="row">
          <div class="col-lg-12">
            <ul class="breadcrumb">
              <li class="active">Welcome to Travel Hub > Neutral</li>
            </ul>
          </div>
          <div class="col-lg-12 switch" style="padding:0;">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <?php if (count($businesses) == 1): ?>
                  <a href="#" aria-haspopup="true" aria-expanded="false">
                  <?php if (!empty($business_name)): ?>
                  <?php echo $business_name?>
                  <?php else: ?>
                    Business
                  <?php endif; ?> </a>
                <?php else: ?>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <?php if (!empty($business_name)): ?>
                  <?php echo $business_name?>
                  <?php else: ?>
                    Business
                  <?php endif; ?> <span class="caret"></span></a>
                <?php endif; ?>
                  <?php if (!empty($businesses)): ?>
                    <ul class="dropdown-menu">
                      <?php foreach ($businesses as $key => $business): ?>
                        <?php if ($business->business_name == $business_name): ?>
                        <?php else: ?>
                          <li><a href="<?php echo base_url(); ?>Account/switch_business?business=<?php echo $business->business_name ?>"><?php echo $business->business_name ?></a></li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </ul>
                  <?php else: ?>
                  <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="container">
    <div class="row">
      <div class="col-lg-3" style="background-color:#fff;border-right:10px solid #ebe9e9;padding-top: 20px;">
      <?php if (!empty($details->image)): ?>
        <img src="<?php echo $details->image?>" class="center-block" alt="User Image" width="200px" height="200px">
      <?php else: ?>
        <img src="<?php echo base_url(); ?>public/img/default-img.jpg" class="center-block" alt="User Image" width="200px" height="200px">
      <?php endif; ?>
        <div class="add-box pull-right">
          <a href="<?php echo base_url(); ?>Account/new_business"><span><i class="ion-ios-plus"></i> </span>New business</a>
        </div>
        <div class="vertical-menu">
          <a href="<?php echo base_url(); ?>Account" class="active">Dashboard</a>
          <a href="<?php echo base_url(); ?>Account/profile">Profile</a>
          <a href="<?php echo base_url(); ?>Account/site_identity">Site Identity</a>
          <a href="<?php echo base_url(); ?>Neutral/home">Home Page Settings</a>
          <a href="<?php echo base_url(); ?>Neutral/about">About Page Settings</a>
          <a href="<?php echo base_url(); ?>Neutral/gallery">Gallery Page Settings</a>
          <a href="<?php echo base_url(); ?>Neutral/contacts">Contacts Page Settings</a>
          <a href="<?php echo base_url(); ?>Neutral/theme">Theme</a>
        </div>
      </div>
      <div class="col-lg-9" style="background-color:#fff;padding-top:20px;">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-heart"></i></span>
              <div class="info-box-content">
                <?php if (!empty($vote_count->vote)): ?>
                  <?php if ($vote_count->vote > 1): ?>
                    <span class="info-box-text">Faves</span>
                    <span class="info-box-number"><?php echo $vote_count->vote ?></span>
                  <?php else: ?>
                    <span class="info-box-text">Fave</span>
                    <span class="info-box-number"><?php echo $vote_count->vote ?></span>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="info-box-text">Fave</span>
                  <span class="info-box-number"><?php echo $vote_count->vote ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-comment"></i></span>
              <div class="info-box-content">
                <?php if (!empty($review_count->review)): ?>
                  <?php if ($review_count->review > 1): ?>
                    <a href="<?php echo base_url(); ?>Account/view_all_reviews">
                      <span class="info-box-text">Reviews</span>
                      <span class="info-box-number"><?php echo $review_count->review ?></span>
                    </a>
                  <?php else: ?>
                    <a href="<?php echo base_url(); ?>Account/view_all_reviews">
                      <span class="info-box-text">Review</span>
                      <span class="info-box-number"><?php echo $review_count->review ?></span>
                    </a>
                  <?php endif; ?>
                <?php else: ?>
                  <a href="<?php echo base_url(); ?>Account/view_all_reviews">
                    <span class="info-box-text">Review</span>
                    <span class="info-box-number"><?php echo $review_count->review ?></span>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa  fa-bar-chart"></i></span>
              <div class="info-box-content">
                <?php if (!empty($rating->rate)): ?>
                  <?php if ($rating->rate > 1): ?>
                    <span class="info-box-text">Rating</span>
                    <span class="info-box-number"><?php echo number_format($rating->rate, 1)?></span>
                  <?php else: ?>
                    <span class="info-box-text">Rating</span>
                    <span class="info-box-number"><?php echo number_format($rating->rate, 1)?></span>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="info-box-text">Rating</span>
                  <span class="info-box-number"><?php echo number_format($rating->rate, 1)?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
      </div>
        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="box box-widget">
              <div class="box-header with-border">
                <h3 class="box-title">Reviews</h3>
                <span class="pull-right"><a href="<?php echo base_url(); ?>Account/mark_reviews_read">Mark all as read</a></span>
              </div>
              <!-- /.box-header -->
              <div class="box-footer box-comments">
                <?php if (!empty($reviews)): ?>
                  <?php foreach ($reviews as $key => $review): ?>
                    <div class="box-comment">
                      <!-- User image -->
                      <?php if (!empty($review->image)): ?>
                        <img class="img-circle img-sm" src="<?php echo $review->image ?>" alt="User Image">
                      <?php else: ?>
                        <img class="img-circle img-sm" src="<?php echo base_url(); ?>public/img/default-img.jpg" alt="User Image">
                      <?php endif; ?>
                      <div class="comment-text">
                            <span class="username">
                              <?php echo $review->firstname ?> <?php echo $review->lastname ?>
                              <span class="text-muted pull-right"><?php echo date('F j Y',strtotime($review->date_created))?></span>
                            </span><!-- /.username -->
                        <?php echo $review->review ?>
                      </div>
                      <!-- /.comment-text -->
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  You have no reviews yet
                <?php endif; ?>
              </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
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
</script>
</body>
</html>
