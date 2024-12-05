<?php
echo 'Validating...';

// Importar libreria modelo
require_once '../../models/Tabla_artistas.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del modelo
    $tabla_artista = new Tabla_artistas();

    if (
        isset($_POST["pseudonimo_artista"]) && isset($_POST["nacionalidad_artista"]) &&
        isset($_POST["id_usuario"]) && isset($_POST["id_genero"])
    ) {
        $pseudonimo = $_POST["pseudonimo_artista"];
        $nacionalidad = $_POST["nacionalidad_artista"];
        $biografia = isset($_POST["biografia_artista"]) ? $_POST["biografia_artista"] : null;
        $id_usuario = $_POST["id_usuario"];
        $id_genero = $_POST["id_genero"];

        $data = array(
            "pseudonimo_artista" => $pseudonimo,
            "nacionalidad_artista" => $nacionalidad,
            "biografia_artista" => $biografia,
            "id_usuario" => $id_usuario,
            "id_genero" => $id_genero,
        );

        echo print ("<pre>" . print_r($data, true) . "</pre>");

        // STATEMENT QUERY - INSERT
        if ($tabla_artista->createArtista($data)) {
            $_SESSION['message'] = array(
                "type" => "success",
                "description" => "El artista ha sido registrado de manera correcta...",
                "title" => "¡Registro Exitoso!"
            );
            header('Location: ../../views/panel/artistas.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning",
                "description" => "Error al intentar registrar al artista...",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../views/panel/artista_nuevo.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error",
            "description" => "Ocurrió un error al procesar la información...",
            "title" => "¡ERROR!"
        );
        header('Location: ../../views/panel/artistas.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error",
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );
    header('Location: ../../views/panel/artista_nuevo.php');
    exit();
}
