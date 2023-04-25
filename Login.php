<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
// making sure that a signed in user cannot return to the login page
if (isset($_SESSION["UserId"])) {
  Redirect_to("Dashboard.php");
}

//get the users details
if (isset($_POST["Submit"])) {
  $UserName = $_POST["UserName"];
  $Password = $_POST["Password"];
  if (empty($UserName) || empty($Password)) {
    $_SESSION["ErrorMessage"] = "All fields must be completed";
    Redirect_to("Login.php");
  } else {
    // checking the users name and password
    $Found_Account = Login_Attempt($UserName, $Password);

    // if logon is successfull - store the user data in sessions
    if ($Found_Account) {
      $_SESSION["UserId"] = $Found_Account["id"];
      $_SESSION["UserName"] = $Found_Account["username"];
      $_SESSION["AdminName"] = $Found_Account["aname"];

      // check if is tracking var is set to redirect back to the same screen after sigin
      if ($_SESSION["TrackingURL"]) {
        Redirect_to($_SESSION["TrackingURL"]);
      } else {
        Redirect_to("Dashboard.php");
      }
    } else {
      $_SESSION["ErrorMessage"] = "Incorrect User name and pasword combination";
      Redirect_to("Login.php");
    }
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://kit.fontawesome.com/5b7ab696fa.js" crossorigin="anonymous"></script>
</head>

<body>
  <div style="height: 10px; background: #27aae1;"></div>
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
          <!-- Add content for header here  -->
        </div>
      </div>
    </div>
  </header>
  <!-- header end  -->
  <!-- main area start -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-sm-3 col-sm-6" style="min-height: 400px;">
        <br>
        <br>
        <br>
        <br>
        <br>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <div class="card bg-secondary text-light">
          <div class="card-header text-center">
            <h4>Welcome Back</h4>
          </div>
          <div class="card-body bg-dark">
            <form action="Login.php" method="post">
              <div class="form-group">
                <label for="username">
                  <span class="fieldInfo">User Name:</span>
                </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-info" style="height: 40px">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="UserName" id="username">
                </div>
              </div>
              <div class="form-group">
                <label for="password">
                  <span class="fieldInfo">Password:</span>
                </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-info" style="height: 40px">
                      <i class="fas fa-lock"></i>
                    </span>
                  </div>
                  <input type="password" class="form-control" name="Password" id="password">
                </div>
              </div>
              <div class="d-grid">
                <input type="submit" name="Submit" class="btn btn-info" value="Login">
              </div>
            </form>
          </div>
        </div>
        <br>
        <br>
        <br>
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