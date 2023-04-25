<?php require_once("includes/DB.php"); ?>

<?php
function Redirect_to($new_Location)
{
  header("Location:" . $new_Location);
  exit;
}

function CheckIfUserNameExist($UserName)
{
  global $ConnectingDB; //use global in functions or the functon will give error
  $sql = "SELECT username FROM admins WHERE username=:usernamE";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue('usernamE', $UserName);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result == 1) {
    return true;
  } else {
    return false;
  }
}

function Login_Attempt($UserName, $Password)
{
  global $ConnectingDB;
  $sql = "SELECT * FROM admins WHERE username = :usernamE AND password = :passworD LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':usernamE', $UserName);
  $stmt->bindValue(':passworD', $Password);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result == 1) {
    return $Found_Account = $stmt->fetch();
  } else {
    return null;
  }
}

function Confirm_Login()
{
  if (isset($_SESSION["UserId"])) {
    return true;
  } else {
    $_SESSION["ErrorMessage"] = "Login Required";
    Redirect_to("Login.php");
  }
}

function TotalPosts()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM post";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalPosts = array_shift($TotalRows);
  echo $TotalPosts;
}
function TotalCategories()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM category";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalCategories = array_shift($TotalRows);
  echo $TotalCategories;
}
function TotalAdmins()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM admins";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalAdmins = array_shift($TotalRows);
  echo $TotalAdmins;
}
function TotalComments()
{
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM comments";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalComments = array_shift($TotalRows);
  echo $TotalComments;
}

function ApproveCommentsAccordingToPosts($PostId)
{
  global $ConnectingDB;
  $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
  $stmtApprove = $ConnectingDB->query($sqlApprove);
  $RowsTotal = $stmtApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}

function NotApproveCommentsAccordingToPosts($PostId)
{
  global $ConnectingDB;
  $sqlNotApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
  $stmtNotApprove = $ConnectingDB->query($sqlNotApprove);
  $RowsTotal = $stmtNotApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}


?>