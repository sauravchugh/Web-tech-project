<?php require_once("include/db.php");?>
<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Comments</title>

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
<!-- main area starts here-->
<div style="height: 4px; background:#00bfff;"></div>
<header class="bg-secondary text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <h1><i class="fas fa-comments" style="color:#27aae1;"></i> Manage Comments</h1>
          </div>
        </div>
      </div>
    </header>


<!--hearde end here-->
    
    <section class="container py-2 mb-4">
      <div class="row" style="min-height:30px;">
        <div class="col-lg-12" style="min-height:400px;">
          <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
          <h2>Un-Approved Comments</h2>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>No. </th>
                <th>Date&Time</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Aprove</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>
          <?php
    
          $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
          $Execute =$connect->query($sql);
          $SrNo = 0;
          while ($DataRows=$Execute->fetch()) {
            $CommentId = $DataRows["id"];
            $DateTimeOfComment = $DataRows["datetime"];
            $CommenterName = $DataRows["name"];
            $CommentContent= $DataRows["comment"];
            $CommentPostId = $DataRows["post_id"];
            $SrNo++;
          ?>
          <tbody>
            <tr>
              <td><?php echo htmlentities($SrNo); ?></td>
              <td><?php echo htmlentities($DateTimeOfComment); ?></td>
              <td><?php echo htmlentities($CommenterName); ?></td>
              <td><?php echo htmlentities($CommentContent); ?></td>
              <td> <a href="ApproveComments.php?id=<?php echo $CommentId;?>" class="btn btn-success">Approve</a>  </td>
              <td> <a href="DeleteComments.php?id=<?php echo $CommentId;?>" class="btn btn-danger">Delete</a>  </td>
              <td style="min-width:140px;"> <a class="btn btn-primary"href="full_post.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a> </td>
            </tr>
          </tbody>
          <?php } ?>
          </table>
          <h2>Approved Comments</h2>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>No. </th>
                <th>Date&Time</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Approved by</th>
                <th>Revert</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>
          <?php
      
          $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
          $Execute =$connect->query($sql);
          $SrNo = 0;
          while ($DataRows=$Execute->fetch()) {
            $CommentId         = $DataRows["id"];
            $DateTimeOfComment = $DataRows["datetime"];
            $CommenterName     = $DataRows["name"];
            $ApprovedBy        = $DataRows["approvedby"];
            $CommentContent    = $DataRows["comment"];
            $CommentPostId     = $DataRows["post_id"];
            $SrNo++;
          ?>
          <tbody>
            <tr>
              <td><?php echo htmlentities($SrNo); ?></td>
              <td><?php echo htmlentities($DateTimeOfComment); ?></td>
              <td><?php echo htmlentities($CommenterName); ?></td>
              <td><?php echo htmlentities($CommentContent); ?></td>
              <td><?php echo htmlentities($ApprovedBy); ?></td>
              <td style="min-width:140px;"> <a href="DisApproveComments.php?id=<?php echo $CommentId;?>" class="btn btn-warning">Dis-Approve</a>  </td>
              <td> <a href="DeleteComments.php?id=<?php echo $CommentId;?>" class="btn btn-danger">Delete</a>  </td>
              <td style="min-width:140px;"> <a class="btn btn-primary"href="full_post.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a> </td>
            </tr>
          </tbody>
          <?php } ?>
          </table>
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