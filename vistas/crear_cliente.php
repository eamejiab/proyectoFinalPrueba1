<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo '<script>
            alert("⚠️ Debes iniciar sesión para acceder.");
            window.location = "../index.php";
          </script>';
    session_destroy();
    exit();
}
// Obtener nombre completo y rol
$nombreCompleto = $_SESSION['nombre_completo'] ?? 'Usuario Desconocido';
// Verificar si el usuario tiene permiso para ver esta página
$id_rol = $_SESSION['id_rol'] ?? null;
if ($id_rol == 3) { // Si es Operario, restringir acceso
    echo '<script>
            alert("⛔ No tienes permisos para acceder a esta sección.");
            window.location = "inicio.php";
          </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleVistas.css">
</head>

<body>
    <main>
        <div class="contenedorPrincipal">
            <div class="cajaFormulario">
                <div class="cajaExteriorFormulario">
                    <!--Envía los datos a ClienteControlador.php cuando se presiona el botón Registrar Cliente.-->
                    <form action="../controlador/ClienteControlador.php" method="POST">
                        <div>
                            <h2>Bienvenido, <?php echo htmlspecialchars($nombreCompleto); ?> 👋</h2>
                            <h2>Registrar Cliente</h2>
                        </div>
                        <div>
                            <input type="text" name="nombre_completo" placeholder="Nombre Completo" required>
                            <input type="text" name="documento" placeholder="Número de Documento" required>
                            <input type="text" name="direccion" placeholder="Dirección">
                            <input type="text" name="telefono" placeholder="Teléfono">
                            <input type="email" name="correo" placeholder="Correo Electrónico">
                            <button type="submit">Registrar Cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div>
        <a href="crear_vehiculo.php" class="btn-finalizar">Crear vehículo</a>
        <a href="inicio.php" class="btn-finalizar">Historial vehículo</a>
        <a href="inicio.php" class="btn-finalizar">Inicio</a>
        </div>        
    </footer>
</body>

</html>