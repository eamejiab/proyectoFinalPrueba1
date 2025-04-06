<?php
/*permite que la sesión permanezca iniciada para moverse entre las vistas después de su autenticación
Iniciar sesión y verificar permisos, cuando el usuario es operario no tendría permiso y arroja mensaje de alerta*/
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_rol'])) {
    echo '<script>
            alert("No tienes permiso para acceder a esta página.");
            window.location = "../index.php";
          </script>';
    exit();
}

// Obtener nombre completo y rol y se almacena en la variable para concatenarla en la vista con el saludo del usuario
$nombreCompleto = $_SESSION['nombre_completo'] ?? 'Usuario Desconocido';

// Verificar que solo Administradores y Asesores puedan acceder
if ($_SESSION['id_rol'] == 3) { // Si es Operario no permite la interacción y arroja el mensaje 
    echo '<script>
            alert("⛔Acceso denegado!. No tienes permisos para registrar vehículos.");
            window.location = "inicio.php";
          </script>';
    exit();
}

// Direccionamiento a la conexión a la base de datos presente en la ruta y poder realizar la consulta que procede
require_once __DIR__ . "/../modelo/Conexion.php";  
$conexion = Conexion::conectar(); // Llamamos al método conectar() de la clase Conexion

// Realiza la consulta en la BD para obtener la lista de clientes y de esta manera asociarlo a la creación del vehículo
$clientesOptions = "";
$sql = "SELECT id_cliente, nombre_completo FROM Clientes";
$result = $conexion->query($sql);
/*Se utiliza el while para recorrer el listado de clientes y traerlo como arreglo asociativo y acceder a los clientes en forma de lista
cuando se está creando el vehículo, htmlspecialchars impoide que se inyecte código malicioso y convierte caracteres especiales en 
string*/
while ($row = $result->fetch_assoc()) {
    $clientesOptions .= "<option value='{$row['id_cliente']}'>" . htmlspecialchars($row['nombre_completo']) . "</option>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehículo</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleVistas.css">
</head>
<body>
    <main class="contenedorPrincipal">
        <div class="cajaFormulario">
            <div class="cajaExteriorFormulario" id="crearVehiculo">                
                <form action="../controlador/VehiculoControlador.php" method="POST">
                    <div>
                        <h2>Bienvenido, <?php echo htmlspecialchars($nombreCompleto); ?> 👋</h2>                        
                        <h2>Registrar vehículo</h2>
                    </div>
                    <div>                    
                    <input type="text" name="placa" placeholder="Placa del Vehículo" required>
                    <input type="text" name="chasis" placeholder="Número de Chasis" required>
                    <input type="text" name="motor" placeholder="Número de Motor" required>
                    <input type="text" name="cilindrada" placeholder="Cilindrada" required>
                    <input type="text" name="marca" placeholder="Marca" required>
                    <input type="text" name="clase" placeholder="Clase" required>
                    <input type="text" name="modelo" placeholder="Modelo" required>
                    <select name="id_cliente" required class="seleccionCliente">
                        <option value="" disabled selected>Seleccionar Cliente</option>
                        <?= $clientesOptions; ?>  <!-- Trae el listado de clientes generadas por PHP -->
                    </select>
                    <button type="submit">Registrar Vehículo</button>   
                    </div>                                    
                </form>
            </div>
        </div>
    </main>
    <!--Botones para interactuar entre las vistas dentro del entorno y las diferentes funciones del programa-->
    <footer>
        <div class="footer-links">
            <a href="crear_cliente.php" class="btn-finalizar">Crear cliente</a>
            <a href="historial_vehiculo.php" class="btn-finalizar">Historial vehículo</a>
            <a href="trabajo_diario.php" class="btn-finalizar">Trabajo diario</a>
            <a href="inicio.php" class="btn-finalizar">Inicio</a>                       
        </div>
    </footer>
</body>
</html>
<!--
    Muestra el formulario para registrar un vehículo.
    Tras tener la lista de clientes registrados en la BD en el arreglo asociativo en la parte superior los muestra en el <select>.
    Envía los datos al VehiculoControlador.php cuando se presiona el botón Registrar Vehículo.
-->