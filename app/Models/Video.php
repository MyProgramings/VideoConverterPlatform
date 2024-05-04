<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function convertedvideos()
    {
        return $this->hasMany('App\Models\Convertedvideo');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\Video', 'video_user', 'video_id', 'user_id')->withTimestamps()->withPivot('id');
    }
}
