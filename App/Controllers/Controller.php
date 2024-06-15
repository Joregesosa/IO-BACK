<?php
namespace Controllers;
use Models\Session;

require_once $_SERVER['DOCUMENT_ROOT'] . '/App/Controllers/Auth/AuthController.php';

class Controller
{
    protected $authUser;

    public function __construct()
    {
        $token = str_replace("Bearer ", '', $_SERVER["HTTP_AUTHORIZATION"]);
        $auth = new \AuthController();
        $decoded = $auth->validateToken($token);

        if ($decoded === false) {
            http_response_code(403);
            echo json_encode(['error' => "Invalid token"]);
            exit();
        }
        
        $session = new Session();
        $session = $session->where('token', $token);

        if ($session['status'] === 0) {
            http_response_code(403);
            echo json_encode(['error' => "Token expired"]);
            exit();
        }

        $this->authUser = $decoded;
    }
}
