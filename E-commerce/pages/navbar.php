<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-Commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <?php if (!isset($_SESSION["auth"])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="./register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Login</a>
                </li>
                <?php
                else:
                    ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <?php
                        $user_id = $_SESSION["auth"]["id"];
                        ?>
                    <a class="nav-link" href="AllProduct.php?user_id=<?= $user_id ?>">All Product</a>
                </li>
                <li class="nav-item">
                    <?php
                        $user_id = $_SESSION["auth"]["id"];
                        ?>
                    <a class="nav-link" href="cart.php?user_id=<?= $user_id ?>">Cart</a>
                </li>

                <li class="nav-item">
                    <?php
                        $user_id = $_SESSION["auth"]["id"];
                        ?>
                    <a class="nav-link" href="order.php?user_id=<?= $user_id ?>">Order</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" id="navbar">
                        <?= $_SESSION["auth"]["name"]; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbar">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="./controller/LogoutController.php">Logout</a>
                        </li>
                    </ul>
                </li>
                <?php
                endif;
                ?>
            </ul>
        </div>
    </div>
</nav>