<?php

namespace HaiXin\Surl;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BasicModel;

class Model extends BasicModel
{
    protected $guarded = [];
    protected $dates   = ['expires_at'];
    
    public function __construct(array $attributes = [])
    {
        $this->setConnection(config('surl.database.connection'));
        $this->setTable(config('surl.database.table'));
        parent::__construct($attributes);
    }
    
    public function scopeCode(Builder $query, $code)
    {
        return $query->where('code', $code);
    }
}
