<?php

namespace App\Requests;

use App\Exceptions\ResponseException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient as SymfonyClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Класс HTTP клиента Symfony
 */
class HttpClient implements ClientInterface, Responsable
{
    private $client;

    public function __construct()
    {
        $this->client = SymfonyClient::create();
    }

    public function get(string $url): string
    {
        $response = $this->request($url, 'GET');

        $this->checkStatusCode($response);
        return $this->fetchContent($response);
    }

    public function request(string $url, string $method = 'GET'): ResponseInterface
    {
        $response = $this->client->request(
            $method,
            $url
        );

        return $response;
    }

    public function checkStatusCode($response): void
    {
        ResponseException::handle($response->getStatusCode());
    }

    /**
     * Получение контента из запроса
     *
     * @param ResponseInterface $response
     * @return void
     */
    protected function fetchContent(ResponseInterface $response): string
    {
        return $response->getContent();
    }
}
