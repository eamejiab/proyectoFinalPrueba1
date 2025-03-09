<?php
require_once "Conexion.php";

class VehiculoModelo {
    public static function registrarVehiculo($placa, $chasis, $motor, $cilindrada, $marca, $clase, $modelo, $id_cliente) {
        global $conexion;

        $sql = "INSERT INTO Vehiculos (placa, chasis, motor, cilindrada, marca, clase, modelo, id_cliente) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssssi", $placa, $chasis, $motor, $cilindrada, $marca, $clase, $modelo, $id_cliente);

        return $stmt->execute();
    }
}
?>
