<?php
    require 'config/config.php';
    require 'config/database.php';
    $db=new Database();
    $con=$db->conectar();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    if($id == ''  || $token == '')
    {
        echo 'Error al procesar la peticion. ID o Token vacíos';
        exit;
    }
    else
    {
        $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
        if($token == $token_tmp)
        {
            $sql=$con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
            $sql->execute([$id]);
            if($sql->fetchColumn() > 0)
            {
                $sql=$con->prepare("SELECT nombre, descripcion, precio FROM productos WHERE id=? AND activo=1 LIMIT 1");
                $sql->execute([$id]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre'];
                $precio = $row['precio'];
                $descripcion = $row['descripcion'];
            }
        }else
        {
            echo 'Error al procesar la peticion';
            exit;
        }
    }
?>


<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="Andrés Pablo" />
        <title>Semillares - Tienda</title>
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
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>


    <body>
        
 <!-- Responsive navbar-->
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
                            <li class="nav-item "><a class="nav-link texto-cuenta" href="registro.html">Registrarme</a></li>
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
                      <a class="nav-link" href="tienda.html">Tienda</a>
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
    <header class="header-tienda ">
        <div class="container-fluid my-5">
            <div class="row ">
                <div class="col-md-3 d-flex justify-content-center">
                    <a href=""><button class="btn-primary px-4"><i class="bi bi-whatsapp"> </i></button></a>
                </div>
                <div class="col">
                    <form class="w-100">
                        <input type="search" class="form-control" placeholder="¿Que estás buscando hoy?" aria-label="Search">
                    </form>
                </div>
                <div class="col-md-2">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none dropdown-toggle" id="dropdownNavLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Tengo Local
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownNavLink">
                        <li><a class="dropdown-item active" href="#" aria-current="page">Tengo Local</a></li>
                        <li><a class="dropdown-item" href="#">Opcion A</a></li>
                        <li><a class="dropdown-item" href="#">Opcion B</a></li>
                        <li><a class="dropdown-item" href="#">Opcion C</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Opcion D</a></li>
                        <li><a class="dropdown-item" href="#">Opcion E</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!-- WRAPER -->
    <section class="bg-white">
        <div  id="wraper" class="container-fluid row">
            
        <img src="" alt="">
        <h3><?php echo $nombre?></h3>
            <p>$<?php echo MONEDA . number_format($precio, 0, ',', '.' );?></p>
            <p clas="lead"><?php echo $descripcion?></p>
            <button type="button" onclick="addProducto(<?php echo 
            $id; ?>, '<?php echo $token_tmp; ?>')">Agregar</button>
        </div>
    </section>

    <!-- Footer-->
    <footer class="bg-verde-oscuro">
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
                        <ul><i class="bi bi-telephone"></i><a class="#"> (221) 123-456</a></ul>
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
        <!-- Scripts para tienda -->
        <script src="js/main.js"></script>
        <script src="js/menu.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
