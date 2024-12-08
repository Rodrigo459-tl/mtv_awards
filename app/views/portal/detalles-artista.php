<?php
//reinstanciar la variable
session_start();

if (!isset($_SESSION["is_logged"]) || isset($_SESSION["is_logged"]) == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
}
require_once '../../models/Tabla_albumes.php';

// Instanciar la clase
$tabla_albumes = new Tabla_albumes();


// Obtener los álbumes
$albums = $tabla_albumes->readAllAlbumsG();
//debbugear un array
//print ("<pre>" . print_r($_SESSION) . "</pre>")
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
    <title>MTV | awards</title>

    <!-- Favicon -->
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">

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


    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(../../../recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>See what’s new</p>
            <h2>Events</h2>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <img src="../../../recursos/img/albums/<?= htmlspecialchars($albums->imagen_album) ?>"
                            class="card-img-top" alt="Imagen del álbum">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($albums->titulo_album) ?></h5>
                            <p class="card-text"><strong>Artista:</strong> <?= htmlspecialchars($albums->artista) ?></p>
                            <p class="card-text"><strong>Género:</strong> <?= htmlspecialchars($albums->genero) ?></p>
                            <p class="card-text"><strong>Fecha de lanzamiento:</strong>
                                <?= htmlspecialchars($albums->fecha_lanzamiento) ?></p>
                            <p class="card-text"><strong>Descripción:</strong>
                                <?= htmlspecialchars($albums->descripcion) ?></p>
                            <a href="#" class="btn btn-primary">Ver más detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Events Area Start ##### -->
    <section class="events-area section-padding-100">
        <div class="container">
            <div class="row">

    </section>
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