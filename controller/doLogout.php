<?php

session_start();
session_unset();

setcookie("cookieusername",$_COOKIE["cookieusername"],time() - 60 * 60, "/" );
setcookie("cookiepassword",$_COOKIE["cookiepassword"],time() - 60 * 60, "/" );

if( !isset($_SESSION["username"]) ){
    header("Location: ../login.php");
}

?>