<!-- Form Update & Check Session -->
<?php
  session_start(); 
  require_once __DIR__ . '/csrf.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>INSERT</title>
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
          <h3>Insert</h3>
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
			<form class="form-horizontal" method="POST" action="./controller/doInsert.php" enctype="multipart/form-data">
      <input type="hidden" name="_csrf" value="<?= $csrfToken ?>"> <!-- csrf token check -->
			<input type="hidden" name="id"> <!-- id from selected product -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="type">Type:</label>
              <div class="col-sm-10">
                <!-- Show selected brand in value input type -->
                <input type="text" class="form-control" id="type" name="type" placeholder="Enter Type">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="breed">Breed:</label>
              <div class="col-sm-10">
				<!-- Show selected type in value input type -->
                <input type="text" class="form-control" id="breed" name="breed" placeholder="Enter Breed">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="price">Price:</label>
              <div class="col-sm-10">
				<!-- Show selected price in value input type -->
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price">
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
          </form>
		</div>
</body>
</html>