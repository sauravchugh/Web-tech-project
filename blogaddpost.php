<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>

<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
?>
<?php
if(isset($_POST['submit']))
{  
$posttitle=$_POST["posttitle"];
$category=$_POST['category'];
$image=$_FILES['image']['name'];// we are just storing the name of image in our db
$directory_to_store="upload/".basename($_FILES['image']['name']);
$PostDescription=$_POST['PostDescription']; 

  $admin=$_SESSION["UserName"];
// this is for datatime coloumn
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime=time();
   $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

 // $title=$_POST['posttitle'];
  if(empty($posttitle))
  {
    $_SESSION['err_msg']="POST Title can not be empty";
    redirect_to("addpost.php");
  }
  elseif (strlen($posttitle)<6 || strlen($posttitle)>300) {
    $_SESSION['err_msg']="Title should be in range of 6-300 charecters ";
    redirect_to("addpost.php");
  }
  else
  {
      $sql="INSERT INTO posts(datetime,title,category,author,image,post) VALUES(:datetime,:title,:category,:author,:image,:post)";
      $stmt=$connect->prepare($sql);
      $stmt->bindValue(':title',$posttitle);
      $stmt->bindValue(':author',$admin);
      $stmt->bindValue(':datetime',$DateTime);
      $stmt->bindValue(':category',$category);
      $stmt->bindValue(':image',$image);
      $stmt->bindValue(':post',$PostDescription);
      $execute=$stmt->execute();
      move_uploaded_file($_FILES['image']['tmp_name'],$directory_to_store);// to store the image

      if($execute)
      {
        $_SESSION['succ_msg']="Title added succesfully";
        redirect_to("addpost.php");
      }
      else
      {
        $_SESSION['err_msg']="Something went wrong. Try again!";
    redirect_to("addpost.php");
      }
  }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Posts</title>

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
      <form class="form-inline d-none d-sm-block" action="blogs.php">
          <div class="form-group">
          <input class="form-control mr-2" type="text" name="search" placeholder="Search here"value="">
          <button  class="btn btn-primary" name="SearchButton">Go</button>
          </div>
        </form>
      
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
            <h1><i class="fas fa-edit" style="color: #8fd234"></i>Add new posts</h1>
        
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
      <form class="" action="addpost.php" method="post" enctype="multipart/form-data"><!-- entype for images-->
        <div class="card bg-secondary text-light mb-3">
         
          <div class="card-body bg-dark"> 
            <div class="form-group">
              <label for="title"> <span class="fieldinfo"> Post Title: </span></label>
               <input class="form-control" type="text" name="posttitle" id="title" placeholder="Type title here" value="">
              
            </div>
            <div class="form-group">
              <label for="categoryTitle"> <span class="fieldinfo"> Chose Category </span></label>
               <select class="form-control" id="CategoryTitle"  name="category">
                <?php
                 //Fetchinng all the categories from category table
                 global $connect;
                 $sql = "SELECT id,title FROM category";
                 $stmt = $connect->query($sql);
                 while ($DataRows = $stmt->fetch()) {
                   $Id = $DataRows["id"];
                   $CategoryName = $DataRows["title"];
                  ?>
                  <option> <?php echo $CategoryName; ?></option>
                  <?php } ?>
              
                 
               </select>
            </div>
            <div class="form-group">
              <div class="custom-file">
                  <label for="imageSelect" class="custom-file-label">Select Image </label>
              <input class="custom-file-input" type="File" name="image" id="imageSelect" value="">
            
              </div>
            </div>
            <div class="form-group">
              <label for="post"> <span class="FieldInfo"> Post: </span></label>
              <textarea class="form-control" id="post" name="PostDescription" rows="8" cols="80"></textarea>
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