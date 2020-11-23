<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
?>
<?php
if(isset($_POST["submit"])){
  $UserName        = $_POST["UserName"];

  $Password        = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];
   $email=        $_POST["email"];
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
    $_SESSION["err_msg"]= "All fields must be filled out";
    redirect_to("signup.php");
  }elseif (strlen($Password)<4) {
    $_SESSION["err_msg"]= "Password should be greater than 3 characters";
    redirect_to("signup.php");
  }elseif ($Password !== $ConfirmPassword) {
    $_SESSION["err_msg"]= "Password and Confirm Password should match";
    redirect_to("signup.php");
  }elseif (CheckUserNameExistsOrNot_public($UserName)) {
    $_SESSION["err_msg"]= "Username Exists. Try Another One! ";
    redirect_to("signup.php");
  }else{
    // Query to insert new admin in DB When everything is fine
    
    $sql = "INSERT INTO signup(datetime,username,password,email) ";
     $sql .= "VALUES(:dateTime,:userName,:password,:email)";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue(':password',$Password);
    $stmt->bindValue(':email',$email);
  
    $Execute=$stmt->execute();
  
    if($Execute){
      $_SESSION["succ_msg"]="Sign up successfully";
      redirect_to("blogs_public.php");
    }else {
  
      $_SESSION["err_msg"]= "Something went wrong. Try Again !";
      redirect_to("signup.php");
    }
  }
} 
?>


<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>

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
      <ul class="navbar-nav mr-auto"> <!-- mr margin right auto-->
      
           <li class="nav-item">
            <a href="blogs.php" class="nav-link">Home</a>
           </li>
           <li class="nav-item">
            <a href="#" class="nav-link">About us</a>
           </li>
           <li class="nav-item">
            <a href="blogs.php" class="nav-link">Blogs</a>
           </li>
           <li class="nav-item">
            <a href="#" class="nav-link">Contact us</a>
           </li>
           <li class="nav-item">
            <a href="#" class="nav-link">Features</a>
           </li>
          
      
    </ul>
    <ul class="navbar-nav ml-auto"> 
      
      
    </ul>
    <ul class="navbar-nav ml-auto ">
      <li  class="nav-item"><a style="color: pink;" href="signup.php" class="nav-link"> Sign Up</a></li>
      
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a href="logout_public.php" class="nav-link"><i style="color:red;" class="fas fa-user-lock"></i> Log Out</a></li>
      
    </ul>
    </div>
  </div>
</nav>

<!-- nav ends here-->

<div style="height: 4px; background:#00bfff;"></div>
<header class="bg-secondary text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1><i class="fas fa-user" style="color: #8fd234"></i>Sign up</h1>
        
          </div>
        </div>
      </div>
    </header>

<!--main area-->
<section class="container py-2 mb-4">

  <div class ="row">
    <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
    <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <form class="" action="signup.php" method="post">
        <div class="card bg-dark text-light mb-3">
          <div class="card-header">
            <h1>New user!</h1>
          </div>
          <div class="card-body bg_signup"> 
            <div class="form-group">
              <label for="UserName"> <span class="fieldinfo1"> Username </span></label>
               <input class="form-control" type="text" name="UserName" id="UserName" value="">
            </div>

             <div class="form-group">
              <label for="email"> <span class="fieldinfo1"> Email: </span></label>
               <input class="form-control" type="email" name="email" id="email" value="">
               <small class="text-muted">*Optional</small>
            </div>

              <div class="form-group">
              <label for="Password"> <span class="fieldinfo1"> Password </span></label>
               <input class="form-control" type="password" name="Password" id="Password" value="">
            </div>

            <div class="form-group">
              <label for="ConfirmPassword"> <span class="fieldinfo1">Confirm Password</span></label>
               <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value="">
            </div>

          

            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="login_public.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back </a>
                
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-success btn-block">
                  <i class="fas fa-check"></i> Sign up
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
      
  
    </div>
  </div>

</section>


<!--main area ends here-->
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