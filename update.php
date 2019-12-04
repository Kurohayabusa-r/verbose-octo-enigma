<!-- Form Update & Check Session -->
<?php
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update</title>
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
          <h3>Update</h3>
        </center>
      </div>
		<div class="container text-center update-form">
      
			<div class="errorMessage">
				<!-- Show Error Message -->
					<p style="color: red;"> 
            <?php
              if( isset($_SESSION["error"]) )
              {
                echo $_SESSION["error"];
              }
              unset($_SESSION["error"]);
            ?>
          </p>
			</div>
      <form class="form-horizontal" method="POST" action="./controller/doUpdate.php" enctype="multipart/form-data">
      <?php
        include "./database/db.php";
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM handphone WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        //$query = "SELECT * FROM handphone WHERE id = '$id'";
        //$res = $conn->query($query);

        if($res)
        {
          $row = $res->fetch_assoc();
      ?>
			<input type="hidden" name="id" value=<?php echo $row['id']; ?>> <!-- id from selected product -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="brand">Brand:</label>
              <div class="col-sm-10">
                <!-- Show selected brand in value input type -->
                <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter Brand" value=<?php echo $row["brand"]; ?>>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="type">Type:</label>
              <div class="col-sm-10">
				<!-- Show selected type in value input type -->
                <input type="text" class="form-control" id="type" name="type" placeholder="Enter Type" value=<?php echo $row["type"]; ?>>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="price">Price:</label>
              <div class="col-sm-10">
				<!-- Show selected price in value input type -->
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value=<?php echo $row["price"]; ?>>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="image">Image:</label>
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