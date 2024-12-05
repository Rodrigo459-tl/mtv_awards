<?php 
    echo 'Validating...';

    // Importar librería modelo
    require_once '../../../models/Tabla_canciones.php';

    // Iniciar la sesión
    session_start();

    if (isset($_GET['id'])) {
        $id_cancion = $_GET['id'];
        // Instancia del modelo
        $tabla_cancion = new Tabla_canciones();
        $cancion = $tabla_cancion->readGetCancion($id_cancion);
        echo print("<pre>" . print_r($cancion, true) . "</pre>");
        
        if (!empty($cancion)) {
            // Verificar si la canción tiene un archivo mp3 asociado y eliminarlo si existe
            if ($cancion->mp3_cancion != null) {
                if (file_exists('../../../recursos/mp3/' . $cancion->mp3_cancion)) {
                    if (unlink('../../../recursos/mp3/' . $cancion->mp3_cancion)) {
                        if ($tabla_cancion->deleteCancion($id_cancion)) {
                            $_SESSION['message'] = array(
                                "type" => "success", 
                                "description" => "La canción ha sido eliminada de manera correcta...",
                                "title" => "¡Eliminación Éxitosa!"
                            );
                            header('Location: ../../views/panel/canciones.php');
                            exit();
                        } else {
                            $_SESSION['message'] = array(
                                "type" => "warning", 
                                "description" => "Error al intentar eliminar la canción...",
                                "title" => "¡Ocurrió un Error!"
                            );
                            header('Location: ../../views/panel/canciones.php');
                            exit();
                        }
                    } else {
                        $_SESSION['message'] = array(
                            "type" => "warning", 
                            "description" => "Error al intentar eliminar el archivo de la canción...",
                            "title" => "¡Ocurrió un Error!"
                        );
                        header('Location: ../../views/panel/canciones.php');
                        exit();
                    }
                } else {
                    if ($tabla_cancion->deleteCancion($id_cancion)) {
                        $_SESSION['message'] = array(
                            "type" => "success", 
                            "description" => "La canción ha sido eliminada de manera correcta...",
                            "title" => "¡Eliminación Éxitosa!"
                        );
                        header('Location: ../../views/panel/canciones.php');
                        exit();
                    } else {
                        $_SESSION['message'] = array(
                            "type" => "warning", 
                            "description" => "Error al intentar eliminar la canción...",
                            "title" => "¡Ocurrió un Error!"
                        );
                        header('Location: ../../views/panel/canciones.php');
                        exit();
                    }
                }
            } else {
                if ($tabla_cancion->deleteCancion($id_cancion)) {
                    $_SESSION['message'] = array(
                        "type" => "success", 
                        "description" => "La canción ha sido eliminada de manera correcta...",
                        "title" => "¡Eliminación Éxitosa!"
                    );
                    header('Location: ../../views/panel/canciones.php');
                    exit();
                } else {
                    $_SESSION['message'] = array(
                        "type" => "warning", 
                        "description" => "Error al intentar eliminar la canción...",
                        "title" => "¡Ocurrió un Error!"
                    );
                    header('Location: ../../views/panel/canciones.php');
                    exit();
                }
            }
        } else {
            $_SESSION['message'] = array(
                "type" => "warning", 
                "description" => "Error al intentar eliminar la canción...",
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
