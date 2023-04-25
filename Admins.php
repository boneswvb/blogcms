<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login()
  ?>
<?php
if (isset($_POST["Submit"])) {
  // Get data from the input field
  $UserName = $_POST["Username"];
  $Name = $_POST["Name"];
  $Password = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];

  // Temp variable to get the admin name
  $Admin = $_SESSION["UserName"];
  $CurrentTime = time();
  $DateTime = date("j F Y h:i:s");

  // Sanitize the date received from the input field
  if (empty($UserName) || empty($Password) || empty($ConfirmPassword)) {
    $_SESSION["ErrorMessage"] = "All fields must be completed";
    Redirect_to("Admins.php");
  } elseif (strlen($Password) < 4) {
    $_SESSION["ErrorMessage"] = "Password should have at lease 5 caracters";
    Redirect_to("Admins.php");
  } elseif ($Password !== $ConfirmPassword) {
    $_SESSION["ErrorMessage"] = "Password and confirmed should be the same.";
    Redirect_to("Admins.php");
  } elseif (CheckIfUserNameExist($UserName)) {
    $_SESSION["ErrorMessage"] = "User name exist. Please select a different user name.";
    Redirect_to("Admins.php");
  } else {
    //  insert data into the database
    $ConnectingDB; // global is only needed for php 5.6
    $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
    $sql .= "VALUES(:datetimE,:usernamE,:passworD,:anamE,:adminnamE)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':datetimE', $DateTime);
    $stmt->bindValue(':usernamE', $UserName);
    $stmt->bindValue(':passworD', $Password);
    $stmt->bindValue(':anamE', $Name);
    $stmt->bindValue(':adminnamE', $Admin);
    $Execute = $stmt->execute();

    if ($Execute) {
      $_SESSION["SuccessMessage"] = $UserName . " was added successfully";
      Redirect_to("Admins.php");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Please try again.";
      Redirect_to("Admins.php");
    }
  } //end if condition
} // End submit button 
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://kit.fontawesome.com/5b7ab696fa.js" crossorigin="anonymous"></script>
</head>

<body>
  <div style="height: 10px; background: #27aae1;"></div>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a href="#" class="navbar-brand">LESAWI.CO.ZA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="MyProfile.php" class="nav-link" aria-current="page">
              <i class="fas fa-user" style="color:green;"></i> My Profile</a>
          </li>
          <li class="nav-item">
            <a href="Dashboard.php" class="nav-link" aria-current="page">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="Posts.php" class="nav-link">Posts</a>
          </li>
          <li class="nav-item">
            <a href="Categories.php" class="nav-link" aria-current="page">Categories</a>
          </li>
          <li class="nav-item">
            <a href="Admins.php" class="nav-link" aria-current="page">Manage Admins</a>
          </li>
          <li class="nav-item">
            <a href="Comments.php" class="nav-link" aria-current="page">Comments</a>
          </li>
          <li class="nav-item">
            <a href="Blog.php?page=1" class="nav-link" aria-current="page">Live Blog</a>
          </li>
        </ul>
        <ul class="nav-bar ml-auto">
          <li class="nav-item">
            <a href="Logout.php" class="nav-link text-danger" aria-current="page">
              <i class="fas fa-user-times"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div style="height: 10px; background: #27aae1;"></div>
  <!-- navbar end -->

  <!-- header start  -->
  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1><i class="fas fa-user" style="color:#27aae1"></i> Manage Admins</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- header end  -->

  <!-- main area -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-lg-1 col-lg-10" style="min-height: 400px">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form action="Admins.php" method="post">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header">
              <h1>Add New Admin</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="Username"><span class="fieldInfo">User Name: </span></label>
                <input class="form-control mb-2" type="text" name="Username" id="Username" value="">
              </div>
              <div class="form-group">
                <label for="Name"><span class="fieldInfo">Name: </span></label>
                <small class="text-grey">*Optional</small>
                <input class="form-control mb-2" type="text" name="Name" id="Name" value="">
              </div>
              <div class="form-group">
                <label for="Password"><span class="fieldInfo">Password: </span></label>
                <input class="form-control mb-2" type="password" name="Password" id="Password" title here" value="">
              </div>
              <div class="form-group">
                <label for="ConfirmPassword"><span class="fieldInfo">Confirm Password: </span></label>
                <input class="form-control mb-2" type="password" name="ConfirmPassword" id="ConfirmPassword" value="">
              </div>
              <div class="row">
                <div class="d-grid col-6 mx-auto">
                  <a class="btn btn-warning" href="DashBoard.php">
                    <i class="fas fa-arrow-left"></i>
                    Back To Dashboard
                  </a>
                </div>
                <div class="d-grid col-6 mx-auto">
                  <button type="submit" name="Submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Publish
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <h2>Existing Admins</h2>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Date & Time</th>
              <th>User Name</th>
              <th>Admin Name</th>
              <th>Added By</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM admins ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $AdminId = $DataRows["id"];
            $AdminDateTime = $DataRows["datetime"];
            $AdminName = $DataRows["username"];
            $AdminFullName = $DataRows["aname"];
            $AddedBy = $DataRows["addedby"];
            $SrNo++;
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo htmlentities($SrNo); ?>
                </td>
                <td>
                  <?php echo htmlentities($AdminDateTime); ?>
                </td>
                <td>
                  <?php echo htmlentities($AdminName); ?>
                </td>
                <td>
                  <?php echo htmlentities($AdminFullName); ?>
                </td>
                <td>
                  <?php echo htmlentities($AddedBy); ?>
                </td>
                <td style="min-width: 140px">
                  <a href="DeleteAdmin.php?id=<?php echo $AdminId; ?>" class="btn btn-danger">
                    Delete
                  </a>
                </td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
      </div>
    </div>
  </section>
  <!-- main area end -->




  <!-- footer start -->
  <div style=" height: 10px; background: #27aae1;">
  </div>
  <footer class="bg-dark text-white">
    <div class="container">
      <div class="row">
        <div class="col">
          <p class="lead text-center">Product of Lesawi Services | Cell: 061 525 0362 | <span id="year"></span> &copy;
            All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>
  <div style="height: 10px; background: #27aae1;"></div>
  <!-- footer end -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
    integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
  <script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
  </script>
</body>

</html>