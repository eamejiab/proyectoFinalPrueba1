<?php
session_start(); //Mantiene la sesión iniciada
require_once __DIR__ . "/../modelo/ClienteModelo.php"; // Importamos el modelo del cliente
/*
    Este bloque de código está diseñado para manejar los datos que el usuario envía a través del formulario crear_cliente.php
    usando el método POST. Los datos de los campos nombre_completo, documento, direccion, telefono y correo 
    son obtenidos desde el formulario y asignados a las respectivas variables, después de eliminar cualquier 
    espacio adicional al inicio o final de esos valores usando la función trim(). Esto es útil para evitar problemas
    con entradas de texto con espacios extra, que pueden causar errores o inconvenientes al procesar la información.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre_completo']);
    $documento = trim($_POST['documento']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);

    // Validar que los campos de las variables anteriores no estén vacíos, de lo contrario muestra el mensaje
    if (empty($nombre) || empty($documento) || empty($correo)) {
        echo '<script>
                alert("⚠️ Nombre, documento y correo son obligatorios.");
                window.location = "../vistas/crear_cliente.php";
              </script>';
        exit();
    }

    // Accede al Objeto de ClienteModelo.php para registrar el cliente en la base de datos
    $resultado = ClienteModelo::registrarCliente($nombre, $documento, $direccion, $telefono, $correo);

    // Mostrar mensaje según el resultado del clienteModelo.php y direcciona a la vista de crear_cliente.php
    echo '<script>
            alert("' . $resultado . '");
            window.location = "../vistas/crear_cliente.php";
          </script>';
    exit();
}
/*
  Explicación:
    *Recibe los datos del formulario mediante POST.
    *Valida que nombre, documento y correo no estén vacíos.
    *Llama al modelo para registrar el cliente.
    *Muestra un mensaje de éxito o error y redirige a crear_cliente.php.      
*/
?>
