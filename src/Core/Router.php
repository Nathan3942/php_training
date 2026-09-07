<?php
namespace App\Core;


class Router {
    private array $routes = [];

    public function get(string $path, callable|array $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    public function addRoute(string $method, string $path, callable|array $handler): void {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(string $method, string $URL): void {
        $path = parse_url($URL, PHP_URL_PATH);
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            $controller = new $handler[0]();
            $controller->{$handler[1]}();
        } else {
            http_response_code(404);
            echo "404 Not Found\n";
        }
    }
}