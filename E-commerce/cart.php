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
// Select ALL Product 
$product_query = "SELECT * FROM `products`";
$product_result = mysqli_query($conn, $product_query);
$row_product = mysqli_fetch_all($product_result, MYSQLI_ASSOC);

// Select All carts
$cart_query = "SELECT * FROM `carts` WHERE `user_id`=$user_id";
$cart_result = mysqli_query($conn, $cart_query);
$row_cart = mysqli_fetch_all($cart_result, MYSQLI_ASSOC);

// Count Of Row In Carts
$sql = "SELECT COUNT(*) AS row_count FROM `carts`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$countRow = $row["row_count"];
?>
<div class="py-5">
    <div class="container">
        <?php
        keySession("success_order", "success");
        keySession("no_exist_product");
        ?>
        <h3 class="mb-4 text-center">Your Product</h3>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $countId = 1;
                    foreach ($row_cart as $item):
                        // dd($item);
                        $product_id = $item["product_id"];
                        $cart_id = $item["id"];
                        $sql = "SELECT * FROM `products` WHERE `id`=$product_id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        ?>

                    <tr class="text-center">
                        <?php
                            foreach ($row as $key => $item) {
                                ?>
                        <form
                            action="./controller/OrderController.php?cart_id=<?= $cart_id ?>&product_id=<?= $product_id ?>"
                            method="POST">
                            <th>
                                <?= $countId++ ?>
                            </th>
                            <td>
                                <?= $row[$key]["name"] ?>
                            </td>
                            <td>
                                <?= $row[$key]["price"] ?>
                            </td>
                            <td>
                                <select class="form-select" style="width: 100px; margin: 0 auto" name="qty">
                                    <?php
                                            for ($i = 1; $i <= $row[$key]["qty"]; $i++): ?>
                                    <option value="<?= $i ?>">
                                        <?= $i ?>
                                    </option>
                                    <?php
                                            endfor;
                                            ?>
                                </select>
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                            </td>
                            <td>
                                <img src="./Admin/img/product_img/<?= $row[$key]["image"] ?>" width="100" height="100"
                                    alt="">
                            </td>
                            <td>
                                <input type="submit" class="btn btn-info" value="Add Order">
                                <a href="./controller/DeleteCartController.php?cart_id=<?= $cart_id ?>&user_id=<?= $user_id ?>"
                                    class="btn btn-danger">Delete</a>
                            </td>
                        </form>
                        <?php
                            }
                            ?>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<?php require_once "./pages/footer.php" ?>