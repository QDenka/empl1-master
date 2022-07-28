<?php

namespace App\Crawlers\Rbk;

use App\Crawlers\AbstractCrawler;
use App\Crawlers\Components\RbkComponents;
use App\Helpers\RbkHelper;
use App\Requests\HttpClient;
use App\DataTransfer\NewsDataTransfer;

class RbkAjaxCrawler extends AbstractCrawler
{
    private $client, $host;

    public function __construct()
    {
        $this->client = new HttpClient();
        $this->host = RbkComponents::getHost();
        $this->dto = new NewsDataTransfer();
    }

    public function start()
    {
        $response = $this->client->get($this->host);

        $this->initHtml($response);
    }

    public function getNewsLinks()
    {
        $links = $this->getLinks(RbkComponents::getNewsListNode());

        return RbkHelper::formatRbkLinks($links);
    }

    public function parseNews()
    {
        $links = $this->getNewsLinks();

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
