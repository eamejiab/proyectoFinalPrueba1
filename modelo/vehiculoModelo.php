<?php
require_once __DIR__ . "/../modelo/Conexion.php"; // Importamos la conexión a la base de datos

class VehiculoModelo {
    /**
     * Método para registrar un vehículo en la base de datos.
     * Recibe los datos del vehículo y los inserta en la tabla `Vehiculos`.
     */
    public static function registrarVehiculo($placa, $chasis, $motor, $cilindrada, $marca, $clase, $modelo, $id_cliente) {
        $conexion = Conexion::conectar(); // Conectar con la base de datos
        
        if (!$conexion) {
            return "❌ ERROR: No se pudo conectar a la base de datos.";
        }

        // Verificar si el vehículo ya está registrado por placa o número de chasis
        $stmt = $conexion->prepare("SELECT id_vehiculo FROM Vehiculos WHERE placa = ? OR chasis = ?");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de verificación.";
        }

        $stmt->bind_param("ss", $placa, $chasis);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return "⚠️ ERROR: El vehículo ya está registrado.";
        }

        // Insertar nuevo vehículo en la base de datos
        $stmt = $conexion->prepare("INSERT INTO Vehiculos (placa, chasis, motor, cilindrada, marca, clase, modelo, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de inserción.";
        }

        $stmt->bind_param("sssssssi", $placa, $chasis, $motor, $cilindrada, $marca, $clase, $modelo, $id_cliente);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return "✅ Vehículo registrado con éxito.";
        } else {
            return "❌ ERROR: No se pudo registrar el vehículo.";
        }
    }

    /**
     * Método para obtener la lista de clientes registrados en la base de datos.
     */
    public static function obtenerClientes() {
        $conexion = Conexion::conectar();
        if (!$conexion) {
            return [];
        }

        $stmt = $conexion->prepare("SELECT id_cliente, nombre_completo FROM Clientes");
        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $clientes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $clientes[] = $fila;
        }

        return $clientes;
    }
}
?>
<!--
    Verifica si el vehículo ya está registrado antes de insertarlo.
    Inserta los datos en la base de datos si no hay duplicados.
    Permite obtener la lista de clientes disponibles (para asignarles un vehículo).
-->