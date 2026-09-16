<?php
namespace App\Controllers;

use App\Models\User;
use App\Core\View;

class UserController {

    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index(): void {
        $users = $this->userModel->getAllUsers();
        header('Content-Type: text/html; charset=utf-8');
        // echo json_encode($users);
        View::render('index', ['users' => $users]);
    }

    public function show(int $id): void {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function store(): void {

        $data = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password_hash' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
            'role' => $_POST['role'] ?? 'student'
        ];

        $userId = $this->userModel->createUser($data);
        if (!$userId) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create user']);
            return;
        }
        http_response_code(201);
        echo json_encode(['id' => $userId]);
    }

    public function update(int $id): void {

        parse_str(file_get_contents('php://input'), $putData);

        $data = [
            'first_name' => $putData['first_name'] ?? '',
            'last_name' => $putData['last_name'] ?? '',
            'email' => $putData['email'] ?? '',
            'password_hash' => password_hash($putData['password'] ?? '', PASSWORD_DEFAULT),
            'role' => $putData['role'] ?? 'student'
        ];

        $result = $this->userModel->updateUser($id, $data);
        if (!$result) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to modify user']);
            return;
        }
        echo json_encode(['first_name' => $putData['first_name'], 'last_name' => $putData['last_name'], 'email' => $putData['email'], 'role' => $putData['role']]);
    }

    public function delete(int $id): void {

        $userId = $this->userModel->deleteUser($id);
        if (!$userId) {
            http_response_code(404);
            echo json_encode(['error' => 'Failed to delete user']);
            return;
        }
        http_response_code(204);
        $_SESSION = [];
        // echo json_encode(['id' => $userId]);
        // View::render('home', ['title' => 'Bienvenue dans mon projet Training PHP']);
        header('Location: /');
        exit;
    }

    public function showUserPage(): void {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        View::render('userPage', ['user' => $user]);
    }
}