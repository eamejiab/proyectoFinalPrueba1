<?php
//Verificar si el usuario ha iniciado sesión
session_start();
//Valida que la sesión no esté vacía(sin iniciar) o el usuario sea diferente a administrador y envía el mensaje denegado)
if (!isset($_SESSION['usuario']) || $_SESSION['id_rol'] != 1) {
    echo '<script>
            alert("⛔ Acceso denegado. Solo los administradores pueden gestionar usuarios.");
            window.location = "inicio.php";
          </script>';
    exit();
}

// Trae los datos de la conexión para que pueda acceder a la BD
require_once __DIR__ . "/../modelo/Conexion.php";  
$conexion = Conexion::conectar(); 

/*  Consulta que se hace en la BD para traer el listado de usuarios registrados y almacenados en la tabla usuarios
    El siguiente segmento de código consulta información de la tabla Usuarios, seleccionando varias columnas y asignando 
    un valor de texto a la columna rol dependiendo del valor de id_rol. Los resultados de esta consulta se almacenan en la 
    variable $resultado para poderlos utilizar posteriormente en la lista de usuarios de la vista.
*/
$sql = "SELECT id_usuario, nombre_completo, nombre_usuario, correo_corporativo, 
               CASE 
                   WHEN id_rol = 1 THEN 'Administrador'
                   WHEN id_rol = 2 THEN 'Asesor'
                   WHEN id_rol = 3 THEN 'Operario'
               END AS rol, fecha_creacion 
        FROM Usuarios";
$resultado = $conexion->query($sql);

// Verificar si hay errores en la consulta
if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleVistas.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>        
</head>
<body>
    <main class="contenedorPrincipal">
        <div class="cajaFormulario">
            <div class="cajaExteriorFormulario">
                <h2>👤 Gestión de Usuarios</h2>

                <!-- Campo de búsqueda -->
                <input type="text" id="buscarUsuario" placeholder="🔍 Buscar usuario..." onkeyup="filtrarUsuarios()">
                
                <!-- Tabla de usuarios -->
                <table>
                    <thead>     <!--Encabezado de la tabla-->
                        <tr> <!--Fila de los encabezados-->
                             <!--Resaltar los encabezados-->
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios"> <!--Cuerpo de la tabla donde se mostrarán los usuarios de la tabla Usuarios-->
                        <?php while ($usuario = $resultado->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                            <td><?= htmlspecialchars($usuario['nombre_completo']); ?></td>
                            <td><?= htmlspecialchars($usuario['nombre_usuario']); ?></td>
                            <td><?= htmlspecialchars($usuario['correo_corporativo']); ?></td>
                            <td><?= htmlspecialchars($usuario['rol']); ?></td>
                            <td><?= htmlspecialchars($usuario['fecha_creacion']); ?></td>
                            <td>
                                <button class="btn-editar" onclick="abrirModalEditar(
                                    '<?= $usuario['id_usuario']; ?>',
                                    '<?= $usuario['nombre_completo']; ?>',
                                    '<?= $usuario['nombre_usuario']; ?>',
                                    '<?= $usuario['correo_corporativo']; ?>',
                                    '<?= $usuario['rol']; ?>'
                                )">✏️</button>
                                <button class="btn-eliminar" onclick="eliminarUsuario(<?= $usuario['id_usuario']; ?>)">❌</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-links">
            <a href="inicio.php" class="btn-finalizar">🏠 Volver al Inicio</a>
        </div>
    </footer>

    <!-- Modal para editar usuario -->
    <div id="modalEditar" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <h2>✏️ Editar Usuario</h2>
            <form id="formEditarUsuario">
                <input type="hidden" id="editIdUsuario">
                <label>Nombre Completo:</label>
                <input type="text" id="editNombre" required>
                <label>Usuario:</label>
                <input type="text" id="editUsuario" required>
                <label>Correo:</label>
                <input type="email" id="editCorreo" required>
                <label>Rol:</label>
                <select id="editRol" required>
                    <option value="1">Administrador</option>
                    <option value="2">Asesor</option>
                    <option value="3">Operario</option>
                </select>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
