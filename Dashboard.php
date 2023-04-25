<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login()
  ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
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
          <h1><i class="fas fa-cog" style="color:#27aae1"></i> Dashboard</h1>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="AddNewPost.php" class="btn btn-primary btn-block">
            <i class="fas fa-edit"> Add new Post</i>
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Categories.php" class="btn btn-info btn-block">
            <i class="fas fa-folder-plus"> Add new category</i>
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Admins.php" class="btn btn-warning btn-block">
            <i class="fas fa-user-plus"> Add new Admin</i>
          </a>
        </div>
        <div class="col-lg-3 mb-2">
          <a href="Comments.php" class="btn btn-success btn-block">
            <i class="fas fa-user-check"> Approve comments</i>
          </a>
        </div>
      </div>
    </div>
  </header>
  <!-- header end  -->

  <!-- main area start  -->
  <section class="container py-2 mb-4">
    <div class="row">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
      ?>
      <!-- left side area start -->
      <div class="col-lg-2">
        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Posts</h1>
            <h4 class="display-5">
              <i class="fab fa-readme">
                <?php
                totalPosts();
                ?>
              </i>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Categories</h1>
            <h4 class="display-5">
              <i class="fas fa-folder">
                <?php
                totalCategories();
                ?>
              </i>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Admins</h1>
            <h4 class="display-5">
              <i class="fas fa-users">
                <?php
                TotalAdmins();
                ?>
              </i>
            </h4>
          </div>
        </div>

        <div class="card text-center bg-dark text-white mb-3">
          <div class="card-body">
            <h1 class="lead">Comments</h1>
            <h4 class="display-5">
              <i class="fas fa-comments">
                <?php
                TotalComments();
                ?>
              </i>
            </h4>
          </div>
        </div>
      </div>
      <!-- left side area end  -->

      <!-- main right side area start -->
      <div class="col-lg-10">
        <h1>Latest posts</h1>
        <table class="table table-striped table-hover">
          <thead class="dark">
            <tr>
              <th>No.</th>
              <th>Title</th>
              <th>Date & Time</th>
              <th>Author</th>
              <th>Comments</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          $SrNo = 0;
          $ConnectingDB;
          $sql = "SELECT * FROM post ORDER BY id desc limit 0,5";
          $stmt = $ConnectingDB->query($sql);
          while ($DataRows = $stmt->fetch()) {
            $PostId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $Author = $DataRows["author"];
            $Title = $DataRows["title"];
            $SrNo++
              ?>
            <tbody>
              <td>
                <?php echo $SrNo; ?>
              </td>
              <td>
                <?php echo $Title; ?>
              </td>
              <td>
                <?php echo $DateTime; ?>
              </td>
              <td>
                <?php echo $Author; ?>
              </td>
              <td>
                <?php
                $Total = ApproveCommentsAccordingToPosts($PostId);
                if ($Total > 0) {
                  ?>
                  <span class="badge text-bg-success">
                    <?php
                    echo $Total;
                    ?>
                  </span>
                <?php } ?>
                <?php
                $Total = NotApproveCommentsAccordingToPosts($PostId);
                if ($Total > 0) {
                  ?>
                  <span class="badge text-bg-danger">
                    <?php
                    echo $Total;
                    ?>
                  </span>
                <?php } ?>
              </td>
              <td>
                <span class="btn btn-info">
                  <a target="_blank" href="FullPost.php?id=<?php echo $PostId ?>">Preview</a>
                </span>
              </td>
            </tbody>
          <?php } ?>
        </table>
      </div>
      <!-- main right side area end  -->
    </div>
  </section>


  <!-- main area end  -->

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