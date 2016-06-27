<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gifted extends Model
{
    protected $table = 'gifted';

    protected $fillable = [
    	'uid', 'gift', 'state'
    ];
}
