<nav class="navbar navbar-expand-sm bg-dark navbar-dark rounded mx-5 sticky-top">
    <!-- <span class="navbar-toggler-icon"></span> -->


    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i></a>
        </li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Category
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

        <li class="nav-item collapse navbar-collapse">
            <a class="nav-link" href="cart.php">View cart</a>
        </li>

        <?php
        if (isset($_SESSION['user']) && $_SESSION['user'] != "") {
            ?>
            <li class="nav-item collapse navbar-collapse">
                <a class="nav-link" href="">Hello, <?php echo $_SESSION['user'] ?></a>
            </li>
            <li class="nav-item collapse navbar-collapse">
                <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            </li>
            <?php
        } else {
            ?>
            <li class="nav-item collapse navbar-collapse">
                <a class="nav-link" href="register.php">Sign up</a>
            </li>

            <li class="nav-item collapse navbar-collapse">
                <a class="nav-link" href="login.php">Log in</a>
            </li>
            <?php
        } ?>
    </ul>
</nav>