<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if (!empty($site_title)): ?><?php echo $site_title->value ?><?php else: ?>Site Title<?php endif; ?></title>
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
  <link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">  <!-- Style -->
  <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/Neutral/home/style.css">
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
          <li><a href="<?php echo base_url(); ?>View/home/<?php echo str_replace(' ', '_', $details->business_name)?>">Home</a></li>
          <li><a href="<?php echo base_url(); ?>View/about/<?php echo str_replace(' ', '_', $details->business_name)?>">About</a></li>
          <li><a href="<?php echo base_url(); ?>View/gallery/<?php echo str_replace(' ', '_', $details->business_name)?>">Gallery</a></li>
          <li><a href="<?php echo base_url(); ?>View/contacts/<?php echo str_replace(' ', '_', $details->business_name)?>">Contact</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <!-- <header class="container-fluid header-style" style="background-image: url('/public/img/Neutral/bg2.jpg');"> -->
    <?php if (!empty($home_bg)): ?>
      <header class="container-fluid header-style" style="background-image: linear-gradient(rgba(0, 0, 0, 0.45),rgba(0, 0, 0, 0.45)),url('<?php echo $home_bg->value?>');">
    <?php else: ?>
      <header class="container-fluid header-style" style="background-image: linear-gradient(rgba(0, 0, 0, 0.45),rgba(0, 0, 0, 0.45)),url('<?php echo base_url(); ?>public/img/Neutral/bg2.jpg');">
    <?php endif; ?>
    <h1>
      <?php if (!empty($home_title)): ?>
        <?php echo $home_title->value ?>
      <?php else: ?>
        ENTER TEXT HERE
      <?php endif; ?>
    </h1>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<p>
				  <?php if (!empty($home_description)): ?>
            <?php echo $home_description->value ?>
				  <?php else: ?>
            “Praesent id tempus augue, eu maximus dolor. Nulla scelerisque malesuada erat eu ornare. Suspendisse dictum metus et efficitur faucibus. Maecenas quis ornare massa. Aenean accumsan sit amet quam in accumsan. In placerat fermentum ultrices. Proin facilisis feugiat nisi eget laoreet. Donec vitae interdum est. Maecenas tempor porttitor efficitur. Morbi convallis vulputate turpis, sed tincidunt ex ultricies eget. Duis ut ex ac enim congue sollicitudin. Nullam finibus eleifend est ac fermentum. Quisque a cursus erat. Etiam massa lorem, maximus eu malesuada eget, malesuada ac nisl. Aenean dignissim ligula in odio pulvinar, at feugiat tellus commodo..”
				  <?php endif; ?>
				</p>
			</div>
		</div>
  </header>

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>public/thesis/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
