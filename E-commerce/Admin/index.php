<?php
include_once("./pages/header.php");
if (isset($_SESSION["auth"])) {
    if ($_SESSION["auth"]["role"] == 0) {
        $_SESSION["not_auth"] = "You Are Not Authorization To Access Dashboard";
        redirect("../login.php");
        die;
    }
} else {
    $_SESSION["login"] = "Login to Continue";
    redirect("../login.php");
    die;
}
keySession("login_success", "info");
$sql = "SELECT COUNT(*) AS row_count FROM `products`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$countRow = $row["row_count"];
$sqlCat = "SELECT COUNT(*) AS row_count FROM `categories`";
$resultCat = mysqli_query($conn, $sqlCat);
$rowCat = mysqli_fetch_array($resultCat);
$countRowCat = $rowCat["row_count"];
$order_query = "SELECT SUM(`total_price`)As `Total` FROM `orders`";
$resultOrder = mysqli_query($conn, $order_query);
$rowOrder = mysqli_fetch_array($resultOrder, MYSQLI_ASSOC);
$total = $rowOrder["Total"];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="row mt-4 ">
                <div class="col-xl-6 col-sm-6 mb-xl-0 mb-sm-4">
                    <div class="card  mb-2 mb-4">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">category</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-3 text-capitalize">Categories</p>
                                <h4 class="mb-4">
                                    <?= $countRowCat ?>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card  mb-2">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">leaderboard</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-3 text-capitalize">Order</p>
                                <h4 class="mb-4">
                                    <?= $total ?>$
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 mb-xl-0 mb-sm-4">
                    <div class="card  mb-4">
                        <div class="card-header p-3 pt-2 bg-transparent">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">store</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-3 text-capitalize ">products</p>
                                <h4 class="mb-4 ">
                                    <?= $countRow ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header p-3 pt-2 bg-transparent">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">add</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-3 text-capitalize ">Cart</p>
                                <h4 class="mb-4 ">+91</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once("./pages/footer.php");
?>