<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Comments</title>
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
          <h1><i class="fas fa-comments" style="color:#27aae1"></i> Managing of Comments</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- header end  -->

  <!-- main area start -->
  <section class="container py-2 mb-4">
    <div class="row" style="min-height: 30px">
      <div class="col-lg-12" style="min-height: 400px">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <h2>Un-approved comments</h2>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Date & Time</th>
              <th>Name</th>
              <th>Comment</th>
              <th>Approve</th>
              <th>Delete</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $CommentId = $DataRows["id"];
            $CommentDateTime = $DataRows["datetime"];
            $CommenterName = $DataRows["name"];
            $CommentContent = $DataRows["comment"];
            $CommentPostId = $DataRows["post_id"];
            $SrNo++;
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo htmlentities($SrNo); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommentDateTime); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommenterName); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommentContent); ?>
                </td>
                <td style="min-width: 140px">
                  <a href="ApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-success">
                    Approve
                  </a>
                </td>
                <td style="min-width: 140px">
                  <a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">
                    Delete
                  </a>
                </td>
                <td style="min-width: 140px">
                  <a href="FullPost.php?id=<?php echo $CommentPostId; ?>" class="btn btn-primary" target="_blank">
                    Live Preview
                  </a>
                </td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
        <h2>Approved comments</h2>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Date & Time</th>
              <th>Name</th>
              <th>Comment</th>
              <th>Revert</th>
              <th>Delete</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $CommentId = $DataRows["id"];
            $CommentDateTime = $DataRows["datetime"];
            $CommenterName = $DataRows["name"];
            $CommentContent = $DataRows["comment"];
            $CommentPostId = $DataRows["post_id"];
            $SrNo++;
            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo htmlentities($SrNo); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommentDateTime); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommenterName); ?>
                </td>
                <td>
                  <?php echo htmlentities($CommentContent); ?>
                </td>
                <td style="min-width: 140px">
                  <a href="DisApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">
                    Dis-Approve
                  </a>
                </td>
                <td style="min-width: 140px">
                  <a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">
                    Delete
                  </a>
                </td>
                <td style="min-width: 140px">
                  <a href="FullPost.php?id=<?php echo $CommentPostId; ?>" class="btn btn-primary" target="_blank">
                    Live Preview
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