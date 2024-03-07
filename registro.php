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

        $direccion = trim($_POST['direccion']);
        $referencia = trim($_POST['referencia']);
        $provincia = trim($_POST['provincia']);
        $localidad = trim($_POST['localidad']);

        $pass = trim($_POST['pass']);
        $repass = trim($_POST['repass']);

        if(esNulo([$nombres, $apellidos, $correo, $telefono, $usuario, $direccion, $provincia, $localidad, $pass, $repass]))
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
            //$id = registraCliente([$nombres, $apellidos, $correo, $telefono, $dni], $con);
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
                    $cuerpo="Estimado $nombres: <br> Para confirmar su cuenta debe clickear el siguiente link: <a href='$url'>Activar Cuenta</a>";

                    if($mailer->enviarMail($correo, $asunto, $cuerpo))
                    {
                        echo "<h3>Revise su correo electrónico</h3> <p>Para completar el proceso de registro, siga las instrucciones que enviamos a su correo electrónico <strong>" . $correo . "</strong>.</p>";
                        exit;
                    }
                }
                else
                {
                    $errors[] = "Error al registrar Usuario";
                }
            }else
            {
                $errors[] = "Error al registrar Cliente";
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
        <!-- Archivo que maneja la logica de las localidades segun la provincia -->
        <script type="text/javascript" src="js/localidad.js"></script>
    </head>


    <body>
        <!-- Responsive navbar-->
        <?php include 'menu.php'?>

        <main>
            <div class="container-fluid row">
                <div class="container row my-3 mx-3">

                    <!-- Columna izquierda -->
                    <div class="container ingreso-izquierda d-none d-lg-flex col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <?php mostrarMensajes($errors); ?>
                        <div class="row logo-login">
                            <img class="logo-login" src="img/marca/logo-semillares.png" alt="">
                        </div>
                        <div class="row my-3">
                            <p>Distribuidora y fraccionadora<br>de productos naturales</p>
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class=" container col-md-6 ingreso-derecha my-4">
                    <div class="row text-center mb-4">
                            <div class="col-sm-6"><a class="" href="login.php">Iniciar Sesión</a></div>
                            <div class="col-sm-6"><a class="active bold">Registrarme</a></div>
                    </div>
                        <form action="registro.php" method="post" class=" row g-3 " autocomplete="off">
                            <!-- INICIO de los CAMPOS -->
                            <!--  NOMBRE de USUARIO / ALIAS -->
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-person-circle"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control text-start" name="usuario" id="usuario" placeholder="">
                                    <label for="usuario">Nombre de Usuario</label>
                                </div>
                            </div>
                            <!--  NOMBRE + APELLIDO -->
                            <div class="input-group">
                                <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-person-fill"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control text-start" name="nombres" id="nombres" placeholder="Ejemplo">
                                    <label for="nombres">Nombre</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="text" class="form-control text-start" name="apellidos" id="apellidos" placeholder="Ejemplo">
                                    <label for="apellidos">Apellido</label>
                                </div>
                            </div>
                                                       
                            <!--  CORREO-->
                            <div class="form-floating position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control text-start" id="correo" name="correo" placeholder="correo@ejemplo.com"> 
                                </div>
                            </div>

                            <!--  CONTRASEÑA + REPETIR-->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-lock-fill"></i></span>
                                <div class="form-floating">
                                    <input type="password" class="form-control text-start" name="pass" id="pass" placeholder="">
                                    <label for="pass">Contraseña</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="password" class="form-control text-start" name="repass" id="repass" placeholder="">
                                    <label for="repass">Repita contraseña</label>
                                </div>
                            </div>

                            <!--  Telefono -->
                            <div class="form-floating position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-telephone-fill"></i></span>
                                    <input type="text" class="form-control text-start" id="telefono" name="telefono" placeholder="Teléfono"> 
                                </div>
                            </div>

                            <!--  DNI -->
                            <div class="form-floating position-relative mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
                                    <input type="text" class="form-control text-start" id="dni" name="dni" placeholder="DNI"> 
                                </div>
                            </div>

                            <!--  Direccion -->
                            <div class="form-floating position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-house-fill"></i></span>
                                    <input type="text" class="form-control text-start" id="direccion" name="direccion" placeholder="Dirección"> 
                                </div>
                            </div>

                            <!--  Referencia -->
                            <div class="form-floating position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
                                    <input type="text" class="form-control text-start" id="referencia" name="referencia" placeholder="Referencia"> 
                                </div>
                            </div>

                            <p>Te enviaremos tus pedidos a esta dirección.</p>

                            <!-- PROVINCIA AJAX -->
                            <div class="form-input"><label for="provincia">Provincia<span class="text-danger">*&nbsp;</span><i class="bi bi-geo-alt-fill"></i></label><br>
                                <select style="text-transform: capitalize!important" name="provincia" class="form-control col" 
                                aria-label="Provincia" id="provincia" 
                                onchange="localiades(document.getElementById('localidad'), document.getElementById('provincia').value);" required>
                                    <option value="" selected disabled hidden>provincia</option>
                                    <option value="ciudad autonoma de bsas y gba">ciudad autonoma de bsas y gba</option>
                                    <option value="buenos aires">buenos aires</option>
                                    <option value="santa fe">santa fe</option>
                                    <option value="cordoba">cordoba</option>
                                    <option value="mendoza">mendoza</option>
                                    <option value="san juan">san juan</option>
                                    <option value="san luis">san luis</option>
                                    <option value="la rioja">la rioja</option>
                                    <option value="catamarca">catamarca</option>
                                    <option value="tucuman">tucuman</option>
                                    <option value="jujuy">jujuy</option>
                                    <option value="salta">salta</option>
                                    <option value="neuquen">neuquen</option>
                                    <option value="rio negro">rio negro</option>
                                    <option value="chubut">chubut</option>
                                    <option value="santa cruz">santa cruz</option>
                                    <option value="tierra del fuego">tierra del fuego</option>
                                    <option value="santiago del estero">santiago del estero</option>
                                    <option value="chaco">chaco</option>
                                    <option value="formosa">formosa</option>
                                    <option value="misiones">misiones</option>
                                    <option value="corrientes">corrientes</option>
                                    <option value="entre rios">entre rios</option>
                                    <option value="la pampa">la pampa</option>
                                </select>
                            </div>

                            <!-- LOCALIDAD-->
                            <div class="form-input"><label for="localidad">Localidad <small>*</small></label><br>
                                <select style="text-transform: capitalize!important" name="dir_localidad" class="form-control col" id="localidad" required>
                                    <option value="" selected disabled hidden>localidad</option>
                                </select>
                            </div>


                            <!-- FIN de los CAMPOS -->
                            <p><span class="text-danger">*</span> Los campos con asterisco son obligatorios.</p>
                            <br>
                            <div class="login_btn d-flex align-items-center justify-content-center my-3">
                                <a href="cuenta.html" type="submit"> <button class="btn-primary">Registrarme</button></a>
                            </div>
                        </form>
                        
                        <!-- social login -->
                        <div class="container d-none">
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
                        </form> 
                    </div>
                </div>
            </div>
        </main>


        <!-- Footer -->
        <?php include 'footer.php'?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script>
            let txtUsuario = document.getElementById('usuario');
            txtUsuario.addEventListener("blur", function(){
                existeUsuario(txtUsuario.value);
            }, false)

            function existeUsuario(usuario)
            {
                let url = "clases/clienteAjax.php"
                let formData = new FormData()
                formData.append("action", "existeUsuario")
                fetch(url, ({
                    method: POST,
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    if(data.ok){
                        document.getElementById('usuario').value = ''
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