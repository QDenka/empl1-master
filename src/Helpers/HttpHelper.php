<?php

namespace App\Helpers;

class HttpHelper
{
    public static function getHostFromUrl($url): string
    {
        return parse_url(self::deleteWorldWide($url), PHP_URL_HOST);
    }

    public static function deleteWorldWide($url): string
    {
        return str_replace('www.', '', $url);
    }

    public static function isEqualLinks($link, $equal)
    {
        $link = self::getHostFromUrl($link);
        $equal = self::getHostFromUrl($equal);

        return $link === $equal;
    }
}
