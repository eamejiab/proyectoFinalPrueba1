<?php
session_start();
require_once __DIR__ . "/../modelo/UsuarioModelo.php";
/*
    Este bloque de código está diseñado para manejar los datos que el usuario envía a través del formulario login.php
    usando el método POST. Los datos de los campos usuario y contrasena son obtenidos desde el formulario y asignados 
    a las respectivas variables, después de eliminar cualquier espacio adicional al inicio o final de esos valores
    usando la función trim(). Esto es útil para evitar problemas con entradas de texto con espacios extra, que pueden
    causar errores o inconvenientes al procesar la información.
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    // Validar que los campos de las variables anteriores no estén vacíos, de lo contrario muestra el mensaje
    if (empty($usuario) || empty($contrasena)) {
        echo '<script>
                alert("Por favor, complete todos los campos.");
                window.location = "../index.php";
              </script>';
        exit();
    }
    /*Accede al Objeto de UsuarioModelo.php para validar que los datos ingresados por el usuario tengan una 
    autenticación exitosa y los almacena en $usuarioValido*/
    $usuarioValido = UsuarioModelo::validarLogin($usuario, $contrasena);
    /*
        Este código se utiliza para almacenar información relevante del usuario en la sesión después de que 
        la autenticación haya sido exitosa. Las variables de sesión creadas aquí permiten acceder a los datos 
        del usuario en diferentes páginas del sitio durante su sesión activa. Este código se utiliza para 
        almacenar información relevante del usuario en la sesión después de que la autenticación haya sido 
        exitosa. Las variables de sesión creadas aquí permiten acceder a los datos del usuario en diferentes
        páginas del sitio durante su sesión activa.   
    */
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
