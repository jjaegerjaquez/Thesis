<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($title->value)) { echo $title->value; } else { echo "Title";}?></title>
  <link rel="icon" href="<?php if (!empty($site_icon->value)) { echo $site_icon->value; } else { echo "Icon";}?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>public/thesis/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,700|Roboto:300,400,500" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700" rel="stylesheet">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/forum/view_topic/style.css">
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
                <li role="separator" class="divider"></li>
                <li><a href="#">Most Viewed</a></li>
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
              <li role="separator" class="divider"></li>
              <li><a href="#">Most Viewed</a></li>
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
      <ul class="breadcrumb navbar-bottom">
  	     <li><a href="<?php echo base_url() ?>">Home</a></li>
         <li><a href="<?php echo base_url(); ?>Forum/all">All topics</a></li>
         <li>Topic</li>
         <li><?php echo $topic->topic ?></li>
  		</ul>
    </div>
    <div class="row content">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 forum-header text-center">
        <h1><?php echo $topic->topic?></h1>
        <?php if (!empty($topic->description)): ?>
          <p style="font-size:22px;font-family:'Roboto Condensed', sans-serif;"><?php echo $topic->description ?></p>
        <?php endif; ?>
        <ul class="list-inline">
          <li>
            <i class="ion-chatbubble">
              <?php echo $topic->count ?>
              <?php if ($topic->count > 1): ?>
                comments
              <?php else: ?>
                comment
              <?php endif; ?>
            </i>
          </li>
          <li>
            <i class="ion-chatbubbles">
              <?php echo $reply_count->reply_count ?>
              <?php if ($reply_count->reply_count > 1): ?>
                replies
              <?php else: ?>
                reply
              <?php endif; ?>
            </i>
          </li>
        </ul>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-content">
        <div class="blog-comment">
          <ul class="comments" id="comments-box">
            <?php if (!empty($count)): ?>
              <?php for ($i=0; $i <$count ; $i++) { ?>
                <li class="clearfix">
                  <?php if (!empty($comments[$i]->image)): ?>
                    <img src="<?php echo $comments[$i]->image?>" class="avatar" alt="">
                  <?php else: ?>
                    <img src="<?php echo base_url(); ?>public/img/default-img.jpg" class="avatar" alt="">
                  <?php endif; ?>
        				  <div class="post-comments">
        				      <p class="meta"><?php echo date('F j Y',$date = strtotime($comments[$i]->date_created))?> <a href="#"><?php echo $comments[$i]->username ?></a> says :
                        <i class="pull-right">
                          <small>
                            <?php if ($this->session->userdata('traveller_is_logged_in')): ?>
                              <!-- <a href="#" data-toggle="collapse" data-target="#reply_box">Reply</a> -->
                            <?php else: ?>
                              <a href="#" data-toggle="modal" data-target="#login">Reply</a>
                            <?php endif; ?>
                          </small>
                        </i>
                      </p>
        				      <p>
        				        <?php echo $comments[$i]->content ?>
        				      </p>
        				  </div>
                  <?php foreach ($this->data['replies'.$i] as $key => $reply): ?>
                    <ul class="comments">
          				      <li class="clearfix">
                          <?php if (!empty($reply->image)): ?>
                            <img src="<?php echo $reply->image?>" class="avatar" alt="">
                          <?php else: ?>
                            <img src="<?php echo base_url(); ?>public/img/default-img.jpg" class="avatar" alt="">
                          <?php endif; ?>
                          <div class="post-comments">
                              <p class="meta"><?php echo date('F j Y',$date = strtotime($reply->date_created))?> <a href="#"><?php echo $reply->username ?></a> says :
                                <i class="pull-right">
                                  <small>
                                    <?php if ($this->session->userdata('traveller_is_logged_in')): ?>
                                      <a href="#" data-toggle="collapse" data-target="#reply_box_<?php echo $reply->comment_id?>">Reply</a>
                                    <?php else: ?>
                                      <a href="#" data-toggle="modal" data-target="#login">Reply</a>
                                    <?php endif; ?>
                                  </small>
                                </i>
                              </p>
                              <p>
                                <?php echo $reply->comment ?>
                              </p>
                          </div>
                          <div class="col-lg-11 col-lg-offset-1 reply-box collapse" id="reply_box_<?php echo $reply->comment_id?>">
                            <form class="" action="<?php echo base_url(); ?>Forum/submit_reply/<?php echo $topic->topic_id?>/?post_id=<?php echo $reply->post_id?>&user_id=<?php echo $reply->user_id?>&username=<?php echo $reply->username?>" method="post">
                              <span>Reply:</span>
                              <div class="form-group">
                                <textarea class="form-control" rows="2" maxlength="500" id="reply_2_<?php echo $reply->comment_id?>" name="reply"></textarea>
                              </div>
                              <div id="reply-count-2-<?php echo $reply->comment_id?>" class="pull-right">
                              </div>
                              <button class="btn btn-info" type="submit" name="button">Submit reply</button>
                            </form>
                          </div>
                          <?php echo "
                              <script>
                              $('#reply_2_".$reply->comment_id."').keyup(function () {
                                var max = 500;
                                var len = $(this).val().length;
                                if (len >= max) {
                                  $('#reply-count-2-".$reply->comment_id."').text('');
                                } else {
                                  var char = max - len;
                                  $('#reply-count-2-".$reply->comment_id."').text(char + ' characters left');
                                }
                              });
                              </script>
                          "; ?>
          				      </li>
          				  </ul>
                  <?php endforeach; ?>
                  <?php if ($this->session->userdata('traveller_is_logged_in')): ?>
                    <div class="col-lg-11 col-lg-offset-1 reply-box">
                      <form class="" action="<?php echo base_url(); ?>Forum/submit_reply/<?php echo $topic->topic_id?>/?post_id=<?php echo $comments[$i]->post_id?>&user_id=<?php echo $comments[$i]->user_id?>&username=<?php echo $comments[$i]->username?>" method="post">
                        <span>Reply:</span>
                        <div class="form-group">
                          <textarea class="form-control" rows="2" maxlength="500" id="reply_1_<?php echo $comments[$i]->post_id?>" name="reply"></textarea>
                        </div>
                        <div id="reply-count-<?php echo $comments[$i]->post_id?>" class="pull-right">
                        </div>
                        <button class="btn btn-info" type="submit" name="button">Submit reply</button>
                      </form>
                    </div>
                    <?php echo "
                        <script>
                        $('#reply_1_".$comments[$i]->post_id."').keyup(function () {
                          var max = 500;
                          var len = $(this).val().length;
                          if (len >= max) {
                            $('#reply-count-".$comments[$i]->post_id."').text('');
                          } else {
                            var char = max - len;
                            $('#reply-count-".$comments[$i]->post_id."').text(char + ' characters left');
                          }
                        });
                        </script>
                    "; ?>
                  <?php endif; ?>
        				</li>
              <?php }?>
            <?php else: ?>
              No comments yet
            <?php endif; ?>
          </ul>
        </div>
        <div class="col-lg-7 col-lg-offset-2 comment-box">
          <h3>Post your comment</h3>
          <div id="comment-error"></div>
          <div class="form-group">
            <textarea class="form-control" rows="7" id="comment" maxlength="500"></textarea>
          </div>
          <div id="count" class="pull-right">
          </div>
          <button class="btn btn-info" type="submit" name="button" id="submit_comment">Submit</button>
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
  $("#submit_comment").click(function(){
    var comment = {
        topic_id: <?php echo $topic->topic_id?>,
        comment: $('#comment').val()
    };
    $.ajax({
        url: "<?php echo base_url(); ?>Forum/submit_comment",
        type: 'POST',
        data: comment,
        success: function(message) {
          if (message == 'Error') {
            $( "#comment-error" ).html('<div class="alert alert-danger">Please enter your comment</div>');
          }else if (message == 'Not logged in') {
            $('#login').modal('show');
          }else if (message = 'Successful') {
            $(location).attr('href','<?php echo base_url(); ?>Forum/topic/'+<?php echo $topic->topic_id?>);
          }
          else {
            $( "#comment-error" ).hide();
            $( "#comments-box" ).html(message);
          }
        }
    });
   });
   $('#comment').keyup(function () {
     var max = 500;
     var len = $(this).val().length;
     if (len >= max) {
       $('#count').text('');
     } else {
       var char = max - len;
       $('#count').text(char + ' characters left');
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
