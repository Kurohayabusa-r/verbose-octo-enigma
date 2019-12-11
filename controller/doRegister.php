<?php
session_start();
unset($_SESSION["error"]);

include "../database/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = htmlspecialchars($_POST["txtUsername"]);
    $password = $_POST["txtPassword"];
    $confirmPassword = $_POST["txtConfirmPassword"];

    if($username == "")
    {
        $_SESSION["error"] = "Username must be filled";
    }
    else if(!preg_match('/[a-zA-Z]+[a-zA-Z0-9]+$/', $username))
    {
        $_SESSION["error"] = "Username must only consist of alphabets and numbers";
    }
    else if($password == "")
    {
        $_SESSION["error"] = "Password must be filled";
    }
    else if($confirmPassword != $password)
    {
        $_SESSION["error"] = "Password confirmation must be the same";
    }

    $view = "SELECT * FROM users WHERE username = '$username'";
    $res = $conn->query($view);

    if($res->num_rows == 0)
    {
        $hashPass = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users(username,password) VALUES(?,?)");
        $stmt->bind_param("ss", $username, $hashPass);
        //$stmt->execute();

        $result = $stmt->execute();
        if( $result )
        {
            $_SESSION["success"] = "Successfully registered";
            header("Location: ../register.php");
        }else{
            if( $result && !isset($_SESSION["error"]) )
            {
                $_SESSION["error"] = "Failed to register";
            }
            header("Location: ../register.php");
        }
        $stmt->free_result();
        $stmt->close();
    }else{
        if( $res && !isset($_SESSION["error"]) )
        {
            $_SESSION["error"] = "User already exist";
        }
        header("Location: ../register.php");
    }
}

?>