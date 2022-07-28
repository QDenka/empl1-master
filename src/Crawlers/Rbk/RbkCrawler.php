<?php

namespace App\Crawlers\Rbk;

use App\Crawlers\AbstractCrawler;
use App\Crawlers\Components\RbkComponents;
use App\Crawlers\INewsCrawler;
use App\Helpers\RbkHelper;
use App\Requests\HttpClient;
use App\DataTransfer\NewsDataTransfer;

class RbkCrawler extends AbstractCrawler implements INewsCrawler
{
    private $client, $host;

    public function __construct(HttpClient $client, NewsDataTransfer $dto)
    {
        $this->client = $client;
        $this->host = RbkComponents::getHost();
        $this->dto = $dto;
    }

    public function start()
    {
        $response = $this->client->get($this->host);

        $this->initHtml($response);
    }

    public function parseNewsLink()
    {
        $links = $this->getLinks(RbkComponents::getNewsListNode());

        return RbkHelper::formatRbkLinks($links);
    }

    public function parseNews()
    {
        $links = $this->parseNewsLink();

        foreach ($links as $link) {
            $html = $this->client->get($link);
            $this->initHtml($html);
            $this->dto->setCategory($this->getText(RbkComponents::NEWS_CATEGORY))
                ->setDescription($this->getEachText(RbkComponents::NEWS_TEXT))
                ->setHeader($this->getText(RbkComponents::NEWS_HEADER))
                ->setImage($this->getImage(RbkComponents::NEWS_IMAGE))
                ->push();
        }
    }

    public function save()
    {
        $this->dto->save();
    }
}
