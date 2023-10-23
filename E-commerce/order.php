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
$user_id = $_GET["user_id"];
// Select All Order
$order_query = "SELECT * FROM `orders` WHERE `user_id`=$user_id";
$order_result = mysqli_query($conn, $order_query);
$row_order = mysqli_fetch_all($order_result, MYSQLI_ASSOC);

$sql = "SELECT COUNT(*) AS row_count FROM `orders`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$countRow = $row["row_count"];
// Select All Products
$product_query = "SELECT * FROM `products`";
$product_result = mysqli_query($conn, $product_query);
$row_product = mysqli_fetch_all($product_result, MYSQLI_ASSOC);
?>
<div class="py-5">
    <div class="container">
        <?php
        keySession("insert_data", "success");
        keySession("no_exist_product");
        keySession("order_shipped", "success");
        ?>
        <div class="card mb-3 w-100" style="height: 300px;">
            <div class="row">
                <?php
                foreach ($row_order as $item):
                    // dd($item);
                    $product_id = $item["product_id"];
                    // $order_id = $item["id"];
                    $sql = "SELECT * FROM `products` WHERE `id`=$product_id";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $total = $item["total_price"];
                    $status = $item["process"];
                    foreach ($row as $key => $item):
                        ?>

                        <div class="col-12 border mb-5 p-0 m-0 d-flex justify-content-start">
                            <div class="col-md-3 mb-3 col-lg-3">
                                <div class="card-img">
                                    <img src="./Admin/img/product_img/<?= $row[$key]["image"] ?>"
                                        class="img-fluid rounded-start" alt="..." style="width:100%;height:300px; margin:0;">
                                </div>
                            </div>
                            <div class="col-md-8 px-0 mb-3 col-lg-9">
                                <div class="card-body">
                                    <!-- <h5 class="card-title">
                                <?= $row[$key]["name"] ?>
                            </h5> -->
                                    <div class="price d-flex align-items-center">
                                        <h5 class="" style="margin-right: 10px ;">
                                            Name :
                                        </h5>
                                        <h5 class="">
                                            <?= ucfirst($row[$key]["name"]) ?>
                                        </h5>
                                    </div>
                                    <div class="price d-flex align-items-center my-5">
                                        <h5 style="margin-right: 10px ;">
                                            TOTAL PRICE :
                                        </h5>
                                        <h5 class="text-success">
                                            <?= " " . $total ?>$
                                        </h5>
                                    </div>
                                    <div class="price d-flex align-items-center my-5">
                                        <h5 style="margin-right: 10px ;">
                                            STATUS :
                                        </h5>
                                        <?php if ($status == '0'): ?>
                                            <h5 class="text-danger">
                                                <?= "Request In Process" ?>
                                            </h5>
                                        <?php else:
                                            $_SESSION["order_shipped"] = "Order Is Being Shipped";
                                            $delete_query = "DELETE FROM `orders` WHERE `process`='1'";
                                            $delete_result = mysqli_query($conn, $delete_query);
                                            echo "<script>location.reload();</script>";
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>
<?php
?>
<?php require_once "./pages/footer.php" ?>