<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';
    protected $guarded = [];

    public function videos(){
        return $this->hasMany(Video::class)->orderby('episode_number','asc');
    }
}
