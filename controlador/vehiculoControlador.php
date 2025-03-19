<!--Controlador para la creacion de vehículo, manejando la lógica y enviando los datos a vehiculoModelo.php-->
<?php
  session_start();
  require_once __DIR__ . "/../modelo/VehiculoModelo.php"; // Importamos el modelo de vehículo
  /*
      Este bloque de código está diseñado para manejar los datos que el usuario envía a través del formulario crear_vehiculo.php
      usando el método POST. Los datos de los campos: placa, chasis, motor, cilindrada, marca, clase, modelo, id_cliente 
      son obtenidos desde el formulario y asignados a las respectivas variables, después de eliminar cualquier 
      espacio adicional al inicio o final de esos valores usando la función trim(). Esto es útil para evitar problemas
      con entradas de texto con espacios extra, que pueden causar errores o inconvenientes al procesar la información.
  */
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $placa = trim($_POST['placa']);
      $chasis = trim($_POST['chasis']);
      $motor = trim($_POST['motor']);
      $cilindrada = trim($_POST['cilindrada']);
      $marca = trim($_POST['marca']);
      $clase = trim($_POST['clase']);
      $modelo = trim($_POST['modelo']);
      $id_cliente = trim($_POST['id_cliente']);

      // Validar que los campos de las variables anteriores no estén vacíos, de lo contrario muestra el mensaje
      if (empty($placa) || empty($chasis) || empty($motor) || empty($marca) || empty($clase) || empty($modelo) || empty($id_cliente)) {
          echo '<script>
                  alert("⚠️ Todos los campos son obligatorios.");
                  window.location = "../vistas/crear_vehiculo.php";
                </script>';
          exit();
      }

      // Accede al objeto presente en VehiculoModelo.php para la creación del vehículo y lo almacena en $resultado
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
    Recibe los datos del formulario crear_vehiculo.php mediante POST.
    Valida que los campos obligatorios no estén vacíos.
    Llama al modelo en VehículoModelo.php para registrar el vehículo.
    Muestra un mensaje de éxito o error y redirige a crear_vehiculo.php.
-->