<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '<script>
            alert("⚠️ Debes iniciar sesión para acceder.");
            window.location = "../index.php";
          </script>';
    session_destroy();
    exit();
}



// Obtener el nombre completo
$nombreCompleto = $_SESSION['nombre_completo'] ?? 'Usuario Desconocido';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de inicio</title>

    <!-- Enlaces a los estilos -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleVistas.css">

    <!-- jQuery y JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../assets/js/script.js"></script> <!-- `defer` para que cargue después del HTML -->
</head>

<body>
    <main>
        <div class="contenedorPrincipal">
            <div class="cajaFormulario">
                <div class="cajaExteriorFormulario">
                    <form action="">
                        <div>
                            <h2>Bienvenido, <?php echo htmlspecialchars($nombreCompleto); ?> 👋</h2>
                            <p>¿Qué acción deseas realizar?</p>
                        </div>
                        <div>
                            <button type="button" onclick="window.location.href='crear_cliente.php'">Crear cliente</button>
                            <button type="button" onclick="window.location.href='crear_vehiculo.php'">Crear vehículo</button>
                            <button type="button" onclick="window.location.href='historial_vehiculo.php'">Revisar historial vehículo</button>
                            <button type="button" onclick="window.location.href='trabajo_diario.php'">Apertura de trabajo diario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="finalizarSesion">
            <a href="../controlador/LogoutControlador.php" class="btn-finalizar">Salir</a>
        </div>
    </footer>
</body>

</html>