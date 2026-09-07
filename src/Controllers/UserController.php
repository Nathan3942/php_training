<?php
namespace App\Controllers;

use App\Models\User;

class UserController {

    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index(): void {
        $users = $this->userModel->getAllUsers();
        header('Content-Type: application/json');
        echo json_encode($users);
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

}