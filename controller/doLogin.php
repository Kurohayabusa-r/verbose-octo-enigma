<?php 

session_start();
session_unset();

session_regenerate_id(true);
include "../database/db.php";

if( $_SERVER["REQUEST_METHOD"] == "POST" ){

    $username = $_POST["txtUsername"];
    $password = $_POST["txtPassword"];
    $shaPassword = sha1($password);

    if( $username == "" ){
        $_SESSION["error"] = "Username must be filled";
    }else if( $password == "" ){
        $_SESSION["error"] = "Wrong username or password";
    }

    $query = "SELECT * FROM users WHERE username = '$username'";
    $res  = $conn->query($query);

    if( $res && !isset($_SESSION["error"]) ){
        $row = $res->fetch_assoc();
        
        if( $shaPassword == $row["password"] ) {
            $_SESSION["username"] = $username;

            if( isset($_POST["chkRemember"]) ){
                setcookie("cookieusername",$username,time() + 60 * 60, "/" );
                setcookie("cookiepassword",$password,time() + 60 * 60, "/" );
            }

            header("Location: ../index.php");
        }else{
            $_SESSION["error"] = "User Not Found!";
            header("Location: ../login.php");
        }
    }else{
        header("Location: ../login.php");
    }
}

?>