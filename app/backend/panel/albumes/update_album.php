<?php
echo 'Validating...';

//Importar librería modelo
require_once '../../../models/Tabla_albumes.php';

//Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Instancia del modelo
    $tabla_album = new Tabla_albumes();

    if (
        isset($_POST["titulo"]) && isset($_POST["id_artista"]) && isset($_POST["id_genero"]) &&
        isset($_POST["fecha_lanzamiento"])
    ) {
        $id_album = $_POST["id_album"];
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];
        $fecha_lanzamiento = $_POST["fecha_lanzamiento"];
        $id_artista = $_POST["id_artista"];
        $id_genero = $_POST["id_genero"];

        $data = array(
            // "field" => "value",
            "titulo_album" => $titulo,
            "descripcion_album" => $descripcion,
            "fecha_lanzamiento_album" => $fecha_lanzamiento,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero,
        );

        //Declarar variable para el archivo
        $img = $_FILES["imagen_album"];
        $file_name = NULL;

        if (!empty($img["name"])) {
            //Validar la extensión
            $temp = explode(".", $img["name"]);
            $exten = end($temp);

            if (($exten != "jpg") && ($exten != "png")) {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "La imagen no corresponde a las extensiones permitidas (jpg o png)...",
                    "title" => "¡ERROR!"
                );

                header('Location: ../../../views/panel/album_detalles.php?id=' . $id_album);
                exit();
            }

            if ($_POST['imagen_anterior'] != null) {
                if (file_exists("../../../recursos/img/albumes/" . $_POST["imagen_anterior"])) {
                    unlink("../../../recursos/img/albumes/" . $_POST["imagen_anterior"]);
                    if (move_uploaded_file($img['tmp_name'], "../../../recursos/img/albumes/" . $img['name'])) {
                        $file_name = $img['name'];
                        $data['imagen_album'] = $file_name;
                    } else {
                        $_SESSION['message'] = array(
                            "type" => "warning",
                            "description" => "La imagen no pudo ser actualizada, intentelo más tarde...",
                            "title" => "¡ERROR!"
                        );

                        header('Location: ../../views/panel/album_detalles.php?id=' . $id_album);
                        exit();
                    }
                } else {
                    $_SESSION['message'] = array(
                        "type" => "warning",
                        "description" => "La imagen no pudo ser actualizada, intentelo más tarde...",
                        "title" => "¡ERROR!"
                    );

                    header('Location: ../../views/panel/album_detalles.php?id=' . $id_album);
                    exit();
                }
            } else {
                if (move_uploaded_file($img['tmp_name'], "../../../recursos/img/albumes/" . $img['name'])) {
                    $file_name = $img['name'];
                    $data['imagen_album'] = $file_name;
                }
            }
        }

        // Ejecutar la actualización
        if ($tabla_album->updateAlbum($id_album, $data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El álbum ha sido actualizado de manera correcta...",
                "title" => "¡Edición Exitosa!"
            );
            header('Location: ../../views/panel/albumes.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar actualizar el álbum...",
                "title" => "¡Error!"
            );
            header('Location: ../../views/panel/album_detalles.php?id=' . $id_album);
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../views/panel/album_detalles.php?id=' . $id_album);
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../views/panel/album_detalles.php?id=' . $id_album);
    exit();
}
