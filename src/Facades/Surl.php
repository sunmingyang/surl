<?php

namespace HaiXin\Surl\Facades;

use HaiXin\GeTui\Alias;
use HaiXin\GeTui\Broadcast;
use HaiXin\GeTui\Group;
use HaiXin\GeTui\Pipeline;
use HaiXin\GeTui\Report;
use HaiXin\GeTui\Single;
use HaiXin\GeTui\Tags;
use HaiXin\GeTui\Task;
use HaiXin\GeTui\User;
use Illuminate\Support\Facades\Facade;

/**
 * Class Surl
 *
 * @method static url($url = null) 设置/获取 url
 * @method code($code = null) 设置/获取 code
 * @method path($path = null) 设置/获取 path
 * @method model($model = null) 设置/获取 model
 * @method domain($domain = null) 设置/获取 domain
 * @method expires($url = null) 设置/获取 expires
 * @method encode() 编码
 * @method static decode($code, bool $increment = true, bool $expires = true) 解码
 * @package HaiXin\Surl\Facades
 */
class Surl extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'surl';
    }
}
