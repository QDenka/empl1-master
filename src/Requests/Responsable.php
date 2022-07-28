<?php
namespace App\Requests;

/**
 * На текущий момент реализованы только необходимые методы, дабы не плодить неиспользуемую реализацию
 */
interface Responsable
{
    /**
     * Проверка статуса запроса на 200 ответ
     *
     * @param string $response
     * @return void
     */
    public function checkStatusCode($response);
}