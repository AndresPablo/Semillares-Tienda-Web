<section>

<nav class="navbar navbar-expand-lg shadow sticky-top navbar-light mb-5">
    <div class="container-fluid">
        <div class="col">
            <!-- BARRA SUPERIOR -->
            <div class="">
                <div class="nav-superior d-flex flex-row justify-content-between align-items-center ">
                    <div class="">
                        <a class="navbar-brand" href="index.php"><img class="nav-logo" src="img/marca/logo-semillares-simple.png" alt=""></a>    
                    </div>
                    <!-- Ingreso y carito -->
                    <div class="d-none d-md-inline ms-auto">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <?php if(isset($_SESSION['user_id'])){ ?>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="cuenta.php"><i class="bi bi-person-fill"></i><?php echo $_SESSION['user_name']; ?></a></li>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="logout.php">Cerrar Sesión</a></li>
                            <?php } else { ?>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="login.php">Ingresar</a></li>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="registro.php">Registrarme</a></li>
                            <?php } ?>
                            <form class="d-inline">
                            <a href="checkout.php" class="btn btn-outline-dark" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                <span id="num_cart" class="badge bg-marron text-white ms-1 rounded-pill"><?php echo $num_cart;?></span>
                            </a>
                            </form>
                        </ul>
                        
                    </div>
                    <!-- MENU MOBILE -->
                    <div class="d-inline d-sm-none ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="menuDesplegableMobile" data-bs-toggle="dropdown" aria-expanded="false">
                                Menú
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuDesplegableMobile">
                                <li class="dropdown-item "><a class="nav-link " href="tienda.php">Tienda</a></li>
                                <li class="dropdown-item "><a class="nav-link " href="conocenos.php">Conocenos</a></li>
                                <li class="dropdown-item "><a class="nav-link " href="trabajo-semillares.php">Trabajo Semillares</a></li>
                                <li class="dropdown-item "><a class="nav-link " href="cuenta.php">Cuenta</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php if(isset($_SESSION['user_id'])){ ?>
                                    <li class="dropdown-item "><a class="nav-link " href="cuenta.php"><i class="bi bi-person-fill"></i> <?php echo $_SESSION['user_name']; ?></a></li>
                                    <li class="dropdown-item "><a class="nav-link " href="logout.php"> Cerrar Sesión</a></li>
                                <?php } else { ?>
                                    <li class="dropdown-item "><a class="nav-link " href="login.php">Ingresar</a></li>
                                    <li class="dropdown-item "><a class="nav-link " href="registro.php">Registrarme</a></li>
                                    <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="d-inline d-sm-none ">
                        <form class="d-inline">
                            <a href="checkout.php" class="btn btn-outline-dark" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                <span id="num_cart_mobile" class="badge bg-marron text-white ms-1 rounded-pill"><?php echo $num_cart;?></span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BARRA INFERIOR -->
            <div class="d-none d-md-block">
                <div class="nav-inferior">
                    <ul class="nav nav-pills nav-fill">
                        <li class="nav-item ">
                        <a class="nav-link" href="tienda.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="conocenos.html">Conocenos</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="trabajo-semillares.html">Trabajo Semillares</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="cuenta.php">Mi Cuenta</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
   
</nav>

<!--
    <nav class="navbar navbar-expand-lg shadow sticky-top navbar-light ">
        <div class="container-fluid row">
            <div class="col d-md-inline">
                <a class="navbar-brand" href="index.php"><img class="nav-logo" src="img/marca/logo-semillares-simple.png" alt=""></a>
            </div>
            <div class="col d-md-inline   bg-danger">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Link
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                </li>
            </ul>
            </div>
            <div class="col d-md-inline   bg-info">b</div>
            <ul class="col d-md-inline navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Link
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
            </ul>
        </div>
    </nav>
-->

<!--
    <nav class="navbar navbar-expand-lg shadow sticky-top navbar-light ">
        <div class="col">
            <div class="nav-superior container-fluid row d-flex justify-content-center ">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    
                    <a class="navbar-brand" href="index.php"><img class="nav-logo" src="img/marca/logo-semillares-simple.png" alt=""></a>
                    
                    <button class="navbar-toggler d-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="col-5 dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menú
                        </a>
                        <div class="dropdown-menu" aria-labelledby="Menu Desplegable">
                            <a class="dropdown-item"href="tienda.php">Tienda</a>
                            <a class="dropdown-item"href="conocenos.php"></a>
                            <a class="dropdown-item"href="trabajo-semillares.php">Trabajo Semillares</a>
                            <a class="dropdown-item"href="cuenta.php">Compras</a>
                            <div class="dropdown-divider"></div>
                            <?php if(isset($_SESSION['user_id'])){ ?>
                                <a class="dropdown-item texto-cuenta" href="cuenta.php"><?php echo $_SESSION['user_name']; ?></a>
                                <a class="dropdown-item texto-cuenta" href="logout.php">Cerrar Sesión</a>
                            <?php } else { ?>
                                <a class="dropdown-item texto-cuenta" href="login.php">Ingresar</a>
                                <a class="dropdown-item texto-cuenta" href="registro.php">Registrarme</a>
                            <?php } ?>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                
                    <div class="col-5">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <?php if(isset($_SESSION['user_id'])){ ?>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="cuenta.php"><?php echo $_SESSION['user_name']; ?></a></li>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="logout.php">Cerrar Sesión</a></li>
                            <?php } else { ?>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="login.php">Ingresar</a></li>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="registro.php">Registrarme</a></li>
                                <?php } ?>
                        </ul>
                        <form class="d-flex">
                            <a href="checkout.php" class="btn btn-outline-dark" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                <span id="num_cart" class="badge bg-marron text-white ms-1 rounded-pill"><?php echo $num_cart;?></span>
                            </a>
                        </form>
                    </div>
            </div>

            <div class="nav-inferior me-5 ms-5 ">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item ">
                    <a class="nav-link" href="tienda.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="conocenos.html">Conocenos</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="trabajo-semillares.html">Trabajo Semillares</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="cuenta.php">Mi Cuenta</a>
                    </li>
                </ul>
            </div>                
        </div>
    </nav>-->
</section>