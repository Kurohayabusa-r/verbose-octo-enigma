<?php

include "../database/db.php";

$id = htmlspecialchars($_GET['id']);

$stmt = $conn->prepare("DELETE FROM pets WHERE id = ?");
$stmt->bind_param("i", $id);
//$stmt->execute();

//$query = "DELETE FROM handphone WHERE id = '$id'";
//$res = $conn->query($query);
$res = $stmt->execute();
if($res)
{
    $stmt->close();
    header("Location: ../index.php");
}else{
    $stmt->close();
    die("Delete failed");
}

?>