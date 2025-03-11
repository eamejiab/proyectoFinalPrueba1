<?php
session_start();
require_once __DIR__ . "/../modelo/ClienteModelo.php"; // Importamos el modelo del cliente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre_completo']);
    $documento = trim($_POST['documento']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($documento) || empty($correo)) {
        echo '<script>
                alert("⚠️ Nombre, documento y correo son obligatorios.");
                window.location = "../vistas/crear_cliente.php";
              </script>';
        exit();
    }

    // Intentar registrar el cliente en la base de datos
    $resultado = ClienteModelo::registrarCliente($nombre, $documento, $direccion, $telefono, $correo);

    // Mostrar mensaje según el resultado
    echo '<script>
            alert("' . $resultado . '");
            window.location = "../vistas/crear_cliente.php";
          </script>';
    exit();
}
/*🔹 Explicación:
✔️ Recibe los datos del formulario mediante POST.
✔️ Valida que nombre, documento y correo no estén vacíos.
✔️ Llama al modelo para registrar el cliente.
✔️ Muestra un mensaje de éxito o error y redirige a crear_cliente.php.
*/
?>
