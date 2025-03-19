<?php
  session_start();
  require_once __DIR__ . "/../modelo/UsuarioModelo.php";
  /*
    Este bloque de código está diseñado para manejar los datos que el usuario envía a través del formulario registro.php
    usando el método POST. Los datos de los campos nombre_completo, correo, usuario, contrasena y rol, 
    son obtenidos desde el formulario y asignados a las respectivas variables, después de eliminar cualquier 
    espacio adicional al inicio o final de esos valores usando la función trim(). Esto es útil para evitar problemas
    con entradas de texto con espacios extra, que pueden causar errores o inconvenientes al procesar la información.
 */
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nombre = trim($_POST['nombre_completo']);
      $correo = trim($_POST['correo']);
      $usuario = trim($_POST['usuario']);
      $contrasena = trim($_POST['contrasena']);
      $id_rol = trim($_POST['id_rol']);

      // Validar que los campos de las variables anteriores no estén vacíos, de lo contrario muestra el mensaje
      if (empty($nombre) || empty($correo) || empty($usuario) || empty($contrasena) || empty($id_rol)) {
          echo '<script>
                  alert("⚠️ Todos los campos son obligatorios.");
                  window.location = "../vistas/registro.php";
                </script>';
          exit();
      }

      // Cifrar la contraseña para que no se introduzca en texto plano
      $contrasenaCifrada = password_hash($contrasena, PASSWORD_DEFAULT);

      // Accede al objeto presente en UsuarioModelo.php para el registro del usuario y lo almacena en $resultado
      $resultado = UsuarioModelo::registrarUsuario($nombre, $correo, $usuario, $contrasenaCifrada, $id_rol);

      // Mostrar mensaje según el resultado y lo  direcciona a index.php en caso de que no sea satisfactorio
      echo '<script>
              alert("' . $resultado . '");
              window.location = "../index.php";
            </script>';
      exit();
  }
?>
