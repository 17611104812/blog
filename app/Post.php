<?php

namespace App;


class Post extends Model
{
    //
    public function user()
    {
        //反向一对一  这篇文章属于哪个user
        return $this->belongsTo('App\User');
        //等于return $this->belongsTo('App\User'，'user_id','id');
    }

    public function comments()
    {
        //一对多
        return $this->hasMany('App\Comment')->orderBy('created_at','desc');
        //等于 return $this->>hasOne('App\Comment,'id','post_id');
    }


    public function zan($user_id)
    {
        return $this->hasOne('App\Zan')->where('user_id',$user_id);
    }

    public function zans()
    {
        return $this->hasMany('App\Zan');
    }

}
