<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../models/UserModel.php';
    $userModel = new UserModel();
    $userData = $userModel->getUserData($_POST['username']);
    
    if ($userData && password_verify($_POST['password'], $userData['password'])) {
        $_SESSION['username'] = $userData['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNT</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-header">
            <img src="../assets/img/logo.png" alt="UNT Logo" class="login-logo">
        </div>

        <?php if (isset($error)): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="login-form">
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i>
                    Matrícula
                </label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       required 
                       placeholder="Ingresa tu matrícula"
                       autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i>
                    Contraseña
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       placeholder="Ingresa tu contraseña"
                       autocomplete="current-password">
            </div>

            <button type="submit" class="login-button">
                <i class="fas fa-sign-in-alt"></i>
                Ingresar
            </button>

            <div class="login-links">
                <a href="#" class="forgot-password">
                    <i class="fas fa-key"></i>
                    ¿Olvidaste tu contraseña?
                </a>
                <a href="#" class="help-link">
                    <i class="fas fa-question-circle"></i>
                    Ayuda
                </a>
            </div>
        </form>

        <div class="login-footer">
            <p>Universidad del Norte de Tamaulipas</p>
            <p class="copyright">© <?php echo date('Y'); ?> Todos los derechos reservados</p>
        </div>
    </div>
</body>
</html>