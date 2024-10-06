<nav class="navbar navbar-expand-lg bg-dark navbar-dark rounded mx-5 sticky-top">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i> Home</i></a>
            </li>

            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle ml-2" href="#" id="navbardrop" data-toggle="dropdown">
                    <i class="fa-solid fa-layer-group"></i> Category
                </a>
                <div class="dropdown-menu">
                    <?php
                    $sql = "Select * from category";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <a class="dropdown-item" href="#"><?php echo $row['name'] ?></a>
                        <?php
                    }
                    ?>
                </div>
            </li>

            <li class="nav-item ml-2">
                <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> View cart</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user'] != "") {
                ?>
                <li class="nav-item mr-3">
                    <a class="nav-link" href=""><i class="fa-solid fa-user mr-2"></i><?php echo $_SESSION['user'] ?></a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
                </li>
                <?php
            } else {
                ?>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="register.php"><i class="fa-solid fa-user mr-1"></i> Sign up</a>
                </li>

                <li class="nav-item mr-2">
                    <a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket mr-1"></i> Log in</a>
                </li>
                <?php
            } ?>
        </ul>
    </div>
</nav>