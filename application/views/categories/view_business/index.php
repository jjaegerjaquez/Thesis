<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($title->value)) { echo $title->value; } else { echo "Title";}?></title>
  <link rel="icon" href="<?php if (!empty($icon->value)) { echo $icon->value; } else { echo "Icon";}?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,700|Roboto:300,400,500" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/categories/view_page/style.css">
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
            <li><a href="<?php echo base_url(); ?>Category/all">Categories</a></li>
            <li><a href="<?php echo base_url(); ?>Destination/all">Destinations</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="ion-android-more-horizontal"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>Advertisement/all">Deals</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo base_url(); ?>Forum/all">Forum</a></li>
              </ul>
            </li>
            <li>
              <button type="button" class="buttonsearch" id="buttonsearch">
                 <i class="ion-ios-search-strong openclosesearch"></i><i class="ion-close openclosesearch" style="display:none"></i>
              </button>
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
                    <?php if (!empty($notifications)): ?>
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
                        <?php else: ?>
                          <li>
                            <a href="<?php echo $notification->href ?>">
                              <i class="ion-thumbsup"></i> <?php echo $notification->title_content ?>
                            </a>
                          </li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li>You have no notifications</li>
                    <?php endif; ?>
                  </ul>
                </li>
                <li class="footer"><a href="<?php echo base_url();?>Home/notifications">View all</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <?php if (!empty($traveller_details->username)): ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $traveller_details->username?> <span class="caret"></span></a>
              <?php else: ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $traveller_profile->firstname?> <span class="caret"></span></a>
              <?php endif; ?>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>Home/profile">Account Settings</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo base_url(); ?>Home/details">Account Details</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo base_url(); ?>Home/logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
      <div class="container searchbardiv" id="formsearch">
        <form action="<?php echo base_url(); ?>Search/result" role="search" method="post" id="searchform">
          <div class="row">
            <div class="col-lg-5 col-xs-6 no-padding">
              <div class="input-group">
                <div class="input-group-addon"><i class="ion-location input-style"></i></div>
                <input type="text" class="form-control input-style" autocomplete="off" placeholder="Location" id="locality_search" name="locality-search">
                <ul class="dropdown-menu _txtlocality" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu" id="_DropdownLocality"></ul>
              </div>
            </div>
            <div class="col-lg-7 col-xs-6">
              <div class="input-group">
                <input type="text" id="look-for" autocomplete="off" class="form-control" name="category" placeholder="Search for...">
                <ul class="dropdown-menu _txtlookfor" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu"  id="_DropdownLookFor"></ul>
                <div class="input-group-btn">
                  <button class="btn btn-default"  id="searchsubmit"  type="submit">
                    <strong>Search</strong>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
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
          <li class=""><a href="<?php echo base_url(); ?>Category/all">Categories</a></li>
          <li><a href="<?php echo base_url(); ?>Destination/all">Destinations</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="ion-android-more-horizontal"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url(); ?>Advertisement/all">Deals</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo base_url(); ?>Forum/all">Forum</a></li>
            </ul>
          </li>
          <li>
            <button type="button" class="buttonsearch" id="buttonsearch">
               <i class="ion-ios-search-strong openclosesearch"></i><i class="ion-close openclosesearch" style="display:none"></i>
            </button>
          </li>
          <!-- <li><a href="#"><span class="ion-ios-search-strong"></span></a></li> -->
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="" data-toggle="modal" data-target="#login" id="login-btn"> Login</a></li>
          <li><a href="" class="register" data-toggle="modal" data-target="#supplier">Register</a></li>
        </ul>
      </div>
    </div>
    <div class="container searchbardiv" id="formsearch">
      <form action="<?php echo base_url(); ?>Search/result" role="search" method="post" id="searchform">
        <div class="row">
          <div class="col-lg-5 col-xs-6 no-padding">
            <div class="input-group">
              <div class="input-group-addon"><i class="ion-location input-style"></i></div>
              <input type="text" class="form-control input-style" autocomplete="off" placeholder="Location" id="locality_search" name="locality-search">
              <ul class="dropdown-menu _txtlocality" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu" id="_DropdownLocality"></ul>
            </div>
          </div>
          <div class="col-lg-7 col-xs-6">
            <div class="input-group">
              <input type="text" id="look-for" autocomplete="off" class="form-control" name="category" placeholder="Search for...">
              <ul class="dropdown-menu _txtlookfor" style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu"  id="_DropdownLookFor"></ul>
              <div class="input-group-btn">
                <button class="btn btn-default"  id="searchsubmit"  type="submit">
                  <strong>Search</strong>
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
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
                <a href="<?php echo $fb_login_url; ?>">
                  <div class="col-lg-6 col-md-6">
                    <div class="btn btn-default btn-block fb-btn">
                     <i class="fa fa-facebook-square"></i> Facebook
                    </div>
                  </div>
                </a>
                <a href="<?php echo $google_login_url; ?>">
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

      <!--SUPPLIER REGISTER FORM-->
      <div class="modal" id="supplier" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Register</h4>
            </div>
            <div class="modal-body supplier-body">
              <div class="col-lg-12" style="margin-bottom:15px;">
                <a href="<?php echo $fb_login_url; ?>">
                  <div class="col-lg-6 col-md-6">
                    <div class="btn btn-default btn-block fb-btn">
                     <i class="fa fa-facebook-square"></i> Facebook
                    </div>
                  </div>
                </a>
                <a href="<?php echo $google_login_url; ?>">
                  <div class="col-lg-6 col-md-6">
                    <div class="btn btn-default btn-block google-btn">
                     <i class="fa fa-google-plus"></i> Google
                    </div>
                  </div>
                </a>
              </div>
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
                <p>By clicking register you agree to our <span><a href="<?php echo base_url(); ?>About/terms" target="_blank">Terms Of Use</a></span> and <span><a href="<?php echo base_url(); ?>About/privacy" target="_blank">Privacy Policy</a></span></p>
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
    </div>
    <!-- END REGISTER MODAL -->
  <?php endif; ?>

  <!-- CONTENT -->
  <div class="container">
    <div class="row content-header">
      <ul class="breadcrumb">
        <li><a href="<?php echo base_url()?>">Home</a></li>
        <li><a href="<?php echo base_url(); ?>Category/all">Categories</a></li>
        <li><a href="<?php echo base_url(); ?>Category/result/<?php echo str_replace(' ', '_', $business->category)?>"><?php echo str_replace('_', ' ', $business->category)?></a></li>
        <li class="active"><?php echo str_replace('_', ' ', $business->business_name)?></li>
      </ul>
    </div>
    <div class="row content">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 main-content">
          <?php if (!empty($business)): ?>
            <div class="media" style="background-color:#fff;border:5px solid #fff;">
              <div class="pull-left visible-lg visible-md visible-sm media-left">
                <?php if (!empty($business->image)): ?>
                  <img class="media-object" src="<?php echo $business->image?>" alt="image" width="200px" height="200px">
                <?php else: ?>
                  <img class="media-object" src="<?php echo base_url(); ?>public/img/default-img.jpg" alt="image" width="200px" height="200px">
                <?php endif; ?>
              </div>
              <div class="media-body rating">
                <?php if (!empty($business->image)): ?>
                  <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="<?php echo $business->image?>" alt="image" width="200px" height="200px"><br class="hidden-lg hidden-md hidden-sm">
                <?php else: ?>
                  <img class="hidden-lg hidden-md hidden-sm center-block img-responsive media-object" src="<?php echo base_url(); ?>public/img/default-img.jpg" alt="image" width="200px" height="200px"><br class="hidden-lg hidden-md hidden-sm">
                <?php endif; ?>
                <span>
                  <span class="business-title"><?php echo $business->business_name?></span>
                  <div class="pull-right">
                    <input class="toggle-heart" id="toggle-heart" type="checkbox" name="<?php echo $business->id?>"/>
                    <label for="toggle-heart" class="fave-icon">❤</label>
                  </div>
                </span>
                <?php if (!empty($voted)): ?>
                  <?php if ($voted == 'Voted'): ?>
                    <script type='text/javascript'>
                      $(document).ready(function(){
                        $('#toggle-heart').prop('checked', true);
                      });
                    </script>
                  <?php endif; ?>
                <?php endif; ?>
                <div class="separator"></div>
                <ul>
                  <div class="list-text visible-lg visible-md visible-sm">
                    <li class="detail-list"><span>Address:</span> <?php echo $business->address?>, <?php echo $business->locality ?></li>
                  </div>
                  <div class="hidden-lg hidden-md hidden-sm">
                    <li class="detail-list"><span>Address:</span> <?php echo $business->address?>, <?php echo $business->locality ?></li>
                  </div>
                  <li class="detail-list"><span>Cellphone:</span> +63<?php echo $business->cellphone?></li>
                  <li class="detail-list"><span>Telephone:</span> <?php echo $business->telephone?></li>
                  <li class="detail-list"><span>Please look for:</span> <?php echo $business->contact_person?></li>
                </ul>
              </div>
            </div>
          <?php endif; ?>
        <div class="row rating-vote-div">
          <div class="col-lg-4 col-md-4 col-xs-4 text-center info-div">
            <ul class="rating-vote">
              <li><i class="ion-ios-star rating-icon"></i></li>
              <li class="">Ratings: <br class="hidden-lg hidden-md hidden-sm"><?php echo number_format($rate->rate_value, 1)?></li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-4 col-xs-4 text-center info-div">
            <ul class="rating-vote">
              <li><i class="ion-heart heart-icon"></i></li>
              <li id="vote">
                <?php if (!empty($vote->vote)): ?>
                  <?php if ($vote->vote > 1): ?>
                    Faves:<br class="hidden-lg hidden-md hidden-sm"> <?php echo $vote->vote?>
                  <?php else: ?>
                    Fave:<br class="hidden-lg hidden-md hidden-sm"> <?php echo $vote->vote?>
                  <?php endif; ?>
                <?php else: ?>
                  Fave:<br class="hidden-lg hidden-md hidden-sm">0
                <?php endif; ?>
              </li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-4 col-xs-4 text-center info-div">
            <ul class="rating-vote">
              <li><i class="ion-edit review-icon"></i></li>
              <li>
                <?php if (!empty($review_count)): ?>
                  <?php if ($review_count->reviews > 1): ?>
                    Reviews:<br class="hidden-lg hidden-md hidden-sm"> <?php echo $review_count->reviews ?>
                  <?php else: ?>
                    Review:<br class="hidden-lg hidden-md hidden-sm"> <?php echo $review_count->reviews ?>
                  <?php endif; ?>
                <?php else: ?>
                  Reviews:<br class="hidden-lg hidden-md hidden-sm"> 0
                <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>
        <div class="">
          <ul class="media-list">
            <?php if (!empty($reviews)): ?>
              <?php foreach ($reviews as $key => $review): ?>
                <div class="row comment-header" style="">
                  <ul>
                    <li class="pull-right date-style"><?php echo $review->date_created?></li>
                  </ul>
                </div>
                <li class="col-lg-12 media">
                  <a class="pull-left" href="#">
                    <img class="media-object img-circle" src="<?php if (!empty($review->image)): ?> <?php echo $review->image?> <?php else: ?> /public/img/default-img.jpg <?php endif; ?>" width="100px" height="100px" alt="profile">
                  </a>
                  <div class="media-body">
                    <div class="well well-lg">
                        <ul class="list-inline">
                          <li><span class="badge rating-style" style=""><?php echo number_format($review->rate, 1)?> </span></li>
                          <li><h4 class="media-heading text-uppercase reviews"><?php echo $review->username?> </h4></li>
                        </ul>
                        <p class="media-comment">
                          <?php echo $review->review?>
                        </p>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 side-content">
        <h3 class="review-title">Write a Review</h3>
        <div id="review_error_msg"></div>
        <!-- Rating Stars Box -->
        <div class='rating-stars text-center'>
          <ul id='stars' name="<?php echo $business->id?>">
            <li class='star' title='Poor' data-value='1'>
              <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' title='Fair' data-value='2'>
              <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' title='Good' data-value='3'>
              <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' title='Excellent' data-value='4'>
              <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' title='WOW!!!' data-value='5'>
              <i class='fa fa-star fa-fw'></i>
            </li>
          </ul>
        </div>

        <div class='success-box'>
          <div class='clearfix'></div>
          <img alt='tick image' width='22' src='https://i.imgur.com/3C3apOp.png'/>
          <div class='text-message'></div>
          <div class='clearfix'></div>
        </div>

        <div class="form-group input-width center-block">
          <span style="color:red" class="help-block"><?php echo form_error('review'); ?></span>
          <textarea class="form-control" name="review" id="review" maxlength="180"></textarea>
        </div>
        <div class="pull-left" style="margin-top:5px;">
          <span id="count"> </span>
        </div>
        <div class="pull-right" style="margin-top:5px;">
          <button class="btn btn-success" type="button" name="button" id="Add_Review">Add review</button>
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
                            <?php endif; ?> <a href="<?php echo base_url(); ?>About" target="_blank">Learn More</a>
                        </p>
                      </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <ul class="social">
                      <li><a href="<?php if (!empty($facebook->value)): ?> <?php echo $facebook->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="<?php if (!empty($twitter->value)): ?> <?php echo $twitter->value ?> <?php endif; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
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

<script>
<?php if ($this->session->userdata('traveller_is_logged_in')): ?>
(function() {
  var notif = function(){
    var user_id = {
        user_id: "<?php echo $traveller_details->user_id ?>"
    };
    $.ajax({
      url: "<?php echo base_url(); ?>Home/get_notif",
      type: "POST",
      data: user_id,
      success: function (data){
        // alert('Kumuha na ng notif');
          $('#notif-div').html(data);
      }
    });
  };
  setInterval(function(){
    notif();
  }, 60000);
})();
$('#notif-div').on('click', '#notif-count', function() {
    // alert('clicked');
    var user_id = {
             user_id: "<?php echo $traveller_details->user_id ?>"
         };
      $.ajax({
          url: "<?php echo base_url(); ?>Home/is_unread",
          type: 'POST',
          data: user_id,
          success: function(msg) {
            // alert("Na read na");
            $('#notif-count').html(msg);
          }
      });
});
<?php endif; ?>
$('#Submit').click(function() {
    $('#error_message').show();
    var form_data = {
        email: $('#email').val(),
        password: $('#password').val()
    };
    $.ajax({
        url: "<?php echo base_url(); ?>Home/login",
        type: 'POST',
        data: form_data,
        success: function(msg) {
            if (msg =='Invalid') {
              $('#error_message').html('<div class="alert alert-danger">Email is not registered, please register first</div>');
            }else if (msg =="Unconfirmed") {
              $('#login').hide();
              $(location).attr('href','<?php echo base_url(); ?>Verify/unconfirmed');
            }else if (msg =='Incorrect') {
              $('#error_message').html('<div class="alert alert-danger">Incorrect password</div>');
            }else if (msg =='Set up') {
              $('#login').hide();
              $(location).attr('href','<?php echo base_url(); ?>Home/set_up');
            }else if (msg == 'Dashboard') {
              $('#login').hide();
              $(location).attr('href','<?php echo base_url(); ?>Account');
            }else if (msg == 'Login') {
              $('#login').hide();
              $(location).attr('href','<?php echo base_url(); ?>Home');
            }else if (msg == 'Account') {
              $('#login').hide();
              $(location).attr('href','<?php echo base_url(); ?>Home/account');
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
        url: "<?php echo base_url(); ?>Home/register",
        type: 'POST',
        data: register_data,
        success: function(message) {
          if (message=='Successful') {
            $('#register').hide();
            $(location).attr('href','<?php echo base_url(); ?>Verify');
          }else if (message=='Unsucessful') {
            $('#register').hide();
            $(location).attr('href','<?php echo base_url(); ?>Verify/not_sent');
          }
          else {
            $('#register_error_message').html('<div class="alert alert-danger">'+ message +'</div>');
          }
        }
    });
    return false;
});
$('#supplier').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    $('#register_error_message').hide();
});
$('#toggle-heart').on('click',function () {
    var ckbox = $('#toggle-heart');
    if (ckbox.is(':checked'))
    {
        // alert($('#toggle-heart').attr('name'));
        var vote = {
            business_id: $('#toggle-heart').attr('name')
        };
        $.ajax({
            url: "<?php echo base_url(); ?>Home/vote",
            type: 'POST',
            data: vote,
            success: function(message) {
              if (message == 'Not logged in') {
                $('#toggle-heart').prop('checked', false);
                $('#login').modal('show');
              }else if (message > 1) {
                $('#vote').html('Faves: '+message);
              }else {
                $('#vote').html('Fave: '+message);
              }
            }
        });
    }
    else
    {
      var vote = {
          business_id: $('#toggle-heart').attr('name')
      };
      $.ajax({
          url: "<?php echo base_url(); ?>Home/unvote",
          type: 'POST',
          data: vote,
          success: function(message) {
            if (message > 1) {
              $('#vote').html('Faves: '+message);
            }else {
              $('#vote').html('Fave: '+message);
            }
          }
      });
    }
});
$('#review').keyup(function () {
  var max = 180;
  var len = $(this).val().length;
  if (len >= max) {
    $('#count').text('');
  } else {
    var char = max - len;
    $('#count').text(char + ' characters left');
  }
});
var rate;
$(document).ready(function(){

  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });

  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });


  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');

    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }

    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }

    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    rate = ratingValue;
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);

    // rate(ratingValue);
  });
});

function responseMessage(msg) {
  $('.success-box').fadeIn(200);
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}

$('#Add_Review').click(function() {
  if (rate==null) {
    var review = {
        rate: 0,
        review: $('#review').val(),
        business_id: $('#stars').attr('name')
    };
    $.ajax({
        url: "<?php echo base_url(); ?>Category/add_review",
        type: 'POST',
        data: review,
        success: function(message) {

          if (message == 'Rate') {
            $('#review_error_msg').html('<div class="alert alert-danger">Please add your rate</div>');
          }else if (message == 'Experience') {
            $('#review_error_msg').html('<div class="alert alert-danger">Please share us your experience...</div>');
          }else if (message == 'Not logged in') {
            $('#login').modal('show');
          }else if (message == 'Offensive') {
            $('#review_error_msg').html('<div class="alert alert-danger">Here at Travel Hub, we promote a healthy and positive community, and we think your review includes offensive language. Please refrain from using one and give us your honest review. Thank you.</div>');
          }
          else {
            $('#review_error_msg').hide();
          }
        }
    });
  }else {
    var review = {
        rate: rate,
        review: $('#review').val(),
        business_id: $('#stars').attr('name')
    };
    $.ajax({
        url: "<?php echo base_url(); ?>Category/add_review",
        type: 'POST',
        data: review,
        success: function(message) {
          if (message == 'Rate') {
            $('#review_error_msg').html('<div class="alert alert-danger">Please add your rate</div>');
          }else if (message == 'Experience') {
            $('#review_error_msg').html('<div class="alert alert-danger">Please share us your experience...</div>');
          }else if (message == 'Not logged in') {
            $('#login').modal('show');
          }else if (message == 'Offensive') {
            $('#review_error_msg').html('<div class="alert alert-danger">Here at Travel Hub, we promote a healthy and positive community, and we think your review includes offensive language. Please refrain from using one and give us your honest review. Thank you.</div>');
          }
          else {
            $('#review_error_msg').hide();
            alert('Thanks for sharing us your experience, it will greatly help other travellers.');
            $(location).attr('href','/Category/view/<?php echo str_replace(' ', '_', $business->business_name)?>');
          }
        }
    });
  }
});
$('#buttonsearch').click(function(){
  $('#formsearch').slideToggle( "fast",function(){
     $( '#content' ).toggleClass( "moremargin" );
  });
  $('#location').focus();
  $('.openclosesearch').toggle(); 
});
$("#locality-search").keyup(function () {
  // alert($("#country").val());
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Home/search_location",
        data: {
            keyword: $("#locality-search").val()
        },
        dataType: "json",
        success: function (data) {
            if (data.length > 0) {
                $('#DropdownLocality').empty();
                $('#locality-search').attr("data-toggle", "dropdown");
                $('#DropdownLocality').dropdown('toggle');
            }
            else if (data.length == 0) {
                $('#locality-search').attr("data-toggle", "");
                // $('#DropdownLocality').append('<li role="displayCountries" ><a role="menuitem DropdownLocalityli" class="dropdownlivalue">No result</a></li>');
            }
            $.each(data, function (key,value) {
                if (data.length >= 0)
                    $('#DropdownLocality').append('<li role="displayCountries" ><a role="menuitem DropdownLocalityli" class="dropdownlivalue">' + value['locality'] + '</a></li>');
            });
        }
    });
});
$('ul.txtlocality').on('click', 'li a', function () {
    $('#locality-search').val($(this).text());
    $('#look_for').focus(); 
});
$("#locality_search").keyup(function () {
  // alert("Hey world");
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Home/search_location",
        data: {
            keyword: $("#locality_search").val()
        },
        dataType: "json",
        success: function (data) {
            if (data.length > 0) {
                $('#_DropdownLocality').empty();
                $('#locality_search').attr("data-toggle", "dropdown");
                $('#_DropdownLocality').dropdown('toggle');
            }
            else if (data.length == 0) {
                $('#locality_search').attr("data-toggle", "");
                // $('#DropdownLocality').append('<li role="displayCountries" ><a role="menuitem DropdownLocalityli" class="dropdownlivalue">No result</a></li>');
            }
            $.each(data, function (key,value) {
                if (data.length >= 0)
                    $('#_DropdownLocality').append('<li role="display_Countries" ><a role="menuitem _DropdownLocalityli" class="_dropdownlivalue">' + value['locality'] + '</a></li>');
            });
        }
    });
});
$('ul._txtlocality').on('click', 'li a', function () {
    $('#locality_search').val($(this).text());
    $('#look-for').focus(); 
});
$("#look_for").keyup(function () {
  // alert($("#country").val());
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Home/look_result",
        data: {
            keyword: $("#look_for").val()
        },
        dataType: "json",
        success: function (data) {
            if (data.length > 0) {
                $('#DropdownLookFor').empty();
                $('#look_for').attr("data-toggle", "dropdown");
                $('#DropdownLookFor').dropdown('toggle');
            }
            else if (data.length == 0) {
                $('#look_for').attr("data-toggle", "");
                // $('#DropdownLocality').append('<li role="displayCountries" ><a role="menuitem DropdownLocalityli" class="dropdownlivalue">No result</a></li>');
            }
            $.each(data, function (key,value) {
                if (data.length >= 0)
                    $('#DropdownLookFor').append('<li role="displayCountries" ><a role="menuitem DropdownLocalityli" class="dropdownlivalue">' + value['category'] + '</a></li>');
            });
        }
    });
});
$('ul.txtlookfor').on('click', 'li a', function () {
    $('#look_for').val($(this).text());
    // $('#look-for').focus(); 
});
$("#look-for").keyup(function () {
  // alert($("#country").val());
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Home/look_result",
        data: {
            keyword: $("#look-for").val()
        },
        dataType: "json",
        success: function (data) {
            if (data.length > 0) {
                $('#_DropdownLookFor').empty();
                $('#look-for').attr("data-toggle", "dropdown");
                $('#_DropdownLookFor').dropdown('toggle');
            }
            else if (data.length == 0) {
                $('#look-for').attr("data-toggle", "");
                // $('#DropdownLocality').append('<li role="displayCountries" ><a role="menuitem DropdownLocalityli" class="dropdownlivalue">No result</a></li>');
            }
            $.each(data, function (key,value) {
                if (data.length >= 0)
                    $('#_DropdownLookFor').append('<li role="displayCountries" ><a role="menuitem _DropdownLocalityli" class="dropdownlivalue">' + value['category'] + '</a></li>');
            });
        }
    });
});
$('ul._txtlookfor').on('click', 'li a', function () {
    $('#look-for').val($(this).text()); 
});
</script>
</body>
</html>
