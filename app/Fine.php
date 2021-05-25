<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable=['car_id','text','price'];
    public function getCar()
    {
        return $this->hasOne(Cars::class,'id','car_id');
    }
}
