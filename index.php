<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir a la página de login
    header("Location: views/login.php");
    exit();
}

// Si el usuario ha iniciado sesión, redirigir a la página de inicio
header("Location: views/dashboard.php");
exit();
?>