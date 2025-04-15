<?php
require_once __DIR__ . "/../modelo/Conexion.php";

class UsuarioModelo {
    //  Método para registrar un usuario nuevo en la base de datos    
    public static function registrarUsuario($nombre, $correo, $usuario, $contrasena, $id_rol) {
        $conexion = Conexion::conectar();
        /* Verifica la conexión de la base de datos */
        if (!$conexion) {
            return "❌ ERROR: No se pudo conectar a la base de datos.";
        }

        /* Prepara una consulta en la BD en la tabla Usuarios para recibir los parámetros: correo_corporativo y nombre_usuario y 
        y de esta manera compare estos 2 atributos y no se vayan a repetir con los parámetros cuando los ingrese el usuario*/
        $sql_verificar = "SELECT id_usuario FROM Usuarios WHERE correo_corporativo = ? OR nombre_usuario = ?";
        $stmt = $conexion->prepare($sql_verificar);
        if (!$stmt) {
            return "❌ ERROR: Fallo en la preparación de la consulta de verificación: " . $conexion->error;
        }
        /* bind_param lo que hace es vincular las variables que se inyectan a la BD para hacer la comparación,SS significa que los 
         datos a insertar son string, la variable $resultado almacena el resultado de la comparación*/
        $stmt->bind_param("ss", $correo, $usuario);
        $stmt->execute();
        $stmt->store_result();
        //Si resultado arroja 1 valor muestra el mensaje/
        if ($stmt->num_rows > 0) {
            return "⚠️ ATENCIÓN: El usuario o correo ya están registrados.";
        }

        // Se prepara la consulta para insertar los parámetros a la tabla de usuarios según las entradas en el formulario de registro
        
        $sql_insert = "INSERT INTO Usuarios (nombre_completo, correo_corporativo, nombre_usuario, contrasena, id_rol) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql_insert);

        if (!$stmt) {
            return "❌ ERROR: Fallo en la preparación de la consulta de inserción: " . $conexion->error;
        }        
        /**Se vinculan los atributos a los parámetros de la consulta y los asocia con los VALUES (s=string, i= integer) */
        $stmt->bind_param("ssssi", $nombre, $correo, $usuario, $contrasena, $id_rol);
        $stmt->execute();
        /**Si se afecta una fila en la tabla arroja el mensaje positivo */
        if ($stmt->affected_rows > 0) {
            return true;  //✅ Devuelve true si se registró correctamente para que resultado no reciba strings y genere error en el json
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
        $sql = "SELECT id_usuario, nombre_completo, contrasena, id_rol FROM Usuarios WHERE nombre_usuario = ?";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("❌ ERROR: La preparación de la consulta de login no pudo llevarse a cabo: " . $conexion->error);
        }
        //Vincula el parámetro ingresado por el usuario y lo compara el usuario dentro de los que están en la tabla de la BD
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        //Si resultado es 1 los asocia en un arreglo y trae los datos solicitados del select
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            /* 📢 Prueba de depuración: Mostrar datos obtenidos
            var_dump($fila);
            */
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
   /*
     * 📌 Editar los datos de un usuario existente
     */
    public static function editarUsuario($id_usuario, $nombre, $usuario, $correo, $id_rol) {
        $conexion = Conexion::conectar();

        //Validar que la conexión a la BD sea exitosa
        if (!$conexion) {
            return "❌ ERROR: No se pudo conectar a la base de datos.";
        }
        /* Verificar si el usuario existe trayendo el id desde el modal que se selecciona para editar        
        $sql_verificar = "SELECT id_usuario FROM Usuarios WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql_verificar);
        if (!$stmt) {
            return "❌ ERROR en consulta de verificación: " . $conexion->error;
        }
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            return "⚠️ ERROR: El usuario no existe.";
        }*/ 
        /*El anterior segmento no se tiene en cuenta ya que el usuario se está tomando de la lista de usuarios que han sido sacados 
        de la base de datos*/

        // Verificar si el correo o nombre de usuario ya existen en otro usuario
        $sql_verificar_existencia = "SELECT id_usuario FROM Usuarios WHERE (correo_corporativo = ? OR nombre_usuario = ?) AND id_usuario != ?";
        $stmt = $conexion->prepare($sql_verificar_existencia);
        if (!$stmt) {
            return "❌ ERROR en consulta de verificación: " . $conexion->error;
        }
        $stmt->bind_param("ssi", $correo, $usuario, $id_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "⚠️ INFO: El correo o usuario ya están en uso por otro usuario.";
        }

        // Actualizar datos del usuario, usando la consulta UPDATE toma los datos modificados en el modal,los envía a la tabla de la BD
        $sql_update = "UPDATE Usuarios SET nombre_completo = ?, nombre_usuario = ?, correo_corporativo = ?, id_rol = ? 
                       WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql_update);
        if (!$stmt) {
            return "❌ ERROR en consulta de actualización: " . $conexion->error;
        }
        $stmt->bind_param("sssii", $nombre, $usuario, $correo, $id_rol, $id_usuario);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true; // ✅ Usuario actualizado con éxito
        } else {
            return "⚠️ INFO: No hubo cambios en la información enviada.";
        }
    }
}
/*    
    *Registro de usuarios y Login para ingresar
    *Valida que un usuario o dirección de correo no exista en la tabla de la BD para poder registrarlo exitosamente
    *Reliza una consulta de los datos del usuario para comparar usuario y contrasena y autenticar el ingreso o denegarlo
    *Utiliza la función password_verify() para verificar si una contraseña en texto plano coincide con un hash de contraseña.
    *Se utiliza el método de editarUsuario para poder realizar la consulta y actualizar la información según sea modificada en el modal
    de la vista gestios_usuarios.php
*/
?>