<?php
require_once __DIR__ . "/../modelo/Conexion.php"; // Importamos la conexión a la base de datos

class ClienteModelo {
    /**
     * Método para registrar un cliente en la base de datos.
     * Recibe los datos del cliente y los inserta en la tabla `Clientes`.
     */
    public static function registrarCliente($nombre, $documento, $direccion, $telefono, $correo) {
        $conexion = Conexion::conectar(); // Conectar con la base de datos
        
        if (!$conexion) {
            return "❌ ERROR: No se pudo conectar a la base de datos.";
        }

        // Verificar si el cliente ya está registrado por documento o correo
        $stmt = $conexion->prepare("SELECT id_cliente FROM Clientes WHERE documento = ? OR correo = ?");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de verificación.";
        }

        $stmt->bind_param("ss", $documento, $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return "⚠️ Atención: El cliente ya está registrado.";
        }

        // Insertar nuevo cliente en la base de datos
        $stmt = $conexion->prepare("INSERT INTO Clientes (nombre_completo, documento, direccion, telefono, correo) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de inserción.";
        }

        $stmt->bind_param("sssss", $nombre, $documento, $direccion, $telefono, $correo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return "✅ Cliente registrado con éxito.";
        } else {
            return "❌ ERROR: No se pudo registrar el cliente.";
        }
    }
}
/*🔹 Explicación:
✔️ Verifica si el cliente ya existe antes de insertarlo.
✔️ Inserta los datos en la base de datos si no hay duplicados.
✔️ Devuelve un mensaje de éxito o error para ser mostrado al usuario.
*/
?>
