<?php
    require 'config/database.php';
    require 'clases/adminFunciones.php';

    $db = new Database();
    $con = $db->conectar();

    /*$password = password_hash('admin', PASSWORD_DEFAULT);
    $sql = "INSERT INTO admin (usuario, password, email, activo, fecha_alta) 
    VALUES ('admin', '$password','Administrador','contacto@codigosdeprogramacion.com','1',NOW())";
    $con->query($sql);*/

    $errors = [];
    if(!empty($_POST)) {
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);

        if(esNulo([$usuario, $password]))
        {
            $errors[] = "Debe llenar todos los campos";
        }

        if(count($errors) == 0)
        {
            $errors[] = login($usuario, $password, $con);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <?php echo mostrarMensajes($errors); ?>
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Ingreso Admin</h3></div>
                                    <div class="card-body">
                                        <form action="index.php" method="post" autocomplete="off">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" autofocus required id="usuario" name="usuario" type="text" placeholder="usuario" />
                                                <label for="usuario">Usuario</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" required id="password"  name="password" type="password" placeholder="contraseña" />
                                                <label for="password">Password</label>
                                            </div>
                                            <?php echo mostrarMensajes($errors); ?>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Recordarme</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Olvidaste la contraseña?</a>
                                                <button type="submit" class="btn btn-primary">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer d-none text-center py-3">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Semillares 2024</div>
                            <div>
                                <a href="./index.php">Página Principal</a>
                                &middot;
                                <a href="./tienda.php">Tienda</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
