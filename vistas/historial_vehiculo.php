<?php
//Verificar si el usuario ha iniciado sesión
session_start();
//Se valida que la sesión no esté vacía, si fuera así mostrar el mensaje de iniciar sesión
if (!isset($_SESSION['usuario'])) {
    echo '<script>
            alert("⚠️ Debes iniciar sesión para acceder.");
            window.location = "../index.php";
          </script>';
    session_destroy();
    exit();
}



// Obtener nombre completo y rol y se almacena en la variable para concatenarla en la vista con el saludo del usuario
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
    <script src="../assets/js/script.js"></script> 
</head>

<body>
    <main>
        <div class="contenedorPrincipal">
            <div class="cajaFormulario">
                <div class="cajaExteriorFormulario">
                    <form action="">
                        <div>
                            <h2>Bienvenido, <?php echo htmlspecialchars($nombreCompleto); ?> 👋</h2>
                            <p>Pendiente Desarrollo Modulo historial_vehiculo</p>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </main>   
    <footer>
        <div class="footer-links">
            <a href="crear_cliente.php" class="btn-finalizar">Crear cliente</a>
            <a href="crear_vehiculo.php" class="btn-finalizar">Crear vehículo</a>
            <a href="trabajo_diario.php" class="btn-finalizar">Trabajo diario</a>
            <a href="Inicio.php" class="btn-finalizar">Inicio</a>                       
        </div>
    </footer>
</body>

</html>

