<?php
session_start(); //Mantiene la sesión iniciada

// Si el usuario inicia sesión, lo redirige a la página de inicio
if (isset($_SESSION['usuario'])) {
    header("Location: vistas/inicio.php");
    exit();
}
?>
