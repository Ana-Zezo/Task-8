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
if (!isset($_GET["id"]) && !isset($_GET["title"])) {
    $_SESSION["no_data"] = "Not Found Data";
    redirect("./categories.php");
    die;
}
$sql = "SELECT * FROM `products`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$myData = $row;
$id = $_GET["id"];
$title = $_GET["name"];
?>
<div class="py-3 mb-4 bg-primary">
    <div class="container">
        <h4 class="text-white">
            <a href="index.php" class="text-white text-capitalize text-decoration-none">Home</a> /
            <a href="./categories.php" class="text-white text-capitalize text-decoration-none">Categories</a> /
            <a href="./product.php" class="text-white text-capitalize text-decoration-none">
                <?= $title ?>
            </a>
        </h4>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <?php
        keySession("insert_data", "success");
        ?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            foreach ($myData as $key => $value) {
                if ($myData[$key]["status"] == 1 && $myData[$key]['cat_id'] == $id) {
                    ?>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="card">
                            <img class="card-img" height="280" src="./Admin/img/product_img/<?= $myData[$key]["image"] ?>"
                                alt="<?= $myData[$key]["name"] ?>">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?= $myData[$key]["name"] ?>
                                </h4>
                                <div class="buy d-flex justify-content-between align-items-center">
                                    <div class="price text-success">
                                        <h5 class="mt-4">$
                                            <?= $myData[$key]["price"] ?>
                                        </h5>
                                    </div>
                                    <a href="./controller/AddCart.php?id=<?= $myData[$key]["id"] ?>"
                                        class="btn btn-danger mt-3">
                                        Add Cart
                                    </a>
                                </div>
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