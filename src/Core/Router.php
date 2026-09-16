<?php
namespace App\Core;

use App\Core\Middleware;


class Router {
    private array $routes = [];

    public function get(string $path, callable|array $handler, bool $protected = false): void {
        $this->addRoute('GET', $path, $handler, $protected);
    }

    public function post(string $path, callable|array $handler, bool $protected = false): void {
        $this->addRoute('POST', $path, $handler, $protected);
    }

    public function put(string $path, callable|array $handler, bool $protected = false): void {
        $this->addRoute('PUT', $path, $handler, $protected);
    }

    public function delete(string $path, callable|array $handler, bool $protected = false): void {
        $this->addRoute('DELETE', $path, $handler, $protected);
    }

    public function addRoute(string $method, string $path, callable|array $handler, bool $protected = false): void {
        $this->routes[$method][$path] = [
            'handler' => $handler,
            'protected' => $protected
        ];
    }

    public function dispatch(string $method, string $URL): void {
        $path = parse_url($URL, PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $routePath => $route) {
            $pattern = preg_replace('#\{[a-zA-Z]+\}#', '([^/]+)', $routePath);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                if ($route['protected'] && !Middleware::handle()) {
                    http_response_code(401);
                    echo json_encode(['error' => 'Unauthorized']);
                    return;
                }

                $handler = $route['handler'];
                if (is_array($handler)) {
                    $controller = new $handler[0]();
                    call_user_func_array([$controller, $handler[1]], $matches);
                } else {
                    call_user_func_array($handler, $matches);
                }
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found\n";
    }
}