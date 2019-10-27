<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">Smartphone</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if( !isset($_SESSION["username"]) ) { ?>
          <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          <li><a href="register.php">Register</a></li>
          <?php } else { ?>
            <?php if( $_SESSION["username"] == "admin" ){ ?> 
              <li><a href="./insert.php">Insert</a></li> 
            <?php } ?>
            <li><a href="./controller/doLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>