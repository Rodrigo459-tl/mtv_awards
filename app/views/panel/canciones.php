<?php
// Importar librerías
require_once '../../helpers/menu_lateral_artista.php';
require_once '../../helpers/funciones_globales.php';
require_once '../../models/Tabla_canciones.php';

session_start();

if (!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit;
}

// Instancia del Objeto
$tabla_canciones = new Tabla_canciones();
$canciones = $tabla_canciones->readAllCanciones($_SESSION["id_usuario"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Canciones</title>
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

    <!-- DataTables -->
    <link rel="stylesheet"
        href="../../../recursos/recursos_panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="../../../recursos/recursos_panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="../../../recursos/recursos_panel/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./dashboard_artista.php" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../backend/panel/liberate_user.php" class="nav-link">Cerrar Sesión</a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="../../index3.html" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="AdminLTE Logo" class="brand-image elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">MTV Awards</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?= mostrar_menu_lateral("CANCIONES") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?php
            $breadcrumb = array(
                array(
                    'tarea' => 'Canciones',
                    'href' => '#'
                )
            );
            echo mostrar_breadcrumb_art('Canciones', $breadcrumb);
            ?>
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <a href="./cancion_nueva.php" class="btn btn-block btn-dark">
                            <i class="fa fa-plus-circle"></i> Agregar
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="card-title">Lista de Canciones</h3>
                            </div>
                            <div class="card-body">
                                <table id="table-canciones" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>URL Cancion</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($canciones)) {
                                            echo '<tr><td colspan="5" class="text-center">No hay canciones disponibles para este artista.</td></tr>';
                                        } else {
                                            $count = 0;
                                            foreach ($canciones as $cancion) {
                                                echo '
                                                    <tr>
                                                        <td>' . ++$count . '</td>
                                                        <td>' . $cancion->nombre_cancion . '</td>
                                                        <td><a href="' . $cancion->url_cancion . '" target="_blank" class="btn btn-sm btn-primary">Ir al enlace</a></td>';
                                                echo ($cancion->estatus_cancion == 0)
                                                    ? '<td><a href="../../backend/panel/canciones/estatus_cancion.php?id=' . $cancion->id_acancion . '&estatus=1" class="btn btn-block btn-info">Habilitar</a></td>'
                                                    : '<td><a href="../../backend/panel/canciones/estatus_cancion.php?id=' . $cancion->id_acancion . '&estatus=0" class="btn btn-block btn-outline-success">Deshabilitar</a></td>';
                                                echo '<td>
                                                        <a href="../../backend/panel/canciones/delete_cancion.php?id=' . $cancion->id_acancion . '" class="btn btn-block btn-xs bg-gradient-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        <a href="./cancion_detalles.php?id=' . $cancion->id_acancion . '" class="btn btn-block btn-xs text-white bg-gradient-warning">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy;</strong>
        </footer>
    </div>
</body>

</html>