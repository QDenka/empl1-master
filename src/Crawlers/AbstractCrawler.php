<?php

namespace App\Crawlers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

abstract class AbstractCrawler
{
    abstract function start();
    abstract function save();

    protected $crawler, $html;

    public function initHtml($html)
    {
        $this->html = $html;
        $this->init();
    }

    protected function init()
    {
        $this->crawler = new DomCrawler($this->html);
    }

    public function getText($name)
    {
        return $this->filterClass($name)->text();
    }

    public function getEachText($name)
    {
        return implode("\n", $this->filterClass($name)->each(function ($node) {
            return $node->text();
        }));
    }

    public function getImage($name)
    {
        $images = $this->filterClass($name)->extract(['src']);
        return count($images) > 0 ? $images[0] : null;
    }

    public function getLinks($name): ?array
    {
        $linksClass = $this->filterClass($name)->links();
        foreach ($linksClass as $link)
            $links[] = $link->getUri();

        return $links ?? null;
    }

    protected function filterClass($name)
    {
        return $this->crawler->filter($name);
    }
}
