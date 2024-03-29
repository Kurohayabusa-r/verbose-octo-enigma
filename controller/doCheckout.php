<?php

session_start();
unset($_SESSION["error"]);
include "../database/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = htmlspecialchars($_POST["id"]);
    $name = htmlspecialchars($_POST["name"]);
    $nohp = htmlspecialchars($_POST["nohp"]);
    $address = htmlspecialchars($_POST["address"]);

    $image = $_FILES["image"];
    $image_name = $image["name"];
    $image_size = $image["size"];
    $image_type = $image["type"];
    $image_path = $image["tmp_name"];
    $image_temp = addslashes(file_get_contents($image_path));

    $fileType = ["image/png","image/jpg","image/jpeg"];

    if(strlen($name) < 2 || strlen($name) > 25)
    {
        $_SESSION["error"] = "Name length must be 2 to 25 characters";
    }

    if (ctype_alpha(str_replace(' ', '', $name)) === false) {
        $_SESSION["error"] = 'Name must contain letters and spaces only';
      }

    if(!is_numeric($nohp))
    {
        $_SESSION["error"] = "Phone number must be numeric";
    }

    if(strlen($nohp) > 13)
    {
        $_SESSION["error"] = "Phone number cannot exceed 13 digits";
    }

    if($address == "")
    {
        $_SESSION["error"] = "Address must be filled";
    }

    if(!preg_match('/[a-zA-Z0-9-. ]+$/', $address))
    {
        $_SESSION["error"] = "Please enter a valid address";
    }

    if($image_size > 2000000)
    {
        $_SESSION["error"] = "File size must be under 2MB";
    }

    if( !in_array($image_type,$fileType) )
    {
        $_SESSION["error"] = "File must be either png, jpg, or jpeg";
    }

    // if( !file_exists("../public/image/product/") )
    // {
    //     mkdir("../public/image/product/", 777);
    // }
//    $uploadPath = "../public/image/product/$image_name";
//    if( move_uploaded_file($image_path, $uploadPath) )
//    {
        if( !isset($_SESSION["error"]) )
        {
            $stmt = $conn->prepare("INSERT INTO transactions(nama,nohp,address,bukti) VALUES(?,?,?,?)");
            $stmt->bind_param("sssb", $name, $nohp, $address, $image_temp);
            //$stmt->execute();
            //$query = "INSERT INTO handphone(type,brand,price,image) VALUES('$type','$brand','$price','$image_name')";
            //$res = $conn->query($query);
            $res = $stmt->execute();
            if($res)
            {
                $_SESSION["success"] = "Checkout success, processing order & checking validity, we will send a notice via phone in 1-2 days.";
                header("Location: ../checkout.php?id=$id");
            }
            $stmt->free_result();
            $stmt->close();
        }else{
            if( !isset($_SESSION["error"]) )
            {
                $_SESSION["error"] = "Checkout failed";
            }
            header("Location: ../checkout.php?id=$id");
        }
//    }

}
?>