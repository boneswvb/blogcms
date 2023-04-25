<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php
if (isset($_POST["Submit"])) {
  // Get data from the input field
  $Name = $_POST["CommentorName"];
  $Email = $_POST["CommentorEmail"];
  $Comment = $_POST["CommentorThoughts"];
  $CurrentTime = time();
  $DateTime = date("j F Y h:i:s");

  // Sanitize the date received from the input field
  if (empty($Name) || empty($Email) || empty($Comment)) {
    $_SESSION["ErrorMessage"] = "All fields must be completed";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  } elseif (strlen($Comment) > 500) {
    $_SESSION["ErrorMessage"] = "Comment should have less than 500 caracters";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  } else {
    //  insert commentors details and comments into the database
    global $ConnectingDB; // only needed for php 5.6
    $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
    $sql .= "VALUES(:dateTime,:namE,:emaiL,:commenT,'Pending','OFF',:postIdFromUrl)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':namE', $Name);
    $stmt->bindValue(':emaiL', $Email);
    $stmt->bindValue(':commenT', $Comment);
    $stmt->bindValue(':postIdFromUrl', $SearchQueryParameter);
    $Execute = $stmt->execute();

    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Comment submitted successfully";
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong. Please try again.";
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }
  } //end if condition
} // End submit button 
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Full Blog</title>
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
            <a href="Blog.php" class="nav-link" aria-current="page">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" aria-current="page">About US</a>
          </li>
          <li class="nav-item">
            <a href="Blog.php" class="nav-link">Blog</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" aria-current="page">Contact US</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" aria-current="page">Features</a>
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
          //default sql query
        } else {
          $PostIdFromURL = $_GET["id"];
          if (!isset($PostIdFromURL)) {
            $_SESSION["ErrorMessage"] = "Bad Request!";
            Redirect_to("Blog.php");
          }
          $sql = "SELECT * FROM post WHERE id = '$PostIdFromURL'";
          $stmt = $ConnectingDB->query($sql);
          $Result = $stmt->rowcount();
          if ($Result != 1) {
            $_SESSION["ErrorMessage"] = "Bad Request!";
            Redirect_to("Blog.php?page=1");
          }
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
              <hr>
              <p class="card-text">
                <?php
                echo htmlentities($PostDescription);
                ?>
              </p>
            </div>
          </div>
          <br>
        <?php } ?>
        <!-- comment start -->

        <!-- fetching existing comments  -->
        <span class="fieldInfo">Comments</span>
        <br>
        <br>
        <?php
        $ConnectingDB;
        $sql = "SELECT * FROM comments 
        WHERE post_id='$SearchQueryParameter' AND status='ON'";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
          $CommentDate = $DataRows['datetime'];
          $CommenterName = $DataRows['name'];
          $CommentContent = $DataRows['comment'];
          ?>
          <!-- showing the comments on the page  -->
          <div>
            <div class="media" style="background-color: #f6f7f9;">
              <img class="rounded float-start img-fluid" style="width: 100px" src="images/comment.jpeg"
                alt="default image">
              <div class="media-body ml-2">
                <h6 class="lead">
                  <?php echo htmlentities($CommenterName); ?>
                </h6>
                <p class="small">
                  <?php echo htmlentities($CommentDate); ?>
                </p>
                <p>
                  <?php echo htmlentities($CommentContent); ?>
                </p>
              </div>
            </div>
          </div>
          <hr>
        <?php } ?>
        <!-- fetching existing end -->
        <div class="">
          <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="fieldInfo">Share your thoughts about this blog</h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-user" style="height:26px"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" name="CommentorName" id="" placeholder="Name" value="">
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-envelope" style="height:26px"></i>
                      </span>
                    </div>
                    <input class="form-control" type="email" name="CommentorEmail" id="" placeholder="Email" value="">
                  </div>
                </div>
                <br>
                <div class="form-group">
                  <textarea name="CommentorThoughts" class="form-control" id="" cols="80" rows="4"></textarea>
                </div>
                <br>
                <button type="submit" name="Submit" class="btn btn-primary">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- comment end  -->
      <!-- main area end -->

      <?php require_once("Footer.php"); ?>