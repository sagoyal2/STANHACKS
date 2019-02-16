
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Post - Verum</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="shortcut icon" href="verum.ico">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="post.js"></script>
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<a href="index.php" class="logo">Verum</a>
					</header>

				<!-- Nav -->
						<nav id="nav" style="background-color:rgb(30,37,45);">
							<ul class="links mainwordsli">
								<li><a href="index.php">The Verum</a></li>
								<li><a href="about.html">About</a></li>
								<li><a href="index.php">Editor's Picks</a></li>
								<li class="active"><a href="login.php">Post</a></li>
							</ul>
						</nav>

				<!-- Main -->
					<div id="main">
								<!-- Form -->
									<h2>Post</h2>
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
                                        if (isset($_SESSION['user'])) {
                                    ?>
									<form action="post.php" method="POST" onsubmit ="return postinger();">
										<div class="row gtr-uniform">
											<!-- Break -->
											<div class="col-12">
												<h3>Title:</h3>
												<input type="text" id="title" name="title">
												<br>
												<select name="topic-category" id="topic-category">
													<option value="">- Topic -</option>
													<option value="1">Should Free Speech Be Limited on Campus</option>
												</select>
												<br>
												<h3>Tags</h3>
											</div>
											<!-- Break -->
											<div class="col-4 col-12-small">
												<input type="checkbox" value = "name" id="name" name="name">
												<label for="name">Name</label>
											</div>
											<div class="col-4 col-12-small">
												<input type="checkbox" id = "year" value="year" name="year">
												<label for="year">Graduation Year</label>
											</div>
											<div class="col-4 col-12-small">
												<input type="checkbox" id = "dorm" value="dorm" name="dorm">
												<label for="dorm">Dorm</label>
											</div>
											<!-- Break -->
											<div class="col-6 col-12-small">
												<input type="checkbox" value="" name="demo-copy">
												<label for="demo-copy">Email me a copy</label>
											</div>
											<div class="col-6 col-12-small">
												<input type="checkbox" id="human" name="human">
												<label for="human">I am a human</label>
											</div>
											<!-- Break -->
											<div class="col-12">
												<textarea onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"
												name="article" value="" id = "article" placeholder="Write your Post" rows="18"></textarea>
											</div>
											<!-- Break -->
											<div class="col-12 pull-right" style = "float:right;">
												<ul class="actions">
													<li><input type="submit" value="Post" class="primary" /></li>
													<li><input type="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>
                                    <?php

                                    } else {
                                     ?>
                                    <script> alert("You must be logged in to post");
                                    window.location = "http://www.suverum.com";
                                    </script>
                                    <?php
                                   }
                                    ?>
									<hr />



			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>

<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
  require "config.php";
  require "database.php";
    if(isset($_POST['title']) and isset($_POST['article'])){
  $con = mysqli_connect('localhost', 'u761899477_wang', 'Lightpower1', 'u761899477_verum');
  if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
        }else{
        
    }
    $nid = $_SESSION['user'];
  $value = $con->query("SELECT * FROM users WHERE id = $nid");
  $answer = $value->fetch_assoc();
  $stmt = $con->prepare("INSERT INTO posts (title, date, post, author, dorm, year)
    VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $title, $date, $article, $name, $dorm, $year);
  $name = "Anonymous";
  $dorm = "";
  $year = "";
  if(isset($_POST['dorm'])){
      $dorm = $answer['user_dorm'];
  }
  if(isset($_POST['name'])){
      $name = $answer['user_name'];
  }
  if(isset($_POST['year'])){
      $year = $answer['user_year'];
  }
  $article = $_POST['article'];
  $title = $_POST['title'];
  $date = date("F d\, Y");
  if($stmt->execute()){
      header('location:index.php');
  }
  $con->close();
}
 ?>
