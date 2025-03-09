<?php
session_start();
require_once __DIR__ . "/../modelo/UsuarioModelo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre_completo']);
    $correo = trim($_POST['correo']);
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    $id_rol = trim($_POST['id_rol']);

    // Validar campos vacíos
    if (empty($nombre) || empty($correo) || empty($usuario) || empty($contrasena) || empty($id_rol)) {
        echo '<script>
                alert("⚠️ Todos los campos son obligatorios.");
                window.location = "../vistas/registro.php";
              </script>';
        exit();
    }

    // Cifrar la contraseña
    $contrasenaCifrada = password_hash($contrasena, PASSWORD_DEFAULT);

    // Intentar registrar el usuario
    $resultado = UsuarioModelo::registrarUsuario($nombre, $correo, $usuario, $contrasenaCifrada, $id_rol);

    // Mostrar mensaje según el resultado
    echo '<script>
            alert("' . $resultado . '");
            window.location = "../vistas/registro.php";
          </script>';
    exit();
}
?>
