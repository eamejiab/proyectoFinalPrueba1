<?php
session_start();
require_once __DIR__ . "/../modelo/UsuarioModelo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    if (empty($usuario) || empty($contrasena)) {
        echo '<script>
                alert("Por favor, complete todos los campos.");
                window.location = "../index.php";
              </script>';
        exit();
    }

    $usuarioValido = UsuarioModelo::validarLogin($usuario, $contrasena);

    if ($usuarioValido) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id_usuario'] = $usuarioValido['id_usuario'];
        $_SESSION['id_rol'] = $usuarioValido['id_rol'];
        $_SESSION['nombre_completo'] = $usuarioValido['nombre_completo']; // Guardamos el nombre completo

        header("location: ../vistas/inicio.php");
        exit();
    } else {
        echo '<script>
                alert("Usuario o contraseña incorrectos.");
                window.location = "../index.php";
              </script>';
        exit();
    }
}

?>
