<?php

namespace HaiXin\Surl;

if (function_exists('surl_encode') === false) {
    function surl_encode($url): string
    {
        return Surl::url($url)->encode()->code();
    }
}
if (function_exists('surl_decode') === false) {
    function surl_decode($code, bool $increment = true)
    {
        return Surl::decode($code, $increment);
    }
}
if (function_exists('surl_save') === false) {
    function surl_save($url)
    {
        return Surl::url($url)->encode()->save()->model();
    }
}

if (function_exists('surl') === false) {
    function surl($url): string
    {
        return Surl::url($url)->encode()->save()->toString();
    }
}

if (function_exists('surl_domain') === false) {
    function surl_domain(): string
    {
        return Surl::domain();
    }
}
