<?php

declare(strict_types=1);

namespace Core;

use RuntimeException;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = require __DIR__ . '/../config/routes.php';
    }

    /**
     * Resolve a rota atual a partir da requisição HTTP.
     */
    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $uri = $request->uri();
        $routeKey = "{$method} {$uri}";

        if (!array_key_exists($routeKey, $this->routes)) {
            $response = new Response();
            $response->setStatusCode(404);
            
            // Exibir página 404 limpa
            $controller = new class extends Controller {
                public function notFound(): void {
                    $this->render('404', ['titulo' => 'Página não Encontrada']);
                }
            };
            $controller->notFound();
            return;
        }

        [$controllerClass, $action] = $this->routes[$routeKey];

        if (!class_exists($controllerClass)) {
            throw new RuntimeException("Controller [{$controllerClass}] não encontrado.");
        }

        $controllerInstance = new $controllerClass();

        if (!method_exists($controllerInstance, $action)) {
            throw new RuntimeException("Método [{$action}] não encontrado no controller [{$controllerClass}].");
        }

        // Executa a ação do Controller passando a requisição
        $controllerInstance->$action($request);
    }
}
