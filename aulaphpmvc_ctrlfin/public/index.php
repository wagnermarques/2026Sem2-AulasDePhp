<?php

declare(strict_types=1);

/**
 * Front Controller - Ponto de Entrada Único da Aplicação MVC
 * 
 * Todas as requisições HTTP passam por este arquivo através do Nginx.
 */

// 1. Carregar Autoloader do Composer (PSR-4)
$autoloader = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloader)) {
    require_once $autoloader;
} else {
    // Autoloader fallback didático caso o composer install ainda não tenha rodado
    spl_autoload_register(function (string $class) {
        $prefixes = [
            'App\\'  => __DIR__ . '/../src/',
            'Core\\' => __DIR__ . '/../core/',
        ];

        foreach ($prefixes as $prefix => $baseDir) {
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                continue;
            }

            $relativeClass = substr($class, $len);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    });
}

use Core\Request;
use Core\Router;

// 2. Inicializar a Requisição HTTP e o Roteador
$request = new Request();
$router  = new Router();

// 3. Processar e Despachar a Requisição para o Controller correspondente
$router->dispatch($request);
