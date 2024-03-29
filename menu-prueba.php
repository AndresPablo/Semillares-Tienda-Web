<!-- <section>
    <nav class="navbar navbar-expand-lg shadow sticky-top navbar-light ">
        <div class="col">
            <div class="nav-superior container-fluid row d-flex justify-content-center ">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    
                    <a class="navbar-brand" href="index.php"><img class="nav-logo" src="img/marca/logo-semillares-simple.png" alt=""></a>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                
                    <div class="col col-5 collapse navbar-collapse" id="navbarSupportedContent">
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
        </div>
    </nav>
</section>
    -->

<section>
<nav class="navbar navbar-expand-lg shadow sticky-top navbar-light px-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img class="nav-logo" src="img/marca/logo-semillares-simple.png" alt="Semillares"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="nav-inferior me-5 ms-5">
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
        <!--<ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
        </ul>-->
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
</nav>
</section>