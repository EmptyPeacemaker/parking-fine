<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $fillable=['number','user_id'];
    public const CREATED_AT = 'create';
    public const UPDATED_AT = null;
}
