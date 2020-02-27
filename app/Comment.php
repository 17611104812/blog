<?php

namespace App;


class Comment extends Model
{
    //
    public function post()
    {
        return $this->belongsTo('App\Post');
        //return $this->belongsTo('App\Post','post_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
