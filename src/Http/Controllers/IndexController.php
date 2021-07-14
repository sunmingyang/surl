<?php

namespace HaiXin\Surl\Http\Controllers;

use App\Http\Controllers\Controller;
use HaiXin\Surl\Model;

class IndexController extends Controller
{
    public function encode()
    {
        return surl(request(config('short-url.request_name')));
    }
    
    public function decode($code)
    {
        return redirect(surl_decode($code)->url());
    }
}
