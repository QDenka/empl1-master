<?php

namespace App\Crawlers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

abstract class AbstractCrawler
{
    abstract function start();
    abstract function save();

    protected $crawler, $html, $currentFilter;

    public function initHtml(string $html): void
    {
        $this->html = $html;
        $this->init();
    }

    protected function init(): void
    {
        $this->crawler = new DomCrawler($this->html);
    }

    public function getText(string $name): ?string
    {
        $this->filter($name);
        return $this->hasFilter() ? $this->currentFilter->text() : null;
    }

    public function getEachText(string $name): ?string
    {
        $this->filter($name);
        return $this->hasFilter() ? implode("\n", $this->currentFilter->each(function ($node) {
            return $node->text();
        })) : null;
    }

    public function getImage(string $name): ?string
    {
        $this->filter($name);
        if (!$this->hasFilter()) return null;

        $images = $this->currentFilter->extract(['src']);
        return count($images) > 0 ? $images[0] : null;
    }

    public function getLinks($name): ?array
    {
        $this->filter($name);
        if (!$this->hasFilter()) return null;
        
        $linksClass = $this->filter($name)->links();
        foreach ($linksClass as $link)
            $links[] = $link->getUri();

        return $links ?? null;
    }

    protected function filter($name)
    {
        return $this->currentFilter = $this->crawler->filter($name);
    }

    protected function hasFilter()
    {
        return $this->currentFilter->count() > 0;
    }
}
