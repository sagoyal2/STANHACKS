<?php
/* [VALIDATION CHECK] */
require "config.php";
$pass = false;

// VALID $_GET VARS
if (is_numeric($_GET['id'])) {
	require "database.php";
	$pdoUsers = new Users();
	$pass = $pdoUsers->verify($_GET['id'], $_GET['h']);
}

/* [THE HTML] */ ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <meta name="description" content="A description of this web page">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css"/>
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
          <link rel="shortcut icon" href="verum.ico">

</head>
<body class="is-preload">
    <div id="wrapper" style = "height: 100vh">

  <!-- [HEADER] -->
<header id="header">
		<a href="index.php" class="logo">Verum</a>
	</header>
  <!-- [BODY] -->
  
    <div id="main" style = "height: 60vh" >
    <div class="row justify-content-center">

	<?php if (true) { ?>
	<div class = "col-md-7" style = "text-align:center">
        	<h2>Welcome to the Verum!</h2>
        	<p>Your account is now active and you may begin posting and voting. If you have any questions contact us at suverum@gmail.com.</p> 
            <button style = "float: center" onclick= "window.location.href = 'login.php'">Login</button>
    </div>
    <?php } else { ?>
	<h2>ERROR</h2><br>
	<p>We encountered some problems while activating your account. Please contact suverum@gmail.com and we will sort out the problem.</p> <br><br><br>
    <?php } ?>
  </div>
</div>
    <br>
    <br><br>
  </div>
</body>
</html>