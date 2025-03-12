<?php
// Iniciar sesión y verificar permisos
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_rol'])) {
    echo '<script>
            alert("No tienes permiso para acceder a esta página.");
            window.location = "../index.php";
          </script>';
    exit();
}

// Obtener nombre completo y rol
$nombreCompleto = $_SESSION['nombre_completo'] ?? 'Usuario Desconocido';

// Verificar que solo Administradores y Asesores puedan acceder
if ($_SESSION['id_rol'] == 3) { // Si es Operario
    echo '<script>
            alert("⛔Acceso denegado!. No tienes permisos para registrar vehículos.");
            window.location = "inicio.php";
          </script>';
    exit();
}

// Incluir la conexión a la base de datos
require_once __DIR__ . "/../modelo/Conexion.php";  
$conexion = Conexion::conectar(); // Llamamos al método conectar() de la clase Conexion

// Realiza la consulta en la BD para obtener la lista de clientes
$clientesOptions = "";
$sql = "SELECT id_cliente, nombre_completo FROM Clientes";
$result = $conexion->query($sql);
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
            <div class="cajaExteriorFormulario">                
                <form action="../controlador/VehiculoControlador.php" method="POST">
                    <div>
                        <h2>Bienvenido, <?php echo htmlspecialchars($nombreCompleto); ?> 👋</h2>                        
                        <h2>Registrar vehículo</h2>
                    </div>                    
                    <input type="text" name="placa" placeholder="Placa del Vehículo" required>
                    <input type="text" name="chasis" placeholder="Número de Chasis" required>
                    <input type="text" name="motor" placeholder="Número de Motor" required>
                    <input type="text" name="cilindrada" placeholder="Cilindrada" required>
                    <input type="text" name="marca" placeholder="Marca" required>
                    <input type="text" name="clase" placeholder="Clase" required>
                    <input type="text" name="modelo" placeholder="Modelo" required>
                    <select name="id_cliente" required>
                        <option value="" disabled selected>Seleccionar Cliente</option>
                        <?= $clientesOptions; ?>  <!-- Insertar opciones generadas por PHP -->
                    </select>
                    <button type="submit">Registrar Vehículo</button>                                       
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-links">
            <a href="crear_cliente.php" class="btn-finalizar">Crear cliente</a>
            <a href="inicio.php" class="btn-finalizar">Historial vehículo</a>
            <a href="inicio.php" class="btn-finalizar">Inicio</a>                       
        </div>
    </footer>
</body>
</html>
<!--
    Muestra el formulario para registrar un vehículo.
    Obtiene la lista de clientes registrados y los muestra en el <select>.
    Envía los datos al VehiculoControlador.php cuando se presiona el botón Registrar Vehículo.
-->