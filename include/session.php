<?php

session_start();
function ErrorMessage(){
	if(isset($_SESSION['err_msg'])){
		$Output = "<div class=\"alert alert-danger\">" ;
    $Output .= htmlentities($_SESSION["err_msg"]);
    $Output .= "</div>";
    $_SESSION["err_msg"] = null;
    return $Output;
	}
}

function SuccessMessage(){
  if(isset($_SESSION["succ_msg"])){
    $Output = "<div class=\"alert alert-success\">" ;
    $Output .= htmlentities($_SESSION["succ_msg"]);
    $Output .= "</div>";
    $_SESSION["succ_msg"] = null;
    return $Output;
  }
}
?>