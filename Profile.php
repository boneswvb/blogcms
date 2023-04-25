<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<!-- getting the writters information  -->
<?php
$SearchQueryParameter = $_GET["username"];
$ConnectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:usernamE";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':usernamE', $SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
if ($Result === 1) {
  while ($DataRow = $stmt->fetch()) {
    $ExistingName = $DataRow["aname"];
    $ExistingBio = $DataRow["abio"];
    $ExistingImage = $DataRow["aimage"];
    $ExistingHeadline = $DataRow["aheadline"];
  }
} else {
  $_SESSION["ErrorMessage"] = "Bad Request";
  Redirect_to("Blog.php?page=1");
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile of Author</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://kit.fontawesome.com/5b7ab696fa.js" crossorigin="anonymous"></script>
</head>

<body>
  <!-- navbar -->
  <div style="height: 10px; background: #27aae1;"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a href="https://www.lesawi.co.za" class="navbar-brand">LESAWI.CO.ZA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="Index.php" class="nav-link" aria-current="page">Home</a>
          </li>
          <li class="nav-item">
            <a href="About.php" class="nav-link" aria-current="page">About US</a>
          </li>
          <li class="nav-item">
            <a href="Blog.php" class="nav-link">Blog</a>
          </li>
          <li class="nav-item">
            <a href="Contact.php" class="nav-link" aria-current="page">Contact US</a>
          </li>
          <li class="nav-item">
            <a href="Features.php" class="nav-link" aria-current="page">Features</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <form class="d-flex" action="Blog.php">
            <input class="form-control mx-2" type="text" name="Search" placeholder="Search Here" value="">
            <button class="btn btn-primary" name="SearchButton">Go</button>
          </form>
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
        <div class="col-md-6">
          <h1>
            <i class="fas fa-user text-success mr-2" style="color:#27aae1"></i>
            <?php echo htmlentities($ExistingName); ?>
          </h1>
          <h3>
            <?php echo htmlentities($ExistingHeadline); ?>
          </h3>
        </div>
      </div>
    </div>
  </header>
  <!-- header end  -->

  <!-- main area start -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="col-md-3">
        <img src="images/<?php echo htmlentities($ExistingImage); ?>" class="d-block ing-fluid rounded-circle" alt="">
      </div>
      <div class="col-md-9" style="min-height: 400px;">
        <div class="card">
          <div class="card-body">
            <p class="lead">
              <?php echo htmlentities($ExistingBio); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- main area end -->

  <!-- footer start -->
  <div style="height: 10px; background: #27aae1;"></div>
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