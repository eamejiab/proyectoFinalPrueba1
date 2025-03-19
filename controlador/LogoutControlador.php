<?php
//Si la sesión está iniciada ejecuta la función session_destroy() para romperla y lo direcciona a la página principal
session_start();
session_destroy();
header("Location: ../index.php");
exit();
?>
