<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once '../controllers/UserController.php';

$userController = new UserController();
$userData = $userController->getUserData($_SESSION['username']);

if (!$userData) {
    die("Error: Usuario no encontrado.");
}

include 'header.php';
?>

<div class="credencial-container">
    <div class="credencial-card">
        <div class="card-header">
            <h1 class="uvm-logo">Universidad del Norte de Tamaulipas</h1>
            <div class="foto-container">
                <img src="data:image/jpeg;base64,<?php echo $userData['foto']; ?>" alt="Foto del usuario" class="foto-estudiante">
            </div>
        </div>
        
        <div class="card-body">
            <h2 class="nombre-estudiante"><?php echo htmlspecialchars($userData['nombre']); ?></h2>
            <p class="carrera"><?php echo htmlspecialchars($userData['carrera']); ?></p>
            <p class="plantel"><?php echo htmlspecialchars($userData['plantel']); ?></p>

            <div class="qr-container">
                <img src="data:image/jpeg;base64,<?php echo $userData['qr']; ?>" alt="Código QR" class="qr-code">
            </div>

            <div class="detalles-container">
                <div class="detalle-item">
                    <span class="etiqueta">Matrícula</span>
                    <span class="valor"><?php echo htmlspecialchars($userData['matricula']); ?></span>
                </div>
                <div class="detalle-item">
                    <span class="etiqueta">Vence el</span>
                    <span class="valor"><?php echo htmlspecialchars($userData['fpago']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>