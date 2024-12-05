<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../../models/Tabla_canciones.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Instancia del modelo
    $tabla_cancion = new Tabla_canciones();

    if (
        isset($_POST["nombre_cancion"]) && isset($_POST["fecha_lanzamiento_cancion"]) &&
        isset($_POST["duracion_cancion"]) && isset($_POST["mp3_cancion"]) &&
        isset($_POST["id_artista"]) && isset($_POST["id_genero"]) && isset($_POST["id_album"])
    ) {
        $id_cancion = $_POST["id_acancion"];
        $nombre = $_POST["nombre_cancion"];
        $fecha_lanzamiento = $_POST["fecha_lanzamiento_cancion"];
        $duracion = $_POST["duracion_cancion"];
        $mp3 = $_POST["mp3_cancion"];
        $url_cancion = (empty($_POST["url_cancion"])) ? null : $_POST["url_cancion"];
        $url_video = (empty($_POST["url_video_cancion"])) ? null : $_POST["url_video"];
        $id_artista = $_POST["id_artista"];
        $id_genero = $_POST["id_genero"];
        $id_album = $_POST["id_album"];

        $data = array(
            "nombre_cancion" => $nombre,
            "fecha_lanzamiento_cancion" => $fecha_lanzamiento,
            "duracion_cancion" => $duracion,
            "mp3_cancion" => $mp3,
            "url_cancion" => $url_cancion,
            "url_video_cancion" => $url_video,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero,
            "id_album" => $id_album,
        );

        // Declarar una variable para el archivo
        $img = $_FILES["foto_album"];
        $file_name = NULL;

        if (!empty($img["name"])) {
            // Validar la extensión
            $temp = explode(".", $img["name"]);
            $exten = end($temp);

            if (($exten != "jpg") && ($exten != "png")) {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "La imagen que desea capturar no corresponde a la extensión establecida (jpg o png)...",
                    "title" => "¡ERROR!"
                );

                header('Location: ../../views/panel/cancion_detalles.php?id=' . $id_cancion);
                exit();
            }

            if ($_POST['foto_album_anterior'] != null) {
                if (file_exists("../../../recursos/img/albums/" . $_POST["foto_album_anterior"])) {
                    unlink("../../../recursos/img/albums/" . $_POST["foto_album_anterior"]);
                    if (move_uploaded_file($img['tmp_name'], "../../../recursos/img/albums/" . $img['name'])) {
                        $file_name = $img['name'];
                        $data['foto_album'] = $file_name;
                    } else {
                        $_SESSION['message'] = array(
                            "type" => "warning",
                            "description" => "La foto del álbum no fue actualizada, intente más tarde...",
                            "title" => "¡ERROR!"
                        );

                        header('Location: ../../views/panel/cancion_detalles.php?id=' . $id_cancion);
                        exit();
                    }
                } else {
                    $_SESSION['message'] = array(
                        "type" => "warning",
                        "description" => "La foto del álbum no fue actualizada, intente más tarde...",
                        "title" => "¡ERROR!"
                    );

                    header('Location: ../../views/panel/cancion_detalles.php?id=' . $id_cancion);
                    exit();
                }
            } else {
                if (move_uploaded_file($img['tmp_name'], "../../../../recursos/img/albums/" . $img['name'])) {
                    $file_name = $img['name'];
                    $data['foto_album'] = $file_name;
                }
            }
        }

        // STAMENT QUERY - UPDATE
        if ($tabla_cancion->updateCancion($id_cancion, $data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "La canción ha sido actualizada de manera correcta...",
                "title" => "¡Edición Exitosa!"
            );
            header('Location: ../../views/panel/canciones.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar actualizar la canción...",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../../views/panel/cancion_detalles.php?id=' . $id_cancion);
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../../views/panel/cancion_detalles.php?id=' . $id_cancion);
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/cancion_detalles.php?id=' . $id_cancion);
    exit();
}
?>
