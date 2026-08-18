<?php

declare(strict_types=1);

namespace Core;

use RuntimeException;

abstract class Controller
{
    protected Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * Renderiza uma view dentro do layout principal.
     */
    protected function render(string $viewPath, array $data = []): void
    {
        $fullPath = __DIR__ . '/../views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($fullPath)) {
            throw new RuntimeException("Arquivo de View não encontrado: {$fullPath}");
        }

        // Extrai as variáveis para ficarem disponíveis dentro do arquivo de view
        extract($data);

        // Inicia o buffer de saída para capturar o HTML da view específica
        ob_start();
        require $fullPath;
        $content = ob_get_clean();

        // Renderiza o layout principal que inclui $content
        $layoutPath = __DIR__ . '/../views/layouts/main.php';
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    /**
     * Auxiliar de redirecionamento.
     */
    protected function redirect(string $url): void
    {
        $this->response->redirect($url);
    }
}
