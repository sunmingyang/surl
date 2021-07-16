<?php

namespace HaiXin\Surl;

use Carbon\Carbon;
use HaiXin\Surl\Exceptions\ExpiresException;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Class Surl
 * @method url($url = null) 设置/获取 url
 * @method code($code = null) 设置/获取 code
 * @method path($path = null) 设置/获取 path
 * @method model($model = null) 设置/获取 model
 * @method domain($domain = null) 设置/获取 domain
 * @method expires($url = null) 设置/获取 expires
 *
 * @package HaiXin\Surl
 */
class Surl
{
    protected $url;
    protected $code;
    protected $path;
    protected $model;
    protected $config;
    protected $domain;
    protected $expires;
    
    public function __construct(array $config)
    {
        $this->config($config);
    }
    
    public function config(array $config = null)
    {
        if ($config !== null) {
            $this->config = $config;
            
            foreach ($config as $key => $value) {
                if ($this->has($key) === true) {
                    $this->{$key} = $value;
                }
            }
            return $this;
        }
        
        return $this->config;
    }
    
    public function has($name): bool
    {
        return property_exists($this, $name);
    }
    
    /**
     * @return string
     * @see toString()
     *
     */
    public function __toString()
    {
        return $this->toString();
    }
    
    /**
     * 输出可访问的短网址
     *
     * @param  null  $url
     *
     * @return string
     */
    public function toString(): string
    {
        return Str::of($this->domain())
                  ->finish('/')
                  ->append(Str::of($this->path())->finish('/'))
                  ->append($this->code())
                  ->replace('//', '/')
                  ->__toString();
    }
    
    public function __call($name, $params = null)
    {
        if (empty($params) === true && $this->validate($name) === true) {
            return $this->{$name};
        }
        
        if ($params !== null && $this->has($name) === true) {
            $this->{$name} = $params['0'];
            
            return $this;
        }
        
        throw new RuntimeException("属性 {$name} 不存在", 404);
    }
    
    protected function validate($name): bool
    {
        throw_if(
            $this->has($name) === false || $this->{$name} === null,
            RuntimeException::class,
            "未设置{$name}"
        );
        
        return true;
    }
    
    /**
     * 保存至数据库
     *
     * @param  null  $url
     *
     * @return $this
     */
    public function save(): Surl
    {
        $values = ['url' => $this->url()];
        
        if ($this->expires !== null) {
            $values['expires_at'] = $this->expires();
        }
        
        $this->model = Model::code($this->code())->firstOrCreate(['code' => $this->code()], $values);
        
        return $this;
    }
    
    /**
     * 编码
     *
     * @param  null  $url
     *
     * @return $this
     */
    public function encode(): Surl
    {
        $abstract = sprintf('%u', crc32($this->url()));
        $code     = '';
        
        while ($abstract > 0) {
            $string = $abstract % 62;
            if ($string > 35) {
                $string = chr($string + 61);
            } elseif ($string > 9 && $string <= 35) {
                $string = chr($string + 55);
            }
            $code     .= $string;
            $abstract = floor($abstract / 62);
        }
        
        $this->code($code);
        
        return $this;
    }
    
    /**
     * 解码，code 换网址
     *
     * @param        $code
     * @param  bool  $increment  每次访问，是否增加访问次数
     * @param  bool  $expires    超过有效期的网址是否允许继续访问
     *
     * @return mixed
     */
    public function decode($code, bool $increment = true, bool $expires = true)
    {
        $builder = Model::code($code);
        
        $model = $builder->firstOrFail();
        
        if ($increment === true) {
            $builder->increment('visits');
        }
    
        if ($expires === false && $model->expires_at instanceof Carbon && $model->expires_at->lte(now())) {
            throw new ExpiresException("已过期", 403);
        }
        
        $this->model = $model;
        $this->url   = $model->url;
        $this->code  = $model->code;
        
        return $this;
    }
}
