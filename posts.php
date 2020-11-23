<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>

<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
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
<div style="height: 10px; background:#00bfff;"></div>
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
          <h1><i class="fas fa-blog" style="color: #8fd234"></i> Blog Posts</h1>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="addpost.php" class="btn btn-primary btn-block">
              <i class="fas fa-edit"></i> Add New Post
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="category.php" class="btn btn-info btn-block">
              <i class="fas fa-folder-plus"></i> Add New Category
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="admins.php" class="btn btn-warning btn-block">
              <i class="fas fa-user-plus"></i> Add New Admin
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="comments.php" class="btn btn-success btn-block">
              <i class="fas fa-check"></i> Approve Comments
            </a>
          </div>
        </div>
      </div>
    </header>
    <!-- header ends here-->

<!-- main area starts here-->
   <section class="container py-2 mb-4">
      <div class="row">
        <div class="col-lg-12">
          <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
          <table class="table table-striped table-hover">
            <thead class="thead-dark ">
            <tr>
              <th>S.no</th>
              <th  >Title</th>
              <th>Category</th>
              <th>Date&Time</th>
              <th>Author</th>
              <th>Image</th>
              <th>Comments</th>
              <th>Action</th>
              <th>Live Preview</th>
            </tr>
            </thead>
                    <?php
        
                    $sql  = "SELECT * FROM posts ORDER BY id desc";
                    $stmt = $connect->query($sql);
                    $Sr = 0;
                    while ($DataRows = $stmt->fetch()) {
                      $Id        = $DataRows["id"];
                      $DateTime  = $DataRows["datetime"];
                      $PostTitle = $DataRows["title"];
                      $Category  = $DataRows["category"];
                      $Admin     = $DataRows["author"];
                      $Image     = $DataRows["image"];
                      $PostText  = $DataRows["post"];
                      $Sr++;
                    ?>
  <tbody>
        <tr>
          <td>
              <?php echo $Sr; ?>
          </td>
          <td>
              <?php
                  if(strlen($PostTitle)>24){$PostTitle= substr($PostTitle,0,11).'...';}
                   echo $PostTitle;
               ?>
           </td>
           <td>
              <?php
                  if(strlen($Category)>15){$Category= substr($Category,0,11).'...';}
                   echo $Category ;
               ?>
           </td>
           <td>
              <?php
                  if(strlen($DateTime)>11){$DateTime= substr($DateTime,0,11).'...';}
                     echo $DateTime ;
              ?>
          </td>
          <td>
              <?php
                  if(strlen($Admin)>15){$Admin= substr($Admin,0,6).'...';}
                     echo $Admin ;
               ?>
          </td>
              <td><img src="upload/<?php echo $Image ; ?>" width="170px;" height="50px"></td>
           <td>
                  <?php $Total = ApproveCommentsAccordingtoPost($Id);
                  if ($Total>0) {
                    ?>
                    <span class="badge badge-success">
                      <?php
                    echo $Total; ?>
                    </span>
                      <?php  }  ?>
                <?php $Total = DisApproveCommentsAccordingtoPost($Id);
                if ($Total>0) {
                                ?>
                  <span class="badge badge-danger">
                    <?php
                  echo $Total;  ?>
                  </span>
                    <?php  }    ?>
              </td>
              <td>
           

              <td>
                <a href="Edit_Post.php?id=<?php echo $Id; ?>"><span class="btn btn-warning ">Edit</span></a>
                <a href="Delete_Post.php?id=<?php echo $Id; ?>"><span class="btn btn-danger ">Delete</span></a>
              </td>
              <td>
                <a href="full_post.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
              </td>
                </tr>
                </tbody>
        <?php } ?>   <!--  Ending of While loop -->
          </table>
        </div>
      </div>
    </section>
<!-- main ends here-->
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