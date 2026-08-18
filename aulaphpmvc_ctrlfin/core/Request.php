<?php

declare(strict_types=1);

namespace Core;

class Request
{
    /**
     * Obter a URI da requisição limpa sem query string.
     */
    public function uri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($uri, '?');

        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }

        return rtrim($uri, '/') ?: '/';
    }

    /**
     * Obter o método HTTP (GET, POST, etc).
     */
    public function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * Obter todos os dados enviados no formulário/body.
     */
    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    /**
     * Obter um campo específico sanitizado.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $data = $this->all();
        if (!isset($data[$key])) {
            return $default;
        }

        $value = $data[$key];
        return is_string($value) ? trim($value) : $value;
    }
}
