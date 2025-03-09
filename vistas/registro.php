<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    
    <!-- Enlaces a los estilos -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleVistas.css">

    <!-- jQuery y JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    
</head>
<body>
    <main>
        <div class="contenedorPrincipal">
            <div class="cajaFormulario">
                <div class="cajaExteriorFormulario">
                <form action="../controlador/UsuarioControlador.php" method="POST">
                    <h2>Registro de Usuario</h2>
                    <input type="text" name="nombre_completo" placeholder="Nombre Completo" required>
                    <input type="email" name="correo" placeholder="Correo Corporativo" required>
                    <input type="text" name="usuario" placeholder="Nombre de Usuario" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    
                    <select name="rol" required>
                        <option value="" disabled selected>Selecciona un perfil</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Asesor">Asesor</option>
                        <option value="Operario">Operario</option>
                    </select>

                    <button type="submit" name="registrar_usuario">Registrarse</button>
                </form>


                    <!-- Mostrar mensaje de error si lo hay -->
                    <?php
                    if (isset($_GET['error'])) {
                        echo "<p style='color: red; text-align: center;'>" . htmlspecialchars($_GET['error']) . "</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="finalizarSesion">
            <a href="../index.php" class="btn-finalizar">Volver</a>
        </div>
    </footer>
</body>
</html>
