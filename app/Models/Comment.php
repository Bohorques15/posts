<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = 'comments';

    protected $fillable = [
        'content',
        'date',
        'post_id',
        'user_id'
    ];

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
