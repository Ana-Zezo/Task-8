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
keyAndValueSession("insert_categories", "title");
keyAndValueSession("insert_categories", "desc");
keyAndValueSession("insert_categories", "status");
keyAndValueSession("insert_categories", "image");
keySession("insert_success", "info");
?>
<div class="container">
    <form action="./controller/CategoriesController.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Categories</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Name : </label>
                                    <input type="text" class="form-control border px-3" id="title"
                                        placeholder="Enter Name" name="title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Description : </label>
                                    <input type="text" class="form-control border px-3" id="desc"
                                        placeholder="Enter Description" name="desc">
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
                                <div class="my-3">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Add Categories</button>
                                        <a href="./displayCategories.php" class="btn btn-dark ">Categories</a>
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