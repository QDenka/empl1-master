<?php

namespace App\Helpers;

use App\Crawlers\Components\RbkComponents;

class RbkHelper
{
    public static function formatRbkLinks(array $links): array
    {
        $links = array_filter($links, ['self', 'isRbkLink']);
        $links = array_slice($links, 0, RbkComponents::NEWS_LIMIT, true);
        
        return array_values($links);
    }

    public static function isRbkLink(string $secondLink)
    {
        return HttpHelper::isEqualLinks(RbkComponents::getHost(), $secondLink);
    }
}
