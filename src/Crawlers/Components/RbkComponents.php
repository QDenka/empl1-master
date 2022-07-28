<?php

namespace App\Crawlers\Components;

class RbkComponents
{
    public const NEWS_LIMIT = 15;

    public const LIST_NEWS_CLASS = 'div.js-news-feed-list';
    public const NEWS_ITEM = '.js-news-feed-item';

    public const NEWS_HEADER = 'h1[itemprop="headline"]';
    public const NEWS_IMAGE = 'img.article__main-image__image';
    public const NEWS_CATEGORY = 'a[itemprop="articleSection"]';
    public const NEWS_TEXT = 'div[itemprop="articleBody"] p';

    public const RBK_HOST = 'rbc.ru';

    public static function getNewsListNode()
    {
        return self::LIST_NEWS_CLASS . ' ' . self::NEWS_ITEM;
    }

    public static function getHost()
    {
        return 'https://' . self::RBK_HOST;
    }
}
 