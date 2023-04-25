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
  $Category = $_POST["CategoryTitle"];

  // Temp variable to get the admin name
  $Admin = $_SESSION["UserName"];
  $CurrentTime = time();
  $DateTime = date("j F Y h:i:s");

  // Sanitize the date received from the input field
  if (empty($Category)) {
    $_SESSION["ErrorMessage"] = "All fields must be completed";
    Redirect_to("Categories.php");
  } elseif (strlen($Category) < 3) {
    $_SESSION["ErrorMessage"] = "Category should have at lease 5 caracters";
    Redirect_to("Categories.php");
  } elseif (strlen($Category) > 49) {
    $_SESSION["ErrorMessage"] = "Category should have less than 50 caracters";
    Redirect_to("Categories.php");
  } else {
    //  insert data into the database
    global $ConnectingDB; // only needed for php 5.6
    $sql = "INSERT INTO category(title,author,datetime)";
    $sql .= "VALUES(:categoryName, :adminName, :dateTime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':dateTime', $DateTime);
    $Execute = $stmt->execute();

    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Category with ID : " . $ConnectingDB->lastInsertId() . " added";
      Redirect_to("Categories.php");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Please try again.";
      Redirect_to("Categories.php");
    }
  } //end if condition
} // End submit button 
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Categories</title>
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
          <h1><i class="fas fa-edit" style="color:#27aae1"></i> Manage Categories</h1>
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
        <form action="Categories.php" method="post">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header">
              <h1>Add New Category</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="CategoryTitle"><span class="fieldInfo">Category Title: </span></label>
                <input class="form-control mb-2" type="text" name="CategoryTitle" id="title" p
                  laceholder="Type title here" value="">
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
        <h2>Existing categories</h2>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Date & Time</th>
              <th>Category Name</th>
              <th>Creator Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM category ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $CategoryId = $DataRows["id"];
            $CategoryDateTime = $DataRows["datetime"];
            $CategoryName = $DataRows["title"];
            $CreatorName = $DataRows["author"];
            $SrNo++;
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo htmlentities($SrNo); ?>
                </td>
                <td>
                  <?php echo htmlentities($CategoryDateTime); ?>
                </td>
                <td>
                  <?php echo htmlentities($CategoryName); ?>
                </td>
                <td>
                  <?php echo htmlentities($CreatorName); ?>
                </td>
                <td style="min-width: 140px">
                  <a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">
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