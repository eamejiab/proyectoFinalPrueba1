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

        // Prepara una consulta en la BD en la tabla Vehiculos el vehículo que se va a insertar y compara placa y # chasis
        $stmt = $conexion->prepare("SELECT id_vehiculo FROM Vehiculos WHERE placa = ? OR chasis = ?");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de verificación.";
        }
        /* bind_param lo que hace es vincular las variables que se inyectan a la BD para hacer la comparación,SS significa que los 
         datos a insertar son string, la variable $resultado almacena el resultado de la comparación*/

        $stmt->bind_param("ss", $placa, $chasis);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return "⚠️ ERROR: El vehículo ya está registrado.";
        }

        // Prepara la consulta para insertar un nuevo vehículo en la base de datos en la tabla Vehículos
        $stmt = $conexion->prepare("INSERT INTO Vehiculos (placa, chasis, motor, cilindrada, marca, clase, modelo, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            return "❌ ERROR: No se pudo preparar la consulta de inserción.";
        }
        /*Vincula los parámetros a la preparación de la consulta anterior, reemplazando los parámetros con los values*/
        $stmt->bind_param("sssssssi", $placa, $chasis, $motor, $cilindrada, $marca, $clase, $modelo, $id_cliente);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return "✅ Vehículo registrado con éxito.";
        } else {
            return "❌ ERROR: No se pudo registrar el vehículo.";
        }
    }

    /*
      Método para obtener la lista de clientes registrados en la base de datos.
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
    a tavés del método obtenerClientes permite obtener la lista de clientes disponibles (para asignarlos a un vehículo).

    -La función obtenerClientes() se encarga de:
    -Conectar a la base de datos.
    -Preparar una consulta SQL para obtener los datos de los clientes.
    -Ejecutar la consulta y obtener los resultados.
    -Almacenar los resultados en un arreglo.
    -Retornar ese arreglo con los datos de todos los clientes.
-->