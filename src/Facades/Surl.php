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
 * @method \HaiXin\Surl\Surl url($url) 设置网址
 * @method \HaiXin\Surl\Surl setDomain($domain) 设置域名
 * @method \HaiXin\Surl\Surl setPath($path) 设置路径
 * @method string|null code() 获取编码
 * @method string|null toString() 获取完整短网址
 * @method \HaiXin\Surl\Surl save($url = null, $values = []) 保存至数据库
 * @method \HaiXin\Surl\Surl encode($url = null) 编码网址
 * @method string domain() 获取短网址域名
 * @method string path() 获取短网址路径
 * @method Model model() 获取模型
 * @method \HaiXin\Surl\Surl decode($code, bool $increment = true) 通过编码还原网址（自动填充网址、编码与模型）
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
