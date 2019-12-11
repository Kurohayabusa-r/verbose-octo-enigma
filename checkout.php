<!-- Form Update & Check Session -->
<?php
  session_start();
  require_once __DIR__ . 'csrf.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
	<?php include_once 'helper/template/include.php'; ?>
</head>
<body>
	<?php include_once 'helper/template/header.php'; ?>
	
	<!-- If user has not logged in, Redirect to login.php -->
  <?php
    if( !isset($_SESSION["username"]) )
    {
      header("Location: ./login.php");
    }
  ?>
  
    <div class="title">
        <center>
          <h3>Checkout Confirmation</h3>
        </center>
        <?php
            include "./database/db.php";
            $id = $_GET['id']; 
            $stmt = $conn->prepare("SELECT image, breed FROM pets WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                $row = $result->fetch_assoc();
            }
        ?>
        <center>
        <img src="./public/image/product/<?php echo $row["image"]; ?>" class="img-responsive" alt="Image"> <!-- {image} = image from database -->
        <br>
        <p><?php echo $row["breed"]; ?></p>
      </center>
      </div>
		<div class="container text-center update-form">
      
			<div class="errorMessage">
				<!-- Show Error Message -->
        <?php if( isset($_SESSION["error"]) ){ ?>
					<p style="color: red;">
            <?php
              if( isset($_SESSION["error"]) )
              {
                echo $_SESSION["error"];
              }
              unset($_SESSION["error"]);
            ?>
          </p>
          <?php
          }else{ ?>
          <p style="color: green;"> <?php
            if( isset($_SESSION["success"]) )
            {
              echo $_SESSION["success"];
            }
            unset($_SESSION["success"]);
          }
          ?> </p>
			</div>
      <form class="form-horizontal" method="POST" action="./controller/doCheckout.php" enctype="multipart/form-data">
      <?php
//        include "./database/db.php";
//        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM pets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        //$query = "SELECT * FROM handphone WHERE id = '$id'";
        //$res = $conn->query($query);

        if($res)
        {
          $row = $res->fetch_assoc();
      ?>
      <input type="hidden" name="_csrf" value="<?= $csrfToken ?>"> <!-- csrf token check -->
			<input type="hidden" name="id" value=<?php echo $row['id']; ?>> <!-- id from selected product -->
            <p> Please fill in the following details and transfer <b>Rp.<?php echo $row['price']; ?></b> to the BCA account no: <b>12345678910</b>. </p>
            <div class="form-group">
              <label class="control-label col-sm-2" for="name">Full Name:</label>
              <div class="col-sm-10">
                <!-- Show selected brand in value input type -->
                <input type="text" class="form-control" id="name" name="name" placeholder="Bob Ross">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="nohp">Phone number:</label>
              <div class="col-sm-10">
				<!-- Show selected type in value input type -->
                <input type="text" class="form-control" id="nohp" name="nohp" placeholder="081234567898">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="address">Address:</label>
              <div class="col-sm-10">
				<!-- Show selected price in value input type -->
                <input type="text" class="form-control" id="address" name="address" placeholder="Jl. Apel 2 No. 9">
              </div>
            </div>
            <p> Please upload a photo of the payment receipt. </p>
            <div class="form-group">
              <label class="control-label col-sm-2" for="image">Payment receipt:</label>
              <div class="col-sm-10">
                <input type="file" id="image" name="image">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-default">Submit</button></button>
            </div>
        <?php } 
        $stmt->free_result();
        $stmt->close();
        ?>
          </form>
		</div>
</body>
</html>