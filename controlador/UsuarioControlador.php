<?php
  session_start();
  require_once __DIR__ . "/../modelo/UsuarioModelo.php";

  /* Configurar la respuesta como JSON para las acciones AJAX, para hacer que las solicitudes no tengan que recargar
  cada vez la página y sea mas fluida la interacción a realizar cada solicitud*/
  header("Content-Type: application/json");
  
  // Verificar que sea una solicitud POST
  if ($_SERVER["REQUEST_METHOD"] != "POST") {
    
    echo json_encode(["success" => false, "error" => "⚠️ Método no permitido."]);
    exit();
  }

  // 📌 Verificar qué acción se está realizando/ registrar o editar
  $accion = $_POST["accion"] ?? null;

  /*Manejo del registro de usuarios:
    Este bloque de código está diseñado para manejar los datos que el usuario envía a través del formulario registro.php
    usando el método POST. Los datos de los campos nombre_completo, correo, usuario, contrasena y rol, 
    son obtenidos desde el formulario y asignados a las respectivas variables, después de eliminar cualquier 
    espacio adicional al inicio o final de esos valores usando la función trim(). Esto es útil para evitar problemas
    con entradas de texto con espacios extra, que pueden causar errores o inconvenientes al procesar la información.
 */
  if ($accion === "registrar") {
      //Cuando se selecciona la acción de registrar usuario
      $nombre = trim($_POST['nombre_completo'] ?? "");
      $correo = trim($_POST['correo'] ?? "");
      $usuario = trim($_POST['usuario'] ?? "");
      $contrasena = trim($_POST['contrasena'] ?? "");
      $id_rol = trim($_POST['id_rol'] ?? "");

      // Validar que los campos de las variables anteriores no estén vacíos, de lo contrario muestra el mensaje
      if (empty($nombre) || empty($correo) || empty($usuario) || empty($contrasena) || empty($id_rol)) {         
          echo json_encode(["success" => false, "error" => "⚠️ Todos los campos son obligatorios."]);
          exit();
      }

      // Cifrar la contraseña para que no se introduzca en texto plano
      $contrasenaCifrada = password_hash($contrasena, PASSWORD_DEFAULT);

      // Accede al objeto presente en UsuarioModelo.php para el registro del usuario y lo almacena en $resultado
      $resultado = UsuarioModelo::registrarUsuario($nombre, $correo, $usuario, $contrasenaCifrada, $id_rol);
      /*
        Mensajes del resultado asociado con el registro del usuario
      */
      if ($resultado === true) {        
        echo json_encode(["success" => true, "message" => "✅ Usuario registrado exitosamente."]);
      } else {        
        echo json_encode(["success" => false, "error" => $resultado]);
      }
      exit();
  }
  if ($accion === "editar") {
    // 📌 Manejo de la edición de usuarios
    $id_usuario = $_POST["id_usuario"] ?? null;
    $nombre = trim($_POST["nombre"] ?? "");
    $usuario = trim($_POST["usuario"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $id_rol = $_POST["rol"] ?? null;

    // Validar que no haya campos vacíos
    if (!$id_usuario || !$nombre || !$usuario || !$correo || !$id_rol) {        
        echo json_encode(["success" => false, "error" => "⚠️ Todos los campos son obligatorios."]);
        exit();
    }

    // Verificar que el usuario tenga permisos para editar (solo Administradores)
    if (!isset($_SESSION["id_rol"]) || $_SESSION["id_rol"] != 1) {       
        echo json_encode(["success" => false, "error" => "⛔ No tienes permisos para editar usuarios."]);
        exit();
    }

    // Intentar actualizar los datos del usuario
    $resultado = UsuarioModelo::editarUsuario($id_usuario, $nombre, $usuario, $correo, $id_rol);

    if ($resultado) {        
        echo json_encode(["success" => true, "message" => "✅ Usuario actualizado correctamente."]);
    } else {        
        echo json_encode(["success" => false, "error" => "❌ Error al actualizar el usuario."]);
    }
    exit();
  }
  // 📌 Si no se reconoce la acción 
  echo json_encode(["success" => false, "error" => "⚠️ Acción no válida."]);
  exit();
?>