<?php
include_once("./pages/header.php");
if (isset($_SESSION["auth"])) {
    if ($_SESSION["auth"]["role"] == 0) {
        $_SESSION["not_auth"] = "You Are Not Authorization To Access Dashboard";
        redirect("../index.php");
        die;
    }
} else {
    $_SESSION["login"] = "Login to Continue";
    redirect("../login.php");
    die;
}
keySession("insert_success", "info");
$sql = "SELECT * FROM `orders`";
$result = mysqli_query($conn, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

keySession("request_error");
keySession("no_exist");
keySession("success_delete", "info");
keySession("not_found");
keySession("update_success", "info");
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>All Orders</h3>
                </div>
                <div class="card-body">
                    <table class="table ">
                        <thead class="border text-center">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Total</th>
                                <th scope="col">image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $count = 1;
                            foreach ($orders as $key => $item):
                                $product_id = $item["product_id"];
                                $user_id = $item["id"];
                                $sql = "SELECT * FROM `products` WHERE `id`=$product_id";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                ?>
                                <tr class="border">
                                    <?php
                                    foreach ($row as $key => $value):
                                        ?>
                                        <form action="./controller/order/ProcessRequest.php" method="POST">
                                            <td scope="row">
                                                <?= $count++ ?>
                                            </td>
                                            <td>
                                                <?= $value["name"] ?>
                                            </td>
                                            <td>
                                                <?= $item["total_price"] ?>
                                            </td>
                                            <td>
                                                <img src="img/product_img/<?= $value["image"] ?>" width="150" height="150"
                                                    alt="">
                                            </td>
                                            <td class="w-25">
                                                <select class="form-select" style="width: 350px;" name="process">
                                                    <?php
                                                    if ($item["process"] === '0') { ?>
                                                        <option value="0">Request Process</option>
                                                        <option value="1">Request Shipped</option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="1" selected>Request Shipping</option>
                                                    </select>
                                                    <?php
                                                    }
                                                    ?>

                                                <input type="hidden" name="order_id" value="<?= $item["id"] ?>" id="">
                                            </td>
                                            <td class="w-25">
                                                <input type="submit" class="btn btn-primary" value="Accept Request">
                                            </td>
                                        </form>
                                        <?php
                                    endforeach;
                                    ?>
                                </tr>
                                <?php
                            endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once("./pages/footer.php");
?>
<!-- displayCategories.php.php -->