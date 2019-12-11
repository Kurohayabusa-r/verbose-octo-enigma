<?php

session_start();
unset($_SESSION["error"]);
include "../database/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = htmlspecialchars($_POST["id"]);
    $type = htmlspecialchars($_POST["type"]);
    $breed = htmlspecialchars($_POST["breed"]);
    $price = htmlspecialchars($_POST["price"]);

    $image = $_FILES["image"];
    $image_name = $image["name"];
    $image_size = $image["size"];
    $image_type = $image["type"];
    $image_path = $image["tmp_name"];

    $fileType = ["image/png","image/jpg","image/jpeg"];

    if($image_size > 10000000)
    {
        $_SESSION["error"] = "File size must be under 10MB";
    }

    if( !in_array($image_type,$fileType) )
    {
        $_SESSION["error"] = "File must be either png, jpg, or jpeg";
    }

    if( !file_exists("../public/image/product/") )
    {
        mkdir("../public/image/product/", 777);
    }
    $uploadPath = "../public/image/product/$image_name";
    if( move_uploaded_file($image_path, $uploadPath) )
    {
        if( !isset($_SESSION["error"]) )
        {
            $stmt = $conn->prepare("INSERT INTO pets(type,breed,price,image) VALUES(?,?,?,?)");
            $stmt->bind_param("ssis", $type, $breed, $price, $image_name);
            //$stmt->execute();
            //$query = "INSERT INTO handphone(type,brand,price,image) VALUES('$type','$brand','$price','$image_name')";
            //$res = $conn->query($query);
            $res = $stmt->execute();
            if($res)
            {
                $_SESSION["success"] = "Insert success";
                header("Location: ../insert.php");
            }
            $stmt->free_result();
            $stmt->close();
        }else{
            if( !isset($_SESSION["error"]) )
            {
                $_SESSION["error"] = "Insert failed";
            }
            header("Location: ../insert.php");
        }
    }

}
?>