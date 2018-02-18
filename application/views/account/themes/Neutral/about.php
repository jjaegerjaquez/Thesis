<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    <?php if (!empty($site_title)): ?>
      <?php echo $site_title->value ?>
    <?php else: ?>
      Site Title
    <?php endif; ?>
  </title>
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
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/Neutral/about/style.css">
</head>
<body>

  <!-- NAV -->
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
          <li><a href="/View/home/<?php echo $details->username?>">Home</a></li>
          <li><a href="/View/about/<?php echo $details->username?>">About</a></li>
          <li><a href="/View/gallery/<?php echo $details->username?>">Gallery</a></li>
          <li><a href="/View/contacts/<?php echo $details->username?>">Contact</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container-fluid text-center about-header" style="background-image:url('<?php echo $about_header_image->value?>');">
    <h1><span class="section-heading-lower">ABOUT</span></h1>
  </div>

  <section class="container text-center custom">
    <h2>
      <?php if (!empty($about_title)): ?>
        <?php echo $about_title->value ?>
      <?php else: ?>
        Put your text here
      <?php endif; ?>
    </h2>
    <div class="row">
      <div class="col-lg-2"></div>
      <div class="col-lg-8">
        <p>
          <?php if (!empty($about_description)): ?>
            <?php echo $about_description->value ?>
          <?php else: ?>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec convallis urna at malesuada fermentum. Integer quis augue a metus hendrerit suscipit ut sit amet nisl. Mauris finibus ex blandit tempus molestie. Ut at faucibus mauris. Nullam in viverra enim. Curabitur aliquet, arcu in euismod egestas, leo ex pharetra ex, eget dictum magna purus sed mauris. Nullam feugiat tellus justo, quis tincidunt est dictum ut. Morbi nec purus velit. Etiam aliquet est elit, id congue libero venenatis in. Pellentesque posuere orci iaculis neque consequat, sit amet cursus sem egestas. In facilisis turpis at velit pulvinar luctus. Morbi ac placerat purus, et porta erat. Sed rhoncus sem eu libero consectetur, sed faucibus velit bibendum. Morbi blandit volutpat enim et scelerisque.
          <?php endif; ?>
        </p>
      </div>
    </div>
  </section>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
