<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pet Shop</title>
  <meta charset="utf-8">
  
  <?php include_once 'helper/template/include.php'; ?>
</head>
<body>

<?php include_once 'helper/template/header.php'; ?>
  
<div class="container text-center">
  <h3>
  
    <!-- View After Login -->
    <?php
      include "./database/db.php";
      $query = "SELECT * FROM handphone";
      $res = $conn->query($query);
      if( isset($_SESSION["username"]) ) {
    ?>
      Welcome, <?php echo $_SESSION["username"]; ?> <!--Change With Username -->
  </h3><br>
  <div class="row">
  <!-- Show All Products and Searching -->
  <?php while($row = $res->fetch_assoc()) {?>
    <div class="col-sm-4 distance">
      <p><b> <?php echo $row["brand"]; ?> </b></p> <!-- Show smartphone brand from database -->
      <!-- Image from path public/image/product/{image} -->
      <center>
        <img src="./public/image/product/<?php echo $row["image"]; ?>" class="img-responsive" alt="Image"> <!-- {image} = image from database -->
      </center>
      <p><?php echo $row["type"]; ?></p> <!-- Show smartphone type from database -->
      <p>Rp <?php echo $row["price"]; ?></p> <!-- Show smartphone price from database -->
      <?php if($_SESSION["username"] != "admin") {?>
      <a class="btn btn-warning" href="./purchase.php?id=<?php echo $row["id"]; ?>">Purchase</a>
      <?php }?>
      <!-- Show Button Update and Delete -->
      <?php if($_SESSION["username"] == "admin") {?>
      <a class="btn btn-warning" href="./update.php?id=<?php echo $row["id"]; ?>">Update</a>     
      <a class="btn btn-danger" href="./controller/doDelete.php?id=<?php echo $row["id"]; ?>">Delete</a>
      <?php }?>     
    </div>

      <?php
        }
      }
      else{
      ?>
      Welcome, Guest
      <?php } ?>
  <!-- End Show Products -->
  </div>
</div><br>

<?php include_once 'helper/template/footer.php' ?>

</body>
</html>
