<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php
// destroy all sessions
$_SESSION["UserId"] = null;
$_SESSION["UserName"] = null;
$_SESSION["AdminName"] = null;
//added by Wim - to delete
$_SESSION["TrackingURL"] = null;

session_destroy();

// redirect to login page
Redirect_to("Login.php");
?>