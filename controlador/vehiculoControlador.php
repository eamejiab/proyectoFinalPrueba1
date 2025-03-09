<!--Controlador para la creacion de vehículo, manejando la lógica y enviando los datos a vehiculoModelo.php-->

<?php
require_once "../modelo/VehiculoModelo.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = trim($_POST['placa']);
    $chasis = trim($_POST['chasis']);
    $motor = trim($_POST['motor']);
    $cilindrada = trim($_POST['cilindrada']);
    $marca = trim($_POST['marca']);
    $clase = trim($_POST['clase']);
    $modelo = trim($_POST['modelo']);
    $id_cliente = (int) $_POST['id_cliente'];

    if (empty($placa) || empty($chasis) || empty($motor) || empty($id_cliente)) {
        echo '<script>
                alert("⚠️ Todos los campos obligatorios deben estar llenos.");
                window.location = "../vistas/crear_vehiculo.php";
              </script>';
        exit();
    }

    $vehiculoRegistrado = VehiculoModelo::registrarVehiculo($placa, $chasis, $motor, $cilindrada, $marca, $clase, $modelo, $id_cliente);

    if ($vehiculoRegistrado) {
        echo '<script>
                alert("✅ Vehículo registrado correctamente.");
                window.location = "../vistas/inicio.php";
              </script>';
    } else {
        echo '<script>
                alert("❌ Error al registrar el vehículo. Verifica la información.");
                window.location = "../vistas/crear_vehiculo.php";
              </script>';
    }
}
?>
