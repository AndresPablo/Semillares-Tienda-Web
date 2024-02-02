<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$comando = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$comando->execute();
$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
print($_SESSION['user_name']);
?>

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
        <section>
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
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="login.php">Ingresar</a></li>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="registro.php">Registrarme</a></li>
                                <li class="nav-item "><a class="nav-link texto-cuenta" href="cuenta.php"><?php echo $_SESSION['user_name']; ?></a></li>
                            </ul>
                            <form class="d-flex">
                                <button class="btn btn-outline-dark" href="compra-datos.html" type="submit">
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

        <!-- Header-->
        <header class="banner">
            <div class="banner col container-fluid">
                 <!-- overlay negro-->   
                    <!-- <div class="overlay"></div> -->
                <!-- Columnas de Texto + Imagen-->
                <div class="container-flex row d-flex align-items-center h-100 pb-5">
                    <div class="col px-5 ">
                        <h2>¡Queremos estar en tu local!</h2>
                        </br>
                        <p class="">¿Estás buscando <strong> incorporar productos <br> 
                            veganos y saludables</strong> en tu tienda o servicio?</p>
                        <p class="">Probá con nuestros <strong>mix de frutos secos</strong></p>
                        <button class="btn btn-primary shadow" type="button">
                            Saber más
                        </button>
                    </div>
                    <div class="col-lg-4 d-none d-md-block d-flex  ">
                        <div class="row d-flex align-items-end">
                            <img class="al-fondo" src="img/banner-cereales.png" alt="">
                        </div>
                    </div>
                </div>
                    <div class=" d-none container d-flex  align-content-around flex-wrap">
                        <div class="col col-8-lg">
                            <h1>¡Queremos estar en tu local!</h1>
                            </br></br>
                            <p class="">¿Estás buscando <strong> incorporar productos veganos y saludables</strong> en tu tienda o servicio?</p>
                            </br>
                            <p class="">Probá con nuestros <strong>mix de frutos secos</strong></p>
                            <button class="btn btn-primary shadow" type="button">
                                Saber más
                            </button>
                        </div>
                        <!-- Se esconde en ventanas menores a MD -->
                        <div class="col col-4-lg d-none d-md-block">
                            <img class="al-fondo" src="img/banner-cereales.png" alt="">
                        </div>
                    </div>
            </div>
         </header>

         <!-- Features section-->
        <section class="py-2  bg-verde-claro" id="features">
            <div class="container">
                <div class="row my-0 d-flex align-items-center">
                    <div class="col-md">
                        <div class="row d-flex align-items-center h-100">
                            <div class="col feature text-black rounded-3 h-100 d-flex align-items-center"><i class="bi bi-cart-fill"></i></div>
                            <div class="col-10 h-100 d-flex align-items-center"><p >Agregá los productos a tu carrito.</p> </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row d-flex align-items-center h-100">
                            <div class="col feature text-black rounded-3"><i class="bi bi-credit-card"></i></div>
                            <div class="col-10"><p>Elegí medio de pago y dirección de envío</p> </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="row d-flex align-items-center h-100">
                            <div class="col feature text-black rounded-3 "><i class="bi bi-check"></i></div>
                            <div class="col-10"><p>Confirmá tus datos ¡Y listo!</p> </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>

        <!-- Combos section-->
         <section class="py-5 border-bottom" id="combos">
            <div class="titular-combos container">
                <h2>Conocé nuestros mix</h2>
                <p>
                    Desde <strong class="resaltado-verde">Semillares</strong> queremos facilitar el acceso a alimentos nobles y de calidad frente al ritmo acelerado que nos presenta la vida
                    cotidiana. Por eso diseñamos estos paquetes con la ración justa de frutos secos. 
                </p>
            </div>
            
            <div class="grilla-combos container col">
                <div class="row row-cols-lg-3">
                    <div class="col-auto caja-mix text-center">
                        <img src="/img/Mix Estrella.jpg" alt="">
                        <div class="row text-center"><h3>Estrella</h3></div>
                        <p>Nueces, almendras, pasas de uva y maní</p>
                    </div>
                    <div class="col-auto caja-mix text-center">
                        <img src="/img/Mix Cuyano.jpg" alt="">
                        <div class="row text-center"><h3>Cuyano</h3></div>
                        <p>Nueces, almedras, pasas de uva y maní</p>
                    </div>
                    <div class="col-auto caja-mix text-center">
                        <img src="/img/Mix Choco-Cafe.jpg" alt="">
                        <div class="row text-center"><h3>Chococafe</h3></div>
                        <p>Almendras, arándanos, café bañado, chips de chocolate, maní</p>
                    </div>
                    <div class="col-auto caja-mix text-center">
                        <img src="/img/Mix Bananita.jpg" alt="">
                        <div class="row text-center"><h3>Bananita</h3></div>
                        <p>Nueces, pasas de uva, maní y chips de banana</p>
                    </div>
                    <div class="col-auto caja-mix text-center">
                        <img src="/img/Mix Tostado.jpg" alt="">
                        <div class="row text-center"><h3>Tostadito</h3></div>
                        <p>Maíz tostado, semillas de zapallo, almendras y maní</p>
                    </div>
                    <div class="col-auto caja-mix text-center">
                        <img src="/img/Mix Patagonico.jpg" alt="">

                        <div class="row text-center"><h3>Patagónico</h3></div>
                        <p>Arándanos, almendras, cajú, manzana y maní</p>
                    </div>
                </div>

            </div>
         </section>


        <!-- Footer-->
        <footer class="py-5 bg-verde-oscuro">
            <div class="container">
                <div class=" row-cols-lg-4 row row-cols-md-2 row-cols-sm-1 text-white">
                    <div class="col-lg-0">
                        <h4>Política de Seguridad</h4>
                        <li class="list-group ">
                            <ul><a href="politicas.html">Política de devolución</a></ul>
                            <ul><a href="envios.html" class="">Envíos</a></ul>
                            <ul><a href="preguntas.html" class="">Preguntas Frecuentes</a></ul>
                        </li>
                    </div>
                    <div class="col-lg-0">
                        <h4>Contactanos</h4>
                        <li class="list-group ">
                            <ul><i class="bi bi-pin"></i><a href="https://goo.gl/maps/aJRv7TEeXq5S28246" class=""> Calle 45 420 <br> La Plata, Buenos Aires, Argentina</a></ul>
                            <ul><i class="bi bi-telephone"></i><a class="#">  (221) 123-456</a></ul>
                            <ul><i class="bi bi-envelope"> </i><a class="#">  semillares@gmail.com</a></ul>
                        </li>
                    </div>               
                    <div class="col-lg-0 ">
                        <h4>Medios de pago</h4>
                        <div class="row logos-pago">
                            <img src="img/medios-pago/mercadopago@2x.png" alt="Mercado Pago">
                            <img src="img/medios-pago/banelco@2x.png" alt="Banelco">
                            <img src="img/medios-pago/visa@2x.png" alt="Mercado Pago">
                            <img src="img/medios-pago/mastercard@2x.png" alt="Mastercard">
                            <img src="img/medios-pago/rapipago@2x.png" alt="Rapipago">
                            <img src="img/medios-pago/pagofacil@2x.png" alt="Pago Facil">
                        </div>
                    </div>
                    <div class="col-lg-2 d-flex justify-content-center">
                        <img class="data-fiscal" src="img/Data-fiscal-Ejemplo.jpg" alt="Data Fiscal">
                    </div>
                </div>
                <br>
                <p class="m-0 text-center text-white">Copyright &copy; Semillares 2023</p>
            </div>
        </footer>
        
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