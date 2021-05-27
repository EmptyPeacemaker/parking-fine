<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $fillable=['car_id'];
    public const CREATED_AT = 'create';
    public const UPDATED_AT = null;

    public function getCar()
    {
        return $this->hasOne(Cars::class,'id','car_id');
    }

}
