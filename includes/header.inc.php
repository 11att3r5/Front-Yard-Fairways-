<!DOCTYPE html>
<html class="no-js" lang="en" >
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
  <meta name="author" content="Alexander Grimes">
  <meta name="robots" content="index">
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script> 
  <script type="text/javascript">
    if (typeof jQuery == 'undefined') {
      document.write(decodeURI("%3Cscript src='jquery-1.11.2.min.js' type='text/javascript'%3E%3C/script%3E"));
    }
  </script>
  <script type="text/javascript" src="js/app.js"></script>
  <link rel="stylesheet" href="css/app.css">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
  <link href='https://fonts.googleapis.com/css?family=Lemonada:400,300' rel='stylesheet' type='text/css'>
    <title>
      <?php echo constant("SITENAME") . ": " . constant(strtoupper($pagelet) . '_TITLE');
      ?>
    </title>
    <?php
      session_start();
    ?>
    <?php phpinfo(); ?>
</head>