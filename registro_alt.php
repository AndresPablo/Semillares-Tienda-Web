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
        $correo = trim($_POST['correo']);
        $telefono = trim($_POST['telefono']);
        $dni = trim($_POST['dni']);
        $usuario = trim($_POST['usuario']);
        $provincia = trim($_POST['provincia']);
        $localidad = trim($_POST['localidad']);
        $direccion = trim($_POST['direccion']);
        $referencia = trim($_POST['referencia']);
        $pass = trim($_POST['pass']);
        $repass = trim($_POST['repass']);

        if(esNulo([$nombres, $apellidos, $correo, $telefono, $usuario, $pass, $repass]))
        {
            $errors[] = "Debe llenar todos los campos obligatorios.";
        }

        if(!esEmail($correo))
        {
            $errors[] = "La dirección de correo no es válida.";
        }

        if(!validaPassword($pass, $repass))
        {
            $errors[] = "Las contraseñas no coinciden."; 
        }

        if(usuarioExiste($usuario, $con))
        {
            $errors[] = "El nombre de usuario $usuario ya existe."; 
        }

        if(emailExiste($email, $con))
        {
            $errors[] = "El correo electrónico $correo ya existe. "; 
        }

        if(count($errors) == 0)
        {
            $id = registraClienteAvanzado([$nombres, $apellidos, $correo, $telefono, $dni, $direccion, $referencia, $provincia, $localidad], $con);
            if($id > 0)
            {
                require 'clases/Mailer.php';
                $mailer = new Mailer();
                $token = generarToken();
                $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

                $idUsuario =  registraUsuario([$usuario, $pass_hash, $token, $id, $correo], $con);
                if($idUsuario > 0)
                {
                    $url = SITE_URL . '/activar_cliente.php?id='.$idUsuario.'&token='.$token;
                    $asunto ="Activar cuenta - Semillares";
                    $cuerpo="Estimado $nombres: <br> para confirmar su cuenta debe clickear el siguiente link <a href='$url'>Activar Cuenta</a>";

                    if($mailer->enviarMail($correo, $asunto, $cuerpo))
                    {
                        echo "para completar el proceso de registro, siga las instrucciones que enviamos a su correo electrónico $correo";
                        exit;
                    }
                }
                else
                {
                    $errors[] = "error al registrar Usuario";
                }
            }else
            {
                $errors[] = "error al registrar Cliente";
            }
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
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
        
        <!-- Responsive navbar-->
        <?php include 'menu-prueba.php'?>
        <!------- -------------------->
        
        <main>
            <div class="container-fluid row mb-3">
                <div class="container row vh-100 my-3 mx-3">
                    <!-- Columna izquierda -->
                    <div class="container ingreso-izquierda col-md-6 d-sm-none d-md-flex flex-column align-items-center justify-content-center">
                        <div class="row logo-login">
                            <img class="logo-login" src="img/marca/logo-semillares.png" alt="">
                        </div>
                            <div class="row my-3">
                                <p>Distribuidora y fraccionadora<br>de productos naturales</p>
                            </div>
                    </div>
                    <!-- Columna media -->
                    <div class="container col col-12 col-lg-6 p-3">
                        <form action="registro_alt.php" method="post" class=" row g-3 " autocomplete="off">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                                <label for="usuario"><span class="text-danger">*</span>Usuario</label>
                            </div>
                            <div class="row mt-3 mx-0">
                                <div class="col">
                                    <div class="col form-floating px-1">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                                        <label for="floatingInput"><span class="text-danger">*</span>Nombre</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="col form-floating px-1">
                                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                                        <label for="floatingInput"><span class="text-danger">*</span>Apellido </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating">
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="correo@ejemplo.com">
                                <label for="correo"><span class="text-danger">*</span>Correo Electrónico</label>
                            </div>
                            <div class="row mt-3 mx-0">
                                <div class="col">
                                    <div class="col form-floating">
                                        <input type="password" class="form-control" id="pass" name="pass" placeholder="">
                                        <label for="referencia"><span class="text-danger">*</span>Contraseña</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="col form-floating">
                                    <input type="password" class="form-control" id="repass" name="repass" placeholder="">
                                <label for="referencia"><span class="text-danger">*</span>Repita Contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="">
                                <label for="direccion"><span class="text-danger">*</span>Dirección de Envío</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ejemplo: Local verde">
                                <label for="referencia">Referencia</label>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="(221) 123 456">
                                        <label for="referencia"><span class="text-danger">*</span>Teléfono</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="dni" name="dni" placeholder="">
                                        <label for="referencia">DNI</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select" id="provincia" name="provincia" aria-label="Provincia">
                                            <option selected><span class="text-danger">*</span>Elija su provincia</option>
                                            <option value="1">Buenos Aires</option>
                                            <option value="2">Ciudad Autónoma de Buenos Aires</option>
                                            <option value="4">Catamarca</option>
                                            <option value="5">Chaco</option>
                                            <option value="6">Chubut</option>
                                            <option value="7">Córdoba</option>
                                            <option value="8">Corrientes</option>
                                            <option value="9">Entre Ríos</option>
                                            <option value="10">Formosa</option>
                                            <option value="11">Jujuy</option>
                                            <option value="12">La Pampa</option>
                                            <option value="13">La Rioja</option>
                                            <option value="14">Mendoza</option>
                                            <option value="15">Misiones</option>
                                            <option value="16">Neuquén</option>
                                            <option value="17">Río Negro</option>
                                            <option value="18">Salta</option>
                                            <option value="19">San Juan</option>
                                            <option value="20">San Luis</option>
                                            <option value="21">Santa Cruz</option>
                                            <option value="22">Santa Fe</option>
                                            <option value="23">Santaigo del Estero</option>
                                            <option value="24">Tierra del Fuego</option>
                                            <option value="25">Tucumán</option>
                                        </select>
                                        <label for="provincia">Provincia</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="localidad" name="localidad" placeholder="(221) 123 456">
                                        <label for="localidad"><span class="text-danger">*</span>Localidad</label>
                                    </div>
                                </div>
                            </div>
                            <p><span class="text-danger">*</span> Los campos con asterisco son obligatorios.</p>
                            <div class="login_btn d-flex align-items-center justify-content-center my-3">
                                <a href="cuenta.html" type="submit"> <button class="btn-primary">Resgistrarme</button></a>
                            </div>
                            <br>
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <br>
                <br>
            </div>
        </main>

        <!-- Footer -->
        <?php include 'footer.php'?>
        
        <!------- -------------------->
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