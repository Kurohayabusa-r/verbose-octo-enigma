<?php

session_start();
session_unset();

setcookie("cookieUsername",$_COOKIE["username"],time() - 3600, "/");
setcookie("cookiePassword",$_COOKIE["password"],time() - 3600, "/");

if( !isset($_SESSION["username"]) )
{
    header("Location: ../login.php");
}

?>