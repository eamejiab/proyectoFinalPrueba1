<?php
session_start();
// Verificar si el usuario ha iniciado sesión
/*permite que la sesión permanezca iniciada para moverse entre las vistas después de su autenticación*/
if (!isset($_SESSION['usuario'])) {
    echo '<script>
            alert("⚠️ Debes iniciar sesión para acceder.");
            window.location = "../index.php";
          </script>';
    session_destroy(); //cierra la sesion si esta no se encuentra iniciada.
    exit();
}
// Obtener nombre completo y rol y se almacena en la variable para concatenarla en la vista con el saludo del usuario
$nombreCompleto = $_SESSION['nombre_completo'] ?? 'Usuario Desconocido';
// Verificar si el usuario tiene permiso para ver esta página, si es operario(rol_id=3), no permite el ingreso
$id_rol = $_SESSION['id_rol'] ?? null;
if ($id_rol == 3) { // Si es Operario, restringir acceso
    echo '<script>
            alert("⛔Acceso denegado!. No tienes permisos para crear clientes.");
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

        <!-- Enlaces a estilos de las vistas -->
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
                            <!--Atributos del formulario para la creación del cliente-->
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
        <!--Botones para interactuar entre las vistas dentro del entorno y las diferentes funciones del programa-->
        <footer>
            <div class="centrarBotones">
            <a href="crear_vehiculo.php" class="btn-finalizar">Crear vehículo</a>
            <a href="historial_vehiculo.php" class="btn-finalizar">Historial vehículo</a>
            <a href="trabajo_diario.php" class="btn-finalizar">Trabajo diario</a>
            <a href="inicio.php" class="btn-finalizar">Inicio</a>
            </div>        
        </footer>
    </body>
</html>
<!--
    Formulario para crear clientes con los atributos previamente establecidos
    Envío de datos al controlador/ClienteControlador.php para que ingresen a los objetos y interactúe con la BD
-->