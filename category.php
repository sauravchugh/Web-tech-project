<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login();?>
<?php
if(isset($_POST['submit']))
{   

  $admin=$_SESSION["UserName"];;
// this is for datatime coloumn
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime=time();
   $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  $title=$_POST['title'];
  if(empty($title))
  {
    $_SESSION['err_msg']="Please fill all fields";
    redirect_to("category.php");
  }
  elseif (strlen($title)<3 || strlen($title)>49) {
    $_SESSION['err_msg']="Title should be in range of 3-50 charecters ";
    redirect_to("category.php");
  }
  else
  {
      $sql="INSERT INTO category(title,author,datetime) VALUES(:title,:author,:datetime)";
      $stmt=$connect->prepare($sql);
      $stmt->bindValue(':title',$title);
      $stmt->bindValue(':author',$admin);
      $stmt->bindValue(':datetime',$DateTime);
      $execute=$stmt->execute();
      if($execute)
      {
        $_SESSION['succ_msg']="Title added succesfully";
        redirect_to("posts.php");
      }
      else
      {
        $_SESSION['err_msg']="Something went wrong. Try again!";
    redirect_to("category.php");
      }
  }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Categories</title>

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
           	<a href="blogs_public.php" class="nav-link">Live Blogs</a>
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
            <h1><i class="fas fa-edit" style="color: #8fd234"></i>Manage Categories</h1>
        
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
      <form class="" action="category.php" method="post">
        <div class="card bg-secondary text-light mb-3">
          <div class="card-header">
            <h1>Add new category</h1>
          </div>
          <div class="card-body bg-dark"> 
            <div class="form-group">
              <label for="title"> <span class="fieldinfo"> Category Title: </span></label>
               <input class="form-control" type="text" name="title" id="title" placeholder="Type title here" value="">
              
            </div>
            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-success btn-block">
                  <i class="fas fa-check"></i> Publish
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>


      <h2>Existing Categories</h2>
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>No. </th>
            <th>Date&Time</th>
            <th> Category Name</th>
            <th>Creator Name</th>
            <th>Action</th>
          </tr>
        </thead>
      <?php
      
      $sql = "SELECT * FROM category ORDER BY id desc";
      $Execute =$connect->query($sql);
      $SrNo = 0;
      while ($DataRows=$Execute->fetch()) {
        $CategoryId = $DataRows["id"];
        $CategoryDate = $DataRows["datetime"];
        $CategoryName = $DataRows["title"];
        $CreatorName= $DataRows["author"];
        $SrNo++;
      ?>
      <tbody>
        <tr>
          <td><?php echo htmlentities($SrNo); ?></td>
          <td><?php echo htmlentities($CategoryDate); ?></td>
          <td><?php echo htmlentities($CategoryName); ?></td>
          <td><?php echo htmlentities($CreatorName); ?></td>
          <td> <a href="DeleteCategory.php?id=<?php echo $CategoryId;?>" class="btn btn-danger">Delete</a>  </td>

      </tbody>
      <?php } ?>
      </table>
    </div>
  </div>

</section>


      
    </div>
    
  </div>
</section>
<!--main area ends-->
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