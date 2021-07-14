<?php

namespace HaiXin\Surl;

use Illuminate\Support\Str;

class Surl
{
    protected $url;
    protected $code;
    protected $path;
    protected $model;
    protected $domain;
    
    public function __construct($url = null)
    {
        if ($url !== null) {
            $this->url($url);
        }
    }
    
    /**
     * 设置网址
     *
     * @param $url
     *
     * @return $this
     */
    public function url($url): Surl
    {
        $this->url = $url;
        
        return $this;
    }
    
    public static function __callStatic($name, $params): Surl
    {
        return (new self())->{$name}(...$params);
    }
    
    /**
     * 设置域名
     *
     * @param $domain
     *
     * @return $this
     */
    public function setDomain($domain): Surl
    {
        $this->domain = $domain;
        return $this;
    }
    
    /**
     * 设置路径
     *
     * @param $path
     *
     * @return $this
     */
    public function setPath($path): Surl
    {
        $this->path = $path;
        
        return $this;
    }
    
    /**
     * 获取 code
     *
     * @return mixed
     */
    public function code()
    {
        return $this->code;
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
    public function toString($url = null): string
    {
        if ($url !== null) {
            $this->url($url)->encode()->save();
        }
        
        return Str::of($this->domain())
                  ->finish('/')
                  ->append(Str::of($this->path())->finish('/'))
                  ->append($this->model()->code)
                  ->replace('//', '/')
                  ->__toString();
    }
    
    /**
     * 保存至数据库
     *
     * @param  null  $url
     *
     * @return $this
     */
    public function save($url = null): Surl
    {
        if ($url !== null) {
            $this->encode($url);
        }
        
        $this->model = Model::code($this->code)->firstOrCreate(['code' => $this->code], ['url' => $this->url]);
        
        return $this;
    }
    
    /**
     * 编码
     *
     * @param  null  $url
     *
     * @return $this
     */
    public function encode($url = null): Surl
    {
        if ($url !== null) {
            $this->url($url);
        }
        
        $abstract = sprintf('%u', crc32($this->url));
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
        
        $this->code = $code;
        
        return $this;
    }
    
    /**
     * 获取域名
     *
     * @return mixed
     */
    public function domain(): string
    {
        if ($this->domain === null) {
            $this->domain = config('surl.domain');
        }
        
        return $this->domain;
    }
    
    /**
     * 获取路径
     *
     * @return string
     */
    public function path(): string
    {
        if ($this->path === null) {
            $this->path = config('surl.path');
        }
        
        return $this->path;
    }
    
    /**
     * 获取 model
     *
     * @return mixed
     */
    public function model()
    {
        return $this->model;
    }

    /**
     *  获取原始网址
     *
     *  @return string
     */
    public function getUrl(){
        return $this->url;
    }

    /**
     * 解码，code 换网址
     *
     * @param        $code
     * @param  bool  $increment
     *
     * @return mixed
     */
    public function decode($code, bool $increment = true)
    {
        $builder = Model::code($code);
        
        $model = $builder->firstOrFail();
        
        if ($increment === true) {
            $builder->increment('visits');
        }
        
        $this->model = $model;
        $this->url   = $model->url;
        $this->code  = $model->code;
        
        return $this;
    }
}
