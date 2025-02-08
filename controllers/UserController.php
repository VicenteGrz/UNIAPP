<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        // Verifica el User-Agent al instanciar el controlador
        $this->checkUserAgent();

        // Inicializa el modelo de usuario
        $this->userModel = new UserModel();
    }
    private function checkUserAgent() {
        // Obtiene el User-Agent de la solicitud HTTP
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

        if (strpos($userAgent, 'Vinebre') === false) {
            header("HTTP/1.1 403 Forbidden");
            exit(); 
        }
    }
    public function getUserData($username) {
        return $this->userModel->getUserData($username);
    }
    public function getUserGrades($username) {
        return $this->userModel->getUserGrades($username);
    }
}
?>
