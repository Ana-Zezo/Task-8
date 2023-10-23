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
$sql = "SELECT * FROM `categories`";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                    <h3>Categories Table</h3>
                </div>
                <div class="card-body">
                    <table class="table ">
                        <thead class="border">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($categories as $key => $value): ?>
                                <tr class="border">
                                    <td scope="row">
                                        <?= $count++ ?>
                                    </td>
                                    <td>
                                        <?= $value["title"] ?>
                                    </td>
                                    <td>
                                        <?= $value["desc"] ?>
                                    </td>
                                    <td>
                                        <?= $value["status"] == "1" ? "visible" : "hidden" ?>
                                    </td>
                                    <td>
                                        <img src="img/<?= $value["image"] ?>" width="150" height="150" alt="">
                                    </td>
                                    <td>
                                        <a href="./edit.php?id=<?= $value["id"] ?>" class="btn btn-info">Edit</a>
                                        <a href="./controller/DeleteController.php?id=<?= $value["id"] ?>"
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
<!-- displayCategories.php.php -->