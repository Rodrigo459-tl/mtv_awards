<?php
require_once '../../models/Tabla_usuarios.php';

// Iniciar la sesión
session_start();

$message = '';
$type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo 'Analizando Datos...';

    // Instancia del modelo Tabla_usuarios
    $tabla_usuario = new Tabla_usuarios();

    // Validar si se recibió correctamente el id_usuario en la solicitud POST
    if (isset($_POST['id_usuario'])) {
        $id_usuario = intval($_POST['id_usuario']);

        // Consultar datos del usuario (suponiendo que la función `getUserById` existe en tu modelo)
        $data = $tabla_usuario->readGetUser($id_usuario);

        if ($data) {
            // Verificar el rol del usuario según el id_usuario
            if ($id_usuario == 128) { // Administrador
                $_SESSION['message'] = array(
                    "type" => "info",
                    "description" => "Bienvenido al sistema, Administrador",
                    "title" => "Inicio de sesión exitoso"
                );
                header('Location: ../../views/panel/dashboard.php');
                exit();
            } elseif ($id_usuario == 85) { // Artista
                $_SESSION['message'] = array(
                    "type" => "info",
                    "description" => "Bienvenido al sistema, Artista",
                    "title" => "Inicio de sesión exitoso"
                );
                header('Location: ../../views/panel/dashboard_artista.php');
                exit();
            } elseif ($id_usuario == 8) { // Otro usuario
                $_SESSION['message'] = array(
                    "type" => "info",
                    "description" => "Bienvenido al sistema",
                    "title" => "Inicio de sesión exitoso"
                );
                header('Location: ../../views/portal/index.php');
                exit();
            } else {
                // Usuario con rol no definido
                $_SESSION['message'] = array(
                    "type" => "info",
                    "description" => "Bienvenido al sistema",
                    "title" => "Inicio de sesión exitoso"
                );
                header('Location: ../../views/portal/index.php');
                exit();
            }
        } else {
            // Usuario no encontrado en la base de datos
            $_SESSION['message'] = array(
                "type" => "error",
                "description" => "El usuario no existe o los datos son incorrectos",
                "title" => "Error de autenticación"
            );
            header('Location: ../../../index.php');
            exit();
        }
    } else {
        // ID de usuario no válido
        $_SESSION['message'] = array(
            "type" => "warning",
            "description" => "ID de usuario no válido",
            "title" => "Error en el inicio de sesión"
        );
        header('Location: ../../../index.php');
        exit();
    }
} else {
    // Método de solicitud incorrecto
    $type = 'warning';
    $message = 'Método de solicitud no válido';
    header('Location: ../../../index.php?error=' . urlencode($message) . '&type=' . $type);
    exit();
}