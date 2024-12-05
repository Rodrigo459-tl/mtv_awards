<?php 
echo 'Validating...';

//Importar libreria modelo
require_once '../../../models/Tabla_albumes.php';

//Iniciar la sesión
session_start();

if (isset($_GET['id'])) {
    $id_album = $_GET['id'];
    //Instancia del modelo
    $tabla_album = new Tabla_albumes();
    $album = $tabla_album->readGetAlbum($id_album);
    echo print("<pre>" . print_r($album, true) . "</pre>");
    if (!empty($album)) {
        if ($album->imagen_album != null) {
            if (file_exists('../../../recursos/img/albums/' . $album->imagen_album)) {
                if (unlink('../../../recursos/img/albums/' . $album->imagen_album)) {
                    if ($tabla_album->deleteAlbum($_GET['id'])) {
                        $_SESSION['message'] = array(
                            "type" => "success", 
                            "description" => "El álbum ha sido eliminado de manera correcta...",
                            "title" => "¡Eliminación Exitosa!"
                        );
                        header('Location: ../../views/panel/albumes.php');
                        exit();
                    } else {
                        $_SESSION['message'] = array(
                            "type" => "warning", 
                            "description" => "Error al intentar eliminar el álbum...",
                            "title" => "¡Ocurrió Error!"
                        );
                        header('Location: ../../views/panel/albumes.php');
                        exit();
                    }
                } else {
                    $_SESSION['message'] = array(
                        "type" => "warning", 
                        "description" => "Error al intentar eliminar el álbum...",
                        "title" => "¡Ocurrió Error!"
                    );
                    header('Location: ../../views/panel/albumes.php');
                    exit();
                }
            } else {
                if ($tabla_album->deleteAlbum($_GET['id'])) {
                    $_SESSION['message'] = array(
                        "type" => "success", 
                        "description" => "El álbum ha sido eliminado de manera correcta...",
                        "title" => "¡Eliminación Exitosa!"
                    );
                    header('Location: ../../views/panel/albumes.php');
                    exit();
                } else {
                    $_SESSION['message'] = array(
                        "type" => "warning", 
                        "description" => "Error al intentar eliminar el álbum...",
                        "title" => "¡Ocurrió Error!"
                    );
                    header('Location: ../../views/panel/albumes.php');
                    exit();
                }
            }
        } else {
            if ($tabla_album->deleteAlbum($_GET['id'])) {
                $_SESSION['message'] = array(
                    "type" => "success", 
                    "description" => "El álbum ha sido eliminado de manera correcta...",
                    "title" => "¡Eliminación Exitosa!"
                );
                header('Location: ../../views/panel/albumes.php');
                exit();
            } else {
                $_SESSION['message'] = array(
                    "type" => "warning", 
                    "description" => "Error al intentar eliminar el álbum...",
                    "title" => "¡Ocurrió Error!"
                );
                header('Location: ../../views/panel/albumes.php');
                exit();
            }
        }
    } else {
        $_SESSION['message'] = array(
            "type" => "warning", 
            "description" => "Error al intentar eliminar el álbum...",
            "title" => "¡Ocurrió Error!"
        );
        header('Location: ../../views/panel/albumes.php');
        exit();
    }
} else {
    $_SESSION['message'] = array(
        "type" => "error", 
        "description" => "Ocurrió un error al procesar la información...",
        "title" => "¡ERROR!"
    );

    header('Location: ../../views/panel/albumes.php');
    exit();
}
