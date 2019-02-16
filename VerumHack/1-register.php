<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <meta name="description" content="Verum Registration">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css"/>
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="registering.js"></script>
          <link rel="shortcut icon" href="verum.ico">

</head>
  <body class="is-preload">
    <div id="wrapper">

  <!-- [HEADER] -->
<header id="header">
		<a href="index.php" class="logo">Verum</a>
	</header>
  <!-- [BODY] -->
    <body class="is-preload">

    <div id="main">
        <div class="row justify-content-center">
          <div class="col-md-3" style="padding-left:0px;" align="center">  
          <h3>Register</h3>
            <form onsubmit="return register();">
            <input type="text" id="name" name="name" placeholder="Full name" required autofocus><br>
            <input type="email" id="email" name="email" placeholder="Email" required><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required><br>
            <label for="dorm">Dorm: </label>
            <select id="dorm" name="dorm">
              <option value=""></option>
              <option value="Otero">Otero</option>
              <option value="Toyon">Toyon</option>
              <option value="The Row">The Row</option>
              <option value="Crothers">Crothers</option>
              <option value="Roble">Roble</option>
              <option value="Meier">Meier</option>
              <option value="FloMo">FloMo</option>
              <option value="Serra">Serra</option>
              <option value="Donner">Donner</option>
              <option value="Rinconada">Rinc</option>
              <option value="JRO">Jro</option>
              <option value="Trancos">Trancos</option>
              <option value="Okada">Okada</option>
              <option value="Soto">Soto</option>
            </select>
            <label for="year">Year: </label>
            <select id="year" name="year">
              <option value=""></option>
              <option value="19">'19</option>
              <option value="20">'20</option>
              <option value="21">'21</option>
              <option value="22">'22</option>
            </select>
            <br>
            <input type="submit" value="Register"/>
            </form>
  </div>
  </div>
</div>
</body>
</html>
