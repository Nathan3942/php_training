<?php
namespace App\Controllers;

use App\Models\User;
use App\Core\View;


class AuthController {

    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function signup(): void {
        $foundEmail = $this->userModel->findByEmail($_POST['email']);
        if ($foundEmail) {
            http_response_code(403);
            echo json_encode(['error' => 'Email already exists']);
            return;
        }
        
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
            echo json_encode(['error' => 'Cannot singup']);
            return;
        }
		session_regenerate_id(true);
		$_SESSION['user_id'] = $userId;
		$_SESSION['role'] = $data['role'];
        // http_response_code(201);
		$foundEmail = $this->userModel->getUserById($userId);
        // View::render('userPage', ['user' => $foundEmail]);
		header('Location: /userPage');
		exit;
    }

    public function login(): void {
        $email = $_POST['email'];
        $password = $_POST['password'];

    	$foundEmail = $this->userModel->findByEmail($email);
    	if (!$foundEmail) {
			http_response_code(401);
			// echo json_encode(['error' => 'Login failed']);
            View::render('auth/login', ['error' => 'Identifiants invalides']);
			return;
    	}
		if (password_verify($password, $foundEmail['password_hash'])) {
			session_regenerate_id(true);
			$_SESSION['user_id'] = $foundEmail['id'];
			$_SESSION['role'] = $foundEmail['role'];
			// echo json_encode(['message' => 'Login succesful']);
            // View::render('userPage', ['user' => $foundEmail]);
            // exit;
			header('Location: /userPage');
			exit;
		} else {
			http_response_code(401);
			// echo json_encode(['error' => 'Login failed']);
            View::render('auth/login', ['error' => 'Identifiants invalides']);
			return;
		}
    }

	public function logout(): void {
		$_SESSION = [];
		session_destroy();
		// echo json_encode(['message' => 'Logged out']);
		header('Location: /');
		exit;
	}

    public function showLoginForm(): void {
        View::render('auth/login', ['error' => null]);
    }

	public function showSignupForm(): void {
		View::render('auth/signup', ['error' => null]);
	}

}
