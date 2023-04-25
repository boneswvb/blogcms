<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login();
?>
<?php
// getting the loged on admins data
$AdminId = $_SESSION["UserId"];
$ConnectingDB;
$sql = "SELECT * FROM admins WHERE id=$AdminId";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $ExistingName = $DataRows['aname'];
  $ExistingUserName = $DataRows['username'];
  $ExistingHeadline = $DataRows['aheadline'];
  $ExistingBio = $DataRows['abio'];
  $ExistingImage = $DataRows['aimage'];
}

// getting the loged on admins data
if (isset($_POST["Submit"])) {
  // Get data from the input field
  $AName = $_POST["Name"];
  $AHeadline = $_POST["Headline"];
  $ABio = $_POST["Bio"];
  $Image = $_FILES["Image"]["name"];
  $Target = "adminImages/" . basename($_FILES["Image"]["name"]);
  // get the admin name
  $Admin = $_SESSION["UserName"];

  // sanitize the date received from the input field
  if (strlen($AHeadline) > 50) {
    $_SESSION["ErrorMessage"] = "Only 50 characters allowed for headline";
    Redirect_to("MyProfile.php");
  } elseif (strlen($ABio) > 1000) {
    $_SESSION["ErrorMessage"] = "Bio should have less than 999 caracters";
    Redirect_to("MyProfile.php");
  } else {
    //  update data into the database
    $ConnectingDB; // global only needed for php 5.6
    if (!empty($_FILES["Image"]["name"])) {
      $sql = "UPDATE admins 
            SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
            WHERE id='$AdminId'";
    } else {
      $sql = "UPDATE admins 
            SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
            WHERE id='$AdminId'";
    }
    $Execute = $ConnectingDB->query($sql);

    //Saving the uploaded file to a folder specified
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
    // var_dump($Execute);
    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Details updated successfully";
      Redirect_to("MyProfile.php");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Please try again.";
      Redirect_to("MyProfile.php");
    }
  } //end if condition
} // End submit button 
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Profile</title>
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
          <h1><i class="fas fa-user text-success" style="color:#27aae1"></i>
            Welcome Back
            <?php echo htmlentities($ExistingUserName); ?>
          </h1>
          <small>
            <?php echo htmlentities($ExistingHeadline); ?>
          </small>
        </div>
      </div>
    </div>
  </header>
  <!-- header end  -->

  <!-- main area -->
  <section class="container py-2 mb-4">
    <div class="row">
      <!-- left area end -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-header bg-dark text-light">
            <h3 class="text-center">
              <?php echo htmlentities($ExistingName) ?>
            </h3>
          </div>
          <div class="card-body">
            <img src="images/<?php echo htmlentities($ExistingImage); ?>" class="block img-fluid mb-3" alt="">
            <p>
              <?php echo htmlentities($ExistingBio); ?>
            </p>
          </div>
        </div>
      </div>
      <!-- left area start -->

      <!-- right area end -->
      <div class="col-md-9" style="min-height: 400px">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form action="MyProfile.php" method="post" enctype="multipart/form-data">
          <div class="card bg-dark text-light">
            <div class="card-header bg-secondary text-light">
              <h4>Edit Profile</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <input class="form-control mb-2" type="text" name="Name" id="name" placeholder="Your Name" value="">
              </div>
              <div class="form-group">
                <small>Add a profesional headline like, Website developer at Lesawi Services</small>
                <span class="text-danger">Not more than 50 characters</span>
                <input class="form-control mb-2" type="text" id="name" name="Headline" placeholder="Headline" value="">
              </div>
              <div class="form-group">
                <textarea class="form-control" name="Bio" placeholder="Bio" id="" cols="100" rows="8"></textarea>
              </div>

              <div class="input-group my-2">
                <input type="file" class="form-control" name="Image" id="imageSelect">
                <label class="input-group-text" for="imageSelect">Select Image</label>
              </div>

              <div class="row my-2">
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
      </div>
    </div>
  </section>
  <!-- right area start -->
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