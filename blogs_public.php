<?php require_once("include/db.php"); ?>
<?php require_once("include/function.php"); ?>
<?php require_once("include/session.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//Confirm_Login_public();
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
           	<a href="blogs_public.php" class="nav-link">Home</a>
           </li>
           <li class="nav-item">
           	<a href="#" class="nav-link">About us</a>
           </li>
           <li class="nav-item">
           	<a href="blogs_public.php" class="nav-link">Blogs</a>
           </li>
           <li class="nav-item">
           	<a href="#" class="nav-link">Contact us</a>
           </li>
           <li class="nav-item">
           	<a href="#" class="nav-link">Features</a>
           </li>
          
			
		</ul>
		<ul class="navbar-nav ml-auto"> 
      <form class="form-inline d-none d-sm-block" action="blogs_public.php">
          <div class="form-group">
          <input class="form-control mr-2" type="text" name="search" placeholder="Search here"value="">
          <button  class="btn btn-primary" name="SearchButton">Go</button>
          </div>
        </form>
			
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


<!-- header----->
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

<div class="container">
  <div class="row mt-4">
    <!-- main area-->

    <div class="col-sm-8">
     <div class="mb-3 ">
     
      </div>
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
        }// query when page =1 is active
        elseif (isset($_GET["page"])) 
        {
            $Page = $_GET["page"];
            if($Page==0||$Page<1)
            {
            $ShowPostFrom=0;
          }
          else{
            $ShowPostFrom=($Page*5)-5;
          }
            $sql ="SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
            $stmt=$connect->query($sql);
          }// Query When Category is active in URL Tab
          elseif (isset($_GET["category"])) {
            $Category = $_GET["category"];
            $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
            $stmt=$connect->query($sql);
          }
          else
        { // by default search query
           $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,12";
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
              <small class="text-muted">Category: <span class="text-dark"> <a href="blogs.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a></span> & Written by <span class="text-dark"> <a href="MyProfile.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>

               <span style="float:right;" class="badge badge-dark text-light">Comments:
               <?php echo ApproveCommentsAccordingtoPost($PostId);?> </span>
               <hr>
               <p class="card-text"><?php if (strlen($PostDescription)>250) { $PostDescription = substr($PostDescription,0,250)."...";} echo htmlentities($PostDescription); ?></p>
               <a href="full_post.php?id=<?php echo htmlentities($PostId); ?>" style="float:right;">
                <span class="btn btn-info">Read More &rang;&rang; </span>
              </a>
            
          </div>
        </div>
        <br>
      <?php }?>
        <!-- Pagination algo  -- >
          <nav>
            <ul class="pagination pagination-lg">
              <!-- Creating Backward Button -->
              <?php if( isset($Page) ) {
                if ( $Page>1 ) {?>
             <li class="page-item">
                 <a href="blogs_public.php?page=<?php  echo $Page-1; ?>" class="page-link">&laquo;</a>
               </li>
             <?php } }?>
            <?php
            
            $sql           = "SELECT COUNT(*) FROM posts";
            $stmt          = $connect->query($sql);
            $RowPagination = $stmt->fetch();
            $TotalPosts    = array_shift($RowPagination);
            // echo $TotalPosts."<br>";
            $PostPagination=$TotalPosts;
            $PostPagination=ceil($PostPagination);
            // echo $PostPagination;
            for ($i=1; $i <=$PostPagination ; $i++) {
              if( isset($Page) ){
                if ($i == $Page) {  ?>
              <li class="page-item active">
                <a href="blogs_public.php?page=<?php  echo $i; ?>" class="page-link"><?php  echo $i; ?></a>
              </li>
              <?php
            }else {
              ?>  <li class="page-item">
                  <a href="blogs_public.php?page=<?php  echo $i; ?>" class="page-link"><?php  echo $i; ?></a>
                </li>
            <?php  }
          } } ?>
          <!-- Creating Forward Button -->
          <?php if ( isset($Page) && !empty($Page) ) {
            if ($Page+1 <= $PostPagination) {?>
         <li class="page-item">
             <a href="blogs_public.php?page=<?php  echo $Page+1; ?>" class="page-link">&raquo;</a>
           </li>
         <?php } }?>
            </ul>
          </nav>
        </div>

        
    
      <!-- main area ends here-->

      <!-- side area-->

    <?php require_once("footer.php");?>
      <!--side area ends-->
      
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
          <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="http://pirtpal.com/" target="_blank"> This site is made using php,bootstrap and mysql. For more information you can contact pirtpal.bjf25@gamil.com or ekjotsingh.be18cse@pec.edu.in</a></p>
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