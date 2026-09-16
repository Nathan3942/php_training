

<?php
require __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use App\Core\Database;
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;


$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/users', [UserController::class, 'index'], true);
$router->get('/users/{id}', [UserController::class, 'show'], true);
$router->post('/users', [UserController::class, 'store'], true);
$router->put('/users/{id}', [UserController::class, 'update'], true);

$router->post('/users/{id}/delete', [UserController::class, 'delete'], true);
$router->delete('/users/{id}', [UserController::class, 'delete'], true);

$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);

$router->get('/signup', [AuthController::class, 'showSignupForm']);
$router->post('/signup', [AuthController::class, 'signup']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/userPage', [UserController::class, 'showUserPage']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);


