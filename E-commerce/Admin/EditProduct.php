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
keySession("request_error");
keyAndValueSession("update_error", "name");
keyAndValueSession("update_error", "price");
keyAndValueSession("update_error", "status");
keyAndValueSession("update_error", "qty");
keyAndValueSession("update_error", "image");
keySession("update_success", "info");
if (isset($_GET["id"])) {
    $sql = "SELECT * FROM `products`";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($products as $key => $item) {
        if ($products[$key]["id"] == $_GET["id"]) {
            $myArr = $products[$key];
        }
    }
} else {
    $_SESSION["not_found"] = "Page Not Found";
    echo "<a href='./AllProduct.php' class='btn btn-primary'>Go Back</a>";
    die;
}

?>
<div class="container">
    <form action="./controller/product/UpdateController.php?id=<?= $myArr["id"] ?>" method="POST"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Update Product</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Name : </label>
                                    <input type="text" class="form-control border px-3" id="title"
                                        placeholder="Enter Name" name="name" value="<?= $myArr["name"] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Price : </label>
                                    <input type="number" class="form-control border px-3" id="title"
                                        placeholder="Enter Price" name="price" value="<?= $myArr["price"] ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status : </label>
                                    <select class="form-select form-select-lg mb-3 border px-3"
                                        aria-label="Large select example" name="status" id="status">
                                        <?php
                                        echo $myArr["status"] == 0 ?
                                            "<option selected value='0'>0</option><option  value='1'>1</option>"
                                            : "<option value='0'>0</option><option selected value='1'>1</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Quantity : </label>
                                    <input type="number" class="form-control border px-3" id="title"
                                        placeholder="Enter Quantity" name="qty" value="<?= $myArr["qty"] ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="img" class="form-label">Image : </label>
                                        <input class="form-control border" type="file" id="img" name="image">
                                        <img src="img/product_img/<?= $myArr['image'] ?>" width="75" height="75"
                                            class="mt-2" alt="">
                                        <input type="hidden" name="image" value="<?= $myArr["image"] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="my-3">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-info">Update</button>
                                        <a href="./AllProduct.php" class="btn btn-dark ">Product</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include_once("./pages/footer.php");
?>