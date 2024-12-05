<?php
    //Importar librerias
    require_once '../../helpers/menu_lateral.php';
    require_once '../../helpers/funciones_globales.php';

    //Reintancias la variable
    session_start();

    //Importar Modelo
    require_once '../../models/Tabla_usuarios.php';

    if(!empty($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)){
        header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    }//end if 

    if(!empty($_GET["id"])){
        $_SESSION['message'] = array(
            "type" => "warning", 
            "description" => "El usuario que tratas de encontrar no existe en la Base de Datos...",
            "title" => "¡Advertencia!"
        );
        header("location: ./index.php");
        exit();
    }//end 

    //Instanciar el modelo
    $tabla_usuario = new Tabla_usuarios();
    $usuario = $tabla_usuario->readGetUser($_GET["id"]);
    // echo print("<pre>".print_r($usuario,true)."</pre>");

    if(empty($usuario)){
        $_SESSION['message'] = array(
                        "type" => "error", 
                        "description" => "El usuario que tratas de editar no existe en la Base de Datos...",
                        "title" => "¡ERROR!"
                    );
        header("location: ./index.php");
        exit();
    }//end if 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>One Music - Modern Music HTML5 Template</title>

    <!-- Favicon -->
    <link rel="icon" href="../../../recursos/recursos_portal/img/core-img/favicon.ico">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../../recursos/recursos_portal/style.css">

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Navbar Area -->
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">

                        <!-- Nav brand -->
                        <a href="index.html" class="nav-brand"><img src="img/core-img/logo.png" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="./dashboard.php">Home</a></li>
                                    <li><a href="./albums-store.php">Albums</a></li>
                                    <li><a href="#">Pages</a>
                                        <ul class="dropdown">
                                            <li><a href="./dashboard.php">Home</a></li>
                                            <li><a href="./albums-store.php">Albums</a></li>
                                            <li><a href="./event.php">Events</a></li>
                                            <li><a href="./blog.php">News</a></li>
                                            <li><a href="./contact.php">Contact</a></li>
                                            <li><a href="./elements.php">Elements</a></li>
                                            <li><a href="../../../index.php">Log out</a></li>
                                            <li><a href="#">Dropdown</a>
                                                <ul class="dropdown">
                                                    <li><a href="#">Even Dropdown</a></li>
                                                    <li><a href="#">Even Dropdown</a></li>
                                                    <li><a href="#">Even Dropdown</a></li>
                                                    <li><a href="#">Even Dropdown</a>
                                                        <ul class="dropdown">
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                            <li><a href="#">Deeply Dropdown</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Even Dropdown</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="./event.php">Events</a></li>
                                    <li><a href="./blog.php">News</a></li>
                                    <li><a href="./contact.php">Contact</a></li>
                                </ul>

                                <!-- Login/Register & Cart Button -->
                                <div class="login-register-cart-button d-flex align-items-center">
                                    <!-- Login/Register -->
                                    <div class="login-register-btn mr-50">
                                        <?php if (isset($_SESSION["nickname"])): ?>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <?= htmlspecialchars($_SESSION["nickname"]) ?>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="userDropdown">
                                                    <a class="dropdown-item text-dark" href="./perfil.php">Mi perfil</a>
                                                    <a class="dropdown-item text-dark"
                                                        href="../../backend/panel/liberate_user.php">Cerrar sesión</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a href="../../../login.php">Iniciar sesión / Registrarse</a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Cart Button -->
                                </div>

                            </div>

                            <!-- Nav End -->

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <div class="row">
                <div class="col-md-12">
                    <center>
                        <img src="../../../recursos/img/users/user.png" class="img-rounded" alt="" id="img-preview"
                            width="20%">
                    </center>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Blog Area Start ##### -->
    <form id="form-usuario" action="../../backend/panel/update_user.php" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center>
                                                <img src="../../../recursos/img/users/<?= ($usuario->imagen_usuario == '') ? 'user.png' : $usuario->imagen_usuario ;?>" class="img-rounded" alt="" id="img-preview" width="20%">
                                            </center>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_usuario" class="form-control" id="id_usuario" placeholder="Nombre(s)" value="<?= $usuario->id_usuario ?>">

                                    <input type="hidden" name="perfil_aterior" class="form-control" id="perfil_aterior" placeholder="Nombre(s)" value="<?= ($usuario->imagen_usuario != NULL) ? $usuario->imagen_usuario : '' ?>">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nombre(s)</label>
                                                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre(s)" value="<?= $usuario->nombre_usuario ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Apellido Paterno</label>
                                                <input type="text" name="apellido_paterno" class="form-control" id="apellido_paterno" placeholder="Apelldio Paterno" value="<?= $usuario->ap_usuario ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Apellido Materno</label>
                                                <input type="text" name="apellido_materno" class="form-control" id="apellido_materno" placeholder="Apelldio Paterno" value="<?= $usuario->am_usuario ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Sexo</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" value="2" <?= $usuario->sexo_usuario == 2 ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Femenino</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sexo" value="1" <?= $usuario->sexo_usuario == 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Masculino</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Rol</label>
                                                <select class="form-control" name="rol">
                                                    <option value="">Seleccionar un rol</option>
                                                    <option value="128" <?= $usuario->id_rol == 128 ? 'selected' : '' ?>>Administrador</option>
                                                    <option value="18" <?= $usuario->id_rol == 18 ? 'selected' : '' ?>>Operador</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Correo electrónico</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Correo electrónico" value="<?= $usuario->email_usuario ?>">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Contraseña</label>
                                                <input type="password" name="password" class="form-control" id="password" placeholder="***********">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Repetir Contraseña</label>
                                                <input type="password" name="repassword" class="form-control" id="repassword" placeholder="***********">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Foto perfil</label>
                                            <input type="file" name="foto_perfil" onchange="previsualizar_imagen('previsualizar_imagen','foto-input')" class="form-control" id="foto-input">
                                        </div>
                                    </div>
                                
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                <button type="submit" class="btn btn-info">Registrar</button>
                                <a href="./usuarios.php" class="btn btn-danger">Cancelar</a>
                                </div>
                            </form>
    <!-- ##### Blog Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-12 col-md-6">
                    <a href="#"><img src="img/core-img/logo.png" alt=""></a>
                    <p class="copywrite-text"><a
                            href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>document.write(new Date().getFullYear());</script> All rights reserved | This
                            template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a
                                href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>

                <div class="col-12 col-md-6">
                    <div class="footer-nav">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Albums</a></li>
                            <li><a href="#">Events</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->

    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="../../../recursos/recursos_portal/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="../../../recursos/recursos_portal/js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="../../../recursos/recursos_portal/js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="../../../recursos/recursos_portal/js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="../../../recursos/recursos_portal/js/active.js"></script>
</body>

</html>