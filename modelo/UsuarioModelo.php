<?php
require_once __DIR__ . "/../modelo/Conexion.php";

class UsuarioModelo {
    // 🔹 Método para registrar un usuario en la base de datos
    // 🔹 Método para registrar un usuario
    public static function registrarUsuario($nombre, $correo, $usuario, $contrasena, $id_rol) {
        $conexion = Conexion::conectar();
        
        if (!$conexion) {
            return "❌ ERROR: No se pudo conectar a la base de datos.";
        }

        // Verificar si el usuario o correo ya existen
        $stmt = $conexion->prepare("SELECT id_usuario FROM Usuarios WHERE correo_corporativo = ? OR nombre_usuario = ?");
        if (!$stmt) {
            return "❌ ERROR: Fallo en la preparación de la consulta de verificación: " . $conexion->error;
        }
        
        $stmt->bind_param("ss", $correo, $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return "⚠️ ATENCIÓN: El usuario o correo ya están registrados.";
        }

        // Insertar nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO Usuarios (nombre_completo, correo_corporativo, nombre_usuario, contrasena, id_rol) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            return "❌ ERROR: Fallo en la preparación de la consulta de inserción: " . $conexion->error;
        }

        $stmt->bind_param("ssssi", $nombre, $correo, $usuario, $contrasena, $id_rol);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return "✅ Registro exitoso.";
        } else {
            return "❌ ERROR: No se pudo registrar el usuario.";
        }
    }

    // 🔹 Método para validar el login de un usuario
    public static function validarLogin($usuario, $contrasena) {
        $conexion = Conexion::conectar();
        
        if (!$conexion) {
            die("❌ ERROR: No se pudo conectar a la base de datos.");
        }

        $stmt = $conexion->prepare("SELECT id_usuario, nombre_completo, contrasena, id_rol FROM Usuarios WHERE nombre_usuario = ?");
        if (!$stmt) {
            die("❌ ERROR: Fallo en la preparación de la consulta de login: " . $conexion->error);
        }

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            // 📢 DEBUG: Mostrar datos obtenidos
            var_dump($fila);

            if (password_verify($contrasena, $fila['contrasena'])) {
                return $fila; // ✅ Devuelve los datos del usuario
            }
        }
        return false; // ❌ Usuario no encontrado o contraseña incorrecta
    }
}
?>
