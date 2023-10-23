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
keyAndValueSession("insert_product", "name");
keyAndValueSession("insert_product", "price");
keyAndValueSession("insert_product", "qty");
keyAndValueSession("insert_product", "status");
keyAndValueSession("insert_product", "categories");
keyAndValueSession("insert_product", "image");
keySession("insert_success", "info");
$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);
$myArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<div class="container">
    <form action="./controller/product/ProductController.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Product</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Name : </label>
                                    <input type="text" class="form-control border px-3" id="title"
                                        placeholder="Enter Name" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Price : </label>
                                    <input type="number" class="form-control border px-3" id="desc"
                                        placeholder="Enter Price" name="price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Quantity : </label>
                                    <input type="number" class="form-control border px-3" id="desc"
                                        placeholder="Enter Quantity" name="qty">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status : </label>
                                    <select class="form-select form-select-lg mb-3 border px-3"
                                        aria-label="Large select example" name="status" id="status">
                                        <option selected>Open menu</option>
                                        <option value="0">Hidden</option>
                                        <option value="1">Show</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="img" class="form-label">Image : </label>
                                        <input class="form-control border" type="file" id="img" name="image">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cat" class="form-label">Categories : </label>
                                    <select class="form-select form-select-lg mb-3 border px-3"
                                        aria-label="Large select example" name="cat_id" id="cat">
                                        <option selected>Open menu</option>
                                        <?php
                                        foreach ($myArr as $key => $value) {
                                            $id = $value["id"];
                                            $title = $value["title"];
                                            echo "<option value='$id'>$title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="my-3">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Add Product</button>
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