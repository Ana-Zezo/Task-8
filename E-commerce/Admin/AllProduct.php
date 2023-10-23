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
$sql = "SELECT * FROM `products`";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                    <h3>Product</h3>
                </div>
                <div class="card-body">
                    <table class="table ">
                        <thead class="border">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $count = 1;
                            foreach ($products as $key => $value): ?>
                                <tr class="border">
                                    <td scope="row">
                                        <?= $count++ ?>
                                    </td>
                                    <td>
                                        <?= $value["name"] ?>
                                    </td>
                                    <td>
                                        <?= $value["price"] ?>
                                    </td>
                                    <td>
                                        <?= $value["status"] == "1" ? "visible" : "hidden" ?>
                                    </td>
                                    <td>
                                        <?= $value["qty"] ?>
                                    </td>
                                    <td>
                                        <img src="img/product_img/<?= $value["image"] ?>" width="150" height="150" alt="">
                                    </td>
                                    <td>
                                        <a href="./EditProduct.php?id=<?= $value["id"] ?>" class="btn btn-info">Edit</a>
                                        <a href="./controller/product/DeleteController.php?id=<?= $value["id"] ?>"
                                            class="btn btn-danger">Delete</a>
                                    </td>
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