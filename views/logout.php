<?php
session_start(); // Inicia la sesión
session_destroy(); // Destruye la sesión
header("Location: login.php"); // Redirige al usuario a dashboard.php
exit(); // Termina la ejecución del script
?> 