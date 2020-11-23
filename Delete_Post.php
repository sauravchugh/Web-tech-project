<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php Confirm_Login();?>
<?php
$SearchQueryParameter = $_GET['id'];

$sql  = "SELECT * FROM posts WHERE id=$SearchQueryParameter";
       $stmt = $connect ->query($sql);
       while ($DataRows=$stmt->fetch()) {
         $TitleToBeDeleted    = $DataRows['title'];
         $CategoryToBeDeleted = $DataRows['category'];
         $ImageToBeDeleted    = $DataRows['image'];
         $PostToBeDeleted     = $DataRows['post'];
         // code...
       }



if(isset($_POST['submit']))
{  
  
     $sql="DELETE FROM posts WHERE id=$SearchQueryParameter";
      $execute=$connect->query($sql);

      if($execute)
      {
        $directory_to_delete_image="upload/$ImageToBeDeleted";
        unlink($directory_to_delete_image);// to deltet imag ein our upload folder
        $_SESSION['succ_msg']="Post deleted  succesfully";
        redirect_to("posts.php");
      }
      else
      {
        $_SESSION['err_msg']="Something went wrong. Try again!";
    redirect_to("posts.php");
      }
  
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Delete Post</title>

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
               <a href="profile.php" class="nav-link"><i class="fas fa-user-friends text-success"></i> My Profile</a><!--font aewsome-->
           </li>
           <li class="nav-item">
           	<a href="dashboard.php" class="nav-link">Dashboard</a>
           </li>
           <li class="nav-item">
           	<a href="Posts.php" class="nav-link">Posts</a>
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
            <h1><i class="fas fa-edit" style="color: #8fd234"></i>Delete Post</h1>
        
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
       // Fetching Existing Content according to our
    
       
       ?>
      <form class="" action="Delete_Post.php?id= <?php echo $SearchQueryParameter;?>" method="post" enctype="multipart/form-data"><!-- entype for images-->
        <div class="card bg-secondary text-light mb-3">
         
          <div class="card-body bg-dark"> 
            <div class="form-group">
              <label for="title"> <span class="fieldinfo"> Post Title: </span></label>
               <input disabled class="form-control" type="text" name="posttitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeDeleted?>">
              
            </div>
            <div class="form-group">
                 <span class="fieldinfo">Category: </span>
                 <?php echo $CategoryToBeDeleted;  ?>
                 <br>
              
            </div>
            <div class="form-group mb-1">
              <span class="fieldinfo">Image: </span>
              <img  class="mb-1" src="upload/<?php echo $ImageToBeDeleted;?>" width="170px"; height="70px"; >

             
            </div>
            <div class="form-group">
              <label for="post"> <span class="fieldinfo"> Post: </span></label>
              <textarea disabled class="form-control" id="post" name="PostDescription" rows="8" cols="80" >
                <?php echo $PostToBeDeleted; ?>
              </textarea>
            </div>


            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-danger btn-block">
                  <i class="fas fa-trash"></i> Delete
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