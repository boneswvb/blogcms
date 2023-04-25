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
  $PostTitle = $_POST["PostTitle"];
  $Category = $_POST["CategoryTitle"];
  $Image = $_FILES["Image"]["name"];
  $Target = "uploads/" . basename($_FILES["Image"]["name"]);
  $PostText = $_POST["PostDescription"];
  // Temp variable to get the admin name
  $Admin = $_SESSION["UserName"];
  $CurrentTime = time();
  $DateTime = date("j F Y h:i:s");

  // Sanitize the date received from the input field
  if (empty($PostTitle)) {
    $_SESSION["ErrorMessage"] = "Title can not be empty";
    Redirect_to("AddNewPost.php");
  } elseif (strlen($PostTitle) < 5) {
    $_SESSION["ErrorMessage"] = "Post Title should have at lease 5 caracters";
    Redirect_to("AddNewPost.php");
  } elseif (strlen($Category) > 49) {
    $_SESSION["ErrorMessage"] = "Post description should have less than 9999 caracters";
    Redirect_to("AddNewPost.php");
  } else {
    //  insert data into the database
    global $ConnectingDB; // only needed for php 5.6
    $sql = "INSERT INTO post(dateTime,title,category,author,image,post)";
    $sql .= "VALUES(:dateTime, :postTitle, :categoryName, :adminName, :imageName, :postDescription)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':postTitle', $PostTitle);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':imageName', $Image);
    $stmt->bindValue(':postDescription', $PostText);
    $Execute = $stmt->execute();

    //Saving the uploaded file to a folder specified
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Blog with ID : " . $ConnectingDB->lastInsertId() . " added";
      Redirect_to("AddNewPost.php");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Please try again.";
      Redirect_to("AddNewPost.php");
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
          <h1><i class="fas fa-edit" style="color:#27aae1"></i>Add New Post</h1>
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
        <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="PostTitle"><span class="fieldInfo">Post Title: </span></label>
                <input class="form-control mb-2" type="text" name="PostTitle" id="title" placeholder="Type title here"
                  value="">
              </div>
              <div class="form-group">
                <label for="CategoryTitle"><span class="fieldInfo">Chose Category: </span></label>
                <select class="form-control" name="CategoryTitle" id="">
                  <?php
                  //Get all categories from the database
                  $ConnectingDB;
                  $sql = "SELECT id,title FROM category";
                  $stmt = $ConnectingDB->query($sql);
                  while ($DataRows = $stmt->fetch()) {
                    $Id = $DataRows["id"];
                    $CategoryName = $DataRows["title"];
                    ?>
                    <option value="<?php echo $CategoryName ?>">
                      <?php echo $CategoryName; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="input-group my-2">
                <input type="file" class="form-control" name="Image" id="imageSelect">
                <label class="input-group-text" for="imageSelect">Select Image</label>
              </div>
              <div class="form-group">
                <label for="Post" class="FieldInfo">Post:
                  <textarea class="form-control" name="PostDescription" id="Post" cols="100" rows="8"></textarea>
                </label>
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