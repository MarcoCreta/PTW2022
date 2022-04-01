<!DOCTYPE html>
<html lang="it">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $templateParams["titolo"]; ?></title>
    <script src="js/jquery-3.4.1.min.js"></script>
    <?php
    require_once("bootstrap.php");
    if (isset($templateParams["js"])) :
        foreach ($templateParams["js"] as $script) :
    ?>
            <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>
    <script src="js/baseUtils.js"></script>

    <title>Learny</title>
</head>

<body class="<?php echo ($_COOKIE['mode']) ?>">
    <header class="navbar navbar-expand-lg navbar-dark bg-dark p-0">
        <nav class="container-fluid">
            <div class="d-flex justify-content-start">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="home.php" class="navbar-brand" href="#">Learny</a></li>
                </ul>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="d-flex position-absolute start-50 translate-middle-x m-1">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="home.php" class="nav-link text-white">Home</a></li>
                        <li class="nav-item"><a href="shop.php" class="nav-link text-white">Shop</a></li>
                        <li class="nav-item"><a href="about.php" class="nav-link text-white">About</a></li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-end" , id="nav-left">

                <?php if (isUserLoggedIn()) : ?>
                    <ul class="nav nav-pills ">
                        <li class="nav-item"><a class="nav-link" href="search.php"><i class="bi bi-search"></i></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php"><i class="bi bi-cart-fill"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="profile.php?user=<?php echo $_SESSION['username'] ?>"><i class="bi bi-person-fill"></i></a></li>
                        <div class="dropdown">
                            <button class="btn btn-primary rounded-circle m-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                <i class="bi bi-caret-down-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end m-1" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="settings.php"> <i class="bi bi-gear-fill me-2"></i> Settings </a></li>
                                <li><a class="dropdown-item" id="switchMode"> <i class="bi bi-circle-half me-2"></i> Switch mode </a></li>
                                <?php if ($_SESSION['teacher']) : ?>
                                    <li><a class="dropdown-item" href="teacher-area.php" id="teacherArea"> <i class="bi bi-person-workspace me-2"></i> Teacher area </a></li>
                                <?php endif ?>
                                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> logout</a></li>
                            </ul>
                        </div>
                    </ul>

                <?php else : ?>

                    <ul class="nav nav-pills ">
                        <li><a class="btn btn-primary m-1" href="login.php">Login</a></li>
                        <li><a class="btn btn-primary m-1" href="signup.php">Sign up</a></li>
                    </ul>
                <?php endif ?>

            </div>
        </nav>
    </header>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="shop.php" class="nav-link">Shop</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                </ul>
            </div>
        </nav>
    </div>



    <main>
        <div class="container-fluid col-12 p-0 m-0 p-0">
            <div class="row col-12 p-0 m-0 p-0">

                <div class=" col-12 col-md-3 px-1" id="left-content-page">
                    <?php
                    if (isset($templateParams["left-components"])) {
                        foreach ($templateParams["left-components"] as $component) {
                            require($component);
                        }
                    }
                    ?>
                </div>

                <div class=" col px-1" id="content-page">

                    <?php
                    if (isset($templateParams["nome"])) {
                        require($templateParams["nome"]);
                    }
                    ?>

                    <?php
                    if (isset($templateParams["components"])) {
                        foreach ($templateParams["components"] as $component) {
                            require($component);
                        }
                    }
                    ?>
                </div>

                <div class=" col-12 col-md-3 px-1" id="right-content-page">
                    <?php
                    if (isset($templateParams["right-components"])) {
                        foreach ($templateParams["right-components"] as $component) {
                            require($component);
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-dark">
        <p class="text-white text-center">Learny - A.A. 2020/2021</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>