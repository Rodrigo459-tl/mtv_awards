<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../models/Tabla_votacion.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_votacion = new Tabla_votaciones();

    if (
        isset($_POST["id_artista"]) &&
        isset($_POST["id_album"]) &&
        isset($_POST["id_usuario"])
    ) {
        $id_artista = $_POST["id_artista"];
        $id_album = $_POST["id_album"];
        $id_usuario = $_POST["id_usuario"];
        $fecha_creacion_votacion = $_POST["fecha_creacion_votacion"];

        // Preparar los datos para la inserción
        $data = array(
            "id_artista" => $id_artista,
            "id_album" => $id_album,
            "id_usuario" => $id_usuario,
            "fecha_creacion_votacion" => $fecha_creacion_votacion
        );

        echo print("<pre>" . print_r($data, true) . "</pre>");

        // Realizar la consulta de inserción
        if ($tabla_votacion->createVotacion($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "La votación ha sido registrada de manera correcta...",
                "title" => "¡Votación Exitosa!"
            );
            header('Location: ../../views/panel/votaciones.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar registrar la votación...",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../views/panel/votacion_nueva.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información. Por favor, completa todos los campos requeridos.",
            "title" => "¡ERROR!"
        );
        header('Location: ../../views/panel/votacion_nueva.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Método de solicitud no permitido...",
        "title" => "¡ERROR!"
    );
    header('Location: ../../views/panel/votacion_nueva.php');
    exit();
}
?>
