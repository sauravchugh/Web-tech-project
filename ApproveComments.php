<?php require_once("include/db.php"); ?>
<?php require_once("include/function.php"); ?>
<?php require_once("include/session.php"); ?>
<?php
if(isset($_GET["id"])){
  $SearchQueryParameter = $_GET["id"];
  
  $Admin = $_SESSION["AdminName"];
  $sql = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
  $Execute = $connect->query($sql);
  if ($Execute) {
    $_SESSION["succ_msg"]="Comment Approved Successfully ! ";
    redirect_to("comments.php");
    // code...
  }else {
    $_SESSION["err_msg"]="Something Went Wrong. Try Again !";
    redirect_to("comments.php");
  }
}
?>
