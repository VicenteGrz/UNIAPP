<?php
session_start();
require_once '../controllers/UserController.php';
$userController = new UserController();
$userData = $userController->getUserData($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="top-bar">
        <img src="../assets/img/logo.png" alt="UNT logo" class="logo">
        <div class="top-right">
            <i class="fas fa-bell"></i>
            <img src="data:image/jpeg;base64,<?php echo $userData['foto']; ?>" alt="Usuario" class="user-photo">
        </div>
    </div>

    <div class="welcome-section">
        <h1>¡Hola, <?php echo htmlspecialchars($userData['nombre']); ?>!</h1>
        <p class="career-info"><?php echo htmlspecialchars($userData['carrera']); ?></p>
        <p class="campus-info">Campus <?php echo htmlspecialchars($userData['plantel']); ?> - Matrícula <?php echo htmlspecialchars($userData['matricula']); ?></p>
    </div>

    <div class="agenda-section">
        <div class="section-header">
            <h2>Agenda</h2>
            <span class="date">Fecha</span>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="class-schedule">
            <div class="class-item online">
                <h3>Clase en Linea</h3>
                <p>En línea</p>
            </div>
            <div class="class-item">
                <h3>Clase II</h3>
                <p>07:30h - 08:30h, Salón B7-B003</p>
            </div>
            <div class="class-item">
                <h3>Clase</h3>
                <p>10:00h - 11:59h, Salón B7-D103</p>
            </div>
        </div>
    </div>

    <div class="progress-section">
        <div class="section-header">
            <h2>Avance académico</h2>
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="progress-stats">
            <div class="stat-item">
                <span class="stat-value">0%</span>
                <span class="stat-label">Avance académico</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">0</span>
                <span class="stat-label">Promedio general</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">0/0</span>
                <span class="stat-label">Materias aprobadas</span>
            </div>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="dashboard.php" class="active">
            <i class="fas fa-home"></i>
            <span>Inicio</span>
        </a>
        <a href="credencial.php">
            <i class="far fa-id-card"></i>
            <span>Credencial</span>
        </a>
        <a href="#" id="menuButton">
            <i class="fas fa-bars"></i>
            <span>Menu</span>
        </a>
    </nav>

    <div class="side-menu" id="sideMenu">
        <div class="menu-header">
            <h2>Menú</h2>
            <button class="close-menu" id="closeMenu">&times;</button>
        </div>
        <ul class="menu-items">
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="#"><i class="fas fa-book"></i> Materias</a></li>
            <li><a href="#"><i class="fas fa-file-alt"></i> Boleta de calificaciones</a></li>
            <li><a href="#"><i class="fas fa-dollar-sign"></i> Pagos y Estado de cuenta</a></li>
            <li><a href="#"><i class="fas fa-calendar"></i> Calendario</a></li>
            <li><a href="#"><i class="fas fa-credit-card"></i> Pago en línea</a></li>
            <li><a href="#"><i class="fas fa-book-reader"></i> Biblioteca virtual</a></li>
            <li><a href="#"><i class="fas fa-user"></i> Información del estudiante</a></li>
            <li><a href="#"><i class="fas fa-file-contract"></i> Términos y condiciones</a></li>
            <li><a href="soporte.php"><i class="fas fa-headset"></i>Ayuda</a></li>
            <li><a href="chat.php"><i class="fas fa-headset"></i>Chat</a></li>
            <li><a href="logout.php"><i class="fa-solid fa-x"></i>Cerrar Sesión</a></li>
        </ul>
    </div>

    <script>
        document.getElementById('menuButton').addEventListener('click', function() {
            document.getElementById('sideMenu').classList.add('active');
        });

        document.getElementById('closeMenu').addEventListener('click', function() {
            document.getElementById('sideMenu').classList.remove('active');
        });
    </script>
</body>
</html>
