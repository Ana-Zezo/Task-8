<?php
require_once "../function/helper.php";
session_start();
unset($_SESSION["auth"]);
session_unset();
session_destroy();
redirect("../login.php");
?>