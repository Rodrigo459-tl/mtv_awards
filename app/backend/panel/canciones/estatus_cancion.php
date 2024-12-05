<?php 
    echo 'Validating...';

    // Importar librería modelo
    require_once '../../../models/Tabla_canciones.php';

    // Iniciar la sesión
    session_start();

    if (isset($_GET['id']) && isset($_GET['estatus'])) {
        $id = $_GET['id'];
        echo $_GET['estatus'];
        
        // Instancia del modelo
        $tabla_cancion = new Tabla_canciones();

        // Actualizar el estatus de la canción
        if ($tabla_cancion->updateCancion($id, array('estatus_cancion' => intval($_GET['estatus'])))) {
            $_SESSION['message'] = array(
                "type" => "success", 
                "description" => "El estatus de la canción ha sido actualizado de manera correcta...",
                "title" => "¡Edición Éxitosa!"
            );
            header('Location: ../../views/panel/canciones.php');
            exit();
        } else {
            $_SESSION['message'] = array(
                "type" => "warning", 
                "description" => "Error al intentar actualizar el estatus de la canción...",
                "title" => "¡Ocurrió un Error!"
            );
            header('Location: ../../views/panel/canciones.php');
            exit();
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "error", 
            "description" => "Ocurrió un error al procesar la información...",
            "title" => "¡ERROR!"
        );

        header('Location: ../../views/panel/canciones.php');
        exit();
    }
?>
