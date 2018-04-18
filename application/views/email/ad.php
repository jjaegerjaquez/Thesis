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
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,700|Roboto:300,400,500" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:500|Roboto|Roboto+Condensed" rel="stylesheet">
  <!-- Style -->
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/style.css"> -->
  <style>
    .button{
      font-family:'Roboto Condensed', sans-serif;border:3px solid #fff;
      padding-top:10px;
      padding-bottom:10px;
      padding-left:20px;
      padding-right:20px;
      text-decoration:none;
      color:#fff;
      font-weight: bold;
    }
    .box{
      margin-top: 200px;
      text-align: center;
      color:#fff;
      height: 300px;
    }
    h3{
      margin-bottom: 30px;
    }
  </style>
</head>
<body style="background-color:#f37430;padding-top:30px;">
  <div class="box">
    <h1>Travel Hub</h1>
    <h3>Hey <?php echo $business_name ?>, your advertisement will expire on <?php echo date('F j Y',strtotime($termination_date))?>. <br>Please contact us at <span style="font-style:italic;">contact@travelhub.ph </span><br>if you want to extend your ad. Thank you.</h3>
  </div>
<script>
</script>
</body>
</html>
