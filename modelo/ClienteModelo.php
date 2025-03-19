<?php
require_once __DIR__ . "/../modelo/Conexion.php"; // Importamos la conexión a la base de datos

class ClienteModelo {
    /**
     * Objeto para registrar un cliente en la base de datos.
     * Recibe los datos del cliente y los inserta en la tabla `Clientes`.
     */
    public static function registrarCliente($nombre, $documento, $direccion, $telefono, $correo) {
        $conexion = Conexion::conectar(); // Conexión con la base de datos
        
        if (!$conexion) {
            return "❌ ERROR: No se pudo conectar a la base de datos.";
        }

        // Prepara una consulta en la BD en la tabla Clientes el cliente que se va a insertar y compara documento y correo.
        $stmt = $conexion->prepare("SELECT id_cliente FROM Clientes WHERE documento = ? OR correo = ?");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de verificación.";
        }
        /* bind_param lo que hace es vincular las variables que se inyectan a la BD para hacer la comparación,SS significa que los 
         datos a insertar son string, la vatiable $resultado almacena el resultado de la comparación*/
        $stmt->bind_param("ss", $documento, $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        // si resultado arroja mas de 0 resultados significa que existe en la BD y arroja el mensaje
        if ($resultado->num_rows > 0) {
            return "⚠️ Atención: El cliente ya está registrado.";
        }

        // Insertar nuevo cliente en la base de datos, arroja error si la conexión es vacía
        $stmt = $conexion->prepare("INSERT INTO Clientes (nombre_completo, documento, direccion, telefono, correo) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de inserción.";
        }
        /*vincula los atributos a la BD con la información ingresada cambiando el value en la consulta */
        $stmt->bind_param("sssss", $nombre, $documento, $direccion, $telefono, $correo);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            return "✅ Cliente registrado con éxito.";
        } else {
            return "❌ ERROR: No se pudo registrar el cliente.";
        }
    }
}
/*
    Verifica si el cliente ya existe antes de insertarlo.
    Inserta los datos en la base de datos si no hay duplicados.
    Devuelve un mensaje de éxito o error para ser mostrado al usuario.
*/
?>
