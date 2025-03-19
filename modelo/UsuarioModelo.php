<?php
require_once __DIR__ . "/../modelo/Conexion.php";

class UsuarioModelo {
    // 🔹 Método para registrar un usuario en la base de datos    
    public static function registrarUsuario($nombre, $correo, $usuario, $contrasena, $id_rol) {
        $conexion = Conexion::conectar();
        
        if (!$conexion) {
            return "❌ ERROR: No se pudo conectar a la base de datos.";
        }

        /* Prepara una consulta en la BD en la tabla Usuarios para recibir los parámetros: correo_corporativo y nombre_usuario y 
        y de esta manera compare estos 2 atributos y no se vayan a repetir con los parámetros cuando los ingrese el usuario*/
        $stmt = $conexion->prepare("SELECT id_usuario FROM Usuarios WHERE correo_corporativo = ? OR nombre_usuario = ?");
        if (!$stmt) {
            return "❌ ERROR: Fallo en la preparación de la consulta de verificación: " . $conexion->error;
        }
        /* bind_param lo que hace es vincular las variables que se inyectan a la BD para hacer la comparación,SS significa que los 
         datos a insertar son string, la variable $resultado almacena el resultado de la comparación*/
        $stmt->bind_param("ss", $correo, $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        /*Si resultado arroja 1 valor muestra el mensaje*/
        if ($resultado->num_rows > 0) {
            return "⚠️ ATENCIÓN: El usuario o correo ya están registrados.";
        }

        // Se prepara la consulta para insertar los parámetros a la tabla de usuarios según las entradas en el formulario de registro
        $stmt = $conexion->prepare("INSERT INTO Usuarios (nombre_completo, correo_corporativo, nombre_usuario, contrasena, id_rol) 
                                    VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            return "❌ ERROR: Fallo en la preparación de la consulta de inserción: " . $conexion->error;
        }
        /**Se vinculan los atributos a los parámetros de la consulta y los asocia con los VALUES (s=string, i= integer) */
        $stmt->bind_param("ssssi", $nombre, $correo, $usuario, $contrasena, $id_rol);
        $stmt->execute();
        /**Si se afecta una fila en la tabla arroja el mensaje positivo */
        if ($stmt->affected_rows > 0) {
            return "✅ Registro de usuario exitoso.";
        } else {
            return "❌ ERROR: No se pudo registrar el usuario.";
        }
    }

    // Método para validar el login de un usuario
    public static function validarLogin($usuario, $contrasena) {
        $conexion = Conexion::conectar();
        //Conexión vacía
        if (!$conexion) {
            die("❌ ERROR: No se pudo conectar a la base de datos.");
        }
        /*
            Prepara la consulta para obtener de la tabla Ususarios en la base de datos los siguuientes datos y compararlos
            con la información ingresada por el usuario y aprobar o denegar el ingreso de acuardo a las credenciales 
        */
        $stmt = $conexion->prepare("SELECT id_usuario, nombre_completo, contrasena, id_rol FROM Usuarios WHERE nombre_usuario = ?");
        if (!$stmt) {
            die("❌ ERROR: Fallo en la preparación de la consulta de login: " . $conexion->error);
        }
        //Vincula el parámetro ingresado por el usuario y lo compara el usuario dentro de los que están en la tabla de la BD
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        //Si resultado es 1 los asocia en un arreglo y trae los datos solicitados del select
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            // 📢 Prueba de depuración: Mostrar datos obtenidos
            var_dump($fila);
            /*
                La función password_verify() es una función de PHP utilizada para verificar si una contraseña en texto plano 
                coincide con un hash de contraseña.
             */
            if (password_verify($contrasena, $fila['contrasena'])) {
                return $fila; // ✅ Devuelve los datos del usuario
            }
        }
        return false; // ❌ Usuario no encontrado o contraseña incorrecta
    }
}
?>
<!--
    *Registro de usuarios y Login para ingresar
    *Valida que un usuario o dirección de correo no exista en la tabla de la BD para poder registrarlo exitosamente
    *Reliza una consulta de los datos del usuario para comparar usuario y contrasena y autenticar el ingreso o denegarlo
    *Utiliza la función password_verify() para verificar si una contraseña en texto plano coincide con un hash de contraseña.
-->
