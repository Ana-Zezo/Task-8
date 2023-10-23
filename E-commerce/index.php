<?php require_once "./pages/header.php" ?>
<?php require_once "./pages/navbar.php";
require_once "./function/helper.php";
if (!isset($_SESSION["auth"])) {
    redirect("./login.php");
    die;
} else {
    if ($_SESSION["auth"]["role"] == 1) {
        $_SESSION["not_auth"] = "You Are Authorization To Access Dashboard";
        redirect("./login.php");
        die;
    }
}
?>
<h1>Home</h1>
<?php
keySession("login_success", "success");
keySession("not_auth", "warning");
?>
<?php require_once "./pages/footer.php" ?>