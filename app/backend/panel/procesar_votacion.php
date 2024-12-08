<?php
echo 'Validating...';

// Importar librería modelo
require_once '../../models/Tabla_votaciones.php';
require_once '../../models/Tabla_albumes.php';
require_once '../../models/Tabla_artista.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_votacion = new Tabla_votaciones();
    $tabla_albumes = new Tabla_albumes();
    $tabla_artista = new Tabla_artista();

    $album = $tabla_albumes->readGetAlbum($_POST["id_al"]);

    print_r($album);

    if (!empty($album)) {

        $id_artista = $album->id_artista;
        $id_album = $album->id_album;
        $id_usuario = $_SESSION["id_usuario"];

        // Preparar los datos para la inserción
        $data = array(
            "id_artista" => $id_artista,
            "id_album" => $id_album,
            "id_usuario" => $id_usuario,
        );

        echo print ("<pre>" . print_r($data, true) . "</pre>");

        // Realizar la consulta de inserción
        if ($tabla_votacion->createVotacion($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "La votación ha sido registrada de manera correcta...",
                "title" => "¡Votación Exitosa!"
            );
            header('Location: ../../views/portal/votar.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar registrar la votación...",
                "title" => "¡Ocurrió un Error!"
            );
            //header('Location: ../../views/portal/votar.php');
            print_r("Error al votar,  datos: " . $data);
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información. Por favor, completa todos los campos requeridos.",
            "title" => "¡ERROR!"
        );
        //header('Location: ../../views/portal/votar.php');
        print_r("Error al obtener album,  datos: ");
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Método de solicitud no permitido...",
        "title" => "¡ERROR!"
    );
    header('Location: ../../views/portal/votar.php');
    exit();
}
