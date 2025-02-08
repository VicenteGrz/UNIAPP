<?php
session_start();
require_once '../controllers/UserController.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$userController = new UserController();
$userData = $userController->getUserData($_SESSION['username']);

// Procesar la creación del ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $archivo = null;
    $tipo_archivo = null;

    // Procesar archivo adjunto
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0) {
        $allowed = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'png' => 'image/png'];
        $filename = $_FILES['archivo']['name'];
        $filetype = $_FILES['archivo']['type'];
        $filesize = $_FILES['archivo']['size'];

        // Verificar extensión y tipo
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die('Error: Formato de archivo no permitido');
        }

        // Verificar tipo MIME
        if (!in_array($filetype, $allowed)) {
            die('Error: Tipo de archivo incorrecto');
        }

        // Verificar tamaño (5MB máximo)
        if ($filesize > 5242880) {
            die('Error: El archivo es demasiado grande (máximo 5MB)');
        }

        // Generar nombre único
        $newname = uniqid() . "." . $ext;
        $destination = '../uploads/' . $newname;

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destination)) {
            $archivo = $newname;
            $tipo_archivo = ($ext === 'pdf') ? 'pdf' : 'imagen';
        }
    }

    // Insertar ticket en la base de datos
    $stmt = $db->prepare("INSERT INTO tickets (username, titulo, descripcion, archivo_adjunto, tipo_archivo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $_SESSION['username'], $titulo, $descripcion, $archivo, $tipo_archivo);
    
    if ($stmt->execute()) {
        header("Location: mis_tickets.php");
        exit();
    }
}

include 'header.php';
?>

<div class="support-container">
    <div class="support-card">
        <div class="card-header">
            <h2>Centro de Atencion</h2>
        </div>
        
        <form method="POST" enctype="multipart/form-data" class="support-form">
            <div class="form-group">
                <label for="titulo">Asunto</label>
                <input type="text" id="titulo" name="titulo" required 
                       class="form-control" placeholder="Describe brevemente tu problema">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required 
                          class="form-control" rows="5" 
                          placeholder="Explica tu situacion"></textarea>
            </div>

            <div class="form-group">
                <label>Adjuntar archivo</label>
                <div class="file-options">
                    <button type="button" class="btn-option" onclick="document.getElementById('archivo').click()">
                        <i class="fas fa-file-pdf"></i> Subir Archivo
                    </button>

            <button type="submit" class="submit-button">
                <i class="fas fa-paper-plane"></i> Enviar
            </button>
        </form>
    </div>
</div>

<script>
function tomarFoto() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Tu dispositivo no soporta la captura de fotos');
        return;
    }

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            // Implementar lógica de captura de foto
            const video = document.createElement('video');
            const canvas = document.createElement('canvas');
            // ... código para capturar foto ...
        })
        .catch(function(error) {
            console.error('Error al acceder a la cámara:', error);
            alert('No se pudo acceder a la cámara');
        });
}

function mostrarNombreArchivo(input) {
    const nombreSpan = document.getElementById('nombre-archivo');
    nombreSpan.textContent = input.files[0] ? input.files[0].name : '';
}
</script>

<style>
.support-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 0 15px;
}

.support-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
}

.support-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.file-options {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.btn-option {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    background: #590b1e;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
}

.submit-button {
    padding: 15px;
    background: #590b1e;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

#nombre-archivo {
    display: block;
    margin-top: 10px;
    font-size: 0.9em;
    color: #666;
}
</style>

<?php include 'footer.php'; ?>