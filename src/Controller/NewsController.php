<?php

namespace App\Controller;

use App\Crawlers\Rbk\RbkCrawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    /**
     * Получение списка новостей из базы данных
     *
     * @return Response
     */
    #[Route('/', name: 'news.index')]

    public function index(RbkCrawler $handler): Response
    {
        $handler->start();
        $handler->parseNews();
        $handler->save();

        return $this->render('news/index.html.twig');
    }

    public function parse(): array
    {
        return [];
    }
}