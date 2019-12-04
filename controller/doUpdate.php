<?php
session_start();
unset($_SESSION["error"]);
include "../database/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST["id"];
    $brand = $_POST["brand"];
    $type = $_POST["type"];
    $price = $_POST["price"];

    $image = $_FILES["image"];
    $image_name = $image["name"];
    $image_size = $image["size"];
    $image_type = $image["type"];
    $image_path = $image["tmp_name"];

    $fileType = ["image/png","image/jpg", "image/jpeg"];

    if($image_size > 10000000)
    {
        $_SESSION["error"] = "Image size must be under 10MB";
    }

    if( !in_array($image_type,$fileType) )
    {
        $_SESSION["error"] = "File must be either jpg, png, or jpeg";
    }

    if( !file_exists("../public/image/product/") )
    {
        mkdir("../public/image/product/", 777);
    }
    $uploadPath = "../public/image/product/$image_name";
    if( move_uploaded_file($image_path,$uploadPath) )
    {
        if( !isset($_SESSION["error"]) )
        {
            $stmt = $conn->prepare("UPDATE handphone SET type = ?, brand = ?, price = ?, image = ? WHERE id = ?");
            $stmt->bind_param("ssisi", $type, $brand, $price, $image_name, $id);
            //$stmt->execute();
            $res = $stmt->execute();
            //$query = "UPDATE handphone SET type = '$type', brand = '$type', price = '$price', image = '$image_name' WHERE id = '$id'";
            //$res = $conn->query($query);
            if($res && !isset($_SESSION["error"]) )
            {
                header("Location: ../index.php");
            }
            $stmt->free_result();
            $stmt->close();
        }else{
            if( !isset($_SESSION["error"]) )
            {
                $_SESSION["error"] = "Update failed";
            }
            header("Location: ../update.php?id=$id");
        }
    }
    header("Location: ../update.php?id=$id");
}


?>