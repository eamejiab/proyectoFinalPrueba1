<?php
session_start();

// Si el usuario ya ha iniciado sesión, lo redirige a la página de inicio
if (isset($_SESSION['usuario'])) {
    header("Location: vistas/inicio.php");
    exit();
}
?>
