<?php 
session_start();

// Si el usuario ya ha iniciado sesión, redirigirlo a la página de inicio
if (isset($_SESSION['usuario'])) {
    header("location: vistas/inicio.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software de Solución Automotriz EAM</title>

    <!-- Enlace a los estilos -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/styleVistas.css">

    <!-- jQuery y JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <main>
        <!-- Contenedor principal -->
        <div class="contenedorPrincipal">
            <!-- Sección de bienvenida con botones -->
            <div class="cuadroLoginRegistro">
                <div class="cuadroLogin">
                    <h2>¿Eres miembro de nuestro equipo?</h2>
                    <p>Ingresa tus credenciales para iniciar sesión</p>
                    <button id="botonInicioSesion">Iniciar sesión</button>
                </div>
                <div class="cuadroRegistroInicial">
                    <h2>¿No eres miembro de nuestro equipo?</h2>
                    <p>Regístrate para ingresar</p>
                    <button id="botonRegistroInicial">Registrarse</button> 
                </div>
            </div>                
            
            <!-- Contenedor de los formularios -->
            <div class="contenedorFormulariosRegistroeInicioSesion">
                <!-- Formulario de inicio de sesión -->
                <form action="controlador/LoginControlador.php" class="formularioInicioSesion" method="POST">
                    <h2>Inicio de Sesión</h2>
                    <input type="text" name="usuario" placeholder="Nombre de usuario" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <button type="submit">Ingresar</button>
                </form>

                <!-- Formulario de registro -->
                <form action="controlador/UsuarioControlador.php" method="POST" class="formularioRegistroInicial">
                    <h2>Registrarse en nuestro equipo</h2>
                    <input type="text" name="nombre_completo" placeholder="Nombre Completo" required>
                    <input type="email" name="correo" placeholder="Correo Corporativo" required>
                    <input type="text" name="usuario" placeholder="Nombre de Usuario" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    
                    <select name="id_rol" required>
                        <option value="" disabled selected>Selecciona un perfil</option>
                        <option value="1">Administrador</option>
                        <option value="2">Asesor</option>
                        <option value="3">Operario</option>
                    </select>

                    <button type="submit">Registrarse</button>
                </form>
            </div>
        </div>
    </main>
<!--
    <footer>
        <div class="finalizarSesion">
            <a href="index.php" class="btn-finalizar">Volver</a>
        </div>
    </footer>
-->
    <!-- Script para manejo de los formularios -->
    <script src="assets/js/script.js"></script>
</body>
</html>
