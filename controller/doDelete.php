<?php

include '../database/db.php';

$id = $_GET['id'];

$query = "DELETE FROM handphone WHERE id = '$id'";
$res = $conn->query($query);

if( $res ){
    header("Location: ../index.php");
}else{
    die("Delete failed!");
}

?>