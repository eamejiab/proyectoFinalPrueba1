<!--Controlador para la creacion de vehículo, manejando la lógica y enviando los datos a vehiculoModelo.php-->
<?php
session_start();
require_once __DIR__ . "/../modelo/VehiculoModelo.php"; // Importamos el modelo de vehículo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = trim($_POST['placa']);
    $chasis = trim($_POST['chasis']);
    $motor = trim($_POST['motor']);
    $cilindrada = trim($_POST['cilindrada']);
    $marca = trim($_POST['marca']);
    $clase = trim($_POST['clase']);
    $modelo = trim($_POST['modelo']);
    $id_cliente = trim($_POST['id_cliente']);

    // Validar que los campos obligatorios no estén vacíos
    if (empty($placa) || empty($chasis) || empty($motor) || empty($marca) || empty($clase) || empty($modelo) || empty($id_cliente)) {
        echo '<script>
                alert("⚠️ Todos los campos son obligatorios.");
                window.location = "../vistas/crear_vehiculo.php";
              </script>';
        exit();
    }

    // Intentar registrar el vehículo en la base de datos
    $resultado = VehiculoModelo::registrarVehiculo($placa, $chasis, $motor, $cilindrada, $marca, $clase, $modelo, $id_cliente);

    // Mostrar mensaje según el resultado
    echo '<script>
            alert("' . $resultado . '");
            window.location = "../vistas/crear_vehiculo.php";
          </script>';
    exit();
}
?>
<!--
  Recibe los datos del formulario mediante POST.
  Valida que los campos obligatorios no estén vacíos.
  Llama al modelo para registrar el vehículo.
  Muestra un mensaje de éxito o error y redirige a crear_vehiculo.php.
-->