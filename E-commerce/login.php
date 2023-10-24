<?php require_once "./pages/header.php" ?>
<?php require_once "./pages/navbar.php" ?>
<div class="py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center py-2">Login</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION["auth"])) {
                            unset($_SESSION["auth"]);
                        }
                        unset($_SESSION["login_success"]);
                        unset($_SESSION["register_error"]);
                        keySession("not_auth");
                        keySession("login");
                        keySession("register_success", "success");
                        keySession("request_error");
                        keyAndValueSession("login_error", "email");
                        keyAndValueSession("login_error", "password");
                        keySession("message");
                        keySession("password_error");

                        ?>
                        <form action="controller/LoginController.php" method="POST">
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

                            <div class="my-4 d-flex justify-content-around">
                                <button type="submit" class="btn btn-primary w-25">Login</button>
                                <a href="register.php" class="btn btn-dark w-50">Create Account</a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php require_once "./pages/footer.php" ?>