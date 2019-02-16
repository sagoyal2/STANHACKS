<?php
    session_start();
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 86400)) {
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); 
        if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 1800) {
        // session started more than 30 minutes ago
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }
  
    if(isset($_POST['email']) and isset($_POST['password'])){
      $con = mysqli_connect('localhost', 'u761899477_wang', 'Lightpower1', 'u761899477_verum');
      $email = $_POST['email'];
      $password = $_POST['password'];
     $password = md5($password);
    $sql = $con->prepare("SELECT id FROM users WHERE user_email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $answer = $sql->get_result();
    if($answer->num_rows < 1){
      $message = "Account not registered please make one";
     echo "<script type='text/javascript'>alert('$message');</script>";

    }
    $stmt = $con->prepare("SELECT * FROM users WHERE user_email=? and user_password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = mysqli_num_rows($result);

    if($count == 1){
        $row = $result->fetch_assoc();
        $cookie_name = "user";
        $cookie_value = (int) $row['id'];
        $_SESSION['user'] = $cookie_value;
        header("Location: http://www.suverum.com/index.php");
    }
    else{
        $message = "Invalid Login";
        header("Location: login.php");
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
        die();
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="shortcut icon" href="verum.ico">
    <link rel="stylesheet" href="assets/css/main.css"/>
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    <title>Login</title>
  </head>
  
  
  <body class="is-preload">
    <div id="wrapper">
    <header id="header">
		<a href="index.php" class="logo">Verum</a>
	</header>
	<div id="main">
        <div class="row justify-content-center">
          <div class="col-md-4 col-md-offset-3" style="padding-left:0px;" align="center">
         <span>
          <form action="login.php" method="post">
            <br>
            <h2>Login</h2>
            <div class="col-16 col-12-medium">
                <input type="email" name="email" value="" placeholder="Email"><br>
            </div>
            <div class="col-16 col-12-medium">
                <input type="password" name="password" value="" placeholder="Password"><br>
            </div>
            <input type="submit" name="login" value="Login">
                        <button id="myButton" type='button'>Register</button>

          </form>
            <br>
          </span>
          
        </div>
        </div>
    </div>
    </div>
    <script type="text/javascript"> 
    document.getElementById("myButton").onclick = function () {
        location.href = "1-register.php";
    };</script>
    <script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
  </body>
</html>
