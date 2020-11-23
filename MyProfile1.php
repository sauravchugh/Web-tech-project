<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php  
// Fetching the existing Admin Data Start
$AdminId = $_SESSION["UserId"];
global $connect;

$sql  = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt =$connect->query($sql);
while ($DataRows = $stmt->fetch()) {
  $ExistingName     = $DataRows['aname'];
  $ExistingUsername = $DataRows['username'];
  $ExistingHeadline = $DataRows['aheadline'];
  $ExistingBio      = $DataRows['abio'];
  $ExistingImage    = $DataRows['aimage'];
}
// Fetching the existing Admin Data End
if(isset($_POST["Submit"])){
  $AName     = $_POST["Name"];
  $AHeadline = $_POST["Headline"];
  $ABio      = $_POST["Bio"];
  $Image     = $_FILES["Image"]["name"];
  $Target    = "images/".basename($_FILES["Image"]["name"]);
if (strlen($AHeadline)>30) {
    $_SESSION["err_msg"] = "Headline Should be less than 30 characters";
    Redirect_to("MyProfile.php");
  }elseif (strlen($ABio)>500) {
    $_SESSION["err_msg"] = "Bio should be less than than 500 characters";
    Redirect_to("MyProfile.php");
  }else{
    // Query to Update Admin Data in DB When everything is fine
    
    if (!empty($_FILES["Image"]["name"])) {
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
              WHERE id='$AdminId'";
    }else {
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
              WHERE id='$AdminId'";
    }
    $Execute= $connect->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if($Execute){
      $_SESSION["succ_msg"]="Details Updated Successfully";
      Redirect_to("MyProfile.php");
    }else {
      $_SESSION["err_msg"]= "Something went wrong. Try Again !";
      Redirect_to("MyProfile.php");
    }
  }
} //Ending of Submit Button If-Condition
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>My Profile</title>

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
               <a href="MyProfile.php" class="nav-link"><i class="fas fa-user-friends text-success"></i> My Profile</a><!--font aewsome-->
           </li>
           <li class="nav-item">
           	<a href="dashboard.php" class="nav-link">Dashboard</a>
           </li>
           <li class="nav-item">
           	<a href="posts.php" class="nav-link">Posts</a>
           </li>
           <li class="nav-item">
           	<a href="category.php" class="nav-link">Categories</a>
           </li>
           <li class="nav-item">
           	<a href="admins.php" class="nav-link">Manage Admins</a>
           </li>
           <li class="nav-item">
           	<a href="comments.php" class="nav-link">Comments</a>
           </li>
           <li class="nav-item">
           	<a href="blogs.php" class="nav-link">Live Blogs</a>
           </li>
			
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item"><a href="logout.php" class="nav-link"><i style="color:red;" class="fas fa-user-lock"></i> Log Out</a></li>
			
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
          <!--  <h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $ExistingUsername; ?></h1>
          <small><?php echo $ExistingHeadline; ?></small>-->
          </div>
        </div>
      </div>
    </header>

<!--main area-->
<section class="container py-2 mb-4">

  <div class ="row">
    <!-- left area-->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header bg-dark text-light">
       <!--   <h3> <?php echo $ExistingName; ?></h3>-->
        </div>
        <div class="card-body">
          <img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
          <div class="">
            <?php echo "Welcome Pirtpal"; ?>  </div>

        </div>

      </div>

    </div>
    <!--right area-->
       <div class="col-md-9" style="min-height:400px;">
    <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data"><!-- entype for images-->
         <div class="card bg-dark text-light">
          <div class="card-header bg-secondary text-light">
            <h4>Edit Profile</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
               <input class="form-control" type="text" name="Name" id="title" placeholder="Your name" value="">
            </div>
            <div class="form-group">
               <input class="form-control" type="text" id="title" placeholder="Headline" name="Headline">
               <small class="text-muted"> Add a professional headline like, 'Engineer' at XYZ or 'Architect' </small>
               <span class="text-danger">Not more than 30 characters</span>
            </div>
            <div class="form-group">
              <textarea  placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"></textarea>
            </div>

            <div class="form-group">
              <div class="custom-file">
              <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
              <label for="imageSelect" class="custom-file-label">Select Image </label>
              </div>
            </div>



            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="Submit" class="btn btn-success btn-block">
                  <i class="fas fa-check"></i> Publish
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
      
    </div>
    
  </div>
</section>

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