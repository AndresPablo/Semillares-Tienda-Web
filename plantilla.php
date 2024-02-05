

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
        <?php include 'menu.php'?>
        <!------- -------------------->
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
                    <div class="col ingreso-derecha d-flex flex-column ">
                        <div class="row">
                            <div class="col-sm-6"><a class="" href="login.php">Iniciar Sesión</a></div>
                            <div class="col-sm-6"><a class="active bold" href="#">Registrarme</a></div>
                        </div>
                        
                        <form>
                            <label for="nombre">Nombre</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control text-start" id="nombre" placeholder="Ejemplo"> 
                                </div>
                            </div>
                            <label for="nombre">Apellido</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="Ejemplo" > 
                                </div>
                            </div>
                            <label for="nombre">Correo Electrónico</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="Ejemplo" > 
                                </div>
                            </div>
                            <label for="nombre">Nombre de Cuenta</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-vcard"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="Tu Local" > 
                                </div>
                            </div>
                            <label for="nombre">Dirección</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="Calle, altura" > 
                                </div>
                            </div>
                            <label for="nombre">Referencia de Dirección</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="Entrecalle, color de frente" > 
                                </div>
                            </div>
                            <label for="nombre">DNI</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge-fill"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="12.123.123" > 
                                </div>
                            </div>
                            <label for="nombre">Teléfono</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="(221) 123-456" > 
                                </div>
                            </div>
                            <label for="nombre">Contraseña</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control text-start" id="nombre" placeholder="Contraseña" > 
                                </div>
                            </div>
                            <label for="nombre">Repetir Contraseña</label>
                            <div class="form-floating mb-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i><span class="text-danger">*</span></span>
                                    <input type="text" class="form-control  text-start" id="nombre" placeholder="Contraseña" > 
                                </div>
                            </div>
                    </form>


                    </div>
                </div>
            </div>
        </section>
        
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