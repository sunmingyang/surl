<?php

namespace HaiXin\Surl\Helpers;

use HaiXin\Surl\Facades\Surl;

if (function_exists('surl_encode') === false) {
    function surl_encode($url = null): string
    {
        return Surl::url($url)->encode()->code();
    }
}
if (function_exists('surl_decode') === false) {
    function surl_decode($code = null, bool $increment = true, $expires = false)
    {
        return Surl::decode($code, $increment, $expires);
    }
}
if (function_exists('surl_save') === false) {
    function surl_save($url, $expires = null)
    {
        $surl = Surl::url($url);
    
        if ($expires !== null) {
            $surl->expires($expires);
        }
    
        return $surl->encode()->save()->model();
    }
}
if (function_exists('surl') === false) {
    function surl($url, $expires = null): string
    {
        $surl = Surl::url($url);
    
        if ($expires !== null) {
            $surl->expires($expires);
        }
        return $surl->encode()->save()->toString();
    }
}
