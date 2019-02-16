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
    $con = mysqli_connect('localhost', 'u761899477_wang', 'Lightpower1', 'u761899477_verum');
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
        }
	$article = $con->query("SELECT * FROM posts ORDER BY votes DESC LIMIT 0,7");
    $sql = $con->prepare("SELECT * FROM votes WHERE user_id = ? ORDER BY total_votes DESC");
    if(isset($_SESSION['user'])){ 
        $sql->bind_param("i", $_SESSION['user']);
        $sql->execute();
        $resvote = $sql->get_result();    
        $val = $resvote->fetch_assoc();
        $counter = 0;
    }
    $row = $article->fetch_assoc();
 ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Verum</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="verum.ico">
		<script src="jquery.min.js"></script>
	    <script src="assets/upvote/upvote.vanilla.js"></script>
		<script src="assets/upvote/upvote.jquery.js"></script>
        <script src="upvotefile.js"></script>
        <script>
			document.getElementsByClassName("upvote").onclick=function(){
			    displayDate()
			};
    
            function displayDate()
            {
                 <?php if(isset($_SESSION['user'])) {} else { ?>
                    alert("You must be logged in to vote");
                 <?php } ?>
            }         
        </script>
		<link rel="stylesheet" href="assets/upvote/upvote.css">
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
		  .vote {
          display: inline-block;
          overflow: hidden;
          width: 40px;
          height: 25px;
          cursor: pointer;
          background: url("images/vote.png");
          background-position: 0 -25px;
        }
        .vote.on {
        background-position: 0 2px;
        }
        .flipity {
    	transform: rotate(180deg);
    	  display: inline-block;
        }
		</style>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper" class="fade-in">
				</nav>
				<!-- Intro -->
					<div id="intro">
						<h1 style="color: #1E252D">Verum</h1>
						<ul class="actions">
							<li><a href="#header" style="background-color:rgb(30,37,45);"class="button icon solo fa-arrow-down scrolly">Continue</a></li>
						</ul>
					</div>

				<!-- Header -->
					<header id="header">
						<a href="index.php" class="logo">Topic: Should Speech Be Limited on Campus?</a>
					</header>
				<!-- Nav -->
					<nav id="nav" style="background-color:rgb(30,37,45);">
						<ul class="links mainwordsli">
							<li class="active"><a href="index.php">The Verum</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="#">Editor's Picks</a></li>
							<li><a href="post.php">Post</a></li>
							<?php  if (isset($_SESSION['user'])) {
							    $num = $_SESSION['user'];
    							$ess = $con->prepare("SELECT user_name FROM users WHERE id = ?");
    							$ess->bind_param("i", $num);
    							$ess->execute();
    							$tere = $ess->get_result();
    							$namers = $tere->fetch_assoc();
                            ?>
							<li><a class = "postbutton"><?php 
							echo $namers['user_name'];
							?></a></li>
							<?php
                                 } else {
                            ?>
							<li><a class="postbutton"href="login.php">Login/Register</a></li>
							<?php
                                 }
                            ?>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main"> 

						<!-- Featured Post -->
							<article class="post featured">
								<header class="major">
									<span class="date"><?php $firstd = $row['date'];
									echo $firstd;
									?></span>
							        	<div id="firstvote" style = "float:left" class="upvote">
                                     <a class="upvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 1){echo "upvote-on"; $counter++; $val = $resvote->fetch_assoc();}?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 2){ echo "downvote-on"; $counter++; $val = $resvote->fetch_assoc();}
                                     if($val['post_id'] == $row['id'] && $val['vote_type'] == 0){$counter++; $val = $resvote->fetch_assoc(); }?>"></a>
                                     <a class="star"></a>
                                </div>
                                <script>
                                    var id = "firstvote";
                                    var votes = parseInt(<?php echo $row['votes'];?>); 
                                    var realid = parseInt(<?php echo $row['id'];?>);
                                    controllercounter(id, votes, realid);
                                </script>
									<h1><a style="margin-right:1rem;" href ="article.php?posters=<?=urlencode($row['id']) ?>&user=<?=urlencode($namers['user_name'])?>"><?php $firstt = $row['title'];
									echo $firstt; 
									?></a></h1>
									<h3><?php $firsta = $row['author'];
									echo "By: ", $firsta;
									?></h3>
								    
									<p><?php $first = $row['post'];
									$string = substr($row['post'], 0, 500);
									$fid = $row['id'];
									echo $string, ".......";
									?></p>
									
								</header>
								<a href="article.php?posters=<?=urlencode($fid) ?>" class="image main"><img src="images/Background.jpg" alt="Verum Image" /></a>
								<ul class="actions special">
									<li><a href="article.php?posters=<?=urlencode($fid) ?>&user=<?=urlencode($namers['user_name'])?>" class="button large">
									    Full Story</a></li>
								</ul>
								<?php if($row['dorm'] !== "") { ?>
								    <span class="tags badge-pill badge-success"><?php echo $row['dorm'];?></span>
								<?php
								} else {
								}
								?>
								<?php if($row['year'] !== "") { ?>
								<span class="tags badge-pill badge-info"><?php echo "Class of '", $row['year'];?></span>
									<?php
								} else {
								}
								?>
							</article>

						<!-- Posts -->
							<section class="posts">
								<article>
								    <?php 
        						    if($row = $article->fetch_assoc()){ 
        						    
        						    ?>
									<header>
										<span class="date"><?php 
									    echo $row['date'];
								
									    ?></span>
                                <div id="secondvote" style = "float:left" class="upvote">
                                     <a class="upvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 1){ echo "upvote-on"; $counter++; $val = $resvote->fetch_assoc();}?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 2){ echo "downvote-on"; $counter++; $val = $resvote->fetch_assoc();} if($val['post_id'] == $row['id'] && $val['vote_type'] == 0){$counter++; $val = $resvote->fetch_assoc(); }?>"></a>
                                     <a class="star"></a>
                                </div>
                                <script>
                                    var id = "secondvote";
                                    var votes = parseInt(<?php echo $row['votes'];?>);
                                    var realid = parseInt(<?php echo $row['id'];?>);
                                    controllercounter(id, votes, realid);
                                </script>										
                                <h2 style="display: inline;"><a href = "article.php?posters=<?=urlencode($row['id'])?>&user=<?=urlencode($namers['user_name'])?>"><?php echo $row['title'];?></a></h2>
										<h6><?php echo "By: ", $row['author'];?></h6>
									
									</header>
									<a class="image fit"><img src="images/rainy.jpg" alt="" /></a>
									<p> <?php
									$string = substr($row['post'], 0, 500);
									echo $string;
									$sid = $row['id'];?>
									</p>
									<ul class="actions special">
										<li><a name = "two" href="article.php?posters=<?=rawurlencode($sid)?>&user=<?=urlencode($namers['user_name'])?>" class="button">
										    
										    Full Story</a></li>
									</ul>
									<?php if($row['dorm'] !== "") { ?>
									    <span class="tags badge-pill badge-success"><?php echo $row['dorm'];?></span>
									<?php
									} else {
									}
									?>
									<?php if($row['year'] !== "") { ?>
									<span class="tags badge-pill badge-info"><?php echo "Class of '", $row['year'];?></span>
										<?php
									} else {
									}}
									?>
									
								</article>
								<!-- SECOND -->
								<article>
								    <?php 
        						    if($row = $article->fetch_assoc()){ 
        						    
        						    ?>
									<header>
										<span class="date"><?php 
									    echo $row['date'];
									
									    ?></span>
							    <div id="thirdvote" style = "float:left" class="upvote">
                                     <a class="upvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 1){ echo "upvote-on"; $counter++; $val = $resvote->fetch_assoc();}?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 2){ echo "downvote-on"; $counter++; $val = $resvote->fetch_assoc();} if($val['post_id'] == $row['id'] && $val['vote_type'] == 0){ $val = $resvote->fetch_assoc(); $counter++; }?>"></a>
                                     <a class="star"></a>
                                </div>
                                <script>
                                    var id = "thirdvote";
                                    var votes = parseInt(<?php echo $row['votes'];?>);
                                    var realid = parseInt(<?php echo $row['id'];?>);
                                    controllercounter(id, votes, realid);
                                </script>
										<h2><a  href = "article.php?posters=<?=urlencode($row['id'])?>&user=<?=urlencode($namers['user_name'])?>"><?php echo $row['title'];?></a></h2>
										<h6><?php echo "By: ", $row['author'];?></h6>
									</header>
									<a class="image fit"><img src="images/st1.jpeg" alt="" /></a>
									<p> <?php
    									$string = substr($row['post'], 0, 500);
    									echo $string;
									    $tid = $row['id'];
									    ?>
									    </p>
									<ul class="actions special">
										<li><a href="article.php?posters=<?=rawurlencode($tid)?>&user=<?=urlencode($namers['user_name'])?>" class="button">
										    Full Story</a></li>
									</ul>
									<?php if($row['dorm'] !== "") { ?>
									    <span class="tags badge-pill badge-success"><?php echo $row['dorm'];?></span>
									<?php
									} else {
									}
									?>
									<?php if($row['year'] !== "") { ?>
									    <span class="tags badge-pill badge-info"><?php echo "Class of '", $row['year'];?></span>
									<?php
									} else {
									}}
									?>
								</article>
								<!-- third -->
								<article>
								    <?php 
        						    if($row = $article->fetch_assoc()){ 
        						    
        						    ?>
									<header>
										<span class="date"><?php 
        									    echo $row['date'];
        									
									    ?>
									    </span>
							     <div id="fourthvote" style = "float:left" class="upvote">
                                     <a class="upvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 1){ echo "upvote-on";  $counter++; $val = $resvote->fetch_assoc();}?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 2){ echo "downvote-on"; $counter++; $val = $resvote->fetch_assoc();} if($val['post_id'] == $row['id'] && $val['vote_type'] == 0){ $val = $resvote->fetch_assoc(); $counter++;}?>"></a>
                                     <a class="star"></a>
                                </div>
                                <script>
                                    var id = "fourthvote";
                                    var votes = parseInt(<?php echo $row['votes'];?>);
                                    var realid = parseInt(<?php echo $row['id'];?>);
                                    controllercounter(id, votes, realid);
                                </script>
										<h2><a  href = "article.php?posters=<?=urlencode($row['id'])?>&user=<?=urlencode($namers['user_name'])?>"><?php echo $row['title'];?></a></h2>
										<h6><?php echo "By: ", $row['author'];?></h6>
									</header>
									<a class="image fit"><img src="images/nights.jpg" alt="" /></a>
								    <p> 
							    	<?php
    									$string = substr($row['post'], 0, 500);
    									echo $string;
									 $fid = $row['id'];?>
									    
									</p>
									<ul class="actions special">
										<li><a href="article.php?posters=<?=rawurlencode($fid)?>&user=<?=urlencode($namers['user_name'])?>" class="button">
										    
										    Full Story</a></li>
									</ul>
									<?php if($row['dorm'] !== "") { ?>
									    <span class="tags badge-pill badge-success"><?php echo $row['dorm'];?></span>
									<?php
									} else {
									}
									?>
									<?php if($row['year'] !== "") { ?>
									    <span class="tags badge-pill badge-info"><?php echo "Class of '", $row['year'];?></span>
									<?php
									} else {
									}}
									?>
								</article>
								<!--Article-->
								<article>
								    <?php 
        						    if($row = $article->fetch_assoc()){ 
        						    
        						    ?>
									<header>
										<span class="date"><?php 
    									    echo $row['date'];
    									
									    ?>
									    </span>
    								<div id="fifthvote" style = "float:left" class="upvote">
                                         <a class="upvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 1){ echo "upvote-on"; $counter++; $val = $resvote->fetch_assoc();}?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 2){ echo "downvote-on"; $counter++; $val = $resvote->fetch_assoc();} if($val['post_id'] == $row['id'] && $val['vote_type'] == 0){ $val = $resvote->fetch_assoc(); $counter++;}?>"></a>
                                     <a class="star"></a>
                                    </div>
                                    <script>
                                        var id = "fifthvote";
                                        var votes = parseInt(<?php echo $row['votes'];?>);
                                        var realid = parseInt(<?php echo $row['id'];?>);
                                        controllercounter(id, votes, realid);
                                    </script>
										<h2><a  href = "article.php?posters=<?=urlencode($row['id'])?>&user=<?=urlencode($namers['user_name'])?>"><?php echo $row['title'];?></a></h2>
										<h6><?php echo "By: ", $row['author'];?></h6>
									</header>
									<a class="image fit"><img src="images/rainy.jpg" alt="" /></a>
										<p> <?php
    									$string = substr($row['post'], 0, 500);
    									echo $string;
										$nid = $row['id'];?>
									    </p>
									<ul class="actions special">
										<li><a href="article.php?posters=<?=rawurlencode($nid)?>&user=<?=urlencode($namers['user_name'])?>" class="button">
										    
										    Full Story</a></li>
									</ul>
									<?php if($row['dorm'] !== "") { ?>
									    <span class="tags badge-pill badge-success"><?php echo $row['dorm'];?></span>
									<?php
									} else {
									}
									?>
									<?php if($row['year'] !== "") { ?>
									    <span class="tags badge-pill badge-info"><?php echo "Class of '", $row['year'];?></span>
										<?php
									} else {
									}}
									?>
								</article>
								
								
								<!-- Fifth-->
								<article>
								    <?php 
        						    if($row = $article->fetch_assoc()){ 
        						    
        						    ?>
									<header>
										<span class="date"><?php 
    									    echo $row['date'];
    									    ?>
									    </span>
    								<div id="sixthvote" style = "float:left" class="upvote">
                                        <a class="upvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 1){ echo "upvote-on"; $counter++; $val = $resvote->fetch_assoc();}?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 2){ echo "downvote-on"; $counter++; $val = $resvote->fetch_assoc();} if($val['post_id'] == $row['id'] && $val['vote_type'] == 0){ $val = $resvote->fetch_assoc(); $counter++; }?>"></a>
                                     <a class="star"></a>
                                    </div>
                                    <script>
                                        var id = "sixthvote";
                                        var votes = parseInt(<?php echo $row['votes'];?>);
                                        var realid = parseInt(<?php echo $row['id'];?>);
                                        controllercounter(id, votes, realid);
                                    </script>
										<h2><a  href = "article.php?posters=<?=urlencode($row['id']) ?>"><?php echo $row['title'];?></a></h2>
										<h6><?php echo "By: ", $row['author'];?></h6>
									</header>
									<a  class="image fit"><img src="images/Church.jpg" alt="" /></a>
										<p> <?php
    									$string = substr($row['post'], 0, 500);
    									echo $string;
										$rid = $row['id'];?>
									    </p>
									<ul class="actions special">
										<li><a href="article.php?posters=<?=rawurlencode($rid)?>" class="button">Full Story</a></li>
									</ul>
									<?php if($row['dorm'] !== "") { ?>
									    <span class="tags badge-pill badge-success"><?php echo $row['dorm'];?></span>
									<?php
									} else {
									} 
									?>
									<?php if($row['year'] !== "") { ?>
									    <span class="tags badge-pill badge-info"><?php echo "Class of '", $row['year'];?></span>
										<?php
									} else {
									}
									?>
									<?php
                                    } else {
                                    }?>
								</article>
								<!--Sixth-->
								<article>
								    <?php 
        						    if($row = $article->fetch_assoc()){ 
        						    
        						    ?>
									<header>
										<span class="date"><?php 
        									    echo $row['date'];
        									    ?>
									    </span>
        								<div id="sevvote" style = "float:left" class="upvote">
                                             <a class="upvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 1){ echo "upvote-on"; $counter++; $val = $resvote->fetch_assoc();}?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['post_id'] == $row['id'] && $val['vote_type'] == 2){ echo "downvote-on"; $counter++; $val = $resvote->fetch_assoc();} if($val['post_id'] == $row['id'] && $val['vote_type'] == 0){ $val = $resvote->fetch_assoc(); $counter++;}?>"></a>
                                     <a class="star"></a>
                                        </div>
                                        <script>
                                            var id = "sevvote";
                                            var votes = parseInt(<?php echo $row['votes'];?>);
                                            var realid = parseInt(<?php echo $row['id'];?>);
                                            controllercounter(id, votes, realid);
                                        </script>
										<h2><a  href = "article.php?posters=<?=urlencode($row['id']) ?>"><?php echo $row['title'];?></a></h2>
										<h6><?php echo "By: ", $row['author'];?></h6>
									</header>
									<a  class="image fit"><img src="images/pic1.jpg" alt="" /></a>
										<p> <?php
    									$string = substr($row['post'], 0, 500);
    									echo $string;
										$per = $row['id'];?>
									    </p>
									<ul class="actions special">
										<li><a href="article.php?posters=<?=rawurlencode($per)?>" class="button">
										    
										    Full Story</a></li>
									</ul>
									<?php if($row['dorm'] !== "") { ?>
									    <span class="tags badge-pill badge-success"><?php echo $row['dorm'];?></span>
									<?php
									} else {
									}
									?>
									<?php if($row['year'] !== "") { ?>
								    	<span class="tags badge-pill badge-info"><?php echo "Class of '", $row["year"];?></span>
										<?php
									} else {
									}
									?>
									<?php
                                    } else {
                                    }?>
								</article>
							</section>

						<!-- Footer -->
						
					</div>

				<!-- Footer -->
					<footer id="footer">
						<section class="split contact">
							<section>
								<h3>Contact Us!</h3>
								<p><a href="#">suverum@gmail.com</a></p>
							</section>
						</section>
					</footer>

		<!-- Scripts -->
		    <script type = "text/javascript">
		        <?php if(!isset($_SESSION['user'])){ ?>
		        $(".upvote").on('click', function(event){
                        window.location.href = "login.php";
                        alert("You must log in to vote");
                    });
                 $(".downvote").on('click', function(event){
                        window.location.href = "login.php";
                        alert("You must log in to vote");
                    });
                <?php }?>
		        var start = 7;
		        var limit = 6;
		        var reachedMax = false;
		        $(window).scroll(function() {
		            if($(window).scrollTop()  >= ($(document).height() * .8) - $(window).height()  && $(window).scrollTop()  <= ($(document).height()) - $(window).height()){
    		            getData();
		            }
		        }); 
		        
		        function getData() {
		            if (reachedMax){
		                return;
		            } 
		            $.ajax({
		              url: "infinite.php",  
		              method: "POST",
		              async: false,
		              data: {start: start, reachedMax: reachedMax},
                      dataType: "JSON",                   
                      success: function(data)
                      {   if(data.max || reachedMax){
                                 reachedMax = true;
                                 return;
                            }
                         

                          $.each(data, function(i, item) {
                            start++;
                         var did = "vote" + item.id; 
		                  var str = '<article> <header> <span class="date">' + item.date + '</span> <div id=' + did  +' style = "float:left" class="upvote"> <a class="upvote'
		                  if(item.votetype == 1){
		                      str+=" upvote-on";
		                  }
		                  str+='"></a><span class="count">0</span><a class="downvote'
		                  if(item.votetype == 2){
		                      str+=" downvote-on";
		                  }
		                  str+='"></a><a class="star"></a> </div> <h2 style="display: inline;"><a>'+ item.title + '</a></h2> <h6> By:' + item.author + '</h6> </header> <a  class="image fit"><img src="images/pic2.jpeg" alt="" /></a> <p>' + item.post.substring(0, 500) +'</p> <ul class="actions special"> <li><a name = "two" href="article.php?posters='+ encodeURIComponent(item.id) +' "class="button">  Full Story</a></li> </ul> ';
		                  
		                  if(item.dorm != ""){
		                      str+='<span class="tags badge-pill badge-success">' + item.dorm + '</span>'
		                  }
		                  if(item.year != ""){
		                      str+='<span class="tags badge-pill badge-info"> Class of ' + item.year + '</span>'
		                  }
		                  str+="</article>";
		                   $(".posts").append(str);
		                    var id = "vote" + item.id; 
                            controllercounter(id, parseInt(item.votes), parseInt(item.id));
                            });
                         
		                },
		                error: function(xhr, status, error) {
                          var err = JSON.parse(xhr.responseText);
                          alert(err.Message);
                        }
		            }); 
		        }
		    </script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
