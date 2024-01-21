<?php
    require 'config/config.php';
    require 'config/database.php';
    require 'clases/clienteFunciones.php';

    // conexion a base de datos
    $db = new Database();
    $con = $db->conectar();    

    $errors = [];

    if(!empty($_POST)){
        $nombres = trim($_POST['nombres']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['telefono']);
        $dni = trim($_POST['dni']);
        $usuario = trim($_POST['usuario']);
        $contraseña = trim($_POST['contraseña']);
        $recontraseña = trim($_POST['recontraseña']);

        $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);
        
        // si es mayor a 0 es porque hay un error y nose registro el cliente
        if($id > 0)
        {
            $pass_hash = password_hash($contraseña, PASSWORD_DEFAULT);
            $token = generarToken();
            if(!registraUsuario([$usuario, $password, $token, $id], $con))
            {
                $errors[] = "error al registrar Usuario";
            }
        }else
        {
            $errors[] = "error al registrar Cliente";
        }

        if(count($errors) == 0)
        {

        }else
        {
            print_r($errors);
        }

    }
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

        <section>
            <div class="container-fluid">
                <div class="row vh-100">
                    <!-- Columna izquierda -->
                    <div class="ingreso-izquierda col-md-6 d-sm-none d-md-flex flex-column align-items-center justify-content-center">
                        <div class="row logo-login">
                            <img class="logo-login" src="img/marca/logo-semillares.png" alt="">
                        </div>
                            <div class="row my-3">
                                <p>Distribuidora y fraccionadora<br>de productos naturales</p>
                            </div>
                    </div>
                    <!-- Columna derecha -->
                    <div class="col-md-6 ingreso-derecha d-flex flex-column align-items-center justify-content-center">
                        <div class="row">
                            <div class="col-sm-6"><a class="" href="login.php">Iniciar Sesión</a></div>
                            <div class="col-sm-6"><a class="active bold" href="registro.html">Registrarme</a></div>
                        </div>
                        <div class="signin_form s_form d-grid justify-content-center p-3 "> 
                            <div class="input_text my-1"> 
                                <i class="bi bi-person"></i> 
                                <input type="text" placeholder="Nombre de usuario"> 
                            </div> 
                            <div class="input_text my-1"> 
                                <i class="bi bi-envelope"></i> <i class="fa fa-eye-slash"></i>
                                <input class="signin_email" type="email" name="email" placeholder="Correo electrónico"> 
                            </div> 
                            <div class="input_text my-1"> 
                                <i class="bi bi-lock"></i> <i class="fa fa-eye-slash"></i> 
                                <input class="signin_pass" type="password" name="password" placeholder="Contraseña"> 
                            </div>
                            <div class="login_btn d-flex align-items-center justify-content-center my-3">
                                <a href="cuenta.html"> <button class="btn-primary">Resgistrarme</button></a>
                            </div>
                            <div class="text-center">O registrate con</div>
                            <div class="social-login">
                                <a href="#" class="facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="google">
                                    <i class="bi bi-google"></i>
                                </a>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>

        <!-- Contenido -->
        <section class="d-none" id="main-login" class="">
            <div class="content-fluid text-center d-flex align-items-center justify-content-center">
                <div class="row vh-100">
                    
                    <div class="col-6  d-sm-none d-md-inline-flex flex-column align-items-center justify-content-center ">

                        </div>
                    <!-- Columna derecha -->
                    <div class="col-6 d-inline-flex flex-column ingreso-derecha align-items-center justify-content-center">
                        <div class="row">
                            <div class="col-sm-6"><a class="" href="login.php">Iniciar Sesión</a></div>
                            <div class="col-sm-6"><a class="active bold" href="registro.html">Registrarme</a></div>
                        </div>
                        <div class="signin_form s_form d-grid justify-content-center p-3 "> 
                            <div class="input_text my-1"> 
                                <i class="bi bi-person"></i> 
                                <input type="text" placeholder="Nombre de usuario"> 
                            </div> 
                            <div class="input_text my-1"> 
                                <i class="bi bi-envelope"></i> <i class="fa fa-eye-slash"></i>
                                <input class="signin_email" type="email" name="email" placeholder="Correo electrónico"> 
                            </div> 
                            <div class="input_text my-1"> 
                                <i class="bi bi-lock"></i> <i class="fa fa-eye-slash"></i> 
                                <input class="signin_pass" type="password" name="password" placeholder="Contraseña"> 
                            </div>
                            <div class="login_btn d-flex align-items-center justify-content-center my-3">
                                <a href="cuenta.html"> <button class="btn-primary">Resgistrarme</button></a>
                            </div>
                            <div class="text-center">O registrate con</div>
                            <div class="social-login">
                                <a href="#" class="facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="google">
                                    <i class="bi bi-google"></i>
                                </a>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer-->
        <section>
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
            
        </section>

        <section>
            <form action="registro.php" method="post" class=" row g-3 " autocomplete="off">
                <div class="col-md-6"> 
                    <label for="nombres"><span class="text-danger">*</span>Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required> 
                </div>
                <div class="col-md-6"> 
                    <label for="apellidos"><span class="text-danger">*</span>Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required> 
                </div>
                <div class="col-md-6"> 
                    <label for="correo"><i class="bi bi-envelope"></i><span class="text-danger">*</span>Correo electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" required> 
                </div>
                <div class="col-md-6"> 
                    <label for="telefono"><span class="text-danger">*</span>Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required> 
                </div>
                <div class="col-md-6"> 
                    <label for="dni"><span class="text-danger">*</span>DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required> 
                </div>
                <div class="col-md-6"> 
                    <label for="usuario"><span class="text-danger">*</span>Alias de Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required> 
                </div>
                <div class="col-md-6"> 
                    <label for="contraseña"><span class="text-danger">*</span>Contraseña</label>
                    <input type="password" name="contraseña" id="contraseña" class="form-control" required> 
                </div>
                <div class="col-md-6"> 
                    <label for="recontraseña"><span class="text-danger">*</span>Repetir Contraseña</label>
                    <input type="password" name="recontraseña" id="recontraseña" class="form-control" required> 
                </div>
                <i><b>Nota:</b>los campos con asteriscos son obligatorios</i>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </section>
        

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