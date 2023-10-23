<?php require_once "./pages/header.php" ?>
<?php require_once "./pages/navbar.php" ?>
<div class="py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center py-2">Register</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION["auth"])) {
                            unset($_SESSION["auth"]);
                        }
                        unset($_SESSION["login_error"]);
                        unset($_SESSION["message"]);
                        keySession("email_exist");
                        keySession("request_error");
                        keySession("register_fail");
                        keyAndValueSession("register_error", "name");
                        keyAndValueSession("register_error", "phone");
                        keyAndValueSession("register_error", "email");
                        keyAndValueSession("register_error", "password");
                        keyAndValueSession("register_error", "confPassword");
                        keyAndValueSession("register_error", "role");
                        keySession("confirm_password_error");
                        ?>
                        <form action="controller/RegisterController.php" method="POST">
                            <div class="mb-3">
                                <label for="userName" class="form-label">UserName</label>
                                <input type="text" class="form-control" id="userName" placeholder="Enter UserName"
                                    name="name">
                            </div>
                            <div class="mb-3">
                                <label for="Phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="Phone" placeholder="Enter Phone"
                                    name="phone">
                            </div>
                            <div class="mb-3">
                                <label for="Email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="Email" placeholder="Enter Email"
                                    name="email">
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" placeholder="Enter Password" name="password" class="form-control"
                                    id="Password">
                            </div>
                            <div class="mb-3">
                                <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" placeholder="Confirm Password" name="confPassword"
                                    class="form-control" id="ConfirmPassword">
                            </div>
                            <div class="mb-3">
                                <label for="ConfirmPassword" class="form-label">Choose Status</label>
                                <select class="form-select" name="role">
                                    <option value="">Choose Status</option>
                                    <option value="1">Admin</option>
                                    <option value="0">Costumer</option>
                                </select>
                            </div>
                            <div class="my-4 d-flex justify-content-around">
                                <button type="submit" class="btn btn-primary w-25">Submit</button>
                                <a href="login.php" class="btn btn-dark w-50">Already Have Account</a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php require_once "./pages/footer.php" ?>