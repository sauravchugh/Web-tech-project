<?php require_once("include/db.php"); ?>

<?php
global $connect;
function redirect_to($new_location)
{
	header("Location:".$new_location);
	exit;
}

function CheckUserNameExistsOrNot($UserName){
	global $connect;
  
  $sql    = "SELECT username FROM admins WHERE username=:userName";
  $stmt   = $connect->prepare($sql);
  $stmt->bindValue(':userName',$UserName);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}
function CheckUserNameExistsOrNot_public($UserName){
  global $connect;
  
  $sql    = "SELECT username FROM signup WHERE username=:userName";
  $stmt   = $connect->prepare($sql);
  $stmt->bindValue(':userName',$UserName);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}

function Login_Attempt($UserName,$Password){
  global $connect;
  $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
  $stmt = $connect->prepare($sql);
  $stmt->bindValue(':userName',$UserName);
  $stmt->bindValue(':passWord',$Password);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return $Found_Account=$stmt->fetch();
  }else {
    return null;
  }
}

function Login_Attempt_public($UserName,$Password){
  global $connect;
  $sql = "SELECT * FROM signup WHERE username=:userName AND password=:passWord LIMIT 1";
  $stmt = $connect->prepare($sql);
  $stmt->bindValue(':userName',$UserName);
  $stmt->bindValue(':passWord',$Password);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return $Found_Account=$stmt->fetch();
  }else {
    return null;
  }
}

function Confirm_Login(){
if (isset($_SESSION["UserId"])) {
  return true;
}  else {
  $_SESSION["err_msg"]="Login Required !";
  redirect_to("login.php");
}
}
function Confirm_Login_public(){
if (isset($_SESSION["UserId_P"])) {
  return true;
}  else {
  $_SESSION["err_msg"]="Login Required !";
  redirect_to("login_public.php");
}
}
function Confirm_Login_blogs(){
if (isset($_SESSION["UserId_P"])) {
  return true;
}  else {
  $_SESSION["err_msg"]="Login Required !";
  redirect_to("login.php");
}
}


function TotalPosts(){
  global $connect;
  $sql = "SELECT COUNT(*) FROM posts";
  $stmt = $connect->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalPosts=array_shift($TotalRows);
  echo $TotalPosts;
}

function TotalCategories(){
   global $connect;
  $sql = "SELECT COUNT(*) FROM category";
  $stmt = $connect->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalCategories=array_shift($TotalRows);
  echo $TotalCategories;
}

function TotalAdmins(){

   global $connect;
  $sql = "SELECT COUNT(*) FROM admins";
  $stmt = $connect->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalAdmins=array_shift($TotalRows);
  echo $TotalAdmins;

}

function TotalComments(){
   global $connect;
  $sql = "SELECT COUNT(*) FROM comments";
  $stmt = $connect->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalComments=array_shift($TotalRows);
  echo $TotalComments;
}

function ApproveCommentsAccordingtoPost($PostId){
   global $connect;
  $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
  $stmtApprove =$connect->query($sqlApprove);
  $RowsTotal = $stmtApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}

function DisApproveCommentsAccordingtoPost($PostId){
   global $connect;
  $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
  $stmtDisApprove =$connect->query($sqlDisApprove);
  $RowsTotal = $stmtDisApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}

?>