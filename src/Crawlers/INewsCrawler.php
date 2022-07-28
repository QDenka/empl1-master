<?php

namespace App\Crawlers;

interface INewsCrawler
{
    public function parseNewsLink();
    public function parseNews();
}
