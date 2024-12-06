<?php
require_once '../../helpers/funciones_globales.php';

// Reinstancias la sesión
session_start();

// Importar Modelo
require_once '../../models/Tabla_usuarios.php';

// Validar sesión activa
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit;
}

// Validar ID de usuario en sesión
if (!isset($_SESSION["id_usuario"])) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "No se puede identificar al usuario en la sesión.",
        "title" => "¡ERROR!"
    );
    header("location: ../../../index.php");
    exit;
}

// Instanciar el modelo
$tabla_usuario = new Tabla_usuarios();
$usuario = $tabla_usuario->readGetUser($_SESSION["id_usuario"]);

// Validar si el usuario existe
if (empty($usuario)) {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "El usuario no existe en la base de datos.",
        "title" => "¡ERROR!"
    );
    header("location: ../../views/portal/miPerfil.php.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Blank Page</title>

    <!-- Icon -->
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../recursos/recursos_panel/css/adminlte.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">

                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            <?php
            if (isset($_SESSION['message'])) {
                echo mostrar_alerta_mensaje($_SESSION['message']["type"], $_SESSION['message']["description"], $_SESSION['message']["title"]);
                unset($_SESSION['message']);
            }
            ?>
        });
    </script>
</body>

</html>