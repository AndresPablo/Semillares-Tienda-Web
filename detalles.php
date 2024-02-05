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
            $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
            $sql->execute([$id]);
            if($sql->fetchColumn() > 0)
            {
                $sql = $con->prepare("SELECT nombre, descripcion, precio FROM productos WHERE id=? AND activo=1 LIMIT 1");
                $sql->execute([$id]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre']; 
                $precio = $row['precio'];
                $descripcion = $row['descripcion'];
                $descuento = $row['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $dir_images = 'img/productos/' . $id .  '/';
                $rutaImg = $dir_images . 'principal.jpg';
                if(!file_exists($rutaImg))
                {
                    $rutaImg = 'img/productos/no-photo.jpg';
                }

                $images = array();
                $dir = dir($dir_images);

                while(($archivo = $dir->read()) != false){
                    if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();
            }
        }else
        {
            echo 'Error al procesar la peticion';
            exit;
        }
    }
    //session_destroy();
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
        <?php include 'menu.php'?>

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
        <main>
            <div class="container">
                <div class="row">
                    <!-- Columna A (imagen) -->
                    <div class="col-md-6 order-md-1">
                        <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?php echo $rutaImg; ?>" class="d-block w-100" alt="...">
                                </div>
                                    <?php foreach($imagenes as $img) { ?>
                                        <div class="carousel-item">
                                            <img src="<?php echo $img;?>" class="d-block w-100" alt="">
                                        </div>
                                    <?php } ?>                                
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <!-- Columna B (texto) -->
                    <div class="col-md-6 order-md-2">
                        <h2><?php echo $nombre?></h2>
                        <?php if($descuento > 0) {  ?>
                            <p><del><?php echo MONEDA . number_format($precio_desc, 0, ',', '.' );?></del></p>
                            <h3><?php echo MONEDA . number_format($precio_desc, 0, ',', '.' );?></h3>
                            <small class="text-success"><?php echo $descuento; ?>% OFF</small>
                        <?php } else { ?>
                            <p><?php echo MONEDA . number_format($precio, 0, ',', '.' );?></p>
                            <?php } ?>

                        <p clas="lead">
                            <?php echo $descripcion?>
                        </p>
                        
                        <div class="col-3 my-3">
                            Cantidad: <input class="form-control" id="cantidad" name="cantidad"
                            type="number" min="1" max="10" value="1" >
                        </div>

                        <div class="d-grid gap-3 col-10 mx-auto">
                            <!--<button class="btn btn-primary" type="button">Comprar ahora</button>-->
                            <button class="btn btn-primary" type="button" onclick="addProducto(<?php echo 
                            $id; ?>, cantidad.value, '<?php echo $token_tmp; ?>')">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        

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
        <script src="js/mitienda.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
