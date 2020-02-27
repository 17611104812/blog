<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{

    //不能注入的字段
    protected $guarded = [];

    //可以注入的字段
    //protected $fillable = [];
}
