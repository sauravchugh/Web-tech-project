<?php require_once("include/function.php");?>
<?php require_once("include/session.php"); ?>
<?php
$_SESSION["UserId"]=null;
$_SESSION["UserName"]=null;
$_SESSION["AdminName"]=null;
session_destroy();
redirect_to("login.php");
?>