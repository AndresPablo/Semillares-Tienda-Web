<?php
    require 'config/config.php';
    require 'config/database.php';
    $db=new Database();
    $con=$db->conectar();

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    
    print_r($_SESSION);

    $lista_carrito = array(); 

    if($productos != null)
    {
        foreach($productos as $clave => $cantidad)
        {
            $sql=$con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
            $sql->execute([$clave]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
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


    <!-- Contenido -->
    <main>

        <div class="container">
            <div class="table table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php if($lista_carrito == null)
                            {
                                echo '<tr><td colspan="5 class="text-center"><b>Lista vacia</b></td></tr>';
                            }
                            else
                            {
                                $total = 0;
                                foreach($lista_carrito as $producto)
                                {
                                    $_id = $producto['id'];
                                    $nombre = $producto['nombre'];
                                    $precio = $producto['precio'];
                                    $descuento = $producto['descuento'];
                                    $cantidad = $producto['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td> <?php echo $nombre; ?></td>
                                    <td> <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?></td>
                                    <td> 
                                        <input type="number" min="1" max="20" step="1" value="<?php echo $cantidad; ?>" 
                                        size="5" id="cantidad_<?php echo $_id; ?>" 
                                        onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                                    </td>
                                    <td> 
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"> <?php echo MONEDA . 
                                        number_format($subtotal, 2, '.', ','); ?></div>
                                    </td>
                                    <td> 
                                    <input type="number" min="1" max="20" step="1" value="0" 
                                        size="5" onchange="prueba(this.value, <?php echo $_id; ?>)">
                                    </td>
                                    <td> 
                                        <a href="#" id="eliminar" class="btn btn btn-warning btn-sm" data-bs-id="<?php echo 
                                        $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a> 
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                </td>
                            </tr>
                        </tbody> 
                    <?php } ?>  
                </table>
            </div>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <button class="btn btn-primary btn-lg">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </main>


    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" role="dialog" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="eliminaModalLabel">Advertencia</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ¿Deseas eliminar este producto de la lista?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
        </div>
        </div>
    </div>
    </div>

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
        <script>
            let eliminaModal = document.getElementById('eliminaModal')
            eliminaModal.addEventListener('show.bs.modal', function(event)
            {
                let button = event.relatedTarget
                let id = button.getAttribute('data-bs-id')
                let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
                buttonElimina.value = id
            })

            function prueba(cantidad, id)
            {
                let url = 'clases/carrito.php'
                let formData = new FormData()
                formData.append('id', id);
                formData.append('cantidad', cantidad)

                console.log(id)
                console.log(cantidad)

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(respose => respose.json()) 
                .then(data =>  {
                    if(data.ok){
                        console.log("prueba")
                    }else{
                        console.log("prueba ERROR")
                    }
                })
            }

            function eliminaProducto()
            {
                let botonElimina = document.getElementById('btn-elimina')
                let id = botonElimina.value

                let url = 'clases/actualizar_carrito.php'
                let formData = new FormData()
                formData.append('action', 'eliminar')
                formData.append('id', id)

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(respose => respose.json()).then(data =>  {
                    if(data.ok){
                        location.reload()
                    }
                })
            }

            function actualizaCantidad(cantidad, id)
            {
                let url = 'clases/actualizar_carrito.php'
                let formData = new FormData()
                formData.append('action', 'agregarrr')
                formData.append('id', id)
                formData.append('cantidad', cantidad)

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(respose => respose.json()) 
                .then(data =>  {
                    if(data.ok){
                        console.log(data)
                        // recibimos el subtotal
                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = data.sub
                        let total = 0.00
                        let list = document.getElementsByName("subtotal[]")

                        for(let i = 0; i < list.length; i++)
                        {
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                        }

                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total
                    }
                    else
                    {
                        console.log("Data no esta OK")
                    }
                })
            }

            
        </script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
