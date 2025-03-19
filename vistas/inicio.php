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
                            <p>¿Qué acción deseas realizar?</p>
                        </div>
                        <div>
                            <button type="button" onclick="window.location.href='crear_cliente.php'">Crear cliente</button>
                            <button type="button" onclick="window.location.href='crear_vehiculo.php'">Crear vehículo</button>
                            <button type="button" onclick="window.location.href='historial_vehiculo.php'">Revisar historial vehículo</button>
                            <button type="button" onclick="window.location.href='trabajo_diario.php'">Apertura de trabajo diario</button>
                            <button type="button" onclick="window.location.href='gestion_usuarios.php'">Gestión de usuarios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!--Se conecta con controlador/LogoutControlador.php para finalizar la sesión cuando se da en el botón salir-->
    <footer>
        <div class="finalizarSesion">
            <a href="../controlador/LogoutControlador.php" class="btn-finalizar">Salir</a>
        </div>
    </footer>
</body>

</html>

<!--
    Formulario creado para que se muestre ingresar al entorno, muestra las diferentes vistas que tienen su propia funcionalidad
    Se conecta con controlador/LogoutControlador.php para finalizar la sesión cuando se da en el botón salir 
-->