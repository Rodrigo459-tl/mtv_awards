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
        isset($_POST["nombre_cancion"]) && isset($_POST["duracion_cancion"]) &&
        isset($_POST["mp3_cancion"]) && isset($_POST["id_artista"]) &&
        isset($_POST["id_genero"]) && isset($_POST["id_album"])
    ) {
        $nombre_cancion = $_POST["nombre_cancion"];
        $fecha_lanzamiento = !empty($_POST["fecha_lanzamiento_cancion"]) ? $_POST["fecha_lanzamiento_cancion"] : null;
        $duracion_cancion = $_POST["duracion_cancion"];
        $mp3_cancion = $_POST["mp3_cancion"];
        $url_cancion = !empty($_POST["url_cancion"]) ? $_POST["url_cancion"] : null;
        $url_video_cancion = !empty($_POST["url_video_cancion"]) ? $_POST["url_video_cancion"] : null;
        $id_artista = $_POST["id_artista"];
        $id_genero = $_POST["id_genero"];
        $id_album = $_POST["id_album"];

        // Preparar los datos
        $data = array(
            "nombre_cancion" => $nombre_cancion,
            "fecha_lanzamiento_cancion" => $fecha_lanzamiento,
            "duracion_cancion" => $duracion_cancion,
            "mp3_cancion" => $mp3_cancion,
            "url_cancion" => $url_cancion,
            "url_video_cancion" => $url_video_cancion,
            "id_artista" => $id_artista,
            "id_genero" => $id_genero,
            "id_album" => $id_album,
        );

        echo print ("<pre>" . print_r($data, true) . "</pre>");

        // Consulta para insertar
        if ($tabla_cancion->createCancion($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "La canción ha sido registrada de manera correcta...",
                "title" => "¡Registro Exitoso!"
            );
            header('Location: ../../../views/panel/canciones.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar registrar la canción...",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../../views/panel/cancion_nueva.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../../views/panel/cancion_nueva.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../../views/panel/cancion_nueva.php');
    exit();
}
?>