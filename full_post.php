<?php require_once("include/db.php"); ?>
<?php require_once("include/function.php"); ?>
<?php require_once("include/session.php"); ?>
<?php 
$SearchQueryParameter=$_GET['id'] ;
?>
<?php
if(isset($_POST["Submit"])){
  $Name    = $_POST["CommenterName"];
  $Email   = $_POST["CommenterEmail"];
  $Comment = $_POST["CommenterThoughts"];
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Name)||empty($Email)||empty($Comment)){
    $_SESSION["err_msg"]= "All fields must be filled out";
    Redirect_to("full_post.php?id={$SearchQueryParameter}");
  }elseif (strlen($Comment)>3000) {
    $_SESSION["err_msg"]= "Comment length should be less than 3000 characters";
    Redirect_to("full_post.php?id={$SearchQueryParameter}");
  }else{
    // Query to insert comment in DB When everything is fine
    
    $sql  = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
    $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
    $stmt = $connect->prepare($sql);
    $stmt -> bindValue(':dateTime',$DateTime);
    $stmt -> bindValue(':name',$Name);
    $stmt -> bindValue(':email',$Email);
    $stmt -> bindValue(':comment',$Comment);
    $stmt -> bindValue(':postIdFromURL',$SearchQueryParameter);
    $Execute = $stmt -> execute();
    //var_dump($Execute);
    if($Execute){
      $_SESSION["succ_msg"]="Comment Submitted Successfully";
      Redirect_to("full_post.php?id={$SearchQueryParameter}");
    }else {
      $_SESSION["succ_msg"]="Something went wrong. Try Again !";
      Redirect_to("full_post.php?id={$SearchQueryParameter}");
    }
  }
} //Ending of Submit Button If-Condition
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog Page</title>

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
          <h1><i class="fas fa-blog" style="color: #8fd234"></i>All recent posts </h1>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="blogaddpost.php" class="btn btn-primary btn-block">
              <i class="fas fa-edit"></i> Add New Post
            </a>
          </div>
          
         
         
        </div>
      </div>
    </header>
    <!-- header ends here-->

<!-- head----->
<div class="container">
  <div class="row mt-4">

    <!-- main area-->

    <div class="col-sm-8">
      
      
         
         
         <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
        <?php
        if(isset($_GET["SearchButton"]))
        {
            $search = $_GET["search"];
            $sql = "SELECT * FROM posts
            WHERE datetime LIKE :search
            OR title LIKE :search
            OR category LIKE :search
            OR post LIKE :search";
            $stmt = $connect->prepare($sql);
            $stmt->bindValue(':search','%'.$search.'%');
            $stmt->execute();
        }
        else
        { // by default search query
          $PostIdFromURL = $_GET["id"];
          if (!isset($PostIdFromURL)) {
            $_SESSION["err_msg"]="Bad request";
            redirect_to("blogs.php");
          }
           $sql="SELECT * FROM posts WHERE id=$PostIdFromURL";
           $stmt=$connect->query($sql);
        }
        while ($DataRows=$stmt->fetch()) {
            $PostId          = $DataRows["id"];
            $DateTime        = $DataRows["datetime"];
            $PostTitle       = $DataRows["title"];
            $Category        = $DataRows["category"];
            $Admin           = $DataRows["author"];
            $Image           = $DataRows["image"];
            $PostDescription = $DataRows["post"];
        
        ?>
        <div class="card">
          <img src="upload/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
          <div class="card-body">
             <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
               <small class="text-muted"> Written By:<?php echo $Admin ?> on <?php echo htmlentities($DateTime)?></small>
              
               <hr>
               <p class="card-text"><?php echo htmlentities($PostDescription); ?></p>
               
            
          </div>
        </div>
      <?php }?>
      <!-- comment part start here-->
      <!-- fectching existing comment-->
     <span style="color:black; font-size: 25px; font-weight: 20px;">Comments</span>
          <br><br>
      <?php
      
        $sql  = "SELECT * FROM comments
         WHERE post_id='$SearchQueryParameter' AND status='ON'";
        $stmt =$connect->query($sql);
        while ($DataRows = $stmt->fetch()) {
          $CommentDate   = $DataRows['datetime'];
          $CommenterName = $DataRows['name'];
          $CommentContent= $DataRows['comment'];
        ?>
        <div>
    <div class="media CommentBlock">
      <img class="d-block img-fluid align-self-start" src="images/comment.png" alt="">
      <div class="media-body ml-2">
        <h6 class="lead"><?php echo $CommenterName; ?></h6>
        <p class="small"><?php echo $CommentDate; ?></p>
        <p><?php echo $CommentContent; ?></p>
      </div>
    </div>
  </div>
  <hr>
  <?php } ?>
        
    
      <!-- fetching existing comments ens here-->

      <div class="">
        <form class="" action="full_post.php?id=<?php echo $SearchQueryParameter;?>" method="post">
          <div class="card mb-3">
            <div class="card-header">
              <h5 class="comment"> share your thought about this post</h5>
              
            </div>
            <div class="card-body">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    
                  </div>
                <input class="form-control"type="text" name="CommenterName" placeholder="Name" value="">
              </div>
              </div>

               <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelop"></i></span>
                    
                  </div>
                <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
              </div>
              </div>
               <div class="form-group">
                    <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                  </div>
              <div class="">
                    <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                  </div>
              
            </div>
          </div>
          
        </form>
      </div>
      </div>
      <!-- main area ends here-->

      <!-- side area-->
       <?php require_once("footer.php");?>

      <!--sise area ends-->
      
    </div>
  </div>
</div>

<br>

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