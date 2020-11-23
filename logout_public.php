<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php
$_SESSION["UserId_P"]=null;
$_SESSION["UserName_P"]=null;
//$_SESSION["AdminName"]=null;
session_destroy();
redirect_to("login_public.php");
?>