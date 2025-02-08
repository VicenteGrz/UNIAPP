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

<div class="chat-container">
    <div class="chat-header">
        <h2>Chatbot de Soporte</h2>
        <p>¿En qué podemos ayudarte hoy?</p>
    </div>

    <div class="chat-box" id="chat-box">
        <!-- Mensajes del chat aparecerán aquí -->
    </div>

    <div class="chat-input">
        <input type="text" id="user-input" placeholder="Escribe tu mensaje..." />
        <button id="send-button">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatBox = document.getElementById('chat-box');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-button');

    // Función para añadir un mensaje al chat
    function addMessage(sender, message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chat-message', sender);
        messageElement.innerHTML = `<p>${message}</p>`;
        chatBox.appendChild(messageElement);
        chatBox.scrollTop = chatBox.scrollHeight; // Desplazar al último mensaje
    }

    // Función para enviar un mensaje al chatbot
    async function sendMessage() {
        const userMessage = userInput.value.trim();
        if (!userMessage) return;

        // Mostrar el mensaje del usuario en el chat
        addMessage('user', userMessage);
        userInput.value = ''; // Limpiar el campo de entrada

        console.log('Mensaje enviado:', userMessage); // Añadir log para verificar el mensaje del usuario

        try {
            // Llamar a la API de MagicLoops
            const response = await fetch(
                `https://magicloops.dev/api/loop/4008dadd-daba-4de8-9955-1ed78c45a7fc/run?input=${encodeURIComponent(userMessage)}`
            );

            // Verificar si la respuesta fue exitosa
            if (!response.ok) {
                throw new Error('Error en la respuesta de la API');
            }

            const data = await response.json();
            console.log('Respuesta de la API:', data); // Verificar lo que recibe

            // Asegurarse de que siempre haya una propiedad de respuesta en el JSON
            if (data && data.output) {
                // Mostrar siempre la respuesta de la API en el chat
                addMessage('bot', data.output);
            } else {
                // Si la propiedad "output" no está presente o está vacía, mostrar el mensaje crudo de la API
                addMessage('bot', JSON.stringify(data));  // Mostrar el JSON completo para depuración si no hay "output"
            }

        } catch (error) {
            console.error('Error al comunicarse con el chatbot:', error);
            addMessage('bot', 'Hubo un error al procesar tu solicitud. Inténtalo de nuevo.');
        }
    }

    // Enviar mensaje al hacer clic en el botón
    sendButton.addEventListener('click', sendMessage);

    // Enviar mensaje al presionar Enter
    userInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});
</script>

<style>
.chat-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.chat-header {
    text-align: center;
    margin-bottom: 20px;
}

.chat-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #590b1e;
}

.chat-header p {
    margin: 5px 0;
    color: #666;
}

.chat-box {
    height: 400px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
    background: #f9f9f9;
}

.chat-message {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 8px;
    max-width: 70%;
}

.chat-message.user {
    background: #590b1e;
    color: white;
    margin-left: auto;
}

.chat-message.bot {
    background: #e0e0e0;
    color: #333;
    margin-right: auto;
}

.chat-input {
    display: flex;
    gap: 10px;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.chat-input button {
    padding: 10px 20px;
    background: #590b1e;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
}

.chat-input button:hover {
    background: #cc0000;
}
</style>

<?php include 'footer.php'; ?>
