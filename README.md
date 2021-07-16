# GeTui

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

## 路线图

略。。。

## 安装

``` bash
$ composer require haixin/surl

artisan vendor:publish --provider="HaiXin\Surl\SurlServiceProvider"

# 修改 config/surl.php 后

artisan migrate
```

## 使用

### 编码

```php
/********** 面向对象 **********/
use HaiXin\Surl\Facades\Surl;
$url = 'https://github.com/sunmingyang/surl';
$surl = Surl::url($url)
        //->expires('2021-07-16 00:00:00') 可以设置过期时间
        //->config($config) 可以传入config进行替换
        ->encode()
        ->save()
        ->toString();
print_r($surl); // OWKhm

/********** 面向过程 **********/
use function HaiXin\Surl\Helpers\surl_encode;
$surl = surl_encode($url); // 仅编码，不保存到数据库，返回短码

use function HaiXin\Surl\Helpers\surl_save;
$surl = surl_save($url); // 编码，保存到数据库，返回模型

use function HaiXin\Surl\Helpers\surl;
$surl = surl($url); // 编码，保存到数据库，返回完整地址
print_r($surl); // https:/localhost/s/OWKhm
```

### 解码

```php
use HaiXin\Surl\Facades\Surl;
$code = 'OWKhm'; 
$increment = true; // 每次解码，是否增加访问次数
$expires = true; // 失效是否允许访问

$url = Surl::decode($code, $increment, $expires); // 解码，返回原始地址
print_r($url); // https://github.com/sunmingyang/surl

use function HaiXin\Surl\Helpers\surl_decode;
$url = surl_decode($code); // 解码，返回原始地址
print_r($url); // https://github.com/sunmingyang/surl

```

## 更新日志

[更新日志](changelog.md)

[ico-version]: https://img.shields.io/packagist/v/haixin/getui.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/haixin/getui.svg?style=flat-square

[ico-travis]: https://img.shields.io/travis/haixin/getui/master.svg?style=flat-square

[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/haixin/getui

[link-downloads]: https://packagist.org/packages/haixin/getui

[link-travis]: https://travis-ci.org/haixin/getui

[link-styleci]: https://styleci.io/repos/12345678

[link-author]: https://github.com/haixin

[link-contributors]: ../../contributors
