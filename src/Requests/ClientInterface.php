<?php

namespace App\Requests;

/**
 * На текущий момент реализованы только необходимые методы, дабы не плодить неиспользуемую реализацию
 */
interface ClientInterface
{
    /**
     * Инициализация GET запроса
     *
     * @param string $url
     * @return mixed
     */
    public function get(string $url): string;

    /**
     * Выполнение запроса
     *
     * @param string $url
     * @param string $method
     * @return ResponseInterface
     */
    public function request(string $url, string $method = 'GET');
}
