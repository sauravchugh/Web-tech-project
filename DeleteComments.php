<?php require_once("include/db.php"); ?>
<?php require_once("include/function.php"); ?>
<?php require_once("include/session.php"); ?>
<?php
if(isset($_GET["id"])){
  $SearchQueryParameter = $_GET["id"];
  $sql = "DELETE FROM comments  WHERE id='$SearchQueryParameter'";
  $Execute = $connect->query($sql);
  if ($Execute) {
    $_SESSION["succ_msg"]="Comment Deleted Successfully ! ";
    redirect_to("comments.php");
    // code...
  }else {
    $_SESSION["err_msg"]="Something Went Wrong. Try Again !";
    redirect_to("comments.php");
  }
}
?>
