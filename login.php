<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php
if(isset($_SESSION["UserId"])){
  redirect_to("dashboard.php");
}

if (isset($_POST["Submit"])) {
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  if (empty($UserName)||empty($Password)) {
    $_SESSION["err_msg"]= "All fields must be filled out";
    redirect_to("login.php");
  }else {
    // code for checking username and password from Database
    $Found_Account=Login_Attempt($UserName,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"]=$Found_Account["id"];
      $_SESSION["UserName"]=$Found_Account["username"];
      $_SESSION["AdminName"]=$Found_Account["aname"];
      $_SESSION["succ_msg"]= "Wellcome ".$_SESSION["AdminName"]."!";
      if (isset($_SESSION["TrackingURL"])) {
        redirect_to($_SESSION["TrackingURL"]);
      }else{
      redirect_to("dashboard.php");
    }
    }else {
      $_SESSION["err_msg"]="Incorrect Username/Password";
      redirect_to("login.php");
    }
  }
}


?>



<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<!--<h1 class="display-1">No error</h1>-->
<!-- NAvgation -->
<div style="height: 4px; background:#00bfff;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container "  >
		<a href="#" class="navbar-brand">pirtpal.com</a>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseid">
        <span class="navbar-toggler-icon"></span>
      </button>
		<div class="collapse navbar-collapse" id="navbarcollapseid">		
			
		</div>
	</div>
</nav>
<!-- nav ends here-->

<div style="height: 4px; background:#00bfff;"></div>
<header class="bg-secondary text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
      
          </div>
        </div>
      </div>
    </header>

<!--header ends--

  main area starts-->
   <section class="container py-2 mb-4">
      <div class="row">
        <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
          <br><br><br>
          <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>

          <div class="card bg-secondary text-light">
            <div class="card-header">
              <h4>Wellcome Back !</h4>
              </div>
              <div class="card-body bg-dark">
              <form class="" action="login.php" method="post">
                <div class="form-group">
                  <label for="username"><span class="fieldinfo">Username:</span></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white bg-info"> <i class="fas fa-user"></i> </span>
                    </div>
                    <input type="text" class="form-control" name="Username" id="username" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password"><span class="fieldinfo">Password:</span></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-white bg-info"> <i class="fas fa-lock"></i> </span>
                    </div>
                    <input type="password" class="form-control" name="Password" id="password" value="">
                  </div>
                </div>
                <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
              </form>

            </div>

          </div>

        </div>

      </div>

    </section>

  <!-- main area ends here-->
<!-- footer starts here-->
 <footer class="bg-dark text-white">
      <div class="container">
        <div class="row">
          <div class="col">
          <p class="lead text-center">Theme By | Pirtpal Singh| <span id="year"></span> &copy; ----All right Reserved.</p>
          <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="http://pirtpal.com/" target="_blank"> This site is made using php,bootstrap and mysql. For more information you can contact pirtpal.bjf25@gamil.com</a></p>
           </div>
         </div>
      </div>
    </footer>
        <div style="height:4px; background:pink;"></div>
        <!--footer ends here-->








<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script>
  $('#year').text(new Date().getFullYear());
</script>
</body>
</html>