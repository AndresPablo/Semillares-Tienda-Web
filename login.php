<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$proceso =isset($GET['pago']) ? 'pago' : 'login';

$errors = [];

if(!empty($_POST))
{
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $proceso = $_POST['proceso'] ?? 'login';

    if(esNulo([$usuario, $password]))
    {
        $errors[] = "Debe llenar todos los campos.";
    }
    if(count($errors) == 0)
    {
        $errors[] = login($usuario, $password, $con, $proceso);
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

        

        <!-- Contenido -->
        <section id="main-login" class="">
            <div class="content text-center my-5">
                <div class="row">
                    <!-- Columna izquierda -->
                    <div class="col-lg-6 ingreso-izquierda d-none d-lg-flex flex-column align-items-center justify-content-center ">
                        <div class="row logo-login">
                            <img class="" src="img/marca/logo-semillares.png" alt="">
                        </div>
                            <div class="row my-3">
                                <p>Distribuidora y fraccionadora<br>de productos naturales</p>
                            </div>
                            <?php mostrarMensajes($errors); ?>
                        </div>
                    <!-- Columna derecha -->
                    <div class="col-lg-6 d-inline-flex flex-column ingreso-derecha align-items-center justify-content-center">
                        <div class="row mb-5">
                            <div class="col-sm-6"><a class="active bold" href="#">Iniciar Sesión</a></div>
                            <div class="col-sm-6"><a class="" href="registro.php">Registrarme</a></div>
                        </div>
                        <form class="row g-3" action="login.php" method="post" autocomplete="off">
                            <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">
                            <label for="usuario">Usuario / Correo </label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="text" class="form-control text-start" id="usuario" name="usuario" placeholder="Usuario"> 
                                </div>
                            </div>
                                                       
                            <label for="password">Contraseña</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control text-start" id="password" name="password" placeholder="Contraseña"> 
                                </div>
                            </div>

                            <div class="col-12">
                                <a href="recupera.php">¿Olvidaste tu contraseña?</a>
                            </div>
                            <div class="login_btn d-flex align-items-center justify-content-center my-3">
                                <button type="submit" class="btn btn-primary" >Ingresar</button>
                            </div>
                            <!-- Social login -->
                            <div class="container d-none">
                                <div class="text-center">O ingresá con</div>
                                <div class="social-login">
                                    <a href="#" class="facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="#" class="google">
                                        <i class="bi bi-google"></i>
                                    </a>
                                </div>
                            </div>
                           
                            
                        </form>
                        </div> 
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <?php include 'footer.php'?>

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