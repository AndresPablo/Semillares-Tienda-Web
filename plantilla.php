

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
        <?php include 'menu.php'?>
        <!------- -------------------->
        
        <main>
            <div class="container-fluid row">
                <div class="container row my-3 mx-3">

                    <!-- Columna izquierda -->
                    <div class="container ingreso-izquierda d-none d-lg-flex col-md-6 d-flex flex-column align-items-center justify-content-center">
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
                                    <input type="text" class="form-control" name="usuario" id="usuario" placeholder="">
                                    <label for="usuario">Nombre de Usuario</label>
                                </div>
                            </div>
                            <!--  NOMBRE + APELLIDO -->
                            <div class="input-group">
                                <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-person-fill"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ejemplo">
                                    <label for="nombres">Nombre</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ejemplo">
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
                                    <input type="password" class="form-control" name="pass" id="pass" placeholder="">
                                    <label for="pass">Contraseña</label>
                                </div>
                                <div class="form-floating ">
                                    <input type="password" class="form-control" name="repass" id="repass" placeholder="">
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
                                    <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-person-vcard-fill"></i></span>
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
                                    <span class="input-group-text"><span class="text-danger">*&nbsp;</span><i class="bi bi-house-fill"></i></span>
                                    <input type="text" class="form-control text-start" id="referencia" name="referencia" placeholder="Referencia"> 
                                </div>
                            </div>

                            <!--  PROVINCIA + LOCALIDAD-->
                            <div class="input-group">
                                <label class="input-group-text" for="provincia"><span class="text-danger">*&nbsp;</span><i class="bi bi-geo-alt-fill"></i></label>
                                <select class="form-select" id="provincia" name="provincia" aria-label="Provincia">
                                            <option selected>Elija su provincia</option>
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
                                        <input type="text" class="form-control" name="localidad" id="localidad" placeholder="Localidad">
                            </div>

                            <!-- FIN de los CAMPOS -->
                            <p><span class="text-danger">*</span> Los campos con asterisco son obligatorios.</p>
                            <br>
                            <div class="login_btn d-flex align-items-center justify-content-center my-3">
                                <a href="cuenta.html" type="submit"> <button class="btn-primary">Resgistrarme</button></a>
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