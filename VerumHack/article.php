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
$username = $_GET['user'];
$pid = (int) $_GET['posters'];
$stmt = $con->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $pid );
$stmt->execute();
$seeql = $stmt->get_result();
$article = $seeql->fetch_assoc();
$sql = $con->prepare("SELECT * FROM votes WHERE post_id= ? AND user_id = ? ORDER BY total_votes DESC");
    if(isset($_SESSION['user'])){ 
        $sql->bind_param("ii", $pid, $_SESSION['user'] );
        $sql->execute();
        $resvote = $sql->get_result();    
                $val = $resvote->fetch_assoc();
    }
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Article - Verum</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	    <script src="jquery.min.js"></script>
	    <script src="assets/upvote/upvote.vanilla.js"></script>
		<script src="assets/upvote/upvote.jquery.js"></script>
        <script src="upvotefile.js"></script>
        <link rel="shortcut icon" href="verum.ico">

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
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<a href="index.php" class="logo">Verum</a>
					</header>


				<!-- Main -->
					<div id="main">

						<!-- Post -->
							<section class="post">
								<header class="major">
									<span class="date"><?php $adate = $article['date'];
									echo $adate;?></span>
									<div id="devote" style = "float:left" class="upvote">
                                     <a class="upvote <?php  if($val['vote_type'] == 1){echo "upvote-on"; }?>"></a>
                                     <span class="count">0</span>
                                     <a class="downvote <?php if($val['vote_type'] == 2){ echo "downvote-on"; }?>"></a>
                                     <a class="star"></a>
                                 </div>
                                 <script>
                                     var id = "devote";
                                    var votes = parseInt(<?php echo $article['votes'];?>);
                                    var realid = parseInt(<?php echo $article['id'];?>);
                                    controllercounter(id, votes, realid);
                                 </script>
									<h2><?php echo $article['title'];?></h2>
									<h4><?php echo "By: ", $article['author'];?></h4>
								</header>

								<!-- Text stuff -->
									<p><?php
									$string = $article['post'];
									echo  nl2br($string)?></p>
                                <div class="col-12">
                                        <hr>
                                        <h3>Comments</h3>
                                        <br>
                                        <textarea id = "message" onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"
												name="article" value="" id = "article" placeholder="Join the Discussion..." rows="3"></textarea>
										<div class="col-12">
										    <br>
											<ul class="actions">
												<li><button id = "commentsub" />Comment</button>
											</ul>
										</div>
                                        <article id = "cment">
                                           <br>
                                            
                                        </article>
				<!-- Footer -->

			</div>

		<!-- Scripts -->

		    <script type = "text/javascript">
                var id = parseInt(<?php echo $article['id'];?>);
                console.log("lwef");
                getComments();
                var namez = <?=json_encode($username);?>;
                <?php if(isset($_SESSION['user'])){ ?>
                    $("#commentsub").click(function(e){
                        var message = $("#message").val().trim();
                        if(message.length > 10){
                            $("#message").val('');
                            $.ajax({
                                url : "comment.php",
                                type : "POST",
                                async: false,
    		                    data: {id:id, name:namez, message:message},
                                error: function() {
                                   alert('Error');
                                },
                                success : function(data) {
                                    var str = '<h5>' + namez +'</h5> <p>' + message +'</p> <hr>';
                                     $("#cment").append(str);

                                }
                            });
                        } else{
                            alert("Please make sure your comment is at least 10 characters.");
                            $("#message").val('');

                        }
                         }); 


                <?php } if(!isset($_SESSION['user'])) {?>
                     $("#commentsub").click(function(e){
                        $("#message").val('');
                         alert("You must be logged in to comment");
                     }); 
                    <?php } ?>
                 function getComments() {
		            $.ajax({
		              url: "getcomments.php",  
		              method: "POST",
		              async: false,
		              data: {id:id},
                      dataType: "JSON",                   
                      success: function(data)
                      { 
                        $.each(data, function(i, item) {
                            var str = '<h5>' + item.Name +'</h5> <p>' + item.comment +'</p> <hr>';
                            $("#cment").append(str);
                        });

                      }
                    
		            }); 
            }
		    </script>
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
