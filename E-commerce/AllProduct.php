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
$sql = "SELECT * FROM `products`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<div class="py-3 mb-4 bg-primary">
    <div class="container">
        <h4 class="text-white">Home / Categories / Products</h4>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            foreach ($row as $key => $value) {
                if ($row[$key]["status"] == 1) {
                    ?>
            <div class="col">
                <div class="card">
                    <img src="./Admin/img/product_img/<?= $row[$key]['image'] ?> " class="card-img-top w-100"
                        height="250" alt="...">
                    <div class="card-body h-75">
                        <h3 class="card-title">
                            <?= $row[$key]["name"] ?>
                        </h3>
                        <p class="card-text">
                            <?= $row[$key]["price"] ?>
                        </p>
                        <a href="./controller/AddCart.php?id=<?= $row[$key]["id"] ?>" class="btn btn-primary w-100">Add
                            Product</a>
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