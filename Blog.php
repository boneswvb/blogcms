<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Read our blogs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://kit.fontawesome.com/5b7ab696fa.js" crossorigin="anonymous"></script>
  <style>
    .heading {
      font-family: Bitter, Georgia, "Times new Roman", Serif;
      font-weight: bold;
      color: #005e90;
    }

    .heading:hover {
      color: #0090db;
    }
  </style>
</head>

<body>
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
  <div class="container">
    <div class="row mt-4">

      <!-- main area start -->
      <div class="col-sm-8">
        <h1>The complete responsive CMS Blog</h1>
        <h1 class="lead">A complete blog website using PHP</h1>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <?php
        $ConnectingDB;
        // PHP for the search button
        if (isset($_GET["SearchButton"])) {
          $Search = $_GET["Search"];
          $sql = "SELECT * FROM post 
          WHERE datetime LIKE :search
          OR  title LIKE :search
          OR  category LIKE :search
          OR  post LIKE :search";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':search', '%' . $Search . "%");
          $stmt->execute();
        }
        // pagination
        elseif (isset($_GET["page"])) {
          $Page = $_GET["page"];
          if ($Page == 0 || $Page < 1) {
            $ShowPageFrom = 0;
          } else {
            $ShowPageFrom = ($Page * 5) - 5;
          }
          $sql = "SELECT * FROM post ORDER BY id desc LIMIT $ShowPageFrom,5";
          $stmt = $ConnectingDB->query($sql);
        }
        // display post according to category that is selected
        elseif (isset($_GET["category"])) {
          $Category = $_GET["category"];
          $sql = "SELECT * FROM post WHERE category = :categoryName";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':categoryName', $Category);
          $stmt->Execute();
        }
        // default sql query
        else {
          $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,3";
          $stmt = $ConnectingDB->query($sql);
        }
        while ($DataRows = $stmt->fetch()) {
          $PostId = $DataRows["id"];
          $DateTime = $DataRows["datetime"];
          $PostTitle = $DataRows["title"];
          $Category = $DataRows["category"];
          $Admin = $DataRows["author"];
          $Image = $DataRows["image"];
          $PostDescription = $DataRows["post"];
          ?>
          <div class="card mb-2">
            <img src="uploads/<?php echo htmlentities($Image); ?>" alt="<?php echo $PostTitle; ?>"
              class="img-fluid card-img-top" style="max-height: 450px">
            <div class="card-body">
              <h4 class="card-title">
                <?php echo htmlentities($PostTitle); ?>
              </h4>
              <small class="text-body-secondary">
                Category:
                <span class="text-dark">
                  <strong>
                    <a href="Blog.php?category=<?php echo htmlentities($Category); ?>">
                      <?php echo htmlentities($Category); ?>
                    </a>
                  </strong>
                </span>
                . Written by
                <span class="text-dark">
                  <strong>
                    <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>">
                      <?php echo htmlentities($Admin); ?>
                    </a>
                  </strong>
                </span>
                On
                <span class=" text-dark">
                  <?php echo htmlentities($DateTime); ?>
                </span>
              </small>
              <span style="float: right;" class="badge bg-secondary">
                Comments
                <?php
                echo ApproveCommentsAccordingToPosts($PostId);
                ?>
              </span>
              <hr>
              <p class="card-text">
                <?php
                if (strlen($PostDescription) > 150) {
                  $PostDescription = substr($PostDescription, 0, 150) . "...";
                }
                echo htmlentities($PostDescription);
                ?>
              </p>
              <a href="FullPost.php?id=<?php echo $PostId ?>" style="float: right;">
                <span class="btn btn-info">Read More >></span>
              </a>
            </div>
          </div>
          <br>
        <?php } ?>

        <!-- pagination start -->
        <nav>
          <ul class="pagination pagination-lg">
            <!-- back button for pagination start -->
            <?php
            if (isset($Page)) {
              if ($Page > 1) {
                ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page - 1 ?>" class="page-link">&laquo;</a>
                </li>
                <?php
              }
            }
            ?>
            <!-- back button for pagination end -->
            <?php
            $ConnectingDB;
            $sql = "SELECT COUNT(*) FROM post";
            $stmt = $ConnectingDB->query($sql);
            $RowPgination = $stmt->fetch();
            $TotalPost = array_shift($RowPgination);
            $PostPagination = $TotalPost / 5;
            $PostPagination = ceil($PostPagination);
            for ($i = 1; $i <= $PostPagination; $i++) {
              if (isset($Page)) {
                if ($i == $Page) {
                  ?>
                  <li class="page-item active">
                    <a href="Blog.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a>
                  </li>
                  <?php
                } else {
                  ?>
                  <li class="page-item">
                    <a href="Blog.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a>
                  </li>
                  <?php
                }
              } else {
                ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a>
                </li>
                <?php
              }
            }
            ?>
            <!-- forward button for pagination start -->
            <?php
            if (isset($Page) && !empty($Page)) {
              if ($Page + 1 <= $PostPagination) {
                ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page + 1 ?>" class="page-link">&raquo;</a>
                </li>
                <?php
              }
            }
            ?>
            <!-- forward button for pagination end -->
          </ul>
        </nav>
        <!-- pagination end -->

      </div>
      <!-- main area end -->

      <?php require_once("Footer.php"); ?>