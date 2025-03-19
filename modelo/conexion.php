<?php
/*Objeto que guardará la conexión a la BD que será utilizado en el programa cada vez que sea necesaria */
class Conexion {
    public static function conectar() {
        $servidor = "localhost";
        $usuario = "root";
        $password = "";
        $baseDatos = "taller_vehiculos";

        $conexion = new mysqli($servidor, $usuario, $password, $baseDatos);

        if ($conexion->connect_error) {
            die("❌ ERROR: Fallo en la conexión a la base de datos: " . $conexion->connect_error);
        }

        return $conexion;
    }
}
?>
