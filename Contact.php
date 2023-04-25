<?php
$NameError = "";
$EmailError = "";
$GenderError = "";
$WebsiteError = "";

// check if the form fields are completed and fields have valid input
if (isset($_POST["Submit"])) {
  if (empty($_POST["Name"])) {
    $NameError = "This field is required";
  } else {
    $Name = Test_User_Input($_POST["Name"]);
    if (!preg_match("/^[A-za-z .]*$/", $Name)) {
      $NameError = "Only spaces and letter allowed";
    }
  }

  if (empty($_POST["Email"])) {
    $EmailError = "This field is required";
  } else {
    $Email = Test_User_Input($_POST["Email"]);
    if (!preg_match("/[A-za-z0-9._-]{3,}@[A-za-z0-9._-]{3,}[.]{1}[A-za-z0-9._-]{2,}/", $Email)) {
      $EmailError = "Incorrect email format";
    }
  }

  if (empty($_POST["Gender"])) {
    $GenderError = "This field is required";
  } else {
    $Gender = Test_User_Input($_POST["Gender"]);
  }

  if (empty($_POST["Website"])) {
    $WebsiteError = "This field is required";
  } else {
    $Website = Test_User_Input($_POST["Website"]);
    if (!preg_match("/(https:|http:|ftp:)\/\/+[a-zA-Z0-9.\-\/?\$\=\~]+\.[a-zA-Z0-9.\-\/?\$\=\~]*/", $Website)) {
      $WebsiteError = "Incorrect website adress format";
    }
  }

  // do not display data if not correct
  if (!empty($_POST["Name"]) && !empty($_POST["Email"]) && !empty($_POST["Gender"]) && !empty($_POST["Website"]) && !empty($_POST["Comment"])) {
    if (preg_match("/^[A-za-z .]*$/", $Name) && preg_match("/[A-za-z0-9._-]{3,}@[A-za-z0-9._-]{3,}[.]{1}[A-za-z0-9._-]{2,}/", $Email) && preg_match("/(https:|http:|ftp:)\/\/+[a-zA-Z0-9.\-\/?\$\=\~]+\.[a-zA-Z0-9.\-\/?\$\=\~]*/", $Website)) {
      echo "<h2>Details submitted</h2>";
      echo "Name: " . ucwords($_POST["Name"]) . "<br>";
      echo "Email: " . $_POST["Email"] . "<br>";
      echo "Gender: " . $_POST["Gender"] . "<br>";
      echo "Website: " . $_POST["Website"] . "<br>";
      echo "Comments: " . $_POST["Comment"] . "<br>";
    }
  }
  //Send email to somewhere
  $emailTo = "boneswvb@gmail.com";
  $subject = "Web form info received";
  $body = "Name: " . $_POST["Name"] . "<br>" . "Email: " . $_POST["Email"] . "<br>"
    . "Gender: " . $_POST["Gender"] . "<br>" . "Website: " . $_POST["Website"]
    . "Comments: " . $_POST["Comment"];
  $Sender = "From:info@lesawi.co.za";

  if (mail($emailTo, $subject, $body, $Sender)) {
    echo "Mail was send";
  } else {
    echo "Mail not send";
  }
}

// get and return user data from the form
function Test_User_Input($Data)
{
  return $Data;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CMS Blogging Site</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://kit.fontawesome.com/5b7ab696fa.js" crossorigin="anonymous"></script>
  <style type="text/css">
    input[type=text],
    input[type=email],
    textarea {
      border: 1px solid_dashed;
      background-color: rgb(221, 226, 212);
      width: 600px;
      padding: .5em;
      font-size: 1.0em;
    }

    .error {
      color: red;
    }
  </style>
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
          <h1><i class="fas fa-text-height" style="color:#27aae1"></i> Basic</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- header end  -->

  <!-- main area start -->
  <div class="container">
    <div class="row">
      <!-- left side with form start -->
      <h1 class="text-center my-5">If you need to get hold of us.</h1>
      <div class="col-lg-6">
        <form action="FormValidationWim.php" method="post">
          <legend>* Please Fill Out the following Fields.</legend>
          <fieldset>
            Name:<br>
            <input class="input form-control" type="text" Name="Name" value="">
            <span class="error">*
              <?php echo $NameError ?>
            </span>
            <br>
            E-mail:<br>
            <input class="input form-control" type="text" Name="Email" value="">
            <span class="error">*
              <?php echo $EmailError ?>
            </span>
            <br>
            Gender:<br>
            <input class="radio" type="radio" Name="Gender" value="Female"> Female
            <br>
            <input class="radio" type="radio" Name="Gender" value="Male"> Male
            <span class="error">*
              <?php echo $GenderError ?>
            </span>
            <br>
            Website:<br>
            <input class="input form-control" type="text" Name="Website" value="">
            <span class="error">*
              <?php echo $WebsiteError ?>
            </span>
            <br>
            Comment:
            <br>
            <textarea style="border: none; border-radius: 10px;" Name="Comment" rows="5" cols="25"></textarea>
            <br>
            <br>
            <input class="form-control btn btn-danger" type="Submit" Name="Submit" value="Submit Your Information">
          </fieldset>
        </form>
      </div>
      <!-- left side with form end -->

      <!-- right side with end -->
      <div class="col-lg-6">
        <span class="text-center">
          <h1 class="text-center">Adress</h1>
          <p>Aress 1</p>
          <p>Aress 2</p>
          <p>Aress 3</p>
          <p>Aress 4</p>
        </span>
        <br>
        <span class="text-center">
          <h1 class="text-center">Contact Numbers</h1>
          <p><strong>Department Name:</strong> +27 (0)12 345 6789</p>
          <p><strong>Department Name:</strong> +27 (0)12 345 6789</p>
          <p><strong>Department Name:</strong> +27 (0)12 345 6789</p>
        </span>
        <br>
        <!-- </div> -->
        <span class="text-center">
          <h1 class="text-center my-5">Social Media</h1>
          <p class="mb-5">
            <a href="#"><i class="fa-brands fa-square-facebook fa-2xl"></i></a>
            <a href="#"><i class="fa-brands fa-square-twitter fa-2xl"></i></a>
            <a href="#"><i class="fa-brands fa-square-whatsapp fa-2xl"></i></a>
            <a href="#"><i class="fa-brands fa-square-instagram fa-2xl"></i></a>
          </p>
        </span>
      </div>
      <!-- right side with end -->
    </div>
    <!-- main area start -->

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