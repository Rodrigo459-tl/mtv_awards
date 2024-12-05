<?php
echo 'Validating...';

//Importar libreria modelo
require_once '../../../models/Tabla_albumes.php';

//Inciar la sesion
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Instancia del modelo
    $tabla_album = new Tabla_albumes();
    if (
        isset($_POST["titulo"]) && isset($_POST["fecha_lanzamiento"]) && isset($_POST["id_artista"]) &&
        isset($_POST["id_genero"])
    ) {
        $titulo = $_POST["titulo"];
        $fecha_lanzamiento = $_POST["fecha_lanzamiento"];
        $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : null;
        $id_artista = $_POST["id_artista"];
        $id_genero = $_POST["id_genero"];

        //Declarate a variable to FILE
        $img = $_FILES["imagen_album"];
        $file_name = null;

        if (!empty($img["name"])) {
            //Validate the extension
            $temp = explode(".", $img["name"]);
            $exten = end($temp);

            if (($exten != "jpg") && ($exten != "png")) {
                $_SESSION['message'] = array(
                    "type" => "error",
                    "description" => "La imagen que desea capturar no corresponde a la extensión establecida (jpg o png)...",
                    "title" => "¡ERROR!"
                );

                header('Location: ../../views/panel/albumes.php');
                exit();
            }//end 

            if (move_uploaded_file($img['tmp_name'], "../../../recursos/img/albums/" . $img['name'])) {
                $file_name = $img['name'];
            }//end move_uploaded_file
        }//end if

        $data = array(
            // "field" => "value",
            "titulo_album" => $titulo,
            "fecha_lanzamiento_album" => $fecha_lanzamiento,
            "descripcion_album" => $descripcion,
            "imagen_album" => ($file_name == null) ? null : $file_name,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero,
        );

        echo print ("<pre>" . print_r($data, true) . "</pre>");

        //STAMENT QUERY - INSERT
        if ($tabla_album->createAlbum($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El álbum ha sido registrado de manera correcta...",
                "title" => "¡Registro Éxitoso!"
            );
            header('Location: ../../views/panel/albumes.php');
            exit();
        }//end if
        else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar registrar el álbum...",
                "title" => "¡Ocurrió Error!"
            );
            header('Location: ../../views/panel/album_nuevo.php');
            exit();
        }//end else
    }//end if 
    else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../views/panel/albumes.php');
        exit();
    }//end else
}//end REQUEST_METHOD
else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../views/panel/album_nuevo.php');
    exit();
}//end else
