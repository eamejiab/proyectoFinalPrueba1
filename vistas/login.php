<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    
    <!-- Enlaces a los estilos -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleVistas.css">


    <!-- jQuery y JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    
</head>
<body>
    <main>
    <div class="contenedorFormulariosRegistroeInicioSesion">
    <form action="controllers/login_usuario.php" class="formularioInicioSesion" method="POST">
        <h2>Inicio Sesión</h2>
        <input type="text" placeholder="Nombre de usuario" name="usuario">
        <input type="password" placeholder="Ingresa tu contraseña" name="contrasena">
        <button id="botonInicioSesion">Ingresar</button>
    </form>

    <form action="controllers/registro_usuario_backEnd.php" method="POST" class="FormularioRegistroInicial">
        <h2>Registrarse en nuestro equipo</h2>
        <input type="text" placeholder="Ingresa nombre completo" name="nombre_completo">
        <input type="email" placeholder="Correo corporativo" name="correo">
        <input type="text" placeholder="Ingresa usuario a utilizar" name="usuario">
        <input type="password" placeholder="Ingresa una contraseña" name="contrasena">
        
        <select name="id_rol">
            <option disabled selected>Elige tu perfil de operación</option>
            <option value="1">Administrador</option>
            <option value="2">Asesor</option>
            <option value="3">Operario</option>
        </select>

        <button id="botonRegistroInicial">Registrarse</button>
    </form>
</div>
    </main>
    <footer>
        <div class="finalizarSesion">
            <a href="../index.php" class="btn-finalizar">Volver</a>
        </div>
    </footer>   
</body>
</html>

<!--
    Formulario para registrar usuario nuevo e ingresar usuario y contraseña al momento de la autenticación-->