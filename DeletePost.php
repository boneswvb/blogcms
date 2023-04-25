<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php Confirm_Login() ?>
<?php
$SearchQueryParameter = $_GET["id"];
// fetchng the current content from the database
$ConnectingDB;
$sql = "SELECT * FROM post WHERE id='$SearchQueryParameter'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $TitletToBeDeleted = $DataRows['title'];
  $CategoryToBeDeleted = $DataRows['category'];
  $ImageToBeDeleted = $DataRows['image'];
  $PostToBeDeleted = $DataRows['post'];
}
if (isset($_POST["Submit"])) {
  $ConnectingDB; // global only needed for php 5.6 
  //  delete data in the database for selected id
  $sql = "DELETE FROM post WHERE id='$SearchQueryParameter'";
  $Execute = $ConnectingDB->query($sql);
  // var_dump($Execute); // debuging the code - un comment the redirect statements below
  // error/success handling
  if ($Execute) {
    $Taret_Path_to_DELETE_Image = "uploads/$ImageToBeDeleted";
    unlink($Taret_Path_to_DELETE_Image);
    $_SESSION["SuccessMessage"] = "Blog deleted successfully!";
    Redirect_to("Posts.php");
  } else {
    $_SESSION["ErrorMessage"] = "Something went wrong. Please try again.";
    Redirect_to("Posts.php");
  } //end if condition
} // End submit button 
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete Post</title>
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
      <a href="https://www.lesawi.co.za" class="navbar-brand">LESAWI.CO.ZA</a>
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
          <h1><i class="fas fa-edit" style="color:#27aae1"></i>Delete Post</h1>
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
        //show error and success messages
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form action="DeletePost.php?id=<?php echo $SearchQueryParameter ?>" method="post"
          enctype="multipart/form-data">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="PostTitle"><span class="fieldInfo">Post Title: </span></label>
                <input disabled class="form-control mb-2" type="text" name="PostTitle" id="title"
                  placeholder="Type title here" value="<?php echo $TitletToBeDeleted; ?> ">
              </div>
              <div class="form-group">
                <span>Existing Category:</span>
                <?php echo $CategoryToBeDeleted; ?>
              </div>
              <br>
              <span>Existing Image:</span>
              <img class="my-2" src="uploads/<?php echo $ImageToBeDeleted ?>" alt="<?php echo $TitletToBeDeleted; ?>"
                width="120px" height="70px">
              <div class="form-group">
                <label for="Post" class="FieldInfo">Post:
                  <textarea disabled class="form-control" name="PostDescription" id="Post" cols="100" rows="8">
                    <?php echo $PostToBeDeleted; ?>
                  </textarea>
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
                  <button type="submit" name="Submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Post
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