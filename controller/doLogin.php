<?php

session_start();
session_unset();

session_regenerate_id(true);

include "../database/db.php";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST["txtUsername"];
        $password = $_POST["txtPassword"];

        if($username == "")
        {
            $_SESSION["error"] = "Username must be filled";
        }
        else if($password == "")
        {
            $_SESSION["error"] = "Password must be filled";
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $res = $stmt->get_result();

        if( $res && !isset($_SESSION["error"]) )
        {
            $row = $res->fetch_assoc();

            if( password_verify($password, $row["password"]) )
            {
                $_SESSION["username"] = $username;

                if( isset($_POST["chkRemember"]) )
                {
                    setcookie("cookieUsername",$username,time()+60*60,"/");
                    setcookie("cookiePassword",$password,time()+60*60,"/");
                }
                header("Location: ../index.php");
            }
            else{
                $_SESSION["error"] = "User not found";
                header("Location: ../login.php");
            }
        }
        else{
            header("Location: ../login.php");
        }
        $stmt->free_result();
        $stmt->close();
    }


?>