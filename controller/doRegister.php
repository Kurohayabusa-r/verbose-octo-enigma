<?php

session_start();
unset($_SESSION["error"]);

include "../database/db.php";

if( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $username = $_POST["txtUsername"];
    $password = $_POST["txtPassword"];
    $confpass = $_POST["txtConfirmPassword"];

    if( $username == "" ){
        $_SESSION["error"] = "Username must be filled";
    }else if( $password == "" ){
        $_SESSION["error"] = "Wrong username or password";
    }else if( $password != $confpass ){
        $_SESSION["error"] = "Password confirmation must be the same";
    }

    $view = "SELECT * FROM users WHERE username = '$username'";
    $res = $conn->query($view);

    if( $res->num_rows == 0 ){
        $shaPassword = sha1($password);
        $query = "INSERT INTO users(username,password) VALUES('$username','$shaPassword')";
        $result = $conn->query($query);
        if( $result ){
            $_SESSION["success"] = "Registration complete";
            header("Location: ../register.php");
        }else{
            if( $result && !isset($_SESSION["error"]) ) {
                $_SESSION["error"] = "Failed to register";
            }
            header("Location: ../register.php");
        }
    }else{
        if( $res && !isset($_SESSION["error"]) ) {
            $_SESSION["error"] = "User already exist";
        }
        header("Location: ../register.php");
    }


}

?>