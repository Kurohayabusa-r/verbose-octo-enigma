<?php

session_start();
unset($_SESSION["error"]);
include '../database/db.php';

if( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $id = $_POST["id"];
    $brand = $_POST["brand"];
    $type = $_POST["type"];
    $price = $_POST["price"];
    
    $image      = $_FILES["image"];
    $image_name = $image["name"];
    $image_size = $image["size"];
    $image_type = $image["type"];
    // $image_path = $image["tmp_name"];

    $fileType   = ['image/jpeg','image/png','image/jpg'];

    if( $fileSize > 10000000 ){
        $_SESSION["error"] = "File Size Must Be Under 10MB!";
    }
    
    if( !in_array($image_type,$fileType) ){
        $_SESSION["error"] = "File must be either .jpg, .png, or .jpeg!";
    }
    // lokasi penyimpanan diganti
    // if( !file_exists("../public/image/$username") ){
    //     mkdir("../public/image/$username/",777);
    // }
    // $uploadPath = "../public/image/$username/$image_name";
    // if( move_uploaded_file($fileTmpName,$image_path) ){
        
    if( !isset($_SESSION["error"]) ){
        $query = "  INSERT INTO handphone(type,brand,price,image) 
                    VALUES('$type','$brand','$price','$image_name')";
        $res = $conn->query($query);
        if( $res ){
            $_SESSION["success"] = "Insert Success";
            header("Location: ../insert.php");
        }
    }else{
        if( !isset($_SESSION["error"])) {
            $_SESSION["error"] = "Insert failed";
        }
        header("Location: ../insert.php");
    }
    // }
}

?>