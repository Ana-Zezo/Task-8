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
keySession("no_data");
$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$myData = $row;

?>
<div class="py-3 mb-4 bg-primary">
    <div class="container">
        <h4 class="text-white">Home / Categories</h4>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            foreach ($myData as $key => $value) {
                if ($myData[$key]["status"] == 1) {
                    ?>
                    <div class="col">
                        <div class="card">
                            <img src="./Admin/img/<?= $myData[$key]['image'] ?> " class="card-img-top w-100" height="250"
                                alt="...">
                            <div class="card-body h-75">
                                <h3 class="card-title">
                                    <?= $myData[$key]["title"] ?>
                                </h3>
                                <p class="card-text">
                                    <?= $myData[$key]["desc"] ?>
                                </p>
                                <a href="./product.php?id=<?= $myData[$key]["id"] ?>&name=<?= $myData[$key]["title"] ?>"
                                    class="btn btn-primary w-100">Product</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
?>
<?php require_once "./pages/footer.php" ?>