<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Semillares - Dietética</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- Custom CSS (personalizado)-->
        <link href="css/custom.css" rel="stylesheet" />
        <!-- Fuentes (Montserrat) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
    </head>


    <body>

        <!-- Top Bar 
        <section>
            <div class="row justify-content-center top-bar bg-mostaza text-dark">
                    <div class="col-4 text-center">Compra Minima $5.000</div>
            </div>
        </section>
        -->

        <!-- Responsive navbar-->
        <?php include 'menu.php'; ?>

        <section>
        <nav class="navbar navbar-expand-lg shadow sticky-top navbar-light ">
            <div class="col">
                <div class="nav-superior container-fluid row d-flex justify-content-center ">
                    <nav class="navbar navbar-expand-lg navbar-light ">
                        <a class="navbar-brand" href="index.html"><img class="nav-logo" src="img/marca/logo-semillares-simple.png" alt=""></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                      
                        <div class="col col-5 collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="login.html">Ingresar</a></li>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="registro.php">Registrarme</a></li>
                            </ul>
                            <form class="d-flex">
                                <button class="btn btn-outline-dark" type="submit">
                                    <i class="bi-cart-fill me-1"></i>
                                    <span id="numerito" class="badge bg-marron text-white ms-1 rounded-pill">0</span>
                                </button>
                            </form>
                        </div>
                </div>      
                <div class="nav-inferior me-5 ms-5">
                    <ul class="container-fluid nav nav-pills nav-fill  collapse navbar-collapse">
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
                            <a class="nav-link" href="cuenta.html">Mi Cuenta</a>
                          </li>
                      </ul>
                </div>                
            </div>
        </nav>
        </section>

        <!-- Contenido -->
        <section id="main">
            <div class="content vh-100">

            </div>
        </section>

        <!-- Footer-->
        <?php include 'footer.php'; ?>
        
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>